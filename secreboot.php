<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_popedom("SafetySet::restartSafe",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>重启系统/服务 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form method="post" name="frm" action="submit.php" onsubmit="return SecClient_Restart(this);"  submitwin="ajax">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2">
    <caption class="nav">
    <div><span></span>重启系统</div>
    </caption>
    <tr>
      <td class="msg"><div>重启过程需要一段时间，请耐心等等。</div></td>
    </tr>
    <tr>
      <td class="f2">
        <input type="submit"  value="重启" class="btn"/>
      </td>
    </tr>
  </table>
   <input name="php_interface" type="hidden" id="php_interface" value="SafetySet::restartSafe" />
   <input name="php_parameter" type="hidden" id="php_parameter" value="[]" />
   <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/safetyset.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>