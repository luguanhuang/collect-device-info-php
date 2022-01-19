<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "Channel",0);
TLOG_MSG("Channel: func begin");
$Obj_Frame = new AtherFrameWork();

error_reporting(0);
session_start();
$Int_Report	= ini_get('error_reporting');
error_reporting($Int_Report);
$tmp = &$_SESSION[_GLO_SESSION_USERINFO_]['userinfo'];

$user = &$_SESSION[_GLO_SESSION_USERINFO_]['username'];
$user_roll = &$_SESSION[_GLO_SESSION_USERINFO_]['roll_id'];

$param = @FuncExt::getnumber('page');
$param.=",";
$param.=$tmp;

$Ary_Result= $Obj_Frame->load_page("Channel::getChannelList",$param,false);
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
    <div><span></span>channel list</div>
  </div>
  <?php echo "$user_roll"; ?>
  <form id="frm" name="frm" action="submit.php" onsubmit="" submitwin="ajax" method="post">
  <input id="id" name="id" type="hidden" value="" />
  <input id="macid" name="macid" type="hidden" value="" />
  <input id="user" name="user" type="hidden" value="" />
  <input name="ptype" id="ptype"  type="hidden" value=""/>
  <input name="servip" id="servip"  type="hidden" value=""/>
  <input name="servport" id="servport"  type="hidden" value=""/>
  <input name="actstep"  id="actstep" type="hidden" value="del" />
  <div class="op"><a href="channeladd.php">add channel</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>devname</td>
		  <td>dtype</td>
		  <td>channelid</td>
          <td>slaveid</td>
		  <td>funcode</td>
          <td>startreg</td>
		  <td>countreg</td>
          <td>companyname</td>
		  <td>groupname</td>
		  <td>stationname</td>
		  <td>chdesc</td>
		  <td>reporttype</td>
		  <td>status</td>
		  <td>history</td>
          <td width="110">operate</td>
        </tr>
      </thead>
      <tbody>
      	<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				TLOG_MSG("reporttype=".$row['reporttype']);
				
		?>
        <tr align="center" id="row_<?=$k?>">
		<td><?php echo($row['devname']); ?><input name="devname_<?=$k?>" id="devname_<?=$k?>" type="hidden" value="<?=$row['devname']?>" /></td>
		<td><?php echo($row['dname']); ?><input name="dtype_<?=$k?>" id="dtype_<?=$k?>" type="hidden" value="<?=$row['dtype']?>" /></td>
		
		<input name="id_<?=$k?>" id="id_<?=$k?>" type="hidden" value="<?=$row['id']?>" />
		<td><?php echo($row['ch']); ?><input name="chid_<?=$k?>" id="chid_<?=$k?>" type="hidden" value="<?=$row['ch']?>" /></td>
		<td><?php echo($row['slaveid']); ?><input name="slaveid_<?=$k?>" id="slaveid_<?=$k?>" type="hidden" value="<?=$row['slaveid']?>" /></td>
		<td><?php echo($row['funcode']); ?><input name="funcode_<?=$k?>" id="funcode_<?=$k?>" type="hidden" value="<?=$row['funcode']?>" /></td>
		
		<td><?php echo($row['startreg']); ?><input name="startreg_<?=$k?>" id="startreg_<?=$k?>" type="hidden" value="<?=$row['startreg']?>" /></td>
		<td><?php echo($row['countreg']); ?><input name="countreg_<?=$k?>" id="countreg_<?=$k?>" type="hidden" value="<?=$row['countreg']?>" /></td>
		<td><?php echo($row['companyname']); ?><input name="companyname_<?=$k?>" id="companyname_<?=$k?>" type="hidden" value="<?=$row['company_id']?>" /></td>
		<td><?php echo($row['groupname']); ?><input name="groupname_<?=$k?>" id="groupname_<?=$k?>" type="hidden" value="<?=$row['group_id']?>" /></td>
		<td><?php echo($row['stationname']); ?><input name="stationname_<?=$k?>" id="stationname_<?=$k?>" type="hidden" value="<?=$row['station_id']?>" /></td>
		<td><?php echo($row['chdesc']); ?><input name="chdesc_<?=$k?>" id="chdesc_<?=$k?>" type="hidden" value="<?=$row['chdesc']?>" /></td>
		
		  <td><?php if ($row['reporttype']=="1") echo('dailyreport');
					else if ($row['reporttype']=="2") echo('hourlyreport'); ?><input name="reporttype_<?=$k?>" id="reporttype_<?=$k?>" type="hidden" value="<?=$row['reporttype']?>" /></td>
		
		  <td><?php if ($row['active']=="1") echo('active');
					else echo('deactive'); ?><input name="status_<?=$k?>" id="status_<?=$k?>" type="hidden" value="<?=$row['active']?>" /></td>
		<td><?php if ($row['history']=="1") echo('history');
			else echo('dehistory'); ?><input name="history_<?=$k?>" id="history_<?=$k?>" type="hidden" value="<?=$row['history']?>" /></td>
			
			<input name="Alarmchannel_<?=$k?>" id="Alarmchannel_<?=$k?>" type="hidden" value="<?=$row['Alarmchannel']?>" />
			
			<td><a href="#" submitwin="_self"  onclick="return Channel_Seting(<?=$k?>)">modify channel</a> 
			| <a href="#" submitwin="tag_edit_self"  onclick="return Tag_Seting(<?=$k?>)">modify tag</a>
			| <a href="#" onclick="return Company_Delete(<?=$k?>)">modify alarm</a>
			| <a href="#" onclick="return Company_Delete(<?=$k?>)">delete channel</a></td>
        </tr>
        <?php }
		}
		?>
      </tbody>
	  <tfoot>
        <tr>
          <td colspan="14"><div class="page">
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

