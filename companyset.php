<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "CompanySet",0);

$arrnic=array();

$Obj_Frame = new AtherFrameWork();
$param = $Obj_Frame->load_interargs();
$nic_data= $Obj_Frame->file_content("/usr/local/comm_platform/etc/cur_nic_data.conf","物理接口配置文件",3010,$interr,$strerr);
$check="";
if (1 == $param['status'])
	$check="checked";
TLOG_MSG("CompanySet: func begin  id=".$param['id']);// $param['id']
$nicredata = explode("|",$nic_data);
$nicname="";

foreach ($nicredata as $nic)
{
    $tmpnic = explode(",", $nic);
    for($index=0;$index<count($tmpnic);$index++)
    {
        //TLOG_MSG("routeset: index=".$index." data=".$tmpnic[$index]);
        if (0 == $index)
        {
            $nicname = $tmpnic[$index];
        }
        
        if (3 == $index && 0 == intval($tmpnic[$index]))
        {
            
           $arrnic[] = $nicname;
            
        }
        /*if (strstr($tmpnic[$index], "eth"))
        {
            $arrnic[] = $tmpnic[$index];
            //TLOG_MSG("bridgeset: tmpnic=".$tmpnic[$index]);
        }*/
    }
}


$Ary_Result= $Obj_Frame->user_popedom("Router::setRoute",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>add company - <?=_GLO_PROJECT_FNAME_?></title>
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Company_Edit(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>edit company</div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">
				   <tr>
                      <td class="t">companyname：</td>
                      <td class="c"><input class="input" id="companyname" name="companyname" type="text" value="<?=$param['companyname']?>"></td>
                    </tr>
					<tr>
                      <td class="t">active：</td>
                <!--      <td class="c"><input class="input" id="active" name="active" type="checkbox" <?=$check?> value="<?=$param['status']?>"></td> -->
                        <td style="text-align:left;"> <label class="switch"><input class=input id="active" name="active" type="checkbox" <?=$check?> value="<?=$param['status']?>"><span class="slider round"></span></label></td>
                    </tr>
					<tr>
                      <td class="t" style="display:none">id：</td>
                      <td class="c" style="display:none"><input class="input" id="id" name="id" type="text" value="<?=$param['id']?>"></td>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave">
                      <input class="btn" id="btnreset" type="button" value="reset" onclick="textClear()">
                      <input class="btn" id="btnreset" type="button" value="return" onclick="window.location.href='company.php'">
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
      <input name="actstep"  id="actstep" type="hidden" value="edit">
      <input name="php_interface" type="hidden" id="php_interface" value="Company::editCompany">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['companyname','active','id'],'actstep']" >
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