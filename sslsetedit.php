<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame	= new AtherFrameWork();
$Ary_Result = $Obj_Frame->load_page("NetConfig::getSslSet",$Obj_Frame->load_interargs(),false);

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
<form name="frm" id="frm" action="submit.php" onsubmit="return SslSet_Validate(this);"  submitwin="ajax" method="post">
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
     	 <td  class="f" colspan="2"><input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='sslset.php'"/></td>
      </tr>
      <?php
	  }
	  else{
		  if ($isset){
	  ?>
      <tr>
        <td class="t">远程管理IP和端口：</td>
        <td class="c">
        <select id="serverlist" style="width:260px;" size="10" onchange="GetCurText()">
       	<?php 
 
       	$server=explode(";",$Ary_Result['result']['server']);
        foreach($server as $k => $row)
        {?>
        	<option value="<?=$row?>"><?=$row?>  </option>
        	<?php 
        }
        ?>
        </select><br>
        <input id="_server" name="_server" type="hidden" type="text" class="input" value="<?=$Ary_Result['result']['server']?>"/> <input id="server" name="server" type="hidden" class="input" value="<?=$Ary_Result['result']['server']?>"/>
      	   例如：202.1.10.4:20<br>
         <input id="serveritem" name="serveritem" type="text" class="input" value=""/>
         <input type="button" id="bseleadd" value="添加" class="btn" onclick="InsertItem()"/>
         <input type="button" id="bseledel" value="删除" class="btn" onclick="DeleteItem()"/>
        </td>
      </tr>
      <tr>
        <td class="t">本地端口：</td>
        <td class="c"><input id="_port" name="_port" type="text" class="input" value="<?=$Ary_Result['result']['port']?>" disabled="disabled"/><input id="port" name="port" type="hidden" class="input" value="<?=$Ary_Result['result']['port']?>"/></td>
      </tr>
      <tr>
        <td class="t">本地IP：</td>
        <td class="c"><input id="_interface" name="_interface" type="text" class="input" value="<?=$Ary_Result['result']['interface']?>" /><input id="interface" name="interface" type="hidden" class="input" value="<?=$Ary_Result['result']['interface']?>"/></td>
      </tr>
       <tr>
        <td class="t">SSL类型：</td>
        <td class="c"><input id="_ssltype" name="_ssltype" type="text" class="input" value="<?=$Ary_Result['result']['ssltype']?>" />0:不启用,1:本地ssl,2:peerssl,3:allssl<input id="ssltype" name="ssltype" type="hidden" class="input" value="<?=$Ary_Result['result']['ssltype']?>"/></td>
      </tr>
       <tr>
        <td class="t">检查证书类型：</td>
        <td class="c"><input id="_ccheck" name="_ccheck" type="text" class="input" value="<?=$Ary_Result['result']['ccheck']?>" /> 1: 检查;0:不检查<input id="ccheck" name="ccheck" type="hidden" class="input" value="<?=$Ary_Result['result']['ccheck']?>"/></td>
      </tr>
       <tr>
        <td class="t">是否签名：</td>
        <td class="c"><input id="_stampd" name="_stampd" type="text" class="input" value="<?=$Ary_Result['result']['stampd']?>" />1:登录验证 ;0:不验证<input id="stampd" name="stampd" type="hidden" class="input" value="<?=$Ary_Result['result']['stampd']?>"/></td>
      </tr>
       <tr>
        <td class="t">检查mac地址：</td>
        <td class="c"><input id="_hmac" name="_hmac" type="text" class="input" value="<?=$Ary_Result['result']['hmac']?>" />1:mac检查;0:不检查<input id="hmac" name="hmac" type="hidden" class="input" value="<?=$Ary_Result['result']['hmac']?>"/></td>
      </tr>
       <tr>
        <td class="t">日志认证：</td>
        <td class="c"><input id="_logaudit" name="_logaudit" type="text" class="input" value="<?=$Ary_Result['result']['logaudit']?>" />1:日志认证;0:不验证<input id="logaudit" name="logaudit" type="hidden" class="input" value="<?=$Ary_Result['result']['logaudit']?>"/></td>
      </tr>
       <tr>
        <td class="t">上报日志：</td>
        <td class="c"><input id="_report" name="_report" type="text" class="input" value="<?=$Ary_Result['result']['report']?>" />1:上报日志;0:不上报<input id="report" name="report" type="hidden" class="input" value="<?=$Ary_Result['result']['report']?>"/></td>
      </tr>
      
      <tr>
        <td class="t">超时：</td>
        <td class="c"><input id="_timeout" name="_timeout" type="text" class="input" value="<?=$Ary_Result['result']['timeout']?>" /><input id="timeout" name="timeout" type="hidden" class="input" value="<?=$Ary_Result['result']['timeout']?>"/></td>
      </tr>
      <tr>
        <td class="t">传输类型：</td>
        <td class="c"><input id="_ptype" name="_ptype" type="text" class="input" value="<?=$Ary_Result['result']['ptype']?>" />0:不检查;1:prot检查;3:tds检查<input id="ptype" name="ptype" type="hidden" class="input" value="<?=$Ary_Result['result']['ptype']?>"/></td>
      </tr>
	  <?php }else{?>
       <tr>
        <td class="t">远程管理IP和端口：</td>
        <td class="c">
      <select id="serverlist" style="width:260px;" size="10" onchange="GetCurText()">
        </select>
        <input id="server" name="server" type="hidden" class="input" value=""/> 
               例如：202.1.10.4:20<br>
      <input id="serveritem" name="serveritem" type="text" class="input" value=""/>
         <input type="button" id="bseleadd" value="添加" class="btn" onclick="InsertItem()"/>
         <input type="button" id="bseledel" value="删除" class="btn" onclick="DeleteItem()"/>
          
        </td>
       </tr>
       <tr>
        <td class="t">本地端口：</td>
        <td class="c"><input id="port" name="port" type="text" class="input" value=""/></td>
      </tr>
      <tr>
        <td class="t">本地IP：</td>
        <td class="c"><input id="interface" name="interface" type="text" class="input" value="0.0.0.0"/></td>
      </tr>
       <tr>
        <td class="t">SSL类型：</td>
        <td class="c"><input id="ssltype" name="ssltype" type="text" class="input" value="0"/>0:不启用,1:本地ssl,2:peerssl,3:allssl</td>
      </tr>
       <tr>
        <td class="t">检查证书类型：</td>
        <td class="c"><input id="ccheck" name="ccheck" type="text" class="input" value="0"/>1: 检查;0:不检查</td>
      </tr>
       <tr>
        <td class="t">是否签名：</td>
        <td class="c"><input id="stampd" name="stampd" type="text" class="input" value="0"/>1:登录验证 ;0:不验证</td>
      </tr>
       <tr>
        <td class="t">检查mac地址：</td>
        <td class="c"><input id="hmac" name="hmac" type="text" class="input" value="0"/>1:mac检查;0:不检查</td>
      </tr>
       <tr>
        <td class="t">日志认证：</td>
        <td class="c"><input id="logaudit" name="logaudit" type="text" class="input" value="0"/>1:日志认证;0:不验证</td>
      </tr>
       <tr>
        <td class="t">上报日志：</td>
        <td class="c"><input id="report" name="report" type="text" class="input" value="0"/>1:上报日志;0:不上报</td>
      </tr>
       <tr>
        <td class="t">超时：</td>
        <td class="c"><input id="timeout" name="timeout" type="text" class="input" value="3600"/></td>
      </tr>
       <tr>
        <td class="t">传输类型：</td>
        <td class="c"><input id="ptype" name="ptype" type="text" class="input" value="0"/>0:不检查;1:prot检查;3:tds检查</td>
      </tr>
      <?php }?>
      <tr>
     	 <td  class="f" colspan="2">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="重置" class="btn" />
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='sslset.php'"/>
            </div>
          </td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <input name="limit" id="limit" type="hidden" value="<?=$count?>" maxval="<?=$maxre?>" />
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setSslSet" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','interface','server','ssltype','ccheck','stampd','hmac','logaudit','report','timeout','ptype'],'actstep']" />
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