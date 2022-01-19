// JavaScript Document

function TimeSer_Validate($form){
	if (!$form){return false;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["ip"]	= new Array(7,	15,	'校时服务器IP地址',	"ip");
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
}

function LogSvr_ReplaceTag($str,$id){
	$str= $_G.strval($str);
	$id	= $_G.strval($id);
	if ($str!="" && $id!=""){
		$str= $str.replace(/\{tag\:id\}/gi,$id);
		$str= $str.replace(/\{tag\:row_num\}/gi,"row_num");
	}
	return $str;
}

function LogSvr_Addnew(){
	var $obj_list = $('row_list');
	var $obj_tmpl = $('row_templet');
	if (!$obj_list || !$obj_tmpl){ return false; }
	var $int_rnd = $_G.random(9);
	var $obj_new = $obj_tmpl.cloneNode(!document.all);
		$obj_new.setAttribute('id','row_'+$int_rnd);
		
		$obj_new.removeAttribute('style');
	if (document.all){
		var $int_rows = $obj_list.rows.length;
		var $ary_cell = $obj_tmpl.cells;
		var $c,$cell;
			$obj_list.insertRow();							//创建一个新行
			$obj_list.rows[$int_rows].swapNode($obj_new);	//替换掉新行
		for ($c=0;$c<$ary_cell.length;$c++){
			//创建一个td节点并设置节点属性
			$cell = $obj_tmpl.cells[$c].cloneNode(false);
			//创建一个新列
			$obj_list.rows[$int_rows].insertCell();
			//替换掉新列
			$obj_list.rows[$int_rows].cells[$c].swapNode($cell);
			//加入内容
			$obj_list.rows[$int_rows].cells[$c].innerHTML = LogSvr_ReplaceTag($obj_tmpl.cells[$c].innerHTML,$int_rnd);
		}
	}
	else{
		$obj_new.innerHTML = LogSvr_ReplaceTag($obj_new.innerHTML,$int_rnd);
		$obj_tmpl.parentNode.appendChild($obj_new);
	}
	if ($int_rnd>0){
		$('port_'+$int_rnd).setAttribute('disabled','disabled');
	   $('port_'+$int_rnd).value=$('port_0').value;
	}
}

function LogSvr_Delete($id){
	$id = $_G.strval($id);
	if ($id==""){ return false; }
	
	var $obj_row = $('row_'+$id);
	if (!$obj_row){ return false; }
	if ($_G.intval($obj_row.getAttribute('enabled')) == -1){
		$obj_row.parentNode.removeChild($obj_row);
		return false;
	}
	var $obj_txt1 = $('ip_'+$id), $obj_txt2 = $('port_'+$id);
	if ($obj_txt1){
		$obj_txt1.disabled		= true;
		$obj_txt1.style.color	= "red";
		$obj_txt1.style.textDecoration = "line-through";
	}
	if ($obj_txt2){
		$obj_txt2.disabled 		= true;
		$obj_txt2.style.color	= "red";
		$obj_txt2.style.textDecoration = "line-through";
	}
	/*
	var $i,$ary_item = [$('ip_'+$id),$('port_'+$id)];
	for($i=0;$i<$ary_item.length;$i++){
		$ary_item[$i].style.textDecoration = "line-through";
		$ary_item[$i].style.color	= "#FF0000";
	}
	*/
	var $obj_handle = $('row_hand_'+$id,1);
		$obj_handle[0].style.display = "none";
		$obj_handle[1].style.display = "inline";
		$obj_row.setAttribute('enabled',0);
}

function LogSvr_Resume($id){
	$id = $_G.strval($id);
	if ($id==""){ return false; }
	var $obj_row = $('row_'+$id);
	if (!$obj_row){ return false; }
	
	var $obj_txt1 = $('ip_'+$id), $obj_txt2 = $('port_'+$id);
	if ($obj_txt1){
		$obj_txt1.disabled		= false;
		$obj_txt1.style.color	= "black";
		$obj_txt1.style.textDecoration = "none";
	}
	if ($obj_txt2){
		$obj_txt2.disabled		= false;
		$obj_txt2.style.color	= "black";
		$obj_txt2.style.textDecoration = "none";
	}
	
	/*
	var $i,$ary_item = $('row_item_'+$id,1);
	for($i=0;$i<$ary_item.length;$i++){
		$ary_item[$i].style.textDecoration = "none";
		$ary_item[$i].style.color	= "";
	}
	*/
	var $obj_handle = $('row_hand_'+$id,1);
		$obj_handle[0].style.display = "inline";
		$obj_handle[1].style.display = "none";
	$obj_row.setAttribute('enabled',1);
}

function LogSvr_Validate($form){
	if (!$form){return $form;}
	
	var $obj_num = $('row_num',1);
	var $ary_val = [], $ary_ext = [];
	var $obj_row,$obj_ip,$obj_port,$i,$v,$e,$r;	//i:循环标记,v:value值,e:enabled值,r:验证结果
	for($i=0;$i<$obj_num.length;$i++){
		$v = $obj_num[$i].value;
		$obj_row = $('row_'+$v);
		$e = $_G.intval($obj_row.getAttribute('enabled'));
		if ($e==1 || $e==-1){
			$obj_ip		= $('ip_'+$v);
		//	$obj_port	= $('port_'+$v);
			$obj_port	= $('port_0');
			if (!$obj_ip || !$obj_port){ continue; }
			//合并值
			$v = $obj_ip.value+":"+$obj_port.value;
			$v = $v.replace(/(^\0+|(\.)0+)([1-9])/g,"$2$3")
			$r = $_G.validate($obj_ip,"第 "+ ($i+1) +" 个服务器地址",1,15,"ip");
			if ($r[0]>0){
				$_C.Alert($r[1],$_C.focus,$obj_ip);
				return false;
			}
			$r = $_G.validate($obj_port,"第 "+ ($i+1) +" 个服务器端口号",1,null,[1,65535]);
			if ($r[0]>0){
				$_C.Alert($r[1],$_C.focus,$obj_port);
				return false;
			}
			if (typeof($ary_ext[$v])!="undefined"){
				$_C.Alert("第 "+ ($i+1) + " 个服务器配置与第 "+ $ary_ext[$v] +" 条配置重复",$_C.focus,$obj_ip);
				return false;
			}
			$ary_ext[$v] = $i+1;
			$ary_val.push($obj_ip.value+":"+$obj_port.value);
		}
	}
	if ($ary_val.length<1){
		$_C.Alert("至少要有一条日志服务器记录",null);
		return false;
	}
	$form.servers.value = $ary_val.join(", ");
	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function(){
				$_C.Alert($_A.result()[3],function (){window.location.reload(true);})
			},
			"backargs":null
		}
	);
}