<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
global $Ary_Group;

$Obj_Frame	= new AtherFrameWork();
$Ary_Group	= $Obj_Frame->load_page("UserManager::getgroups");
$Ary_Result	= $Obj_Frame->load_page("UserManager::getuser",FuncExt::getvalue('user'),false);
//print_r($Ary_Group);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员帐号详细信息 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="?" onsubmit="javascript:return chkform(this);" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>管理员帐号详细信息</div>
    </caption>
    <tbody>
      <tr>
        <td class="t">管理员帐号：</td>
        <td class="c"><?=$Ary_Result['result']['user']?></td>
      </tr>
      <tr>
        <td class="t">管理员名称：</td>
        <td class="c"><?=$Ary_Result['result']['name']?></td>
      </tr>
      <tr>
        <td class="t">创建日期：</td>
        <td class="c"><?=$Ary_Result['result']['date']?></td>
      </tr>
      <tr>
        <td class="t">用户角色：</td>
        <td class="c"><?php
		$group = $Ary_Result['result']['group'];
        if (!isset($Ary_Group['result']['groups'][$group])){ echo($group); }
		else{echo($Ary_Group['result']['groups'][$group]['description']); }
		?></td>
      </tr>
      <tr>
        <td valign="top" class="t">角色权限：</td>
        <td class="c" id="powerlist">
        	<?php
            if ($Ary_Group['result']['common']){
			?>
       	  <h4>共有权限：</h4>
            <ul>
            	<?php 
				foreach($Ary_Group['result']['common'] as $p){
					echo("<li>". $p ."</li>\r\n");
				}
				?>
            </ul>
            <?php
			}
			?>
            <?php
            if (isset($Ary_Group['result']['groups'][$group])){
			?>
        	<h4>独有权限：</h4>
            <ul>
            	<?php 
				foreach($Ary_Group['result']['groups'][$group]['power'] as $p){
					echo("<li>". $p ."</li>\r\n");
				}
				?>
            </ul>
            <?php
			}
			?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
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