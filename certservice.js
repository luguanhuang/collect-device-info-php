// JavaScript Document

function CertUpLoad_TagReplace($str,$val){
	$str = $_G.trim($str);
	var $v;
	if ($str!="" && $_G.isarray($val)){
		$v = typeof($val['filename'])!="undefined" ? $val['filename'] : "";
		$str = $str.replace(/\{tag\:file\}/gi,$v)
		$v = typeof($val['extend'])!="undefined" ? $val['extend'].replace(/^\./,"") : "";
		$str = $str.replace(/\{tag\:extend\}/gi,$v)
	}
	return $str;
}

function CertUpLoad_Validate($form){
	if (!$form){return false;}
	var $file = $form.upload_file.value.replace(/\\/g,"/");
	if ($file==""){
		$_C.Alert('请选择要上传的文件。', $_C.focus, $form.upload_file);
		return false;
	}
	var $lstof= $file.lastIndexOf("/");
	var $name = $lstof==-1 ? $file : $file.substring($lstof+1);
	if (!/^[\w\-][\w\-\.]*(\.[\w\-]+)?$/.test($name)){
		$_C.Alert('证书文件名只能由字线、数字、减号、下划线和点组成。', $_C.focus, $form.upload_file);
		return false;
	}
	var $extrow = $('row_'+$name);
	if ($extrow && $extrow.parentNode.id=="certrow_list"){
		$_C.Confirm(
			"相同文件名的证书已存在，若再上传同名的证书文件将会覆盖原来的证书，您是否要继续？",
			CertUpLoad_Submit,
			null,
			$form
		)
	}
	else{
		CertUpLoad_Submit($form);
	}
	//一定返回false，阻挡表单提交，由 CertUpLoad_Submit 做提交
	return false;
}

function CertUpLoad_Submit($form){
	if (!$form){return false;}
	//显示loading
	var $ary_load = [
		$("divloading"),
		$("divloadfile")
	];
	$ary_load[0].style.display = "block";
	$ary_load[1].style.display = "none";
	//开始上传文件
	if (AjaxSubmit(
		$form,
		{
			"backcall":function($frm,$div){
				//关闭loading
				if ($_G.isarray($div)){
					$div[0].style.display = "none";
					$div[1].style.display = "block";
				}
				if (!$_A.result()[3]['state']){
					$_C.Alert($_A.result()[3]['message'],null);
					return false;
				}
				$_C.Alert(
					$_A.result()[3]['message'],
					CertUpLoad_Complete,
					$_A.result()[3]['result']
				);
			},
			"backargs":[$form,$ary_load],
			"necessary": ["state","stateId","message","result"],
			"remode": "json"
		}
	)){
		$form.submit();
	}
}

function CertUpLoad_Complete($file){
	if ($_G.isobject($file)){
		var $e,$aryval = [];
		for($e in $file){ $aryval[$e] = $file[$e];}
		$file = $aryval;
	}
	if ($_G.isarray($file) && $_G.aryexists($file,"filename","extend")){
		var $list	= $('certrow_list');
		var $tmpl	= $('certrow_templet');
		var $new	= $tmpl.cloneNode(false);
			$new.setAttribute("id", "row_"+$file["filename"])
			$new.removeAttribute('style');
		if ($list && $tmpl){
			//删除已存在的
			var $exrow = $('row_'+$file["filename"]);
			if ($exrow){ $exrow.parentNode.removeChild($exrow); }
			//添加新的
			if (document.all){
				$list.insertRow(0);
				$list.rows[0].swapNode($new);
				var $cells = $tmpl.cells,$cell,$html;
				var $i=0,$l=$cells.length;
				for($i=0;$i<$l;$i++){
					$html = $tmpl.cells[$i].innerHTML;
					//创建一个td节点并设置节点属性
					$cell = $tmpl.cells[$i].cloneNode(false);
					//创建一个新列
					$list.rows[0].insertCell();
					//替换掉新列
					$list.rows[0].cells[$i].swapNode($cell);
					//加入内容
					$list.rows[0].cells[$i].innerHTML=CertUpLoad_TagReplace($html,$file);
				}
			}
			else{
				$new.innerHTML = CertUpLoad_TagReplace($tmpl.innerHTML,$file);
				$_G.addnode($new,$list,0);
			}
			return true;
		}
	}
	window.location.reload(true);
}