<form id="frm2" name="frm2" action="channelset.php" onsubmit="" submitwin="_self" method="get">
	<input name="devname" 		id="devname" 		type="hidden" value="" />
	<input name="dtype" 		id="dtype" 		type="hidden" value="" />
	<input name="id" 		id="id" 		type="hidden" value="" />
	<input name="slaveid" 		id="slaveid" 		type="hidden" value="" />
    
	<input name="funcode" 		id="funcode" 		type="hidden" value="" />
	<input name="startreg" 		id="startreg" 		type="hidden" value="" />
	<input name="countreg" 		id="countreg" 		type="hidden" value="" />
	<input name="status" 		id="status" 		type="hidden" value="" />
	<input name="companyname" 		id="companyname" 		type="hidden" value="" />
	
	<input name="groupname" 		id="groupname" 		type="hidden" value="" />
	
	<input name="stationname" 		id="stationname" 		type="hidden" value="" />
	<input name="chid" 		id="chid" 		type="hidden" value="" />
	<input name="history" 		id="history" 		type="hidden" value="" />
	<input name="chdesc" 		id="chdesc" 		type="hidden" value="" />
	<input name="reporttype" 		id="reporttype" 		type="hidden" value="" />
	<input name="Alarmchannel" 		id="Alarmchannel" 		type="hidden" value="" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="['devname','dtype','id','slaveid','funcode','startreg','countreg','status','groupname','stationname','companyname','chid','history','chdesc','reporttype','Alarmchannel']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<form id="addfrm" name="addfrm" action="tagadd.php" onsubmit="" submitwin="tag_add_self" method="get">
	<input name="devname" 		id="devname" 		type="hidden" value="" />
	<input name="dtype" 		id="dtype" 		type="hidden" value="" />
	<input name="id" 		id="id" 		type="hidden" value="" />
	<input name="slaveid" 		id="slaveid" 		type="hidden" value="" />
    
	<input name="funcode" 		id="funcode" 		type="hidden" value="" />
	<input name="startreg" 		id="startreg" 		type="hidden" value="" />
	<input name="countreg" 		id="countreg" 		type="hidden" value="" />
	<input name="status" 		id="status" 		type="hidden" value="" />
	<input name="companyname" 		id="companyname" 		type="hidden" value="" />
	
	<input name="groupname" 		id="groupname" 		type="hidden" value="" />
	
	<input name="stationname" 		id="stationname" 		type="hidden" value="" />
	
    <input name="php_parameter" type="hidden" id="php_parameter" value="['devname','dtype','id','slaveid','funcode','startreg','countreg','status','groupname','stationname','companyname']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<form id="editfrm" name="editfrm" action="tagset.php" onsubmit="" submitwin="tag_edit_self" method="get">
	<input name="devname" 		id="devname" 		type="hidden" value="" />
	<input name="dtype" 		id="dtype" 		type="hidden" value="" />
	<input name="id" 		id="id" 		type="hidden" value="" />
	<input name="slaveid" 		id="slaveid" 		type="hidden" value="" />
    
	<input name="funcode" 		id="funcode" 		type="hidden" value="" />
	<input name="startreg" 		id="startreg" 		type="hidden" value="" />
	<input name="countreg" 		id="countreg" 		type="hidden" value="" />
	<input name="status" 		id="status" 		type="hidden" value="" />
	<input name="companyname" 		id="companyname" 		type="hidden" value="" />
	
	<input name="groupname" 		id="groupname" 		type="hidden" value="" />
	
	<input name="stationname" 		id="stationname" 		type="hidden" value="" />
	
    <input name="php_parameter" type="hidden" id="php_parameter" value="['devname','dtype','id','slaveid','funcode','startreg','countreg','status','groupname','stationname','companyname']" />
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