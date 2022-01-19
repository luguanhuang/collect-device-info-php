<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "dhcp",0);
TLOG_MSG("dhcp: func begin");

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("DHCPService::getDHCP");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DHCP服务 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return DHCPConf_Validate(this);"  submitwin="ajax" method="post">
	<table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>DHCP服务</div></caption>
		<tr>
        	<td class="t">DHCP服务：</td>
            <td class="c chkbox"><label><input type="radio" name="dhcpsvr" id="dhcpsvr" value="1"<?php if ($Ary_Result['result']['dhcpsvr']=="1"){echo(' checked');} ?> onclick="DHCPConf_Switch(this.form,this.value)"/></label><span>启用</span>
          <label><input type="radio" name="dhcpsvr" id="dhcpsvr" value="0"<?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' checked');} ?> onclick="DHCPConf_Switch(this.form,this.value)"/></label><span>禁用</span><br clear="all" /></td>
       </tr>
       <tr>
          <td class="t">监听：</td>
          <td class="c"><input name="_listen" type="text" class="input" id="_listen" value="<?=$Ary_Result['result']['listen']?>"<?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' disabled');} ?>/><input name="listen" type="hidden" value="<?=$Ary_Result['result']['listen']?>" /></td>
        </tr>
        <tr>
          <td class="t">IP范围(最小值)：</td>
          <td class="c"><input name="_minip" type="text" class="input" id="_minip" value="<?=$Ary_Result['result']['minip']?>" <?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' disabled');} ?>/><input name="minip" type="hidden" value="<?=$Ary_Result['result']['minip']?>" /></td>
        </tr>
        <tr>
          <td class="t">IP范围(最大值)：</td>
          <td class="c"><input name="_maxip" type="text" class="input" id="_maxip" value="<?=$Ary_Result['result']['maxip']?>" <?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' disabled');} ?>/><input name="maxip" type="hidden" value="<?=$Ary_Result['result']['maxip']?>" /></td>
        </tr>
        <tr>
          <td class="t">路由：</td>
          <td class="c"><input name="_router" type="text" class="input" id="_router" value="<?=$Ary_Result['result']['router']?>" <?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' disabled');} ?>/><input name="router" type="hidden" value="<?=$Ary_Result['result']['router']?>" /></td>
        </tr>
        <tr>
          <td class="t">首选DNS服务器：</td>
          <td class="c"><input name="_dns1" type="text" class="input" id="_dns1" value="<?=$Ary_Result['result']['dns1']?>" <?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' disabled');} ?>/><input name="dns1" type="hidden" value="<?=$Ary_Result['result']['dns1']?>" /></td>
        </tr>
        <tr>
          <td class="t">备用DNS服务器：</td>
          <td class="c"><input name="_dns2" type="text" class="input" id="_dns2" value="<?=$Ary_Result['result']['dns2']?>" <?php if ($Ary_Result['result']['dhcpsvr']=="0"){echo(' disabled');} ?>/><input name="dns2" type="hidden" value="<?=$Ary_Result['result']['dns2']?>" /></td>
        </tr>
        <tr>
        <td colspan="2" class="f">
      		<div class="left130">
            <input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="刷新" class="btn" onclick="window.location.reload(true)"/>
            </div>
            </td>
		</tr>
	</table>
    <input name="php_interface" type="hidden" id="php_interface" value="DHCPService::setDHCP" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['listen','minip','maxip','router','dns1','dns2'],'dhcpsvr']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/dhcp.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>