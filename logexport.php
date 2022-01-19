<?php
//15分钟超时
set_time_limit(15*60);
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->call("AuditService::export_logfile", "html");
responseResult();
setNothing();

function responseResult(){
	global $Ary_Result;
	if (!$Ary_Result['state']){
		echo($Ary_Result['stateId'].",".$Ary_Result['message']);
	}
	else{
		$file = iconv("utf-8","gbk//IGNORE",$Ary_Result['result']["filename"]).".html";
		$text = $Ary_Result['result']["content"];
		unset($Ary_Result['result']["content"]);
		$Ary_Result['result']["content"] = NULL;
		header('Content-Type:application/force-download');			//强制下载
		header('Content-Transfer-Encoding: binary');				//使用二进制传输
		header("Content-Disposition:attachment;filename=".$file);	//保存文件名(http协议)
		header("Cache-Control: public");							//令IE支持
		header('Pragma: public'); 									//令IE支持
		header('Expires: 0');										//立即过期
		echo($text);
		$text = NULL;
	}
}

function setNothing(){
	global $Ary_Result;
	global $Obj_Frame;
	unset($Ary_Result); $Ary_Result = NULL;
	unset($Obj_Frame);	$Obj_Frame	= NULL;
	exit();
}
?>