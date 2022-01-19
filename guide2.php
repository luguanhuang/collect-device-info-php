<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
global $Ary_List;

$Obj_Frame	= new AtherFrameWork();
//获取当前配置的
if (array_key_exists('wlantype',$_REQUEST)===false){
	$Ary_Result	= $Obj_Frame->load_page("NetConfig::getWlanConf");
}
else{
	$Ary_Result	= $Obj_Frame->load_page("NetConfig::getWlanConf",$_REQUEST['wlantype'],false);
}
//返回菜单选项
$Ary_List	= array(
	'wan'	=> NetConfig::getWlanTypes(),
	'lan'	=> NetConfig::getLanTypes()
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>设置向导三 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body onload="WlanType_SelInitial('<?=$Ary_Result['result']['wlan']?>')">
<bdo id="ConfList" selected="<?=$Ary_Result['result']['wlan']?>">
<?php
if ($Ary_Result['result']['wlan']=="1"){
?>
	<div id="ConfTable1">
	<form name="frm1" id="frm1" action="submit.php" onsubmit="javascript:return WlanConf_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>设置向导三</div>
    </caption>
    <tr>
      <td class="t">WAN类型：</td>
      <td class="c"><select name="wlan" id="wlan" onchange="WlanType_Select(this.value)" indexval="<?=$Ary_Result['result']['wlan']?>">
      		<?php
            foreach($Ary_List['wan'] as $key=>$value){
			?>
            <option value="<?=$key?>"<?php if ($Ary_Result['result']['wlan']==$key){echo(' selected');}?>><?=$value?></option>
          	<?php
			}
		  	?>
      </select></td>
    </tr>
    <tr>
      <td class="t">IP地址：</td>
      <td class="c"><input name="ip" type="text" class="input" id="ip" value="<?=$Ary_Result['result']['ip']?>" /></td>
    </tr>
    <tr>
      <td class="t">子网掩码：</td>
      <td class="c"><input name="mask" type="text" class="input" id="mask" value="<?=$Ary_Result['result']['mask']?>" /></td>
    </tr>
    <tr>
      <td class="t">网关地址：</td>
      <td class="c"><input name="netgate" type="text" class="input" id="netgate" value="<?=$Ary_Result['result']['netgate']?>" /></td>
    </tr> 
    <tr>
      <td class="t">广播地址：</td>
      <td class="c"><input name="broadcast" type="text" class="input" id="broadcast" value="<?=$Ary_Result['result']['broadcast']?>" /></td>
    </tr> 
    <tr>
        <td colspan="2" class="f">
            <input type="button" id="btnrefresh" value="上一步" class="btn" onclick="window.location.href='guide1.php';" /><input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" /><input type="reset" id="btnreset" value="重置" class="btn" />
        </td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setWlanConf" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['wlan','ip','mask','netgate','broadcast']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
  </div>
<?php
}
?>
<?php
if ($Ary_Result['result']['wlan']=="2"){
?>
	<div id="ConfTable2">
   <form name="frm2" id="frm2" action="submit.php" onsubmit="javascript:return WlanConf_Validate(this);"  submitwin="ajax" method="post">
   <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>设置向导三</div>
    </caption>
    <tr>
      <td class="t">WAN类型：</td>
      <td class="c" colspan="2"><select name="wlan" id="wlan" onchange="WlanType_Select(this.value)" indexval="<?=$Ary_Result['result']['wlan']?>">
      		<?php
            foreach($Ary_List['wan'] as $key=>$value){
			?>
            <option value="<?=$key?>"<?php if ($Ary_Result['result']['wlan']==$key){echo(' selected');}?>><?=$value?></option>
          	<?php
			}
		  	?>
      </select></td>
    </tr>
    <tr>
      <td class="t">拨号帐号：</td>
      <td class="c"><input name="user" type="text" class="input" id="user" value="<?=$Ary_Result['result']['user']?>" style="width:150px;"/></td>
      <td rowspan="2" class="gray" align="left">您的ADSL拨号帐号及口令，如<br />
        有疑问请咨询您的网络服务商</td>
    </tr>
    <tr>
      <td class="t">拨号密码：</td>
      <td class="c"><input name="pwd" type="password" class="input" id="pwd" style="width:150px;"/></td>
    </tr>
    <tr>
      <td class="f" colspan="3">
      	<input type="button" id="btnrefresh" value="上一步" class="btn" onclick="window.location.href='guide1.php';" /><input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" /><input type="button" id="DialConnect_2" name="DialConnect_2" value="连接" class="btn btn1" onclick="return Net_dialConnect(this);" dailtype="pppoe" showstate="1" action="submit.php?php_interface=NetConfig::dialPPPOE&php_parameter=[]&php_returnmode=normal" submitwin="ajax" /><input type="button" id="btndisconn" name="btndisconn" value="断开" class="btn btn1" onclick="return Net_disConnect(this);"  action="submit.php?php_interface=NetConfig::offPPPOE&php_parameter=[]&php_returnmode=normal" submitwin="ajax" /></td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setWlanConf" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['wlan','user','pwd']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
  </div>
<?php
}
?>
<?php
if ($Ary_Result['result']['wlan']=="3"){
?>
	<div id="ConfTable3">
    <form name="frm3" id="frm3" action="submit.php" onsubmit="javascript:return WlanConf_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>设置向导三</div>
    </caption>
    <tr>
      <td class="t">WAN类型：</td>
      <td class="c"><select name="wlan" id="wlan" onchange="WlanType_Select(this.value)" indexval="<?=$Ary_Result['result']['wlan']?>">
      		<?php
            foreach($Ary_List['wan'] as $key=>$value){
			?>
            <option value="<?=$key?>"<?php if ($Ary_Result['result']['wlan']==$key){echo(' selected');}?>><?=$value?></option>
          	<?php
			}
		  	?>
      </select></td>
    </tr>
    <tr>
      <td class="f" colspan="2"><input type="button" id="btnrefresh" value="上一步" class="btn" onclick="window.location.href='guide1.php';" /><input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" /><input type="reset" id="btnreset" value="重置" class="btn" /></td>
    </tr>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setWlanConf" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['wlan']]" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
  </div>
<?php
}
?>
<?php
if ($Ary_Result['result']['wlan']=="4"){
?>
	<div id="ConfTable4">
    <form name="frm4" id="frm4" action="submit.php" onsubmit="javascript:return WlanConf_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>设置向导三</div>
    </caption>
    <tr>
      <td class="t">WAN类型：</td>
      <td class="c"><select name="wlan" id="wlan" onchange="WlanType_Select(this.value)" indexval="<?=$Ary_Result['result']['wlan']?>">
      		<?php
            foreach($Ary_List['wan'] as $key=>$value){
			?>
            <option value="<?=$key?>"<?php if ($Ary_Result['result']['wlan']==$key){echo(' selected');}?>><?=$value?></option>
          	<?php
			}
		  	?>
      </select></td>
    </tr>
    <tr>
      <td class="t">3G网卡类型：</td>
      <td class="c"><select name="lantype" id="lantype">
      		<?php
            foreach($Ary_List['lan'] as $k=>$v){
			?>
            <option value="<?=$k?>"<?php if ($Ary_Result['result']['g3type']==$k){echo(' selected');}?>><?=$v?></option>
            <?php
			}
			?>
        </select></td>
    </tr>
    <tr>
      <td class="f" colspan="2">
      	<input type="button" id="btnrefresh" value="上一步" class="btn" onclick="window.location.href='guide1.php';" /><input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" /><input type="reset" id="btnreset" value="重置" class="btn" /><input type="button" id="DialConnect_4" name="DialConnect_4" value="连接" class="btn btn1" onclick="return Net_dialConnect(this);" dailtype="3g" showstate="1" action="submit.php?php_interface=NetConfig::dialPPPOE&php_parameter=[]&php_returnmode=normal" submitwin="ajax" /><input type="button" id="btndisconn" name="btndisconn" value="断开" class="btn btn1" onclick="return Net_disConnect(this);"  action="submit.php?php_interface=NetConfig::offPPPOE&php_parameter=[]&php_returnmode=normal" submitwin="ajax" /></td>
    </tr>
  </table>
	<input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setWlanConf" />
	<input name="php_parameter" type="hidden" id="php_parameter" value="[['wlan','lantype']]" />
	<input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
	</form>
  </div>
  <?php }?>
</bdo>
<form name="frm0" id="frm0" action="?" submitwin="ajax" method="post">
	<input name="wlantype" type="hidden" value="" />
</form>

<div id="AdslResult" style="display:none;">
<form method="post" name="Adslresult" id="Adslresult" action="submit.php" submitwin="ajax">
	<table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2">
    <caption class="nav" id="AdslHead">
    	<div><span></span><font id="cmdclose" onclick="Adsl_Close(true)">×</font>Adsl</div>
    </caption>
    <tr>
      <td align="center" id="cmdbox">
      <textarea name="Adslmessage" id="Adslmessage"></textarea>
      <input name="php_interface" type="hidden" id="php_interface" value="Tools::getAdsl" />
      <input name="php_parameter" type="hidden" id="php_parameter" value="[]" />
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" />
    </td>
    </tr>
  </table>
</form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/netcfg.js"></script>
<script type="text/javascript" src="js/netdial.js"></script>
<?php
unset($Obj_Frame);	$Obj_Frame	= NULL;
unset($Ary_Result);	$Ary_Result	= NULL;
unset($Ary_List);	$Ary_List	= NULL;
?>
</body>
</html>