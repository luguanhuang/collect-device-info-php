<?php
//set flag for direct access file
define('AXMSD', 1);
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_getlogin();
if (!$Ary_Result){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: enter.php');
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=_GLO_PROJECT_FNAME_?></title>
</head>
<frameset rows="100,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="index-top.php" name="topFrame" id="topFrame" title="topFrame" scrolling="No" noresize="noresize" />
  <frameset rows="32,*" cols="*" frameborder="no" border="0" framespacing="0">
    <frame src="index-top-menu.php" name="topFramemenu" id="topFramemenu" title="topFramemenu" scrolling="No" noresize="noresize" />
      <frameset rows="*" cols="180,*" framespacing="0" frameborder="no" border="0">
    <frame src="index-left.php" name="leftFrame" id="leftFrame" title="leftFrame" scrolling="no" noresize="noresize"/>
    <frame src="index-main.php" name="mainFrame" id="mainFrame" title="mainFrame" scrolling="auto"/>
  </frameset>
</frameset>
</frameset>
<noframes>
<body>
Sorry, your browser does not support the framework page!
</body>
</noframes>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>