// JavaScript Document

function Backup_Validate($form){
	if (!$form){return $form;}
	//提交数据
	return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3])},"backargs":null});
}

function Reset_Validate($form){
	if (!$form){return $form;}
	$_C.Confirm(
		"您确定要恢复到出厂时的配置",
		function (){
			if (!$form){return $form;}
			//提交数据
			return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3])},"backargs":null});
		},
		null,
		$form
	);
	return false;
}

function Recover_Validate($form){
	if (!$form){return $form;}
	$_C.Confirm(
		"您确定要还原到最后一次备份的配置",
		function (){
			if (!$form){return $form;}
			//提交数据
			return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3])},"backargs":null});
		},
		null,
		$form
	);
	return false;
}