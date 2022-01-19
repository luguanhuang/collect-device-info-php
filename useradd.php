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

$user = &$_SESSION[_GLO_SESSION_USERINFO_]['username'];
TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "UserAdd",0);
TLOG_MSG("user: func begin tmp=".$tmp." user=".$user);
$arrnic=array();

$comid = 0;
$grpid = 0;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("User::getAddUserList",1,false);
$Ary_Params	= $Ary_Result['result']['pagequery'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>add user  - <?=_GLO_PROJECT_FNAME_?></title>
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return AddUser_Validate(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>add user </div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">

				   <tr>
                      <td class="t">Name：</td>
                      <td class="c"><input class="input" id="name" name="name" type="text"></td>
                    </tr>
					
					<tr>
                      <td class="t">Username：</td>
                      <td class="c"><input class="input" id="username" name="username" type="text"></td>
                    </tr>
					<tr>
                      <td class="t">LoginPassword：</td>
                      <td class="c"><input class="input" id="password" name="password" type="Password" required
       minlength="6"></td>
                    </tr>
					
					<tr>
                      <td class="t">Data Writepassword：</td>
                      <td class="c"><input class="input" id="writepassword" name="writepassword" type="Password" required
       minlength="6"></td>
                    </tr>

					<tr>
                      <td class="t">Mobile number：</td>
                      <td class="c"><input class="input" id="mobilenumber" name="mobilenumber" type="text" required
       minlength="10"></td>
                    </tr>
					<tr>
                      <td class="t">Email：</td>
                      <td class="c"><input class="input" id="email" name="email" type="text"></td>
                    </tr>
					
					 <tr>
                      <td class="t">Rolename：</td>
						<td class="c"><select id="rolename" name="rolename">	
						<option value="-1">Select Role name</option>
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
						?>
						
						<option value="<?=$row['id']?>"><?=$row['name']?></option>
						
					<?php }
					}
					?>			
					</select>
						</td>
				   
					</tr>
					
					 <tr>
					<td class="t">Companyname：</td>

					<td class="c"><select id="companyname" name="companyname" <?=$companydisable?> onchange="document.forms.frm.php_interface.value='Company::getGroupInfo'; gradeChange();">
					<option value="-1">Select Company Name</option>
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
					
					<td class="c"><select id="groupname" name="groupname" <?=$groupdisable?> onchange="document.forms.frm.php_interface.value='Station::getStationNameInfo'; groupChange();">
					<option value="-1">Select Group name</option>
							
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
								/*if (($useinfo[0] != 1 || $useinfo[0] != 2) && $useinfo[2] != $k)
									continue;
								//if ($useinfo[0] != 1 && $useinfo[1] != $k)
									//continue;
								if ($useinfo[0] == 3 && $useinfo[2] == $k)
									$selectitem = "selected = \"selected\"";*/
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
					<option value="-1">Select Station name</option>
					
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
                      <td class="t">Active：</td>
                      <td class="c"><input class="input" id="active" name="active" type="checkbox"></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='User::addUser';">
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
      <input name="php_interface" type="hidden" id="php_interface" value="User::addUser">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['name','username','password','rolename','companyname','groupname','stationname','active','mobilenumber','email','writepassword'],'actstep']" >
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