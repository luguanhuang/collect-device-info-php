<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_popedom(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Telnet - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div id="TelnetSend">
<form method="post" name="telnetsend" id="telnetsend" action="submit.php" onsubmit="javascript:return Telnet_Validate(this);"  submitwin="ajax">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>Telnet测试</div>
    </caption>
    <tr>
      <td class="t">目标IP：</td>
      <td class="c"><input id="ip" name="ip" type="text" class="input" /></td>
    </tr>
    <tr>
      <td class="t">端口号：</td>
      <td class="c"><input id="port" name="port" type="text" class="input" /></td>
    </tr>
    <tr>
      <td  class="f" colspan="2">
      	<div class="left130">
        	<input type="submit" id="telnetstart" name="telnetstart" value="开始Telnet" class="btn"/>
        </div>
      </td>
    </tr>
  </table>
      <input name="php_interface" type="hidden" id="php_interface" value="Tools::sendTelnet" />
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['ip','port']]" />
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" />
</form>
</div>

<div id="TelnetResult" style="display:none;">
<form method="post" name="telnetresult" id="telnetresult" action="submit.php" submitwin="ajax">
	<table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2">
    <caption class="nav" id="TelnetHead">
    	<div><span></span><font id="cmdclose" onclick="Telnet_Close()">×</font>Telnet</div>
    </caption>
    <tr>
      <td align="center" id="cmdbox"><textarea name="telnetmessage" id="telnetmessage"></textarea></td>
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