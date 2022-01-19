<?php
require('services/Environ.php');

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new Environ();
$Ary_Result= $Obj_Frame->getEnv();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统环境支持 - <?=_GLO_PROJECT_FNAME_?></title>
<style type="text/css">
<!--
body{margin:0px auto; padding:0px; background-color:none;}
body,p,div,li,td,span,font,label,b,i,u{font-size:12px;}
code,kbd,var,dfn{font-style:normal;font-size:12px;}
input,select{font-size:12px;vertical-align:middle;}

form,pre{margin:0px;padding:0px;}
ul{margin:0px;padding:0px;list-style-type:none;}
ol{margin:0px;padding:0px;padding-left:24px;padding-left:0px \9;margin-left:24px \9;}

a{color:#000; text-decoration:none;}
a:hover{color:#FD4D20;}

*.bred{font-weight:bold;color:#F00;}
*.important{color:#FD4D20;}
*.disabled{color:#808080;}
input.disabled{background-color:#F0F0F0;}
option.selected{background-color:#D8D8D8;color:#414874;font-weight:bold;}

/*
common
*{word-break:break-all;word-wrap:break-word;}
*{background-color:;background-image:;background-repeat:;background-position:;}
*{background:#******* url() repeat fixed x y;}
table{border:1px;border-collapse:collapse;}
td{padding:0px;}
*/

body{margin:30px 40px 30px 40px;}
body, td, th, h1, h2 {font-family: sans-serif;}

table {border-collapse: collapse;}
td{ border: 1px solid #000000; font-size:13px; line-height:18px; height:20px; vertical-align:middle;}
th{ border: 1px solid #000000; font-size:13px; line-height:22px; height:22px; vertical-align:middle;}
h1 {font-size: 150%;}
h2 {font-size: 125%;}

.center {text-align: center;}
.center table{ margin-left: auto; margin-right: auto; text-align: left;}
.center th {text-align: center !important;}

.e {background-color: #ccccff; font-weight: bold; color: #000000; white-space:nowrap;}
.h {background-color: #9999cc; font-weight: bold; color: #000000;}
.v {background-color: #cccccc; color: #000000;word-break:break-all;word-wrap:break-word;}
-->
</style>
</head>

<body>
<div class="center">
<h1>系统配置</h1>
<table border="0" cellpadding="3">
    <tr class="h">
        <th width="168">名称</th><th width="380">Value</th>
    </tr>
    <!--
    <?php if (function_exists('phpversion')){?>
    <tr>
    	<td class="e">version</td>
        <td class="v"><? phpversion() ?></td>
    </tr>
    <?php }?>
    <?php if (function_exists('php_ini_loaded_file')){?>
    <tr>
    	<td class="e">php.ini</td>
        <td class="v"><? php_ini_loaded_file() ?></td>
    </tr>
    <?php }?>
    -->
    <tr>
    	<td class="e">root_path</td>
        <td class="v"><?=$Obj_Frame->_phproot()?></td>
    </tr>
    <tr>
    	<td class="e">project_path</td>
        <td class="v"><?=$Obj_Frame->_phppro()?></td>
    </tr>
    <tr>
    	<td class="e">default_charset</td>
        <td class="v"><?=ini_get('default_charset')?></td>
    </tr>
    <tr>
    	<td class="e">date.timezone</td>
        <td class="v"><?=ini_get('date.timezone')?></td>
    </tr>
    <tr>
    	<td class="e">current_datetime</td>
        <td class="v"><?=date('Y-m-d H:i:s')?></td>
    </tr>
    <tr>
    	<td class="e">display_errors</td>
        <td class="v"><?=ini_get('display_errors')?></td>
    </tr>
    <tr>
    	<td class="e">error_reporting</td>
        <td class="v"><?=ini_get('error_reporting')?></td>
    </tr>
    <tr>
    	<td class="e">register_globals</td>
        <td class="v"><?=(ini_get('register_globals')?'On':'Off')?></td>
    </tr>
    <tr>
    	<td class="e">magic_quotes_gpc</td>
        <td class="v"><?=(ini_get('magic_quotes_gpc')?'On':'Off')?></td>
    </tr>
    <tr>
    	<td class="e">magic_quotes_runtime</td>
        <td class="v"><?=(ini_get('magic_quotes_runtime')?'On':'Off')?></td>
    </tr>
     <tr>
    	<td class="e">session.save_path</td>
        <td class="v"><?=(ini_get('session.save_path')==""?sys_get_temp_dir():ini_get('session.save_path'))?></td>
    </tr>
    <tr>
    	<td class="e">session.name</td>
        <td class="v"><?=ini_get('session.name')?></td>
    </tr>
    <tr>
    	<td class="e">session.auto_start</td>
        <td class="v"><?=(ini_get('session.auto_start')?'Yes':'No')?></td>
    </tr>
    <tr>
    	<td class="e">disable_functions</td>
        <td class="v"><?=str_replace(",",", ",ini_get('disable_functions'))?></td>
    </tr>
</table><br />
<?php foreach($Ary_Result as $k1=>$v1){ ?>
<h1><?=$k1?></h1>
<?php if ($k1=="extend"){?>
<table border="0" cellpadding="3">
    <tr class="h">
        <th width="120">扩展</th><th width="120">状态</th><th width="300">影响</th>
    </tr>
    <?php foreach($v1 as $k2=>$v2){?>
    <tr>
    	<td class="e"><?=$v2['title']?></td>
        <td class="v"><?=($v2['result']?'On':'Off')?></td>
        <td class="v"><?=$v2['msg']?></td>
    </tr>
    <?php }?>
</table><br />
<?php
}
elseif ($k1=="function"){
?>
<table border="0" cellpadding="3">
    <tr class="h">
        <th width="120">函数</th><th width="120">状态</th><th width="300">影响</th>
    </tr>
    <?php foreach($v1 as $k2=>$v2){?>
    <tr>
    	<td class="e"><?=$v2['title']?></td>
        <td class="v"><?=($v2['result']?'On':'Off')?></td>
        <td class="v"><?=$v2['msg']?></td>
    </tr>
    <?php }?>
</table><br />
<?php }
else{
?>
<table border="0" cellpadding="3">
    <tr class="h">
        <th width="240">文件/目录</th><th width="50">存在</th><th width="50">可读</th><th width="50">可写</th><th width="50">可执行</th><th width="240">影响</th>
    </tr>
    <?php foreach($v1 as $k2=>$v2){?>
    <tr>
    	<td class="e"><?=$v2['title']?></td>
        <td class="v"><?=($v2['result']['a']?'Yes':'No')?></td>
        <td class="v"><?=( !isset($v2['result']['r']) ? '-' : ($v2['result']['r']?'Yes':'No') )?></td>
        <td class="v"><?=( !isset($v2['result']['w']) ? '-' : ($v2['result']['w']?'Yes':'No') )?></td>
        <td class="v"><?=( !isset($v2['result']['e']) ? '-' : ($v2['result']['e']?'Yes':'No') )?></td>
        <td class="v">
        	<?php
            if (isset($v2['msg']['a'])){
				echo(implode("<br>",$v2['msg']['a']));
			}
			else{
				$err = array();
				foreach($v2['msg'] as $v3){
					if ($v3==""){continue;}
					$err[] = $v3;
				}
				echo(implode("<br>",$err));
			}
			
			?>
        </td>
    </tr>
    <?php }?>
</table><br />
<?php	}
	}
?>
</div>
</body>
</html>