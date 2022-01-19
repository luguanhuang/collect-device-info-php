<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

require("services/Config.php");

error_reporting(0);
session_start();
$Int_Report	= ini_get('error_reporting');
error_reporting($Int_Report);
$selectitem = "";

$dairlyselectitem = "";
$hourselectitem = "";
$notselect = "";

$tmp = &$_SESSION[_GLO_SESSION_USERINFO_]['userinfo'];
$useinfo = explode(',',$tmp);
$user = &$_SESSION[_GLO_SESSION_USERINFO_]['username'];

$companydisable = "";
$groupdisable = "";
$stationdisable = "";

if ($useinfo[0] == 2)
{
	$companydisable = "disabled=\"disabled\"";
}
else if ($useinfo[0] == 3)
{
	$companydisable = "disabled=\"disabled\"";
	$groupdisable = "disabled=\"disabled\"";
}
else if ($useinfo[0] == 4)
{
	$companydisable = "disabled=\"disabled\"";
	$groupdisable = "disabled=\"disabled\"";
	$stationdisable = "disabled=\"disabled\"";
}

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "channelset",0);

$arrnic=array();

$Obj_Frame = new AtherFrameWork();
$param = $Obj_Frame->load_interargs();
$check="";
$history="";
$Alarmchannel="";
$selectitem="";
$groupitem="";
if (1 == $param['status'])
	$check="checked";

if (1 == $param['history'])
	$history="checked";

if (1 == $param['Alarmchannel'])
	$Alarmchannel="checked";