function TicketCert_Delete($filename){
	$filename = $_G.strval($filename);
	var $row = $('row_'+$filename);
	if (!$row){ return false; }
	$_C.Confirm(
		"证书删除后将不可还原，您确定要删除该证书吗？",
		function ($f,$r){
			var $form = document.forms.frmlist;
			if (!$form){ return false; }
			$form.certfile.value = $f;
			return AjaxSubmit(
				$form,
				{
					"backcall":function($row){
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":[$r]
				}
			);
		},
		null,
		$filename,
		$row
	);
	return false;
}

function VPNCert_Initial(){
	var $ary_vtype = document.getElementsByName('certtype');
	var $x,  $y, $v, $p, $l = $ary_vtype.length;
	for($x=0;$x<$l;$x++){
		$v = $ary_vtype[$x].getAttribute('indexval');
		if ($v==null){ continue; }
		$v = $_G.strval($v);
		$p = $ary_vtype[$x].options.length;
		for($y=0;$y<$p;$y++){
			if ($ary_vtype[$x].options[$y].value==$v){
				$ary_vtype[$x].options[$y].selected = true;
				break;
			}
		}
	}
}

function VPNCert_Select($value,$name){
	$value	= $_G.strval($value);
	$name	= $_G.strval($name);
	var $state	= $("state_"+$name);
	if (!$state){ return false; }
	if ($value==""){
		$state.innerHTML = "未选用";
		$state.style.color = "#000";
	}
	else{
		$state.innerHTML = "已选用";
		$state.style.color = "#FF0000";
	}
}

function VPNCert_Delete($filename){
	$filename = $_G.strval($filename);
	var $row = $('row_'+$filename);
	if (!$row){ return false; }
	$_C.Confirm(
		"证书删除后将不可还原，您确定要删除该证书吗？",
		function ($f,$r){
			var $form = document.forms.frmlist;
			if (!$form){ return false; }
			$form.certfile.value = $f;
			return AjaxSubmit(
				$form,
				{
					"backcall":function($row){
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":[$r]
				}
			);
		},
		null,
		$filename,
		$row
	);
	return false;
}

function VPNCert_Validate(){
	var $form1 = document.forms.frmlist;
	var $form2 = document.forms.frmconf;
	if (!$form1 || !$form2){ return false; }
	var $selectlst = new Array();
		$selectlst['ca']	= ["根证书",		1,	[]];
		$selectlst['cert']	= ["证书文件",	1,	[]];
		$selectlst['key']	= ["私钥文件",	1,	[]];
	var $cert = document.getElementsByName('certtype');
	var $i=0, $v='', $s=[], $l=$cert.length;
	for($i=0;$i<$l;$i++){
		$v = $cert[$i].value;
		if ($v==""){ continue; }
		if ($_G.isarray($selectlst[$v])){
			//未满的
			if ($selectlst[$v][1]>$selectlst[$v][2].length){
				$selectlst[$v][2].push($cert[$i].getAttribute('filename'));
			}
			//已满的
			else{
				$_C.Alert("最多只能选择 "+ $selectlst[$v][1] +" 个"+$selectlst[$v][0], null);
				return false;
			}
		}
	}
	//将值存入表单
	for($v in $selectlst){
		$form2.elements[$v].value = $selectlst[$v][2].join(",");
	}
	var $e;
	for($e in $selectlst){
		if ($selectlst[$e][1]>$selectlst[$e][2]){
			$_C.Alert("你还需要选择 "+($selectlst[$e][1]-$selectlst[$e][2])+" 个"+$selectlst[$e][0]+"！", null);
			return false;
		}
	}
	if (AjaxSubmit(
		$form2,
		{
			"backcall":function($c){
				if ($c && $c.length){
					var $i,$v,$f,$s
					for($i=0;$i<$c.length;$i++){
						$v = $c[$i].value;
						$f = $c[$i].getAttribute('filename');
						$s = $('state_'+$f);
						if (!$s){continue;}
						if ($v==""){ $s.innerHTML = "未选用"; $s.removeAttribute("style"); }
						else{ $s.innerHTML = "已选用"; $s.style.color="#FF0000"; }
					}
				}
				$_C.Alert($_A.result()[3],null)
			},
			"backargs":[$cert]
		}
	)){
		$form2.submit();
	}
}

