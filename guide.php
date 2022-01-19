<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_popedom("NetConfig::setWlanConf",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>设置向导一 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="guide1.php" method="get">
  <table style="width:500px;" align="center" cellpadding="0" cellspacing="0" border="0" class="tab3">
    <caption class="nav">
    <div><span></span>设置向导一</div>
    </caption>
    <tr>
      <td align="left"><br />
        使用本设置向导，您可以轻松地完成上网所需的基本设置。即使您对网络知识一窍不通，您也能够依据提示轻轻松松地完成设置。如果您是一位高手，您完全可以退出本向导程序，直接到菜单项中选择您需要修改的设置项进行设置。<br />
        <br />
        如需要继续，请单击“下一步”。<br />
        如需要退出设置向导，请单击“退出向导”。<br /></td>
    </tr>
    <tr>
      <td align="center" class="f2"><input type="button" id="btnexit" name="btnexit" value="退出向导" class="btn" onclick="window.location.href='station.php'" />
        <input type="submit" id="btnnext" name="btnnext" value="下一步" class="btn"/></td>
    </tr>
  </table>
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>