<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
require("services/Config.php");
TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "StationSet",0);

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
$param = $Obj_Frame->load_interargs();
$check="";
$selectitem="";
if (1 == $param['status'])
	$check="checked";
TLOG_MSG("StationSet: func begin ".$param['companyname']);
$Ary_Result= $Obj_Frame->load_page("Company::getCompanyAllInfo",$param['companyname'],false);
$Ary_Params	= $Ary_Result['result']['pagequery'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>edit station - <?=_GLO_PROJECT_FNAME_?></title>
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Station_Setting(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>edit station</div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
			  <tr>
				  <td class="t">stationname：</td>
				  <td class="c"><input class="input" id="stationname" name="stationname" type="text" value="<?=$param['name']?>"></td>
				</tr>
				<tr>
                      <td class="t" style="display:none">id：</td>
                      <td class="c" style="display:none"><input class="input" id="id" name="id" type="text" value="<?=$param['id']?>"></td>
                    </tr>
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

					<td class="c"><select id="groupname" name="groupname" <?=$groupdisable?> >
					
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
                      <td class="t">active：</td>
                      <td class="c"><input class="input" id="active" name="active" type="checkbox" <?=$check?> value="<?=$param['status']?>"></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='Station::setStation';">
                      <input class="btn" id="btnreset" type="button" value="reset" onclick="textClear()">
                      <input class="btn" id="btnreset" type="button" value="return" onclick="window.location.href='group.php'">
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
      <input name="php_interface" type="hidden" id="php_interface" value="Station::setStation">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['companyname','active','groupname','stationname','id'],'actstep']" >
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