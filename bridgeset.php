<?php
use Zend\Db\Sql\Ddl\Index\Index;
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
//$Ary_Result= $Obj_Frame->user_popedom("FireWall::setFirewallRule",true);

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "bridgeset",0);
$param = $Obj_Frame->load_interargs();
//TLOG_MSG("bridgeset: func begin interface=".$param['interface']);
$arrnic=array();

$nic_data= $Obj_Frame->file_content("/usr/local/comm_platform/tool/cur_nic_data.conf","物理接口配置文件",3010,$interr,$strerr);
//TLOG_MSG("bridgeset: func begin 1 nic_data=".$nic_data);
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

$fulldata = "";
$resnic=array();
$content= $Obj_Frame->file_content("/usr/local/comm_platform/tool/cur_bridge_data.conf","桥接口配置文件",3010,$interr,$strerr);
//if ($content===false){return $this->result_set($interr,$strerr);}
//TLOG_MSG("bridgeset: func begin 1 content=".$content);
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
            //TLOG_MSG("bridgeset: func begin 1 tmpnic=".$tmp[$index]);
            $use_nic[] = $tmp[$index];
        }
        
        if (0 == strcmp($param['interface'], $tmp[$index]))
        {
            //TLOG_MSG("bridgeset: we can find name name=".$tmp[$index]);
            $fulldata = $nicinfo;
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
        //TLOG_MSG("bridgeset: tmpnic111=".$arrnic[$nicidx]);
        $resultnic[] = $arrnic[$nicidx];
    }
}

$selnic = array();
$split_data = explode(",", $fulldata);
$ipinfo = $split_data[2]."/".$split_data[3];
for($index=0;$index<count($split_data);$index++)
{
    if (strstr($split_data[$index], "eth"))
    {
        $selnic[] = $split_data[$index];
    }
}
    
$tmpdata = "";
$sortdata = array();
for($i=0;$i<count($resultnic);$i++)
{
    $tmpdata = $resultnic[$i].",0";
    $sortdata[] = $tmpdata;
}
    
for($i=0;$i<count($selnic);$i++)
{
    $tmpdata = $selnic[$i].",1";
    $sortdata[] = $tmpdata;
}

sort($sortdata);

for($i=0;$i<count($sortdata);$i++)
{
    $tmp = explode(",", $sortdata[$i]);
    TLOG_MSG("bridgeset: data[0]=".$tmp[0]." data[1]=".$tmp[1]);
}

$nicidx = 0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改桥接口 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Bridge_Set(this);"  submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>修改桥接口</div>
    </caption>
    <tbody>
      <tr>
        <td class="t">名称：</td>
        <td class="c"><input id="name" name="name" type="text" class="input" disabled="disabled" value="<?=$split_data[0]?>" /></td>
      </tr>
      <tr>
        <td class="t">IP地址：</td>
        <td class="c"><input id="sip" name="sip" type="text" class="input" value="<?=$split_data[2]?>" /></td>
      </tr>
      <tr>
        <td class="t">子网掩码：</td>
        <td class="c"><input id="mask" name="mask" type="text" class="input" value="<?=$split_data[3]?>" /></td>
      </tr>
      <tr>
        <td class="t">接口列表：</td>
         <td class="c">
          <?php
            for($i=0;$i<count($sortdata);$i++)
            {
                $tmp = explode(",", $sortdata[$i]);
                if (0 == strcmp($tmp[1], "0"))
                {
                ?>
                <input name="nic_<?=$i?>" type="checkbox" class="input" id="nic_<?=$i?>" value="<?=$tmp[0]?>" /><span><?=$tmp[0]?></span>
                <?php 
                }else
                    {
                 ?>
                 <input name="nic_<?=$i?>" type="checkbox" class="input" id="nic_<?=$i?>"  checked ='checked' value="<?=$tmp[0]?>" /><span><?=$tmp[0]?></span>
                 <?php }
		          ?>
            <?php }
		      ?>
      </tr>
      <tr>
        <td class="t">启用/禁用：</td>
        <td class="c"><select id="ptype" name="ptype" size="1">
            <option value="down" <?php if ($split_data[1]=='1'){ echo(' selected'); }?>>禁用</option>
            <option value="up" <?php if ($split_data[1]=='0'){ echo(' selected'); }?>>启用</option>
        </select></td>
      </tr>
      <tr>
        <td colspan="2" class="f">
      		<div class="left130">
        	<input type="submit" id="btnsave" name="btnsave" value="保存" class="btn" />
            <input type="reset" id="btnreset" value="重置" class="btn" />
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='bridgeset.php'"/>
            </div>
        </td>
      </tr>
    </tbody>
  </table>
  <input name="nic" 		id="nic" 		type="hidden" value="111" />
  <input name="php_interface" type="hidden" id="php_interface" value="Bridge::setBridgeInfo" />
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