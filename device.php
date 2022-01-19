<?php
require("services/AtherFrameWork.php");
require("services/Config.php");
global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "Device",0);
TLOG_MSG("Device: func begin");
$Obj_Frame = new AtherFrameWork();

error_reporting(0);
session_start();
$Int_Report	= ini_get('error_reporting');
error_reporting($Int_Report);
$tmp = &$_SESSION[_GLO_SESSION_USERINFO_]['userinfo'];
$user = &$_SESSION[_GLO_SESSION_USERINFO_]['username'];

$param = @FuncExt::getnumber('page');
$param.=",";
$param.=$tmp;

$Ary_Result= $Obj_Frame->load_page("Station::getDeviceList",$param,false);
$Ary_Params	= $Ary_Result['result']['pagequery'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Grpup configure - <?=_GLO_PROJECT_FNAME_?></title>
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
  <div class="op"><a href="deviceadd.php">add device</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
		  <td>macid</td>
          <td>devname</td>
		  <td>ptype</td>
          <td>servip</td>
		  <td>servport</td>
          <td>retry</td>
		  <td>timeout</td>
          <td>polltime</td>
          <td>companyname</td>
          <td>groupname</td>
		  <td>stationname</td>
		  <td>devicedesc</td>
		  <td>templatelocation</td>
		  <td>socktype</td>
          <td>status</td>
          <td>operate</td>
        </tr>
      </thead>
      <tbody>
      	<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				$k = $row['id'];
		?>
        <tr align="center" id="row_<?=$k?>">
		<td><?php echo($row['macid']); ?><input name="macid_<?=$k?>" id="macid_<?=$k?>" type="hidden" value="<?=$row['macid']?>" /></td>
		<td><?php echo($row['devname']); ?><input name="devname_<?=$k?>" id="devname_<?=$k?>" type="hidden" value="<?=$row['devname']?>" /></td>
		<td><?php echo($row['ptypename']); ?><input name="ptype_<?=$k?>" id="ptype_<?=$k?>" type="hidden" value="<?=$row['ptype']?>" /></td>
		<td><?php echo($row['servip']); ?><input name="servip_<?=$k?>" id="servip_<?=$k?>" type="hidden" value="<?=$row['servip']?>" /></td>
		<td><?php echo($row['servport']); ?><input name="servport_<?=$k?>" id="servport_<?=$k?>" type="hidden" value="<?=$row['servport']?>" /></td>
		<td><?php echo($row['retry']); ?><input name="retry_<?=$k?>" id="retry_<?=$k?>" type="hidden" value="<?=$row['retry']?>" /></td>
		<td><?php echo($row['timeout']); ?><input name="timeout_<?=$k?>" id="timeout_<?=$k?>" type="hidden" value="<?=$row['timeout']?>" /></td>
		<td><?php echo($row['polltime']); ?><input name="polltime_<?=$k?>" id="polltime_<?=$k?>" type="hidden" value="<?=$row['polltime']?>" /></td>
		<td><?php echo($row['companyname']); ?><input name="companyname_<?=$k?>" id="companyname_<?=$k?>" type="hidden" value="<?=$row['company_id']?>" /></td>
		<td><?php echo($row['groupname']); ?><input name="groupname_<?=$k?>" id="groupname_<?=$k?>" type="hidden" value="<?=$row['group_id']?>" /></td>
		<td><?php echo($row['stationname']); ?><input name="stationname_<?=$k?>" id="stationname_<?=$k?>" type="hidden" value="<?=$row['station_id']?>" /></td>
		<td><?php echo($row['devicedesc']); ?><input name="devicedesc_<?=$k?>" id="devicedesc_<?=$k?>" type="hidden" value="<?=$row['devicedesc']?>" /></td>
		<td><?php echo($row['templatelocation']); ?><input name="templatelocation_<?=$k?>" id="templatelocation_<?=$k?>" type="hidden" value="<?=$row['templatelocation']?>" /></td>
		<td><?php echo($row['socktype']); ?><input name="socktype_<?=$k?>" id="socktype_<?=$k?>" type="hidden" value="<?=$row['socktype']?>" /></td>
		  <td><?php if ($row['active']=="1") echo('active');
					else echo('deactive'); ?><input name="status_<?=$k?>" id="status_<?=$k?>" type="hidden" value="<?=$row['active']?>" /></td>
          <td><a href="#" submitwin="_self"  onclick="return Device_Seting(<?=$k?>)">modify</a> | <a href="#" onclick="return Company_Delete(<?=$k?>)">delete</a></td>
		  
		  <input name="pic1filelocation_<?=$k?>" id="pic1filelocation_<?=$k?>" type="hidden" value="<?=$row['pic1filelocation']?>" />
		  <input name="pic2filelocation_<?=$k?>" id="pic2filelocation_<?=$k?>" type="hidden" value="<?=$row['pic2filelocation']?>" />
		  <input name="pic3filelocation_<?=$k?>" id="pic3filelocation_<?=$k?>" type="hidden" value="<?=$row['pic3filelocation']?>" />
		  <input name="pic4filelocation_<?=$k?>" id="pic4filelocation_<?=$k?>" type="hidden" value="<?=$row['pic4filelocation']?>" />
		  <input name="mainpagediv_<?=$k?>" id="mainpagediv_<?=$k?>" type="hidden" value="<?=$row['mainpagediv']?>" />
		  
        </tr>
        <?php }
		}
		?>
      </tbody>
	  <tfoot>
        <tr>
          <td colspan="16"><div class="page">
	  <?php
		  echo("total ".$Ary_Result['result']['recordcount']." records&nbsp;&nbsp;");
		  echo("".$Ary_Result['result']['absolutepage']."/". $Ary_Result['result']['pagecount'] ." page&nbsp;&nbsp;");
		  if ($Ary_Result['result']['pagecount']>0){
			  if ($Ary_Result['result']['absolutepage']>1){
				  echo('<a href="?page='. $Ary_Result['result']['previouspage'] .'">last page</a>&nbsp;');
			  }
			  echo('the&nbsp;');
			  for($p=$Ary_Result['result']['startpage'];$p<$Ary_Result['result']['endpage']+1;$p++){
				  if ($p==$Ary_Result['result']['absolutepage']){echo('<u>'.$p.'</u>&nbsp;');}
				  else{echo('<a href="?page='.$p.'">'. $p .'</a>&nbsp;');}
			  }
			  echo(' page');
			  if ($Ary_Result['result']['absolutepage']<$Ary_Result['result']['pagecount']){
				  echo('&nbsp;<a href="?page='. $Ary_Result['result']['nextpage'] .'">next page</a>&nbsp;');
			  }
		  }
		  ?>
          </div></td>
        </tr>
      </tfoot>
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

