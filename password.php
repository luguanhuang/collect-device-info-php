<?php
require("services/UserManager.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new UserManager();
$Ary_Result= $Obj_Frame->user_popedom(true);
$Ary_Result= $Obj_Frame->_userdb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改用户密码 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form method="post" name="frm" action="submit.php" onsubmit="javascript:return setPassword_Validate(this);"  submitwin="ajax">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>修改密码</div></caption>    
    <tr>
      <td class="t">用户名：</td>
      <td class="c"><?=$Ary_Result['user']?></td>
    </tr>
    <tr>
      <td class="t">原密码：</td>
      <td class="c"><input id="oldpass" name="oldpass" type="password" class="input" /></td>
    </tr>
    <tr>
      <td class="t">新密码：</td>
      <td class="c"><input id="newpass" name="newpass" type="password" class="input" /></td>
    </tr>
    <tr>
      <td class="t">确认新密码：</td>
      <td class="c"><input id="renewpass" name="renewpass" type="password" class="input" /></td>
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
  <input name="php_interface" type="hidden" id="php_interface" value="UserManager::setPassword" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['oldpass','newpass']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/usermanager.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>