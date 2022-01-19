<?php
require("services/AtherFrameWork.php");
require_once 'tlog.php';

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "nicset",0);
//TLOG_MSG("nicset: func begin param=".FuncExt::getnumber('ethname'));
TLOG_MSG("nicset: func begin param=111");
//echo($_GET('id'));

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame	= new AtherFrameWork();
//$Ary_Result = $Obj_Frame->load_page("NetConfig::getNicSet",FuncExt::getnumber('id'),false);
$Ary_Result = $Obj_Frame->load_page("NetConfig::getNicSet",$Obj_Frame->load_interargs(),false);
$tmp = explode(",", $Ary_Result['result']);
$ipinfo = "";
if ($tmp[4] !== '' && $tmp[5] !== '')
{
    $ipinfo = $tmp[4]."/".$tmp[5];
}
//$Ary_Result = $Obj_Frame->load_page("NetConfig::getNicSet",strval($_GET('id')),false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$Ary_Result['result']['title']?> - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return NicSet_Validate(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span><?='物理接口'?></div>
    </caption>
    <tbody>
    <tr>
        <td class="t">接口名称：</td>
        <td class="c"><input id="interface_name" name="interface_name" type="text" class="input" value="<?=$tmp[0]?>" disabled="disabled"/><input name="interface" id="interface" type="hidden" value="<?=$tmp[0]?>" /></td>
      </tr>
       <tr>
        <td class="t">IP地址：</td>
        <td class="c"><input id="server" name="server" type="text" class="input" value="<?=$tmp[4]?>"  /></td>
       </tr>
        <tr>
        <td class="t">子网掩码：</td>
        <td class="c"><input id="mask" name="mask" type="text" class="input" value="<?=$tmp[5]?>"  /></td>
       </tr>
       <tr>
        <td class="t">链接模式：</td>
        <td class="c"><input id="link_mode" name="link_mode" type="text" class="input" value="<?=$tmp[2]?>" disabled="disabled"/></td>
      </tr>
      <tr>
        <td class="t">链接状态：</td>
        <td class="c"><input id="link_status" name="link_status" type="text" class="input" value="<?=$tmp[1]?>" disabled="disabled"/></td>
      </tr>
      <tr>
        <td class="t">启用/禁用：</td>
        <td class="c"><select id="ptype" name="ptype" size="1">
            <option value="1"<?php if ($tmp[3]=='1'){ echo(' selected'); }?>>禁用</option>
              <option value="0"<?php if ($tmp[3]=='0'){ echo(' selected'); }?>>启用</option>
               
          </select></td>
      </tr>
      <tr>
     	 <td  class="f" colspan="2">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='nic.php'"/>
            </div>
          </td>
      </tr>
    </tbody>
  </table>
  <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::setNicInfo" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['server','ptype','interface', 'mask']]" />
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