<?php
require('services/UserManager.php');

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new UserManager();
$Ary_Result= $Obj_Frame->logout();

if (!$Ary_Result['state']){
	$Obj_Frame->load_error($Ary_Result['stateId'], $Ary_Result['message']);
}
else{
	unset($Obj_Frame); $Obj_Frame = NULL;
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: enter.php');
	exit();
}
?>