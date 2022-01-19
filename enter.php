<?php require("services/Config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>user login - <?=_GLO_PROJECT_FNAME_?></title>
    <link type="text/css" rel="stylesheet" href="css.css"></head>
  <body scroll="no" style="background: #00a099; overflow: hidden;">
    <div class="login-bg"></div>
    <div class="title" style="font-size:50px;color:white;margin-top:-200px">Axitech Cloud Platform Login</div>
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Login_Validate(this);" submitwin="ajax" method="post">
      <table id="tablogin" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="nav" id="login-nav" style="padding: 25px 0 10px 0;">system login</td>
        </tr>
        <tr>
          <td align="center">
            <label class="username" for="username"><img src="images/account.png" title="username"></label>
            <input class="input input-h" id="username" type="text" name="username" placeholder="username" tabindex="1" autocomplete="off">
<!--             <input class="input input-h" id="username" type="text" name="username" placeholder="用户名" tabindex="1" autocomplete="off" value="用户名" onFocus="if(this.value=='用户名') this.value = ''" onBlur="if(this.value=='') this.value='用户名'"> -->
          </td>
        </tr>
    <tr>
          <td align="center">
            <label class="password" for="password"><img src="images/password.png" title="password"></label>
            <input class="input input-h" id="password" type="password" name="password" tabindex="2" placeholder="password"></td>
        </tr>
    <?php if (_GLO_USER_LOGIN_VCODE_){?>
        <tr>
          <td align="center">
            <div class="vcode-input">
              <label class="vcode" for="vcode"><img src="images/vcode.png" title="验证码"></label>
              <input class="input" id="vcode" type="text" placeholder="验证码" name="vcode" tabindex="3" autocomplete="off" title="请输入右图中的文字">
            </div>
            <img id="rndimg" style="cursor: pointer;" src="vcode.php" name="rndimg" align="absmiddle" title="点击换一张" onclick="this.src=this.src+'?'+Math.random();">
          </td>
        </tr>
    <?php }?>
        <tr>
      <td align="center" colspan="2">
      	<div class="btn-position">
      	<input type="submit" name="cmdlogin" id="cmdlogin" value="login" tabindex="4" class="btn btn-log"/>
        <input type="reset" name="btnreset" id="btnreset" value="reset" tabindex="5" class="btn btn-res" />
        </div>
        </td>
    </tr>
  </table>
      <input name="php_interface" type="hidden" id="php_interface" value="UserManager::login">
      <input name="php_parameter" type="hidden" id="php_parameter" value="['username','password','vcode']">
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" /></form>
<?php
require('loadjs.html');
?>
<script type="text/javascript" src="js/enter.js"></script>
<script type="text/javascript" src="js/png-hack.js"></script>
</body>
</html>