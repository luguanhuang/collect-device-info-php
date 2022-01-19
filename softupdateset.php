<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getSoftUpdate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>升级配置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return SoftUpdateConf_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>升级配置</div></caption>
    <tr>
      <td class="t">服务器IP：</td>
      <td class="c"><input name="serverip" type="text" class="input" id="serverip" value="<?=$Ary_Result['result']['serverip']?>" /></td>
    </tr>
    <tr>
      <td class="t">端口：</td>
      <td class="c"><input name="port" type="text" class="input" id="port" value="<?=$Ary_Result['result']['port']?>" /></td>
    </tr>
    <tr>
      <td class="t">日志级别：</td>
      <td class="c"><input name="loglevel" type="text" class="input" id="loglevel" value="<?=$Ary_Result['result']['loglevel']?>" /></td>
    </tr>
    <tr>
      <td class="t">日志数量：</td>
      <td class="c"><input name="logcount" type="text" class="input" id="logcount" value="<?=$Ary_Result['result']['logcount']?>" /></td>
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
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setSoftUpdate" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['serverip','port','loglevel','logcount']]" />
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