<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "UserSet",0);

$arrnic=array();
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

$Obj_Frame = new AtherFrameWork();
$param = $Obj_Frame->load_interargs();
$check = "";
if (1 == $param['status'])
	$check="checked";
$srt="";
$srt .= strval($param['companyname']);
$srt .= ",";
$srt .= strval($param['groupname']);
TLOG_MSG("DeviceSet: func roll ".$param['roll']." id=".$param['id']." passwd=".$param['password']);
$Ary_Result= $Obj_Frame->load_page("User::getUserAllData",$srt,false);
$Ary_Params	= $Ary_Result['result']['pagequery'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>edit user  - <?=_GLO_PROJECT_FNAME_?></title>
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return User_Setting(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>Edit user </div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">

				   <tr>
                      <td class="t">Name：</td>
                      <td class="c"><input class="input" id="name" name="name" type="text" value="<?=$param['name']?>" ></td>
                    </tr>
					
					<tr>
                      <td class="t">Username：</td>
                      <td class="c"><input class="input" id="username" name="username" type="text" value="<?=$param['username']?>"></td>
                    </tr>
					
					<tr>
                      <td class="t">Mobile：</td>
                      <td class="c"><input class="input" id="mobile" name="mobile" type="text" required
       minlength="10" value="<?=$param['mobile']?>"></td>
                    </tr>
					
					<tr>
                      <td class="t">Email：</td>
                      <td class="c"><input class="input" id="email" name="email" type="text" value="<?=$param['email']?>"></td>
                    </tr>
					
					<tr>
                      <td class="t">Loginpasswd：</td>
                      <td class="c"><input class="input" id="passwd" name="passwd" type="Password" required
       minlength="6" value=""></td>
                    </tr>
					
					<tr>
                      <td class="t">Data Writepassword ：</td>
                      <td class="c"><input class="input" id="writepassword " name="writepassword" type="Password" required
       minlength="6" value=""></td>
                    </tr>
					
					 <tr>
                      <td class="t" style="display:none">id：</td>
                      <td class="c" style="display:none"><input class="input" id="id" name="id" type="text" value="<?=$param['id']?>"></td>
                    </tr>
					
					 <tr>
                      <td class="t">Rolename：</td>
						<td class="c"><select id="rolename" name="rolename">	
						<option value="-1">select role name</option>
						<?php
						if (is_array($Ary_Result['result']['roleinfo'])){
							foreach($Ary_Result['result']['roleinfo'] as $k=>$row){
								$k = $row['id'];
								
								if ($row['id'] == 1 && $useinfo[0] == 2)
									continue;
								else if (($row['id'] == 1 || $row['id'] == 2 || $row['id'] == 5)
									&& $useinfo[0] == 3)
									continue;
								else if (($row['id'] == 1 || $row['id'] == 2 || $row['id'] == 5 || $row['id'] == 3 || $row['id'] == 6)
									&& $useinfo[0] == 4)
									continue;
								
								if ($param['roll'] == $row['id'])
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
					<td class="t">Companyname：</td>

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
					<td class="t">Groupname：</td>
					
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
					<td class="t">Stationname：</td>
					
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
                      <td class="t">Active：</td>
                      <td class="c"><input class="input" id="active" name="active" type="checkbox" <?=$check?> ></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='User::editUser';">
                      <input class="btn" id="btnreset" type="button" value="reset" onclick="textClear()">
                      <input class="btn" id="btnreset" type="button" value="return" onclick="window.location.href='user.php'">
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
      <input name="php_interface" type="hidden" id="php_interface" value="User::addUser">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['name','username','password','rolename','companyname','groupname','stationname','active','id','mobile','email','writepassword','passwd'],'actstep']" >
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

  </body>
</html>