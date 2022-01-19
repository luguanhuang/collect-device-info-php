<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_popedom("Router::setRoute",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加路由 - <?=_GLO_PROJECT_FNAME_?>
</title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Route_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>添加路由</div>
    </caption>
    <tbody>
      <tr>
        <td class="t">路由类型：</td>
        <td class="c"><select id="type" name="type" size="1">
            <option value="net">网络</option>
            <option value="host">主机</option>
          </select></td>
      </tr>
      <tr>
        <td class="t">网段：</td>
        <td class="c"><input id="ip" name="ip" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">子网掩码：</td>
        <td class="c"><input id="mask" name="mask" type="text" class="input" value="<?=AtherFrameWork::_STR_MASK_DEF_?>"/></td>
      </tr>
      <tr>
        <td class="t">网关地址：</td>
        <td class="c"><input id="netgate" name="netgate" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">接口名称：</td>
        <td class="c"><select id="ifname" name="ifname" size="1">
            <option value="sw">内网</option>
            <option value="eth0">外网</option>
          </select></td>
      </tr>
      <tr>
     	 <td  class="f" colspan="2">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="重置" class="btn" />
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='route.php'"/>
            </div>
        </td>
      </tr>
    </tbody>
  </table>
   <input name="actstep"  id="actstep" type="hidden" value="add" />
   <input name="php_interface" type="hidden" id="php_interface" value="Router::setRoute" />
   <input name="php_parameter" type="hidden" id="php_parameter" value="[['ip','type','mask','netgate','ifname'],'actstep']" />
   <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/route.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>