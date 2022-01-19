<?php

require_once 'tlog.php';
require_once 'testtmp.php';
require("services/AtherFrameWork.php");
//print_r($_POST);exit;

global $Obj_Frame;
global $Ary_Result;

$params = (file_get_contents('php://input'));

$arrStr = explode("&", $params); 
$arrCmd = explode("=", $arrStr[0]);
TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "submitgraph",0);
TLOG_MSG("submit: type=".$_SERVER['REQUEST_METHOD']." param=".$params);
$Obj_Frame = new AtherFrameWork();
TLOG_MSG("submit: cmd=$arrCmd[1]");
if ($arrCmd[1] == "gettagdata")
{
	$arrDev = explode("=", $arrStr[1]);
	$param = $arrDev[1];
	TLOG_MSG("gettagdata param=$param");	
	
	$Ary_Resulttmp= $Obj_Frame->load_page("Channel::getTagDataDetail",$param,false);
	echo json_encode($Ary_Resulttmp);
}
else if ($arrCmd[1] == "getmain")
{
	$arrDev = explode("=", $arrStr[1]);
	$param = $arrDev[1];
	TLOG_MSG("will execute updatedata param=$param");	
	
	$Ary_Resulttmp= $Obj_Frame->load_page("Channel::getMaindata",$param,false);
	echo json_encode($Ary_Resulttmp);
}
else if ($arrCmd[1] == "gettaginfo")
{
	$arrDev = explode("=", $arrStr[1]);
	$param = $arrDev[1];
	TLOG_MSG("will execute updatedata param=$param");	
	
	$Ary_Resulttmp= $Obj_Frame->load_page("Channel::getAllTagInfo",$param,false);
	echo json_encode($Ary_Resulttmp);
}else if ($arrCmd[1] == "gethistorydata")
{
	$arrDev = explode("=", $arrStr[1]);
	$param = $arrDev[1];
	
	$time = explode("=", $arrStr[2]);
	$timeparam = $time[1];
	
	TLOG_MSG("will execute updatedata param=$param timeparam=$timeparam");	
	
	$Ary_Resulttmp= $Obj_Frame->load_page("Channel::getHistoryData","$param&$timeparam",false);
	echo json_encode($Ary_Resulttmp);
}
else if ($arrCmd[1] == "getalarminfo")
{
		$arrDev = explode("=", $arrStr[1]);
	$param = $arrDev[1];
	TLOG_MSG("will execute updatedata param=$param");	
	
	$Ary_Resulttmp= $Obj_Frame->load_page("Channel::getAlarmData",$param,false);
	echo json_encode($Ary_Resulttmp);
}
//
//
//$Ary_Resulttmp= $Obj_Frame->load_page("Channel::getAllChannelData");
/*foreach($Ary_Resulttmp['result']['data'] as $allk=>$allrow)
{
	TLOG_MSG("devname=".$allrow['devname']);
}*/

/*if (is_array($Ary_Resulttmp))
{
	if ($Ary_Resulttmp['result'])
	{
		foreach($Ary_Resulttmp['result'] as $allk=>$allrow)
		{
			if (is_array($allrow['result']['data']))
			{
				foreach($allrow['result']['data'] as $k1=>$row1)
				{
					TLOG_MSG("ch=".$row1['ch']." dtype=".$row1['dtype']." devname=".$row1['devname']);
				}
			}	
		}
	}
}*/

//$Ary_Result= $Obj_Frame->call("Channel::getAllChannelData","html");
//TLOG_MSG("submit: func begin 2 Ary_Result111=".$Ary_Result);
//print_r($Ary_Result);exit;
//echo("dddd");
//echo($Ary_Result);

unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>