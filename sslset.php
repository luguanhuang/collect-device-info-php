<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getsslsetlist");
$Ary_Result2= $Obj_Frame->load_page("NetConfig::get_ssltickets");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>配置ssl服务器 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>配置ssl管理列表</div>
  </div>
  <form id="frm" name="frm" action="#">
  <div class="op"><a href="sslsetedit.php">添加配置ssl管理</a><a href="submit.php?php_interface=NetConfig::resetSslSet&php_parameter=[]&php_returnmode=normal" onclick="return SslSet_Restart(this)" submitwin="ajax">重启SSL管理</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="128">本地端口</td>
           <td>本地IP</td>
          <td>远程管理IP和端口</td>
           <td>SSL类型</td>
            <td>检查证书类型</td>
             <td>是否签名</td>
              <td>检查mac地址</td>
               <td>日志认证</td>
                <td>上报日志</td>
                <td>超时</td>
                <td>传输类型</td>
          <td width="128">操作</td>
        </tr>
      </thead>
      <tbody>
      	<?php
        if (is_array($Ary_Result['result'])){
			foreach($Ary_Result['result'] as $k => $row){
		?>
        <tr align="center" id="row_<?=$k?>">
          <td><?=$row['port']?><input name="port_<?=$k?>" id="port_<?=$k?>" type="hidden" value="<?=$row['port']?>" /></td>
           <td><?=$row['interface']?><input name="interface_<?=$k?>" id="interface_<?=$k?>" type="hidden" value="<?=$row['interface']?>" /></td>
          <td title="<?=str_replace(";","\n\r",$row['server'])?>"><?=substr($row['server'],0,10)."..."?><input name="server_<?=$k?>" id="server_<?=$k?>" type="hidden" value="<?=$row['server']?>" /></td>
           <td><?=($row['ssltype']=="0"? "不启用":($row['ssltype']=="1"? "本地ssl":($row['ssltype']=="2"?"peerssl":"allssl"))) ?><input name="ssltype_<?=$k?>" id="ssltype_<?=$k?>" type="hidden" value="<?=$row['ssltype']?>" /></td>
            <td><?=$row['ccheck']=="1"? "检查":"不检查" ?><input name="ccheck_<?=$k?>" id="ccheck_<?=$k?>" type="hidden" value="<?=$row['ccheck']?>" /></td>
             <td><?=$row['stampd']=="1"? "登录验证":"不验证" ?><input name="stampd_<?=$k?>" id="stampd_<?=$k?>" type="hidden" value="<?=$row['stampd']?>" /></td>
              <td><?=$row['hmac']=="1"? "mac检查":"不检查" ?><input name="hmac_<?=$k?>" id="hmac_<?=$k?>" type="hidden" value="<?=$row['hmac']?>" /></td>
               <td><?=$row['logaudit']=="1"? "日志认证":"不验证" ?><input name="logaudit_<?=$k?>" id="logaudit_<?=$k?>" type="hidden" value="<?=$row['logaudit']?>" /></td>
                <td><?=$row['report']=="1"? "上报日志":"不上报" ?><input name="report_<?=$k?>" id="report_<?=$k?>" type="hidden" value="<?=$row['report']?>" /></td>
                 <td><?=$row['timeout']?><input name="timeout_<?=$k?>" id="timeout_<?=$k?>" type="hidden" value="<?=$row['timeout']?>" /></td>
                  <td><?=($row['ptype'] =="0"? "不加密":($row['ptype'] =="1"?"ticket加密协议":"tds协议")) ?><input name="ptype_<?=$k?>" id="ptype_<?=$k?>" type="hidden" value="<?=$row['ptype']?>" /></td>
          <td><a href="#" submitwin="_self"  onclick="return SslSet_Seting(<?=$k?>)">修改</a> | <a href="#" submitwin="ajax"  onclick="return SslSet_Delete(<?=$k?>)">删除</a></td>
        </tr>
        <?php
			}
		}
		?>
      </tbody>
      <!--
      <tfoot>
        <tr>
          <td colspan="5"><div class="page">共95条记录 第1/4页   第 1 2 3 4 页 下一页 末页</div></td>
        </tr>
      </tfoot>
      -->
    </table>
  </form>
</div>
<form id="frm1" name="frm1" action="submit.php" onsubmit="" submitwin="ajax" method="post">
	<input name="port" 		id="port" 		type="hidden" value="" />
	<input name="server" 	id="server"		type="hidden" value="" />
	<input name="php_interface" type="hidden" id="php_interface" value="NetConfig::delSslSet" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','interface','server','ssltype','ccheck','stampd','hmac','logaudit','report','timeout','ptype'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<form id="frm2" name="frm2" action="sslsetedit.php" onsubmit="" submitwin="_self" method="get">
	<input name="port" 		id="port" 		type="hidden" value="" />
	<input name="server" 	id="server"		type="hidden" value="" />
	<input name="actstep"	id="actstep" 	type="hidden" value="mod" />
    <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::getSslSet" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','interface','server','ssltype','ccheck','stampd','hmac','logaudit','report','timeout','ptype'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
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

<div class="listwrap">
  <div class="nav">
    <div><span></span>SSL日志设置</div>
  </div>
 
  <form id="frmset" name="frmset" action="submit.php" submitwin="ajax"  submitwin="_self"  method="post">
  <div class="op">日志级别
  <select id="log" onchange="document.getElementById('loglevel').value=this.value">
       <option value="1" <?=$Ary_Result2['result']['loglevel']=="1"?"selected":""?>>1</option>
       <option  value="2" <?=$Ary_Result2['result']['loglevel']=="2"?"selected":""?>>2</option>
       <option  value="3" <?=$Ary_Result2['result']['loglevel']=="3"?"selected":""?>>3</option>
       <option  value="4" <?=$Ary_Result2['result']['loglevel']=="4"?"selected":""?>>4</option>
       <option  value="5" <?=$Ary_Result2['result']['loglevel']=="5"?"selected":""?>>5</option>
   </select>
        <input name="loglevel" type="hidden" id="loglevel" value="<?=$Ary_Result2['result']['loglevel']?>" />
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setsslTicket" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['loglevel']]" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
    <input type="button" id="btnsave" name="btnsave" value="保存配置" onclick="return ProxyTicket_Set(document.forms.frmset)" class="btn" />
    </div>
 
   </form>
    </div>
</body>
</html>