<?php
require("services/AtherFrameWork.php");
require("mdb/MenuData.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_getlogin(true);

error_reporting(0);
session_start();
$Int_Report	= ini_get('error_reporting');
error_reporting($Int_Report);
$selectitem = "";
$tmp = &$_SESSION[_GLO_SESSION_USERINFO_]['userinfo'];
$useinfo = explode(',',$tmp);

TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "TopMenu",0);
TLOG_MSG("TopMenu: func begin name33=".$tmp." user=".$user);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link type="text/css" rel="stylesheet" href="css.css" />
<base target="mainFrame" />
</head>
<body style="background: #00a099; padding-top:0;" onload="hovermenu('level1','hove','cur');submenu('level2','hove1','hove1');">

<div class="box" style="display:inline-block;height: 32px; width:100%; text-align: right;">
	<ul class="menu" style="width: 100%; display:inline-block; text-align: right;">
  	<?php
    //$g	= intval($Ary_Result['group']);
	$g = $useinfo[0];
	$m	= &$Glo_Ary_Menu;
	$s	= NULL;
	foreach($m as $v){
		if (!is_array($v)){ continue; }
		//不含有二级菜单
		if (!isset($v['child']) || !is_array($v['child'])){
			if (!isset($v['group']) || !isset($v['text']) || !isset($v['url'])){ continue; }
			if (!is_array($v['group'])){ $v['group'] = $v['group']=="" ? array() : explode(",",$v['group']); }
			if ($v['group'] && !in_array($g,$v['group'])){ continue; }
			if (!isset($v['target'])){ $v['target'] = ''; }
			echo "\t\t", '<li class="level1" id="level1" style="text-align:left;display:inline-block;"name="level1"><a href="'. $v['url'] .'" target="'. $v['target'] .'">'. $v['text'] .'</a></li>', "\r\n";
		}
		else{
			$s = array();
			foreach($v['child'] as $vv){
				if (!isset($vv['group']) || !isset($vv['text']) || !isset($vv['url'])){ continue; }
				if (!is_array($vv['group'])){ $vv['group'] = $vv['group']=="" ? array() : explode(",",$vv['group']); }
				if ($vv['group'] && !in_array($g,$vv['group'])){ continue; }
				if (!isset($vv['target'])){ $vv['target'] = ''; }
				$s[] = $vv;
			}
			if (!$s){ continue; }
			echo
				"\t\t",
				'<li class="level1" id="level1" style="text-align:right;display:inline-block;" name="level1"><a href="#" target="_self">'. $v['text'] .'</a>',
				"\r\n",
				"\t\t\t",
				'<ul class="level2" id="level2" name="level2">',
				"\r\n";
			foreach($s as $vv){
				echo "\t\t\t\t",'<li><a href="'. $vv['url'] .'" target="'. $vv['target'] .'">'.$vv['text'].'</a></li>',"\r\n";
			}
			echo "\t\t\t",
				 '</ul>',
				 "\r\n",
				 "\t\t",
				 '</li>',
				 "\r\n";
		}
	}
	unset($s); $s = NULL;
	unset($m); $m = NULL;
	?>
  </ul>
</div>
<script type="text/javascript" src="js/menu.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>