// JavaScript Document

function FireWall_Validate($form){
	if (!$form){ return false; }
	
	//验证表单
	var	$ary_element = new Array();
		$ary_element["sport"]		= new Array(0,	5,	'源端口',		[1,65535]);
		$ary_element["sip"]			= new Array(0,	17,	'源IP',			"ip");
		$ary_element["smask"]		= new Array(0,	17,	'源子网掩码',		SelectRegRule('mask'));
		$ary_element["smac"]		= new Array(0,	17,	'源MAC地址',		SelectRegRule('mac'));
		$ary_element["dport"]		= new Array(0,	5,	'目标端口',		[1,65535]);
		$ary_element["dip"]			= new Array(0,	17,	'目标IP',		"ip");
		$ary_element["dmask"]		= new Array(0,	17,	'目标子网掩码',	SelectRegRule('mask'));
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	//验证其他数据
	if (($form.sport.value!="" || $form.dport.value!="") ){
		var $str_ptype = $_G.strval($form.ptype.value,1);
		if ($str_ptype=="icmp"){
			$_C.Alert("使用ICMP协议时不可指定源端口或目标端口",null);
			return false;
		}
		else if ($str_ptype=="all"){
			$_C.Alert("指定源端口或目标端口时，必须使用UDP/TCP协议",null);
			return false;
		}
	}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" 您是否要继续添加规则？",
					function (){$frm.reset(true)},
					function (){window.location.href='firewallrule.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function FireWall_Delete(){
	var $msg	= "防火墙规则删除后将不可恢复，您确定要删除该规则？";
	var $arg	= !arguments.length ? null : arguments[0];
	if ($arg==null){ return false; }
	var $isfrm	= $_G.isobject($arg) && $arg.tagName && $arg.tagName=="FORM"
	if (!$isfrm){
		$_C.Confirm(
			$msg,
			function ($id){
				$id = $_G.intval($id);
				var $form= document.forms.frm;
				var $row = $('row_'+$id);
				if (!$row || !$form){ return false; }
				var $i,$k,$key = new Array('sport','sip','smask','smac','dport','dip','dmask','link','action','ptype');
				for($i=0;$i<$key.length;$i++){
					$k = $key[$i];
					if (!$form.elements[$k] || !$form.elements[$k+"_"+$id]){ return false; }
					$form.elements[$k].value = $form.elements[$k+"_"+$id].value;
				}
				//提交数据
				if (AjaxSubmit(
					$form,
					{
						"backcall":function($id){
							var $row = $('row_'+$_G.intval($id));
							if ($row){
								$_C.Alert($_A.result()[3],null);
								$row.parentNode.removeChild($row);
							}
							else{
								$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
							}
						},
						"backargs":[$id]
					}	
				)){ $form.submit(); }
			},
			null,
			$arg
		);
	}
	else{
		$_C.Confirm(
			$msg,
			function ($form){
				if (!$form){ return false; }
				//提交数据
				if (AjaxSubmit(
					$form,
					{
						"backcall":function(){
							$_C.Alert($_A.result()[3], function (){ window.location.href='firewallrule.php'; } );
						}
					}	
				)){ $form.submit(); }
			},
			null,
			$arg
		);
	}
	return false;
}

function FireWall_Switch($form){
	if (!$form){ return false; }
	$_C.Confirm(
		"您确定要保存防火墙服务状态？",
		function ($frm){
			//提交数据
			if (AjaxSubmit(
				$form,
				{"backcall":function($id){$_C.Alert($_A.result()[3],null);},"backargs":null}
			)){ $frm.submit(); }
		},
		null,
		$form
	);
	return false;
}