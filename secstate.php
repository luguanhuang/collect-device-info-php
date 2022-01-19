<?php
#本界面在socket发生错误时不显示错误页面，所以采取以下模式加载页面！！！
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("SafetySet::getSafeStatus",true);
if (!$Ary_Result['state'] && !isset($Ary_Result['result']['socket_state'])){
	$Obj_Frame->load_error($Ary_Result["stateId"],$Ary_Result["message"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安全接入服务状态 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2">
  <caption class="nav">
  <div><span></span>安全接入服务状态</div>
  </caption>
  <?php
  if ($Ary_Result['result']['socket_state']){
  ?>
  <tr>
    <td class="t">连接类型：</td>
    <td class="c"><?=$Ary_Result["result"]['type']?></td>
  </tr>
  <tr>
    <td class="t">IP地址：</td>
    <td class="c"><?=$Ary_Result["result"]['ip']?></td>
  </tr>
  <tr>
    <td class="t">子网掩码：</td>
    <td class="c"><?=$Ary_Result["result"]['mask']?></td>
  </tr>
  <tr>
    <td class="t">广播地址：</td>
    <td class="c"><?=$Ary_Result["result"]['broadcast']?></td>
  </tr>
  <tr>
    <td class="t">首选DNS服务器：</td>
    <td class="c"><?=$Ary_Result["result"]['dns1']?></td>
  </tr>
  <tr>
    <td class="t">备用DNS服务器：</td>
    <td class="c"><?=$Ary_Result["result"]['dns2']?></td>
  </tr>
  <?php }else{?>
  <tr>
    <td colspan="2" class="msg"><div><?=$Ary_Result["message"]?></div></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="2" class="f"><input type="button" onclick="return SecClient_Restart(document.forms.formRestart);" value="重启安全接入服务" class="btn" />
      <input type="button" id="btnrefresh" value="刷新状态" class="btn" onclick="window.location.reload(true);" /></td>
  </tr>
</table>
<form method="post" name="formRestart" id="formRestart" action="submit.php" submitwin="ajax">
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