<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_popedom("BackupRecover::defaultConf",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>恢复出厂配置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Reset_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2">
    <caption class="nav">
    <div><span></span>恢复出厂默认设置</div>
    </caption>
    <tr>
      <td class="msg"><div>
        您可以通过导入的设置档来恢复系统设置，<br />
        如果无法恢复，您可以重设回系统出厂配置。</div></td>
    </tr>
    <tr>
      <td class="f2"><input type="submit" id="btnsave" name="btnsave" value="恢复出厂配置" class="btn" />
      	<input name="php_interface" type="hidden" id="php_interface" value="BackupRecover::defaultConf" />
        <input name="php_parameter" type="hidden" id="php_parameter" value="[]" />
        <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
      </td>
    </tr>
  </table>
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/backuprecover.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>