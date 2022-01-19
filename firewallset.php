<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->user_popedom("FireWall::setFirewallRule",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>设置防火墙规则 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return FireWall_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>设置防火墙规则</div>
    </caption>
    <tbody>
      <tr>
        <td class="t">源端口：</td>
        <td class="c"><input id="sport" name="sport" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">源IP：</td>
        <td class="c"><input id="sip" name="sip" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">源子网掩码：</td>
        <td class="c"><input name="smask" type="text" class="input" id="smask" value="<?=AtherFrameWork::_STR_MASK_DEF_?>" /></td>
      </tr>
      <tr>
        <td class="t">源MAC地址：</td>
        <td class="c"><input name="smac" type="text" class="input" id="smac" value="" /></td>
      </tr>
      <tr>
        <td class="t">目标端口：</td>
        <td class="c"><input id="dport" name="dport" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">目标IP：</td>
        <td class="c"><input id="dip" name="dip" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">目标子网掩码：</td>
        <td class="c"><input id="dmask" name="dmask" type="text" class="input" value="<?=AtherFrameWork::_STR_MASK_DEF_?>"/></td>
      </tr>
      <tr>
        <td class="t">规则链：</td>
        <td class="c"><select id="link" name="link" size="1">
            <option value="INPUT">输入</option>
            <!--<option value="FORWARD">转发</option>-->
        </select></td>
      </tr>
      <tr>
        <td class="t">动作：</td>
        <td class="c"><select id="action" name="action" size="1">
            <option value="ACCEPT">接受</option>
            <!--<option value="DROP">丢弃</option>-->
        </select></td>
      </tr>
      <tr>
        <td class="t">协议类型：</td>
        <td class="c"><select id="ptype" name="ptype" size="1">
            <option value="all">所有</option>
            <?php
            $ary_pro = explode(",",AtherFrameWork::_STR_PROTOCOL_ALL_);
			array_shift($ary_pro);
			foreach($ary_pro as $key=>$value){echo('<option value="'. $value .'">'. $value .'</option>');}
			unset($ary_pro); $ary_pro = NULL;
			?>
        </select></td>
      </tr>
      <tr>
        <td colspan="2" class="f">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="重置" class="btn" />
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='firewallrule.php'"/>
            </div>
        </td>
      </tr>
    </tbody>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="FireWall::setFirewallRule" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['sport','sip','smask','smac','dport','dip','dmask','link','action','ptype']]" />
   <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/firewall.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>