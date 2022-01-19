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
$tmp = &$_SESSION[_GLO_SESSION_USERINFO_]['userinfo'];
$useinfo = explode(',',$tmp);
$user = &$_SESSION[_GLO_SESSION_USERINFO_]['username'];

$companydisable = "";
$groupdisable = "";
$stationdisable = "";

$box1sel = "";
$box2sel = "";
$box3sel = "";
$box4sel = "";

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

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "DeviceSet",0);
$styleinfo = "";
$arrnic=array();

$Obj_Frame = new AtherFrameWork();
$param = $Obj_Frame->load_interargs();
$check="";
$selectitem="";
$groupitem="";
if (1 == $param['status'])
	$check="checked";
$srt="";
$srt .= strval($param['companyname']);
$srt .= ",";
$srt .= strval($param['groupname']);
TLOG_MSG("DeviceSet: func begin1111 ".$param['companyname']);
$Ary_Result= $Obj_Frame->load_page("Station::getStationCompAllInfo",$srt,false);
$Ary_Params	= $Ary_Result['result']['pagequery'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>edit device  - <?=_GLO_PROJECT_FNAME_?></title>
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Device_Setting(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>edit device </div>
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
					<option value="-1">select company name</option>
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
					<option value="-1">select group name</option>
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
					<td class="t">stationname：</td>
					
					<td class="c"><select id="stationname" name="stationname" <?=$stationdisable?> >
					<option value="-1">select station name</option>
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
                      <td class="t">socktype：</td>
						<td class="c"><select id="socktype" name="socktype" onchange="change()">
						<?php
						if ("1" == $param['socktype'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
							
						?>
						<option value="1" <?=$selectitem?> >tcp server</option>
						
						<?php
						if ("2" == $param['socktype'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
							
						?>
						<option value="2" <?=$selectitem?> >tcp client</option>
					
					</select>
						</td>
				   
					</tr>
					
					<table id="ip" border="0" >
					<?php  
						if ("1" == $param['socktype'])
									$selectitem = "style=\"display:none\"";
								else
									$selectitem = "";
							
						?>
				   <tr id="servipinfo" <?=$selectitem?>>
                      <td class="t">servip：</td>
                      <td class="c"><input class="input" id="servip" name="servip" type="text" value="<?=$param['servip']?>"></td>
                    </tr>
					</table>
					<table id="port" border="0" >
					<?php  
						if ("1" == $param['socktype'])
									$selectitem = "style=\"display:none\"";
								else
									$selectitem = "";
							
						?>
					<tr id="servportinfo" <?=$selectitem?> >
                      <td class="t">servport：</td>
                      <td class="c"><input class="input" id="servport" name="servport" type="text" value="<?=$param['servport']?>"></td>
                    </tr>
					</table>
					<?php  
						if ("2" == $row['name'])
									$selectitem = "style=\"display:none\"";
								else
									$selectitem = "";
							
						?>
				   <table id="mac" border="0">
						<tr id="macinfo" <?=$selectitem?>>

                      <td class="t">macid：</td>
                      <td class="c"><input class="input" id="macid" name="macid" type="text" value="<?=$param['macid']?>"></td>
                    </tr>
				   </table>
					
					<tr>
					<td class="t">ptype：</td>
					
					<td class="c"><select id="ptype" name="ptype" onchange="document.forms.frm.php_interface.value='Station::getStationNameInfo'; groupChange();">
					<option value="-1">select ptype</option>
					<?php
						if (is_array($Ary_Result['result']['ptypeinfo'])){
							foreach($Ary_Result['result']['ptypeinfo'] as $k=>$row){
								$k = $row['id'];
								if ($param['ptype'] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
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
				   <tr>
                      <td class="t">devicename：</td>
                      <td class="c"><input class="input" id="devicename" name="devicename" type="text" value="<?=$param['devname']?>" disabled></td>
                    </tr>
					
					<tr>
                      <td class="t">retry：</td>
                      <td class="c"><input class="input" id="retry" name="retry" type="text" value="<?=$param['retry']?>"></td>
                    </tr>
					<tr>
                      <td class="t">timeout：</td>
                      <td class="c"><input class="input" id="timeout" name="timeout" type="text" value="<?=$param['timeout']?>"></td>
                    </tr>
					</tr>
                      <td class="t">polltime：</td>
                      <td class="c"><input class="input" id="polltime" name="polltime" type="text" value="<?=$param['polltime']?>"></td>
                    
				   
					</tr>
					
				   
					<tr>
                      <td class="t">devicedesc：</td>
                      <td class="c"><input class="input" id="devicedesc" name="devicedesc" type="text" value="<?=$param['devicedesc']?>"></td>
                    </tr>
					</tr>
                      <td class="t">templatelocation：</td>
                      <td class="c"><input class="input" id="templatelocation" name="templatelocation" type="text" value="<?=$param['templatelocation']?>"></td>
                    
				   
					</tr>
					
					</tr>
                      <td class="t">pic1filelocation：</td>
                      <td class="c"><input class="input" id="pic1filelocation" name="pic1filelocation" type="text" value="<?=$param['pic1filelocation']?>"></td>
                    
				   
					</tr>
					
					</tr>
                      <td class="t">pic2filelocation：</td>
                      <td class="c"><input class="input" id="pic2filelocation" name="pic2filelocation" type="text" value="<?=$param['pic2filelocation']?>"></td>
                    
				   
					</tr>
					
					</tr>
                      <td class="t">pic3filelocation：</td>
                      <td class="c"><input class="input" id="pic3filelocation" name="pic3filelocation" type="text" value="<?=$param['pic3filelocation']?>"></td>
                    
				   
					</tr>
					
					</tr>
                      <td class="t">pic4filelocation：</td>
                      <td class="c"><input class="input" id="pic4filelocation" name="pic4filelocation" type="text" value="<?=$param['pic4filelocation']?>"></td>
                    
				   
					</tr>
					
					<tr>
                      <td class="t">mainpagediv：</td>
						<td class="c"><select id="mainpagediv" name="mainpagediv"">
						<?php
						if ("1" == $param['mainpagediv'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
							
						?>
						<option value="1" <?=$selectitem?> >1</option>
						
						<?php
						if ("2" == $param['mainpagediv'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
							
						?>
						<option value="2" <?=$selectitem?> >2</option>
					
						<?php
						if ("3" == $param['mainpagediv'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
							
						?>
						<option value="3" <?=$selectitem?> >3</option>
						
						<?php
						if ("4" == $param['mainpagediv'])
									$selectitem = "selected = \"selected\"";
								else
									$selectitem = "";
							
						?>
						<option value="4" <?=$selectitem?> >4</option>
					
					</select>
						</td>
				   
					</tr>
					
					<tr>
                      <td class="t">active：</td>
                      <td class="c"><input class="input" id="active" name="active" type="checkbox" <?=$check?> ></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='Station::editDevice';">
                      <input class="btn" id="btnreset" type="button" value="reset" onclick="textClear()">
                      <input class="btn" id="btnreset" type="button" value="return" onclick="window.location.href='device.php'">
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
      <input name="php_interface" type="hidden" id="php_interface" value="Station::editDevice">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['id','macid','devicename','ptype','servip','servport','retry','timeout','polltime','companyname','groupname','stationname','connected','active','socktype','devicedesc','templatelocation','pic1filelocation','pic2filelocation','pic3filelocation','pic4filelocation','mainpagediv'],'actstep']" >
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
      var sel_val = '1';
      function change() {
		  
		  
        sel_val = document.getElementById('socktype').value;
        var macinfo = document.getElementById('macinfo');
        //var host_id = document.getElementById('host');
        //var host_id2 = document.getElementById('host2');
        if(sel_val == '1') {
			//alert("test 1");
          macinfo.style.display = 'block';
		  servipinfo.style.display = 'none';
		  servportinfo.style.display = 'none';
          //host_id.style.display = 'block';
          //host_id2.style.display = 'block';
          sel_val = '2';
        }
        else {
			//alert("test 2");
			macinfo.style.display = 'none';
		  servipinfo.style.display = 'block';
		  servportinfo.style.display = 'block';
          
         // host_id.style.display = 'none';
         // host_id2.style.display = 'none';
          sel_val = '1';
        }
      }
      function textClear() {
        document.getElementById('ip').value='';
        document.getElementById('netgate').value='';
      }
    </script>
  </body>
</html>