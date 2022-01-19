<?php
require("services/AtherFrameWork.php");
require("services/Config.php");
global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "DeviceAdd",0);

error_reporting(0);
session_start();
$Int_Report	= ini_get('error_reporting');
error_reporting($Int_Report);
$tmp = &$_SESSION[_GLO_SESSION_USERINFO_]['userinfo'];
$user = &$_SESSION[_GLO_SESSION_USERINFO_]['username'];
$useinfo = explode(',',$tmp);


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

$arrnic=array();

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("Company::getCompanyList",1,false);
$Ary_Params	= $Ary_Result['result']['pagequery'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>add device  - <?=_GLO_PROJECT_FNAME_?></title>
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Device_Validate(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>add device </div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">
				   
				   <tr>
					<td class="t">companyname：</td>

					<td class="c"><select id="companyname" <?=$companydisable?> name="companyname" onchange="document.forms.frm.php_interface.value='Company::getGroupInfo'; gradeChange();">
					<option value="-1">select company name</option>
					<?php
						if (is_array($Ary_Result['result']['data'])){
							foreach($Ary_Result['result']['data'] as $k=>$row){
								$k = $row['id'];
								$selectitem = "";
								if ($useinfo[0] == 1)
									;
								else if ($useinfo[0] == 2 && $useinfo[1] == $k)
								{
									$selectitem = "selected = \"selected\"";
								}
								else if ($useinfo[0] == 3 && $useinfo[1] == $k)
									$selectitem = "selected = \"selected\"";
								else if ($useinfo[0] == 4 && $useinfo[1] == $k)
									$selectitem = "selected = \"selected\"";
								else 
									continue;
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
					
					<td class="c"><select id="groupname" <?=$groupdisable?> name="groupname" onchange="document.forms.frm.php_interface.value='Station::getStationNameInfo'; groupChange();">
					<option value="-1">select group name</option>
					
					<?php
						if (is_array($Ary_Result['result']['groupinfo'])){
							foreach($Ary_Result['result']['groupinfo'] as $k=>$row){
								$k = $row['id'];
								$selectitem = "";
								if ($useinfo[0] == 1)
									;
								else if($useinfo[0] == 2 && $useinfo[1] == $row['company_id'])
								{
									$selectitem = "selected = \"selected\"";
								}
								else if($useinfo[0] == 3 && $useinfo[1] == $row['company_id'] && $useinfo[2] == $row['id'])
								{
									$selectitem = "selected = \"selected\"";
								}
								else if($useinfo[0] == 4 && $useinfo[1] == $row['company_id'] && $useinfo[2] == $row['id'])
								{
									$selectitem = "selected = \"selected\"";
								}
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
						if (is_array($Ary_Result['result']['stationinfo'])){
							foreach($Ary_Result['result']['stationinfo'] as $k=>$row){
								$k = $row['id'];
								$selectitem = "";
								if ($useinfo[0] == 1)
									;
								else if($useinfo[0] == 2 && $useinfo[1] == $row['company_id'])
									$selectitem = "selected = \"selected\"";
								else if($useinfo[0] == 3 && $useinfo[1] == $row['company_id'] && $useinfo[2] == $row['group_id'])
									$selectitem = "selected = \"selected\"";
								//if ($useinfo[0] != 1 || $useinfo[0] != 2 || $useinfo[0] != 3)
									//continue;
								//if ($useinfo[0] != 1 && $useinfo[1] != $k)
									//continue;
								else if($useinfo[0] == 4 && $useinfo[1] == $row['company_id'] && $useinfo[2] == $row['group_id'] && $useinfo[3] == $row['id'])
									$selectitem = "selected = \"selected\"";
								else 
									continue;
								//if (($useinfo[0] != 1 || $useinfo[0] != 2) && $useinfo[2] != $k)
									//continue;
								//if ($useinfo[0] != 1 && $useinfo[1] != $k)
									//continue;
								//if ($useinfo[0] == 3 && $useinfo[2] == $k)
									//$selectitem = "selected = \"selected\"";
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
						
						<option value="1">tcp server</option>
						<option value="2">tcp client</option>
					
					</select>
						</td>
				   
					</tr>
				   <table id="ip" border="0" >
				   <tr id="servipinfo" style="display:none">
                      <td class="t">servip：</td>
                      <td class="c"><input class="input" id="servip" name="servip" type="text"></td>
                    </tr>
					</table>
					<table id="port" border="0" >
					<tr id="servportinfo" style="display:none">
                      <td class="t">servport：</td>
                      <td class="c"><input class="input" id="servport" name="servport" type="text"></td>
                    </tr>
					</table>
				   <table id="mac" border="0">
						<tr id="macinfo">

                      <td class="t">macid：</td>
                      <td class="c"><input class="input" id="macid" name="macid" type="text"></td>
                    </tr>
				   </table>
				   
					
					 <tr>
                      <td class="t">ptype：</td>
						<td class="c"><select id="ptype" name="ptype">	
						<?php
						if (is_array($Ary_Result['result']['ptypeinfo'])){
							foreach($Ary_Result['result']['ptypeinfo'] as $k=>$row){
								$k = $row['id'];
						?>
						
						<option value="<?=$row['id']?>"><?=$row['name']?></option>
						
					<?php }
					}
					?>			
					</select>
						</td>
				   
					</tr>
					
				   <tr>
                      <td class="t">devicename：</td>
                      <td class="c"><input class="input" id="devicename" name="devicename" type="text"></td>
                    </tr>
				   
					
					
					<tr>
                      <td class="t">retry(count)：</td>
                      <td class="c"><input class="input" id="retry" name="retry" type="text"></td>
                    </tr>
					<tr>
                      <td class="t">timeout(ms)：</td>
                      <td class="c"><input class="input" id="timeout" name="timeout" type="text"></td>
                    </tr>
					<tr>
                      <td class="t">polltime(ms)：</td>
                      <td class="c"><input class="input" id="polltime" name="polltime" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">devicedesc：</td>
                      <td class="c"><input class="input" id="devicedesc" name="devicedesc" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">templatelocation：</td>
                      <td class="c"><input class="input" id="templatelocation" name="templatelocation" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">pic1filelocation：</td>
                      <td class="c"><input class="input" id="pic1filelocation" name="pic1filelocation" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">pic2filelocation：</td>
                      <td class="c"><input class="input" id="pic2filelocation" name="pic2filelocation" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">pic3filelocation：</td>
                      <td class="c"><input class="input" id="pic3filelocation" name="pic3filelocation" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">pic4filelocation：</td>
                      <td class="c"><input class="input" id="pic4filelocation" name="pic4filelocation" type="text"></td>
					</tr>
					
					<tr>
                      <td class="t">mainpagediv：</td>
						<td class="c"><select id="mainpagediv" name="mainpagediv">
						
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					
					</select>
						</td>
				   
					</tr>
					
					<tr>
                      <td class="t">active：</td>
                      <td class="c"><input class="input" id="active" name="active" type="checkbox"></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='Station::addDevice';">
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
      <input name="php_interface" type="hidden" id="php_interface" value="Station::addDevice">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['macid','devicename','ptype','servip','servport','retry','timeout','polltime','companyname','groupname','stationname','connected','active','socktype','devicedesc','templatelocation','pic1filelocation','pic2filelocation','pic3filelocation','pic4filelocation','mainpagediv'],'actstep']" >
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