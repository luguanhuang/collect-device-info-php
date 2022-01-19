<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("ServerConf::getLogSvrConfig");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>日志服务器设置 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
<style type="text/css">
<!--
input.input {text-align:center;}
input.input1{width:128px;}
input.input2{width:44px;}
-->
</style>
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return LogSvr_Validate(this);"  submitwin="ajax" method="post">
<div class="listwrap">
  <div class="nav">
    <div><span></span>日志服务器设置</div>
  </div>
    <div class="op">
    	<a href="#" onclick="return LogSvr_Addnew()">添加服务器</a>
        <div class="clear"></div>
    </div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>服务器IP地址</td>
          <td width="160">端口</td>
          <td width="80">操作</td>
        </tr>
      </thead>
      <tbody id="row_list">
      	<tr align="center" id="row_templet" enabled="-1" style="display:none;">
          <td><input id="ip_{tag:id}" name="ip_{tag:id}" type="text"  class="input input1"/></td>
          <td><input id="port_{tag:id}" name="port_{tag:id}" type="text"  class="input input2"/></td>
          <td>
          	<font id="row_delete_{tag:id}" name="row_delete_{tag:id}"><a href="#" onclick="return LogSvr_Delete({tag:id})">删除</a></font>
            <!--font id="row_resume_{tag:id} name="row_delete_{tag:id}""></font-->
            <input name="{tag:row_num}" id="{tag:row_num}" type="hidden" value="{tag:id}" remark="用于获取所有记录的$k值"/>
          </td>
        </tr>
      	<?php
        if (is_array($Ary_Result['result'])){
        		$firstrow="";
			foreach($Ary_Result['result'] as $k=>$r){
			
		?>
        <tr align="center" id="row_<?=$k?>" enabled="1">
          <td>
          	<input id="ip_<?=$k?>" name="ip_<?=$k?>" type="text" value="<?=$r['ip']?>" class="input input1"/>
         </td>
         <td>
           <input id="port_<?=$k?>" name="port_<?=$k?>" type="text" value="<?=$r['port']?>" <?=$firstrow ?> class="input input2"/>
         </td>
          <td>
          	<font id="row_hand_<?=$k?>" name="row_hand_<?=$k?>"><a href="#" onclick="return LogSvr_Delete(<?=$k?>)">删除</a></font>
          	<font id="row_hand_<?=$k?>" name="row_hand_<?=$k?>" style="display:none;"><a href="#" onclick="return LogSvr_Resume(<?=$k?>)">恢复</a></font>
            <input name="row_num" id="row_num" type="hidden" value="<?=$k?>" remark="用于获取所有记录的$k值"/>
          </td>
        </tr>
        <?php
			$firstrow="disabled='disabled'";
			}
		}
		?>
      </tbody>
      
      <tfoot>
      	<tr>
      		<td colspan="3" align="center" class="f">
            <input type="submit" class="btn" value="保存"/>
            <input type="button" id="btnrefresh" value="刷新" class="btn" onclick="window.location.reload(true);" />
            <input type="hidden" name="servers" id="servers" value="" />
            <input name="php_interface" type="hidden" id="php_interface" value="ServerConf::setLogSvrConfig" />
            <input name="php_parameter" type="hidden" id="php_parameter" value="[['servers']]" />
            <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
            </td>
        </tr>
      </tfoot>
    </table>
</div>
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/servercfg.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body></html>