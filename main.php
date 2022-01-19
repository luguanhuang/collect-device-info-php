<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "Station",0);
TLOG_MSG("Station: func begin");
$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("Station::getStationList");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>station configure - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>device list</div>
  </div>
  <form id="frm" name="frm" action="submit.php" onsubmit="" submitwin="ajax" method="post">
  <input id="id" name="id" type="hidden" value="" />
  <input id="macid" name="macid" type="hidden" value="" />
  <input id="user" name="user" type="hidden" value="" />
  <input name="ptype" id="ptype"  type="hidden" value=""/>
  <input name="servip" id="servip"  type="hidden" value=""/>
  <input name="servport" id="servport"  type="hidden" value=""/>
  <input name="actstep"  id="actstep" type="hidden" value="del" />
  <div class="op"><a href="stationadd.php">add station</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>macid</td>
          <td>user</td>
          <td>ptype</td>
          <td>servip</td>
          <td>servport</td>
		  <td>retry</td>
		  <td>timeout</td>
		  <td>polltime</td>
		  <td>connected</td>
		  <td>active</td>
          <td width="120">operate</td>
        </tr>
      </thead>
      <tbody>
      	<?php
        if (is_array($Ary_Result['result'])){
			foreach($Ary_Result['result'] as $k => $row){
				$k = $row['id'];
		?>
        <tr align="center" id="row_<?=$k?>">
          <td><?php
		   echo($row['macid']); 
		  ?><input name="macid_<?=$k?>" id="macid_<?=$k?>" type="hidden" value="<?=$row['macid']?>" /></td>
          <td><?=$row['user']?><input name="user_<?=$k?>" id="user_<?=$k?>" type="hidden" value="<?=$row['user']?>" /></td>
          <td><?=$row['ptype']?><input name="ptype_<?=$k?>" id="ptype_<?=$k?>" type="hidden" value="<?=$row['ptype']?>" /></td>
          <td><?=$row['servip']?><input name="servip_<?=$k?>" id="servip_<?=$k?>" type="hidden" value="<?=$row['servip']?>" /></td>
          <td><?php echo($row['servport']);?><input name="servport_<?=$k?>" id="servport_<?=$k?>" type="hidden" value="<?=$row['servport']?>" /></td>
		  <td><?php echo($row['retry']);?><input name="retry_<?=$k?>" id="retry_<?=$k?>" type="hidden" value="<?=$row['retry']?>" /></td>
		  <td><?php echo($row['timeout']);?><input name="timeout_<?=$k?>" id="timeout_<?=$k?>" type="hidden" value="<?=$row['timeout']?>" /></td>
		  <td><?php echo($row['polltime']);?><input name="polltime_<?=$k?>" id="polltime_<?=$k?>" type="hidden" value="<?=$row['polltime']?>" /></td>
		  <td><?php echo($row['connected']);?><input name="connected_<?=$k?>" id="connected_<?=$k?>" type="hidden" value="<?=$row['connected']?>" /></td>
		  <td><?php if ($row['active']=="1") echo('active');
					else echo('deactive'); ?><input name="active_<?=$k?>" id="active_<?=$k?>" type="hidden" value="<?=$row['active']?>" /></td>
          <td><a href="routeedit.html">modify</a> | <a href="#" onclick="return Route_Delete(<?=$k?>)">delete</a></td>
        </tr>
        <?php }
		}
		?>
      </tbody>
      <!--
      <tfoot>
        <tr>
          <td colspan="6"><div class="page">共95条记录 第1/4页   第 1 2 3 4 页 下一页 末页</div></td>
        </tr>
      </tfoot>
      -->
    </table>
    <input name="php_interface" type="hidden" id="php_interface" value="Router::setRoute" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['id'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/route.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>