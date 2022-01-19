<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getLanIP");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LAN口设置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return LanConf_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>LAN口设置</div></caption>
    <!--
     <tr>
      <td class="t">MAC地址：</td>
      <td class="c"><span id="lbmac"></span></td>
    </tr>
    -->
    <tr>
      <td class="t">IP地址：</td>
      <td class="c"><input name="ip" type="text" class="input" id="ip" value="<?=$Ary_Result['result']['ip']?>" /></td>
    </tr>
    <tr>
      <td class="t">子网掩码：</td>
      <td class="c"><input name="mask" type="text" class="input" id="mask" value="<?=$Ary_Result['result']['mask']?>" /></td>
    </tr>
    <!--
    <tr>
      <td class="t">默认网关：</td>
      <td class="c"><input name="netgate" type="text" class="input" id="netgate" value="<?=$Ary_Result['result']['netgate']?>" /></td>
    -->
    </tr>
    <tr>
      <td class="t">广播地址：</td>
      <td class="c"><input name="broadcast" type="text" class="input" id="broadcast" value="<?=$Ary_Result['result']['broadcast']?>" /></td>
    </tr>
    <tr>
      <td  class="f" colspan="2">
      	<div class="left130">
        <input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
        <input type="reset" id="btnreset" value="重置" class="btn" />
        </div>
        </td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setLanIP" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['ip','mask','netgate','broadcast']]" />
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