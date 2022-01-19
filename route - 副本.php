<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("Router::getRouteList");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>路由设置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>路由设置</div>
  </div>
  <form id="frm" name="frm" action="submit.php" onsubmit="" submitwin="ajax" method="post">
  <input id="ip" name="ip" type="hidden" value="" />
  <input id="type" name="type" type="hidden" value="" />
  <input name="mask" id="mask"  type="hidden" value=""/>
  <input name="netgate" id="netgate"  type="hidden" value=""/>
  <input name="ifname" id="ifname"  type="hidden" value=""/>
  <input name="actstep"  id="actstep" type="hidden" value="del" />
  <div class="op"><a href="routeset.php">添加路由</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>路由类型</td>
          <td width="220">网段</td>
          <td>子网掩码</td>
          <td>网关地址</td>
          <td>接口名称</td>
          <td width="88">操作</td>
        </tr>
      </thead>
      <tbody>
      	<?php
        if (is_array($Ary_Result['result'])){
			foreach($Ary_Result['result'] as $k => $row){
		?>
        <tr align="center" id="row_<?=$k?>">
          <td><?php
          if ($row['type']=="net"){ echo('网络'); }
		  elseif ($row['type']=="host"){ echo('主机'); }
		  else{ echo($row['type']); }
		  ?><input name="type_<?=$k?>" id="type_<?=$k?>" type="hidden" value="<?=$row['type']?>" /></td>
          <td><?=$row['ip']?><input name="ip_<?=$k?>" id="ip_<?=$k?>" type="hidden" value="<?=$row['ip']?>" /></td>
          <td><?=$row['mask']?><input name="mask_<?=$k?>" id="mask_<?=$k?>" type="hidden" value="<?=$row['mask']?>" /></td>
          <td><?=$row['netgate']?><input name="netgate_<?=$k?>" id="netgate_<?=$k?>" type="hidden" value="<?=$row['netgate']?>" /></td>
          <td><?php
           echo($row['ifname']);
		  ?><input name="ifname_<?=$k?>" id="ifname_<?=$k?>" type="hidden" value="<?=$row['ifname']?>" /></td>
          <td><!--<a href="routeedit.html">修改</a> | --><a href="#" onclick="return Route_Delete(<?=$k?>)">删除</a></td>
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
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['ip','type','mask','netgate','ifname'],'actstep']" />
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