<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getProxyTicketList");
$Ary_Result2= $Obj_Frame->load_page("NetConfig::get_proxytickets2");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>配置客票代理服务器 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>客票代理列表</div>
  </div>
  <form id="frm" name="frm" action="#">
  <div class="op"><a href="proxytkset.php">添加客票代理</a><a href="submit.php?php_interface=NetConfig::resetProxyTicket&php_parameter=[]&php_returnmode=normal" onclick="return ProxyTicket_Restart(this)" submitwin="ajax">重启客票代理</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="128">本地端口</td>
          <td>客票服务IP和端口</td>
          <td width="148">协议类型</td>
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
          <td><?=$row['server']?><input name="server_<?=$k?>" id="server_<?=$k?>" type="hidden" value="<?=$row['server']?>" /></td>
          <td><?php
          switch ($row['ptype']){
          	case "3":
				echo(" TDS");
				break;
		  	case "1":
				echo(" 客票服务");
				break;
				case "0":
				echo(" 移动售票");
				break;
			default:
				$row['ptype'];
		  }
		  ?><input name="ptype_<?=$k?>" id="ptype_<?=$k?>" type="hidden" value="<?=$row['ptype']?>" />
          </td>
          <td><a href="#" submitwin="_self"  onclick="return ProxyTicket_Seting(<?=$k?>)">修改</a> | <a href="#" submitwin="ajax"  onclick="return ProxyTicket_Delete(<?=$k?>)">删除</a></td>
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
	<input name="ptype" 	id="ptype"  	type="hidden" value="" />
	<input name="php_interface" type="hidden" id="php_interface" value="NetConfig::delProxyTicket" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','server','ptype'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<form id="frm2" name="frm2" action="proxytkset.php" onsubmit="" submitwin="_self" method="get">
	<input name="port" 		id="port" 		type="hidden" value="" />
	<input name="server" 	id="server"		type="hidden" value="" />
	<input name="ptype" 	id="ptype"  	type="hidden" value="" />
	<input name="actstep"	id="actstep" 	type="hidden" value="mod" />
    <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::getProxyTicket" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','server','ptype'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<div class="listwrap">
  <div class="nav">
    <div><span></span>客票代理设置</div>
  </div>
 
  <form id="frmset" name="frmset" action="submit.php" submitwin="ajax"  submitwin="_self"  method="post">
  <div class="op">
   <input type="checkbox" name="log" id="log" value="1" <?php if ($Ary_Result2['result']['dzzf_audit']=='1'){ echo('checked=true');} ?> /><span>记录日志</span>
  <input type="checkbox" name="mobi" id="mobi" value="1" <?php if ($Ary_Result2['result']['stamped']=='1'){ echo(' checked=true'); }?> /><span>验签</span>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setProxyTicket2" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['log','mobi']]" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
    <input type="button" id="btnsave" name="btnsave" value="保存配置" onclick="return ProxyTicket_Set(document.forms.frmset)" class="btn" />
    </div>
 
   </form>
    </div>
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