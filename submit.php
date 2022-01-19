<?php
require_once 'tlog.php';
require("services/AtherFrameWork.php");
//print_r($_POST);exit;

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "submit",0);
TLOG_MSG("submit: func begin111111111");
$Obj_Frame = new AtherFrameWork();
TLOG_MSG("Run: func begin 1");
$Ary_Result= $Obj_Frame->call();
TLOG_MSG("submit: func begin 2 Ary_Result111=".$Ary_Result);
//print_r($Ary_Result);exit;
//echo("dddd");
echo($Ary_Result);

unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>