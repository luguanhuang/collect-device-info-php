// JavaScript Document

function setPassword_Validate($form){
	if (!$form){ return false; }
	
	//验证表单
	var	$ary_element = new Array();
		$ary_element["oldpass"]		= new Array(6,	50,		'原密码',		true);
		$ary_element["newpass"]		= new Array(6,	50,		'新密码',		true);
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	$_G.Coexist	= new Array( new Array("==","新密码确认错误",'newpass','renewpass') );
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
}

function User_AddNew($form){
	if (!$form){ return false; }
	//验证表单
	var	$ary_element = new Array();
		$ary_element["user"]		= new Array(4, 	20, 	"管理员帐号",		SelectRegRule('user'));
		$ary_element["name"]		= new Array(1,	20,		'用户姓名',		true);
		$ary_element["group"]		= new Array(1,	null,	'用户角色',		">0");
		$ary_element["pass"]		= new Array(6,	50,		'登录密码',		true);
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	$_G.Coexist	= new Array( new Array("==","确认密码错误",'pass','repass') );
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" 您是否要继续添加管理员帐号？",
					function (){if ($frm){$frm.reset();}},
					function (){window.location.href = "adminlist.php";}
				)
			},
			"backargs":[$form]
		}
	);
}

function User_Update($form){
	if (!$form){ return false; }
	//验证表单
	var	$ary_element = new Array();
		$ary_element["name"]		= new Array(1,	20,		'用户姓名',		true);
		$ary_element["group"]		= new Array(1,	null,	'用户角色',		">0");
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){$_C.Alert($_A.result()[3],null); if ($frm){$frm.reset();}},
			"backargs":$form
		}
	);
}

function User_Delete($user){
	var $user = $_G.trim($user);
	var $form = document.forms.frm;
	if (!$form || $user==""){ return false; }
	$_C.Confirm(
		"管理员帐号删除后将不可恢复，您确定要删除所选帐号？",
		function ($uid,$frm){
			if (!$frm || $uid==""){ return false; }
			$frm.user.value = $uid;
			//提交数据
			AjaxSubmit(
				$frm,
				{
					"backcall":function($uid){
						$uid = $_G.trim($uid);
						$row = $uid=="" ? null : $('row_'+$uid);
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":$uid
				}
			);
		},
		null,
		$user,
		$form
	)
	return false;
}