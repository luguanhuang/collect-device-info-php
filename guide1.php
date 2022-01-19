<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getWlanConf");

//1.静态IP
//2.ADSL拨号
//3.DHCP
//4.3G拨号
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>设置向导二 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="guide2.php" method="get">
  <table width="500" align="center" cellpadding="0" cellspacing="0" border="0" class="tab3" style="width:500px;">
    <caption class="nav">
    <div><span></span>设置向导二</div>
    </caption>
    <tr>
      <td align="left" class="chkbox">
      	<div style="padding-top:16px;padding-bottom:12px;">本路由器支持以下三种常用的上网方式，请您根据实际需要进行先择。</div>
        <label><input type="radio" name="wlantype" id="wlantype" value="2" checked/></label>
        <span>&nbsp;ADSL虚拟拨号(PPPoE)</span>
        <br clear="all"/>
        <label><input type="radio" name="wlantype" id="wlantype" value="3"<?php if ($Ary_Result['result']['wlan']=='3'){echo(' checked');}?>/></label>
        <span>&nbsp;以太网宽带，自动从网络服务商获取IP地址(动态IP)</span>
        <br clear="all"/>
        <label><input type="radio" name="wlantype" id="wlantype" value="1"<?php if ($Ary_Result['result']['wlan']=='1'){echo(' checked');}?>/></label>
        <span>&nbsp;以太网宽带，网络服务商提供的固定IP地址(静态IP)</span>
        <br clear="all"/>
        <label><input type="radio" name="wlantype" id="wlantype" value="4"<?php if ($Ary_Result['result']['wlan']=='4'){echo(' checked');}?>/></label>
        <span>&nbsp;3G拨号</span>
        <br clear="all"/></td>
    </tr>
    <tr>
      <td align="center" class="f2"><input type="button" id="btnexit" name="btnexit" value="上一步" class="btn" onclick="window.location.href='guide.php';" />
        <input type="submit" id="btnnext" name="btnnext" value="下一步" class="btn" /></td>
    </tr>
  </table>
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>