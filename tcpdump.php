<?php
require("services/AtherFrameWork.php");
require("services/LogService.php");
global $Obj_Frame;
global $Ary_Result;

$arrnic=array();
$Obj_Frame = new AtherFrameWork();
$nic_data= $Obj_Frame->file_content("/usr/local/comm_platform/etc/cur_nic_data.conf","物理接口配置文件",3010,$interr,$strerr);
TLOG_MSG("routeset: func begin 1 nic_data=".$nic_data);
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

//$Ary_Result	= $Obj_Frame->load_page("LogService::getLog()");

//$Ary_Result= $Obj_Frame->user_getlogin(true);
//返回菜单选项

$Ary_List	= array(
	'logtype'	=> LogService::getConfigTypes()
);


	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Adsl - <?=_GLO_PROJECT_FNAME_?></title>
    <link rel="stylesheet" href="css.css" type="text/css" >
  </head>
  <body >
    <div class="nav">
      <div><span></span>抓包信息</div>
    </div>
    <form method="post" id="Adslresult" name="Adslresult" action="submit.php" submitwin="ajax">
    	<table style="width: 99%; height: 95%;" class="tab2 b" align="center" cellpadding="0" cellspacing="0" border="0"  border="0"> 
        <tr>
          <td class="td_width" id="td_padding">
            <select style="padding: 2px 0;" id="infotype" name="infotype">
              <?php
                for($i=0;$i<count($arrnic);$i++)
              {?>
              <option value="<?=$arrnic[$i]?>"><?=$arrnic[$i]?></option>
              <?php }
      		    ?>
            </select>
            <span>过滤条件</span>
            <input style="padding: 3px 0; text-indent: 5px;" id="filter_info" name="filter_info" value="icmp">
            <span>抓包个数</span>
            <input style="padding: 3px 0; text-indent: 5px;" id="count" name="count" value="10000">
            <input id="php_interface" type="hidden" name="php_interface" value="LogService::starttcpdumpdis">
            <input id="php_parameter" type="hidden" name="php_parameter" value="[['infotype','filter_info','count']]">
            <input id="php_returnmode" type="hidden" name="php_returnmode" value="json">
            <span class="btn-posit">
              <input class="btn" id="startbtdis" type="button" name="startbtdis" value="开始抓包（显示）" onclick="document.forms.Adslresult.Adslmessage.value=''; document.forms.Adslresult.php_interface.value='LogService::starttcpdumpdis'; setEthconfig();">
              <input class="btn" id="startbtdis" type="button" name="startbtdis" value="显示抓包" onclick="document.forms.Adslresult.php_interface.value='LogService::distcpdump'; getEthconfigInfo();">      
              <input class="btn" id="startbtdown" type="button" name="startbtdown" value="开始抓包(下载)" onclick="document.forms.Adslresult.php_interface.value='LogService::starttcpdumpdown'; setEthconfig();">    
              <input class="btn" id="btnrefresh" type="button" value="下载抓包文件" onclick="window.location.href='tcpdumpexport.php'">
              <input class="btn" id="stopbt" type="button" name="stopbt" value="停止抓包" onclick="document.forms.Adslresult.php_interface.value='LogService::stoptcpdump'; setEthconfig();">
            </span>
          </td>
        </tr>
        <tr style="width: 100%; height: 100%;">
          <td align="center" id="cmdbox2" style="width: 100%; height: 100%;">
            <textarea style="width: 100%; height: 600px;" name="Adslmessage" id="Adslmessage"></textarea>
          </td>
        </tr>
      </table>
    </form>
    <?php
      require('footer.html');
      require('loadjs.html');
    ?>
    <script type="text/javascript" src="js/logtest.js"></script>
    <?php
      unset($Ary_Result); $Ary_Result = NULL;
      unset($Obj_Frame);	$Obj_Frame  = NULL;
    ?>
  </body>
</html>