$srt="";
$srt .= strval($param['companyname']);
$srt .= ",";
$srt .= strval($param['groupname']);
$srt .= ",";
$srt .= strval($param['stationname']);
TLOG_MSG("DeviceSet: func begin1111 ".$param['companyname']." reporttype=".$param['reporttype']);
$Ary_Result= $Obj_Frame->load_page("Channel::getDevCompAllInfo",$srt,false);
$Ary_Params	= $Ary_Result['result']['pagequery'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>add channel  - <?=_GLO_PROJECT_FNAME_?></title>
    <link type="text/css" rel="stylesheet" href="css.css">
    <style type="text/css">
      table {
        min-width: 500px;
      }
      .t {
        width: 180px;
      }
      .c {
        width: 320px;
      }
    </style>
  </head>
  <body>
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Channel_Setting(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>edit channel </div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">
				   
				   <tr>
					<td class="t">companyname：</td>

					<td class="c"><select id="companyname" name="companyname" <?=$companydisable?> onchange="document.forms.frm.php_interface.value='Company::getGroupInfo'; gradeChange();">
					
					<?php
						if (is_array($Ary_Result['result']['data'])){
							foreach($Ary_Result['result']['data'] as $k=>$row){
								$k = $row['id'];
								
								$selectitem = "";
								
								if ($useinfo[0] == 1 && $param['companyname'] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else
								{
									if ($useinfo[0] == 2 && $param['companyname'] == $row['id'])
									$selectitem = "selected = \"selected\"";
									else if ($useinfo[0] == 3 && $useinfo[1] == $k)
										$selectitem = "selected = \"selected\"";
									else if ($useinfo[0] == 4 && $useinfo[1] == $k)
										$selectitem = "selected = \"selected\"";
									else
									continue;
								}
								
						?>
						
						<option value="<?=$k?>" <?=$selectitem?> ><?=$row['companyname']?></option>
						
					<?php }
					}
					?>
					</select>
						</td>
					
                      
                    </tr>
				   
				   <tr>
					<td class="t">groupname：</td>
					
					<td class="c"><select id="groupname" name="groupname" <?=$groupdisable?> onchange="document.forms.frm.php_interface.value='Station::getStationNameInfo'; groupChange();">
					
					<?php
						if (is_array($Ary_Result['result']['datainfo'])){
							foreach($Ary_Result['result']['datainfo'] as $k=>$row){
								$k = $row['id'];
								
								if ($useinfo[0] == 1 || $useinfo[0] == 2)
								{
									if ($param['groupname'] == $row['id'])
									$selectitem = "selected = \"selected\"";
									else
										$selectitem = "";
								}
								else if($useinfo[0] == 3 && $param['groupname'] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else if($useinfo[0] == 4 && $param['groupname'] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else 
									continue;
								
						?>
						
						<option value="<?=$k?>" <?=$selectitem?> ><?=$row['name']?></option>
						
					<?php }
					}
					?>
					</select>
						</td>
					
                      
                    </tr>
					<tr>
                      <td class="t" style="display:none">id：</td>
                      <td class="c" style="display:none"><input class="input" id="id" name="id" type="text" value="<?=$param['id']?>"></td>
                    </tr>
					<tr>
					<td class="t">stationname：</td>
					
					<td class="c"><select id="stationname" <?=$stationdisable?> name="stationname">
					
					<?php
						if (is_array($Ary_Result['result']['stainfo'])){
							foreach($Ary_Result['result']['stainfo'] as $k=>$row){
								$k = $row['id'];
								
								if ($useinfo[0] == 1 || $useinfo[0] == 2 || $useinfo[0] == 3)
								{
									if ($param['stationname'] == $row['id'])
										$selectitem = "selected = \"selected\"";
									else
										$selectitem = "";
								}
								else if($useinfo[0] == 4 && $param['stationname'] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else 
									continue;
								
						?>
						
						<option value="<?=$k?>" <?=$selectitem?> ><?=$row['name']?></option>
						
					<?php }
					}
					?>
					</select>
						</td>
					
                      
                    </tr>
					
					<tr>
					<td class="t">devicename：</td>
					
					<td class="c"><select id="devicename" name="devicename">
					
					<?php
						if (is_array($Ary_Result['result']['devinfo'])){
							foreach($Ary_Result['result']['devinfo'] as $k=>$row){
								$k = $row['id'];
								if ($param['devname'] == $row['name'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
						?>
						
						<option value="<?=$row['name']?>" <?=$selectitem?> ><?=$row['name']?></option>
						
					<?php }
					}
					?>
					</select>
						</td>
					
                      
                    </tr>
					<tr>
                      <td class="t">dtype：</td>
						<td class="c"><select id="dtype" name="dtype">	
						<?php
						if (is_array($Ary_Result['result']['dtypeinfo'])){
							foreach($Ary_Result['result']['dtypeinfo'] as $k=>$row){
								$k = $row['id'];
								if ($param['dtype'] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
						?>
						
						<option value="<?=$row['id']?>" <?=$selectitem?> ><?=$row['name']?></option>
						
					<?php }
					}
					?>			
					</select>
						</td>
				   
					</tr>
				   
				   <tr>
                      <td class="t">reporttype：</td>
						<td class="c"><select id="reporttype" name="reporttype">
						<?php
						
								if ($param['reporttype'] == 1)
									$dairlyselectitem = "selected = \"selected\"";
								else if($param['reporttype'] == 2)
									$hourselectitem = "selected = \"selected\"";
								else
									$notselect = "selected = \"selected\"";
								
								
						?>
						
						<option value="1" <?=$dairlyselectitem?> >dailyreport</option>
						<option value="2" <?=$hourselectitem?> >hourlyreport</option>
						<option value="-1" <?=$notselect?> >Please select Report type</option>
					</select>
						</td>
				   
					</tr>
				   
					<tr>
                      <td class="t">slaveid：</td>
                      <td class="c"><input class="input" id="slaveid" name="slaveid" type="text" value="<?=$param['slaveid']?>"></td>
                    </tr>
					<tr>
                      <td class="t">chid：</td>
                      <td class="c"><input class="input" id="chid" name="chid" type="text" disabled="disabled" value="<?=$param['chid']?>"></td>
                    </tr>
					<tr>
                      <td class="t">funcode：</td>
                      <td class="c"><input class="input" id="funcode" name="funcode" type="text" value="<?=$param['funcode']?>"></td>
                    </tr>
					<tr>
                      <td class="t">startreg：</td>
                      <td class="c"><input class="input" id="startreg" name="startreg" type="text" value="<?=$param['startreg']?>"></td>
                    </tr>
					<tr>
                      <td class="t">countreg：</td>
                      <td class="c"><input class="input" id="countreg" name="countreg" type="text" value="<?=$param['countreg']?>"></td>
                    </tr>
				   <tr>
                      <td class="t">chdesc：</td>
                      <td class="c"><input class="input" id="chdesc" name="chdesc" type="text" value="<?=$param['chdesc']?>"></td>
                    </tr>
					<tr>
                      <td class="t">active：</td>
                      <td class="c"><input class="input" id="active" name="active" type="checkbox" <?=$check?> ></td>
                    </tr>
					<tr>
                      <td class="t">history：</td>
                      <td class="c"><input class="input" id="history" name="history" type="checkbox" <?=$history?> ></td>
                    </tr>
					<tr>
                      <td class="t">Alarmchannel：</td>
                      <td class="c"><input class="input" id="Alarmchannel" name="Alarmchannel" type="checkbox" <?=$Alarmchannel?> ></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='Channel::editChannel';">
                      <input class="btn" id="btnreset" type="button" value="reset" onclick="textClear()">
                      <input class="btn" id="btnreset" type="button" value="return" onclick="window.location.href='channel.php'">
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!--<tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table style="display: none;" id="host" border="0">
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">
                    <tr>
                      <td class="t">网段：</td>
                      <td class="c"><input id="textClear" name="ip" type="text" class="input"></td>
                    </tr>
                    <tr>
                      <td class="t">接口名称：</td>
                      <td class="c">
                        <select id="ifname" name="ifname" size="1">
                          <?php
                            for($i=0;$i<count($arrnic);$i++)
                          {?>
                          <option value="<?=$arrnic[$i]?>"><?=$arrnic[$i]?></option>
                          <?php }
                          ?>
                        </select>
                      </td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="保存" name="btnsave">
                      <input class="btn" id="btnreset" type="button" value="重置" onclick="document.getElementById('textClear').value=''">
                      <input class="btn" id="btnreset" type="button" value="返回" onclick="window.location.href='route.php'">
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>-->
        </tbody>
      </table>
      <input name="actstep"  id="actstep" type="hidden" value="add">
      <input name="php_interface" type="hidden" id="php_interface" value="Channel::addChannel">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['id','devicename','dtype','slaveid','funcode','startreg','countreg','querystr','resstr','active','companyname','groupname','stationname','history','chdesc','reporttype','Alarmchannel'],'actstep']" >
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal">
    </form>
    <?php
      require('footer.html');
      require('loadjs.html');
    ?>
    <script type="text/javascript" src="js/route.js"></script>
    <?php
      unset($Ary_Result); $Ary_Result = NULL;
      unset($Obj_Frame);  $Obj_Frame  = NULL;
    ?>
    <script type="text/javascript">
      var sel_val = 'net';
      function change() {
        sel_val = document.getElementById('type').value;
        var net_id = document.getElementById('net');
        var host_id = document.getElementById('host');
        var host_id2 = document.getElementById('host2');
        if(sel_val == 'net') {
          net_id.style.display = 'block';
          host_id.style.display = 'block';
          host_id2.style.display = 'block';
          sel_val = 'host';
        }
        else {
          net_id.style.display = 'block';
          host_id.style.display = 'none';
          host_id2.style.display = 'none';
          sel_val = 'net';
        }
      }
      function textClear() {
        document.getElementById('ip').value='';
        document.getElementById('netgate').value='';
      }
    </script>
  </body>
</html>