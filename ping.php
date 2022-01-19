<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_getlogin(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ping - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div id="PingSend">
<form method="post" name="pingsend" id="pingsend" action="submit.php" onsubmit="javascript:return Ping_Validate(this);"  submitwin="ajax">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>Ping测试</div>
    </caption>
    <tr>
      <td class="t">目标地址：</td>
      <td class="c"><input id="ip" name="ip" type="text" class="input" /></td>
    </tr>
    <tr>
      <td class="t">连接次数：</td>
      <td class="c"><input id="times" name="times" type="text" class="input" value="10" /></td>
    </tr>
    <tr>
      <td class="t">延时：</td>
      <td class="c"><input id="delay" name="delay" type="text" class="input" value="5" /></td>
    </tr>
    <tr>
      <td  class="f" colspan="2">
      	<div class="left130">
      	<input type="submit" id="pingstart" name="pingstart" value="开始Ping" class="btn" />
        </div>
      </td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="Tools::sendPing" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['ip','times','delay']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
</div>

<div id="PingResult" style="display:none;">
<form method="post" name="pingresult" id="pingresult" action="submit.php" submitwin="ajax">
	<table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2">
    <caption class="nav" id="PingHead">
    	<div><span></span><font id="cmdclose" onclick="Ping_Close(true)">×</font>Ping</div>
    </caption>
    <tr>
      <td align="center" id="cmdbox">
      <textarea name="pingmessage" id="pingmessage"></textarea>
      <input name="php_interface" type="hidden" id="php_interface" value="Tools::getPing" />
      <input name="php_parameter" type="hidden" id="php_parameter" value="[]" />
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" />
    </td>
    </tr>
  </table>
</form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/tool.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>