<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
global $Ary_Group;

$Obj_Frame	= new AtherFrameWork();
$Ary_Group	= $Obj_Frame->load_page("UserManager::getgroups");
$Ary_Result	= $Obj_Frame->load_page("UserManager::getusers",FuncExt::getnumber('page'),false);
//print_r($Ary_Group);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员帐号管理 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>管理员帐号管理</div>
  </div>
  <form id="frm" name="frm" method="post" action="submit.php" submitwin="ajax">
  <input name="user" type="hidden" id="user" value="" />
  <input name="php_interface" type="hidden" id="php_interface" value="UserManager::deluser" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="['user']" />
  <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  <div class="op"><a href="adminadd.php">添加管理员</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>管理员帐号</td>
          <td>管理员名称</td>
          <td>用户角色</td>
          <td>创建时间</td>
          <td width="160">操作</td>
        </tr>
      </thead>
      <tbody>
      	<?php
        if (is_array($Ary_Result['result']['userlist'])){
			foreach($Ary_Result['result']['userlist'] as $k=>$v){
		?>
        <tr align="center" id="row_<?=$v['user']?>">
          <td><a href="admindata.php?user=<?=$v['user']?>"><?=$v['user']?></a></td>
          <td><?=$v['name']?></td>
          <td><?php
          if (!isset($Ary_Group['result']['groups'][$v['group']])){ echo($v['group']); }
		  else{echo($Ary_Group['result']['groups'][$v['group']]['description']); }
		  ?>
		  </td>
          <td><?=$v['date']?></td>
          <td><a href="admindata.php?user=<?=$v['user']?>">详细</a> | <a href="adminset.php?user=<?=$v['user']?>">修改</a> | <?php
          if ($v['group']==1){
			  echo('<font color="#9C9C9C">删除</font>');
		  }
		  else{
			  echo('<a href="#" onclick="User_Delete(\''.$v['user'].'\')">删除</a>');
          }
		  ?></td>
        </tr>
        <?php
			}
		}
		?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5"><div class="page">
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
  </form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/usermanager.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
unset($Ary_Group);	$Ary_Group	= NULL;
?>
</body>
</html>