// JavaScript Document



function Log_GetLog(){
	//发送数据
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	document.forms.Adslresult.exportfile.value="0";
	$_A.send(
		document.forms.Adslresult,
		function (){
			var $result = $_A.result();
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}

			
			if ($result[3]["stateId"]>=0){
				return false;
			}
			else{
				//输出返回结果
				//alert($result+" result[0]="+$result[0]+" $result[2]="+$result[2]+" stateid="+$result[3]["stateId"]+" $result[3]="+$result[3]["result"]);
				
				if ($result[3]["stateId"] == "-171")
				{
					alert("保存配置成功");
				}
				document.forms.Adslresult.Adslmessage.value=$result[3]["result"];
				document.forms.Adslresult.Adslmessage.scrollTop = document.forms.Adslresult.Adslmessage.scrollHeight;
			//	setTimeout("Log_GetLog()",500)
			}
		}
	);
	//返回
	return true;
}


function getEthconfigInfo(){
	//发送数据
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		document.forms.Adslresult,
		function (){
			var $result = $_A.result();
		//	alert($result);
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}

			
			if ($result[3]["stateId"]>=0){
				return false;
			}
			else{
				//输出返回结果
				if ($result[3]["result"]!=""  && $result[3]["result"]!=null){
				document.forms.Adslresult.Adslmessage.value=$result[3]["result"];
				document.forms.Adslresult.Adslmessage.scrollTop = document.forms.Adslresult.Adslmessage.scrollHeight;
				}
				//setTimeout("getEthconfigInfo()",2000)
			}
		}
	);
	//返回
	return true;
}

function  setEthconfig(){
	//发送数据
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		document.forms.Adslresult,
		function (){
			var $result = $_A.result();
		//	alert($result);
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}

			
			if ($result[3]["stateId"]>=0){
				return false;
			}
			else{
				$_C.Alert("发送操作命令成功！",null, false);
			}
		}
	);
	//返回
	return true;
}

function saveconfig($button){
	if (!$button){ return false; }
	$_C.Confirm(
		"您确定要保存吗？",
		function (){
			return AjaxSubmit(
				$button,{"backcall":function(){$_C.Alert($_A.result()[3],function (){})},"backargs":null}
			);
		},
		null
	);
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

function CertUpLoad_Submit($form){
	if (!$form){return false;}
	//显示loading
	var $ary_load = [
		$("divloading")
		//$("divloadfile")
	];
	//$ary_load[0].style.display = "block";
	//$ary_load[1].style.display = "none";
	//提交数据
	//return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
	
	//alert("CertUpLoad_Submit: func begin");
	//开始上传文件
	if (AjaxSubmit(
		$form,
		{
			"backcall":function($frm,$div){
				//关闭loading
				if ($_G.isarray($div)){
					//alert("CertUpLoad_Submit: 1");
					//$div[0].style.display = "none";
					//$div[1].style.display = "block";
				}
				if (!$_A.result()[3]['state']){
					//alert("CertUpLoad_Submit: 2");
					$_C.Alert($_A.result()[3]['message'],null);
					return false;
				}
				$_C.Alert(
					$_A.result()[3]['message'],
					CertUpLoad_Complete,
					$_A.result()[3]['result']
				);
			},
			"backargs":null,
			"necessary": ["state","stateId","message","result"],
			"remode": "json"
		}
	)){
		$form.submit();
	}
}

function UpLoad_Validate($form){
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
