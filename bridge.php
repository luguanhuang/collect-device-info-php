<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "bridge",0);
TLOG_MSG("bridge: func begin111111111");
$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("Bridge::getBridgeList");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>桥列表 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>桥接口列表</div>
  </div>
  <form id="frm" name="frm" action="#">
  <div class="op"><a href="bridgeadd.php">添加桥接口</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="60">索引</td>
          <td width="120">名称</td>
          <td width="200">IP/掩码</td>
          <td width="200">接口列表</td>
          <td width="200">启用</td>
          <td width="200">操作</td>
        </tr>
      </thead>
      <tbody>
      	<?php
      	$idx = 0;
        if (is_array($Ary_Result['result'])){
			foreach($Ary_Result['result'] as $k => $row){
		?>
        <tr align="center" id="row_<?=$k?>">
          <td><?php
          $idx += 1;
           echo($idx);
           $ethlist="";
           for ($i= 0;$i< count($row['ethlist']); $i++)
           {
               $ethlist = $ethlist.$row['ethlist'][$i];
               if ($i != count($row['ethlist']) - 1)
               {
                   $ethlist = $ethlist.",";
               }
           }
           
           /*foreach ($row['ethlist'] as $ethname)
           {
               $ethlist = $ethlist.$ethname.",";
               //echo "This Site url is $url! <br />";
           }*/
           
           
           $ipinfo = "";
           if ($row['ip'] !== '' && $row['mask'] !== '')
           {
               $ipinfo = $row['ip']."/".$row['mask'];
           }
		  ?><input name="idx_<?=$k?>" id="idx_<?=$k?>" type="hidden" value="<?=$idx?>" /></td>
          <td><?=$row['name']?><input name="interface_<?=$k?>" id="interface_<?=$k?>" type="hidden" value="<?=$row['name']?>" /></td>
          <td><?=$ipinfo?><input name="ip_<?=$k?>" id="ip_<?=$k?>" type="hidden" value="<?=$row['ip']?>" /></td>
          <td><?=$ethlist?><input name="mode_<?=$k?>" id="mode_<?=$k?>" type="hidden" value="<?=$ethlist?>" /></td>
          <td><?php
          if ($row['forbitflg']=="1"){ echo('禁用'); }
		  else{ echo('启用'); }
		  ?><input name="forbitflg_<?=$k?>" id="forbitflg_<?=$k?>" type="hidden" value="<?=$row['forbitflg']?>" /></td>
		  <td><a href="#" submitwin="_self"  onclick="return Bridge_Seting(<?=$k?>)">修改</a> | <a href="#" submitwin="ajax"  onclick="return Bridge_Delete(<?=$k?>)">删除</a></td>
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
   
  </form>
</div>

<form id="frm1" name="frm1" action="submit.php" onsubmit="" submitwin="ajax" method="post">
	<input name="interface" 		id="interface" 		type="hidden" value="" />
	<input name="php_interface" type="hidden" id="php_interface" value="NetConfig::delBridgeInfo" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="['interface']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<form id="frm2" name="frm2" action="bridgeset.php" onsubmit="" submitwin="_self" method="get">
	<input name="interface" 		id="interface" 		type="hidden" value="" />
    <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::getNicSet" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="['interface']" />
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