<form id="frm2" name="frm2" action="deviceset.php" onsubmit="" submitwin="_self" method="get">
	<input name="devname" 		id="devname" 		type="hidden" value="" />
	<input name="status" 		id="status" 		type="hidden" value="" />
	<input name="id" 		id="id" 		type="hidden" value="" />
	<input name="companyname" 		id="companyname" 		type="hidden" value="" />
    
	<input name="macid" 		id="macid" 		type="hidden" value="" />
	<input name="ptype" 		id="ptype" 		type="hidden" value="" />
	<input name="servip" 		id="servip" 		type="hidden" value="" />
	<input name="servport" 		id="servport" 		type="hidden" value="" />
	
	<input name="retry" 		id="retry" 		type="hidden" value="" />
	<input name="timeout" 		id="timeout" 		type="hidden" value="" />
	<input name="polltime" 		id="polltime" 		type="hidden" value="" />
	<input name="groupname" 		id="groupname" 		type="hidden" value="" />
	
	<input name="stationname" 		id="stationname" 		type="hidden" value="" />
	<input name="socktype" 		id="socktype" 		type="hidden" value="" />

	<input name="devicedesc" 		id="devicedesc" 		type="hidden" value="" />
	<input name="templatelocation" 		id="templatelocation" 		type="hidden" value="" />
	
	<input name="pic1filelocation" 		id="pic1filelocation" 		type="hidden" value="" />
	<input name="pic2filelocation" 		id="pic2filelocation" 		type="hidden" value="" />
	<input name="pic3filelocation" 		id="pic3filelocation" 		type="hidden" value="" />
	<input name="pic4filelocation" 		id="pic4filelocation" 		type="hidden" value="" />
	<input name="mainpagediv" 		id="mainpagediv" 		type="hidden" value="" />
	
    <input name="php_parameter" type="hidden" id="php_parameter" value="['devname','status','id','companyname','macid','ptype','servip','servport','retry','timeout','polltime','groupname','stationname','socktype','devicedesc','templatelocation','pic1filelocation','pic2filelocation','pic3filelocation','pic4filelocation','mainpagediv']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

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