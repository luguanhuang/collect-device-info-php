// JavaScript Document

function DHCPConf_Validate($form){
	if (!$form){return $form;}
	var $int_svr = $_G.intval($_G.getvalue($form.dhcpsvr));
	if ($int_svr){
		//验证表单
		var	$ary_element = new Array();
			$ary_element["_listen"]	= new Array(7,	15,	'监听IP',		"ip");
			$ary_element["_minip"]	= new Array(7,	15,	'最小IP',		"ip");
			$ary_element["_maxip"]	= new Array(7,	15,	'最大IP',		"ip");
			$ary_element["_router"]	= new Array(7,	15,	'路由IP',		"ip");
			$ary_element["_dns1"]	= new Array(7,	15,	'首选DNS服务器',	"ip");
			$ary_element["_dns2"]	= new Array(7,	15,	'备用DNS服务器',	"ip");
			
		$_G.Form	= $form;
		$_G.Element	= $ary_element;
		
		if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
		
		var $i,$n,$e
		for($i in $ary_element){
			$n = $i.substring(1);
			if ($form.elements[$n]){$form.elements[$n].value = $form.elements[$i].value}
		}
	}

	//提交数据
	return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
}

function DHCPConf_Switch($form,$value){
	if (!$form){return $form;}
	var $ary_element = new Array("_listen", "_minip", "_maxip", "_router", "_dns1", "_dns2")
	var $bln_disbaled= !$_G.intval($value);
	var $i,$e;
	for($i in $ary_element){
		$e = $form.elements[$ary_element[$i]];
		if ($e){ $e.disabled = $bln_disbaled; }
	}
}