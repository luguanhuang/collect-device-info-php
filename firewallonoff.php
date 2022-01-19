<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("FireWall::getFireWallSwitch");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>防火墙开关 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return FireWall_Switch(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>防火墙开关</div>
    </caption>
    <tr>
      <td class="t">启用防火墙：</td>
      <td class="c chkbox"><label><input type="radio" name="enabled" id="enabled" value="1"<?php if ($Ary_Result['result']){echo(' checked');}?>/></label>
        <span>启用</span>
        <label><input type="radio" name="enabled" id="enabled" value="0"<?php if (!$Ary_Result['result']){echo(' checked');}?>/></label>
        <span>禁用</span>
        <br clear="all" />
        </td>
    </tr>
    <tr>
        <td colspan="2" class="f">
      		<div class="left130">
            	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
                <input type="button" id="btnrefresh" value="刷新" class="btn" onclick="window.location.reload(true);" />
            </div>
        </td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="FireWall::setFireWallSwitch" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['enabled']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/firewall.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>