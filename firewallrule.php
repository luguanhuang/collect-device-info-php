<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "firewallrule",0);

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("FireWall::getFirewallRuleList",FuncExt::getnumber('page'),false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>防火墙规则 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>防火墙规则列表</div>
  </div>
  <form name="frm" id="frm" action="submit.php" submitwin="ajax" method="post">
    <div class="op"><a href="firewallset.php">添加规则</a>
      <div class="clear"></div>
    </div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="60">源端口</td>
          <td width="96">源IP</td>
          <td width="96">源子网掩码</td>
          <td>源MAC地址</td>
          <td width="60">目标端口</td>
          <td width="96">目标IP</td>
          <td width="96">目标子网掩码</td>
          <td width="68">操作</td>
        </tr>
      </thead>
       <tbody>
      <?php
	  if (is_array($Ary_Result['result']['datalist'])){
		  $s = ($Ary_Result['result']['absolutepage']-1)*$Ary_Result['result']['pagesize'];
		  foreach($Ary_Result['result']['datalist'] as $k=>$v){
	  ?>
        <tr align="center" id="row_<?=$k?>">
          <td><input type="hidden" name="sport_<?=$k?>" id="sport_<?=$k?>" value="<?=$v['sport']?>"/><?php echo($v['sport']=="" ? "-" : $v['sport']); ?></td>
          <td><input type="hidden" name="sip_<?=$k?>" id="sip_<?=$k?>" value="<?=$v['sip']?>"/><?php echo($v['sip']==""?"-":$v['sip']); ?></td>
          <td><input type="hidden" name="smask_<?=$k?>" id="smask_<?=$k?>" value="<?=$v['smask']?>"/><?php echo($v['smask']=="" ? "-" : $v['smask']); ?></td>
          <td><p>
            <input type="hidden" name="smac_<?=$k?>" id="smac_<?=$k?>" value="<?=$v['smac']?>"/><?php echo($v['smac']=="" ? "-": $v['smac']); ?>
          </p></td>
          <td><input type="hidden" name="dport_<?=$k?>" id="dport_<?=$k?>" value="<?=$v['dport']?>"/><?php echo($v['dport']=="" ? "-" : $v['dport']); ?></td>
          <td><input type="hidden" name="dip_<?=$k?>" id="dip_<?=$k?>" value="<?=$v['dip']?>"/><?php echo($v['dip']=="" ? "-" : $v['dip']); ?></td>
          <td><input type="hidden" name="dmask_<?=$k?>" id="dmask_<?=$k?>" value="<?=$v['dmask']?>"/><?php echo($v['dmask']=="" ? "-": $v['dmask']); ?></td>
          <td><a href="firewalldet.php?id=<?=$s+$k?>">详细</a> <!--<a href="">修改</a> | --><a href="#" onclick="return FireWall_Delete(<?=$k?>)">删除
            <input type="hidden" name="link_<?=$k?>" id="link_<?=$k?>" value="<?=$v['link']?>"/>
            <input type="hidden" name="action_<?=$k?>" id="action_<?=$k?>" value="<?=$v['action']?>"/>
            <input type="hidden" name="ptype_<?=$k?>" id="ptype_<?=$k?>" value="<?=$v['ptype']?>"/>
          </a></td>
        </tr>
        <?php
		  }
	  }
		?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="8"><div class="page">
		  <?php
		  echo("共".$Ary_Result['result']['recordcount']."条记录&nbsp;&nbsp;");
		  echo("第".$Ary_Result['result']['absolutepage']."/". $Ary_Result['result']['pagecount'] ."页&nbsp;&nbsp;");
		  if ($Ary_Result['result']['pagecount']>0){
			  if ($Ary_Result['result']['absolutepage']>1){
				  echo('<a href="?page='. $Ary_Result['result']['previouspage'] .'">上一页</a>&nbsp;');
			  }
			  echo('第&nbsp;');
			  for($p=$Ary_Result['result']['startpage'];$p<$Ary_Result['result']['endpage']+1;$p++){
				  if ($p==$Ary_Result['result']['absolutepage']){echo('<u>'.$p.'</u>&nbsp;');}
				  else{echo('<a href="?page='.$p.'">'. $p .'</a>&nbsp;');}
			  }
			  echo('页');
			  if ($Ary_Result['result']['absolutepage']<$Ary_Result['result']['pagecount']){
				  echo('&nbsp;<a href="?page='. $Ary_Result['result']['nextpage'] .'">下一页</a>&nbsp;');
			  }
		  }
		  ?>
          </div></td>
        </tr>
      </tfoot>
    </table>
	<input type="hidden" name="sport" id="sport" value=""/>
	<input type="hidden" name="sip" id="sip" value=""/>
	<input type="hidden" name="smask" id="smask" value=""/>
    <input type="hidden" name="smac" id="smac" value=""/>
	<input type="hidden" name="dport" id="dport" value=""/>
	<input type="hidden" name="dip" id="dip" value=""/>
	<input type="hidden" name="dmask" id="dmask" value=""/>
	<input type="hidden" name="link" id="link" value=""/>
	<input type="hidden" name="action" id="action" value=">"/>
	<input type="hidden" name="ptype" id="ptype" value=""/>
    <input name="actstep" type="hidden" value="del" />
	<input name="php_interface" type="hidden" id="php_interface" value="FireWall::setFirewallRule" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['sport','sip','smask','smac','dport','dip','dmask','link','action','ptype'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/firewall.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>