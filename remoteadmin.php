<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getRemoteAdminList");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>配置远程管理服务器 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>远程管理列表</div>
  </div>
  <form id="frm" name="frm" action="#">
  <div class="op"><a href="remoteadmset.php">添加远程管理</a><a href="submit.php?php_interface=NetConfig::resetRemoteAdmin&php_parameter=[]&php_returnmode=normal" onclick="return RemoteAdmin_Restart(this)" submitwin="ajax">重启远程管理</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="128">本地端口</td>
          <td>远程管理IP和端口</td>
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
          <td><a href="#" submitwin="_self"  onclick="return RemoteAdmin_Seting(<?=$k?>)">修改</a> | <a href="#" submitwin="ajax"  onclick="return RemoteAdmin_Delete(<?=$k?>)">删除</a></td>
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
	<input name="php_interface" type="hidden" id="php_interface" value="NetConfig::delRemoteAdmin" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','server'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<form id="frm2" name="frm2" action="remoteadmset.php" onsubmit="" submitwin="_self" method="get">
	<input name="port" 		id="port" 		type="hidden" value="" />
	<input name="server" 	id="server"		type="hidden" value="" />
	<input name="actstep"	id="actstep" 	type="hidden" value="mod" />
    <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::getRemoteAdmin" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['port','server'],'actstep']" />
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
</body>
</html>