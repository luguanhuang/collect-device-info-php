<?php
use Zend\Db\Sql\Ddl\Index\Index;
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
//$Ary_Result= $Obj_Frame->user_popedom("FireWall::setFirewallRule",true);

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "bridgeset",0);

$arrnic=array();

$nic_data= $Obj_Frame->file_content("/usr/local/comm_platform/etc/cur_nic_data.conf","物理接口配置文件",3010,$interr,$strerr);
TLOG_MSG("bridgeset: func begin 1 nic_data=".$nic_data);
$nicredata = explode("|",$nic_data);
foreach ($nicredata as $nic)
{
    $tmpnic = explode(",", $nic);
    for($index=0;$index<count($tmpnic);$index++)
    {
        if (strstr($tmpnic[$index], "eth"))
        {
            $arrnic[] = $tmpnic[$index];
            //TLOG_MSG("bridgeset: tmpnic=".$tmpnic[$index]);
        }
    }
}

$resnic=array();
$content= $Obj_Frame->file_content("/usr/local/comm_platform/tool/cur_bridge_data.conf","桥接口配置文件",3010,$interr,$strerr);
//if ($content===false){return $this->result_set($interr,$strerr);}
TLOG_MSG("bridgeset: func begin 1 content=".$content);
$redata = explode("|",$content);
$idx=0;
$resdata = "";
$find = 0;
$use_nic = array();
foreach ($redata as $nicinfo)
{
    $tmp = explode(",", $nicinfo);
    for($index=0;$index<count($tmp);$index++)
    {
        if (strstr($tmp[$index], "eth"))
        {
            TLOG_MSG("bridgeset: func begin 1 tmpnic=".$tmp[$index]);
            $use_nic[] = $tmp[$index];
        }
    }
}

$resultnic = array();
for($nicidx=0;$nicidx<count($arrnic);$nicidx++)
{
    $find = 0;
    for($i=0;$i<count($use_nic);$i++)
    {
        if (0 == strcmp($arrnic[$nicidx], $use_nic[$i]))
        {
            $find = 1;
        }
    }
    
    if (0 == $find)
    {
        TLOG_MSG("bridgeset: tmpnic111=".$arrnic[$nicidx]);
        $resultnic[] = $arrnic[$nicidx];
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加桥接口 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Bridge_Add(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>添加桥接口</div>
    </caption>
    <tbody>
      <tr>
        <td class="t">名称：</td>
        <td class="c"><input id="name" name="name" type="text" class="input" /></td>
      </tr>
      <tr>
        <td class="t">IP地址：</td>
        <td class="c"><input id="sip" name="sip" type="text" class="input" /></td>
      </tr>
       <tr>
        <td class="t">子网掩码：</td>
        <td class="c"><input id="mask" name="mask" type="text" class="input" value="<?=AtherFrameWork::_STR_MASK_DEF_?>" /> </td>
      </tr>
      <tr>
        <td class="t">接口列表：</td>
         <td class="c">
         <?php
            for($i=0;$i<count($resultnic);$i++)
            {?>
                <label><input name="nic_<?=$i?>" type="checkbox" class="input-h" id="nic_<?=$i?>" value="<?=$resultnic[$i]?>" /><span><?=$resultnic[$i]?></span></label>
            <?php }
		      ?>
        
      </tr>
      <tr>
        <td class="t">启用/禁用：</td>
        <td class="c"><select id="ptype" name="ptype" size="1">
            <option value="up">启用</option>
            <option value="down">禁用</option>
        </select></td>
      </tr>
      <tr>
        <td colspan="2" class="f">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="重置" class="btn" />
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='bridge.php'"/>
            </div>
        </td>
      </tr>
    </tbody>
  </table>
  <input name="nic" 		id="nic" 		type="hidden" value="111" />
  <input name="php_interface" type="hidden" id="php_interface" value="Bridge::addBridgeInfo" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['name','sip','nic','smac','dport','dip','mask','link','action','ptype']]" />
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