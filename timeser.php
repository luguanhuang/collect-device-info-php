<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("ServerConf::getVerifyConfig");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>校时服务器设置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return TimeSer_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>校时服务器设置</div></caption>
    <tr>
      <td class="t">校时服务器IP地址：</td>
      <td class="c"><input id="ip" name="ip" type="text" class="input" value="<?=$Ary_Result['result']?>"/></td>
    </tr>
    <tr>
    	<td  class="f" colspan="2">
      		<div class="left130">
            <input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
        	<input type="button" id="btnrefresh" value="刷新" class="btn" onclick="window.location.reload(true);" />
            </div>
        </td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="ServerConf::setVerifyConfig" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['ip']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/servercfg.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>