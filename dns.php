<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getDNS");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNS设置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return DSNConf_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>DNS设置</div></caption>
    <tr>
      <td class="t">首选DNS服务器：</td>
      <td class="c"><input name="dns1" type="text" class="input" id="dns1" value="<?=$Ary_Result['result']['dns1']?>" /></td>
    </tr>
    <tr>
      <td class="t">备用DNS服务器：</td>
      <td class="c"><input name="dns2" type="text" class="input" id="dns2" value="<?=$Ary_Result['result']['dns2']?>" /></td>
    </tr>
    <tr>
        <td colspan="2" class="f">
      		<div class="left130">
            	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
                <input type="reset" id="btnreset" value="重置" class="btn" />
            </div>
        </td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setDNS" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['dns1','dns2']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/netcfg.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>