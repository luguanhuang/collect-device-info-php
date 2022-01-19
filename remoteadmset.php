<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame	= new AtherFrameWork();
$Ary_Result = $Obj_Frame->load_page("NetConfig::getRemoteAdmin",$Obj_Frame->load_interargs(),false);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$Ary_Result['result']['title']?> - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<?php
$isset	= strtolower($Ary_Result['result']['step'])=="mod";
$count	= $Ary_Result['result']['count'];
$maxre	= _GLO_REMOTEADMIN_MAX_;
?>
<form name="frm" id="frm" action="submit.php" onsubmit="return RemoteAdmin_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span><?=$Ary_Result['result']['title']?></div>
    </caption>
    <tbody>
    <?php if (!$isset && $count>=$maxre){?>
      <tr>
      	<td class="msg" colspan="2"><div>最多只能添加 <b><?=_GLO_REMOTEADMIN_MAX_?></b> 个远程管理服务器，<br />
      	  当前配置达到上限，不能再添加服务器。</div></td>
      </tr>
      <tr>
     	 <td  class="f" colspan="2"><input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='remoteadmin.php'"/></td>
      </tr>
      <?php
	  }
	  else{
		  if ($isset){
	  ?>
      <tr>
        <td class="t">远程管理IP和端口：</td>
        <td class="c"><input id="server" name="server" type="text" class="input" value="<?=$Ary_Result['result']['server']?>"/> 例如：202.1.10.4:20</td>
      </tr>
      <tr>
        <td class="t">本地端口：</td>
        <td class="c"><input id="_port" name="_port" type="text" class="input" value="<?=$Ary_Result['result']['port']?>" disabled="disabled"/><input id="port" name="port" type="hidden" class="input" value="<?=$Ary_Result['result']['port']?>"/></td>
      </tr>
	  <?php }else{?>
       <tr>
        <td class="t">远程管理IP和端口：</td>
        <td class="c"><input id="server" name="server" type="text" class="input" value=""/> 例如：202.1.10.4:20</td>
       </tr>
       <tr>
        <td class="t">本地端口：</td>
        <td class="c"><input id="port" name="port" type="text" class="input" value=""/></td>
      </tr>
      <?php }?>
      <tr>
     	 <td  class="f" colspan="2">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="重置" class="btn" />
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='remoteadmin.php'"/>
            </div>
          </td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <input name="limit" id="limit" type="hidden" value="<?=$count?>" maxval="<?=$maxre?>" />
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setRemoteAdmin" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','server'],'actstep']" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  <input name="actstep" id="actstep" type="hidden" value="<?=$Ary_Result['result']['step']?>" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/netcfg.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>