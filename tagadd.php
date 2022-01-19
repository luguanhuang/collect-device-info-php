<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "tagset",0);

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
$srt .= ",";
$srt .= strval($param['stationname']);
TLOG_MSG("DeviceSet: func begin1111 ".$param['companyname']);
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
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Tag_Setting(this);" submitwin="ajax" method="post">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>add tag</div>
        </caption>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
              <table id="net" border="0">
			  <input name="id" id="id" type="hidden" value="<?=$param['id']?>" />
			  <input name="devicename" id="devicename" type="hidden" value="<?=$param['devname']?>" />
                <tr>
                  <td colspan="2" style="padding: 0; border: 0;">
					<tr>
                      <td class="t">tagid：</td>
                      <td class="c"><input class="input" id="tagid" name="tagid" type="text" value=""></td>
                    </tr>
					<tr>
                      <td class="t">tagname：</td>
                      <td class="c"><input class="input" id="tagname" name="tagname" type="text" value=""></td>
                    </tr>
					<tr>
                      <td class="t">tag desc：</td>
                      <td class="c"><input class="input" id="tagdesc" name="tagdesc" type="text" value=""></td>
                    </tr>
					<tr>
                      <td class="t">webshow：</td>
                      <td class="c"><input class="input" id="webshow" name="webshow" type="checkbox" ></td>
					</tr>
					<tr>
					  <td class="t">coiltype：</td>
                      <td class="c"><input class="input" id="coiltype" name="coiltype" type="checkbox" ></td>
					  </tr>
					  <tr>
					  <td class="t">writeenable：</td>
                      <td class="c"><input class="input" id="writeenable" name="writeenable" type="checkbox" ></td>
					  </tr>
                    </tr>
                  </td>
                </tr>
                <tr>
                  <td  class="f" colspan="2">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='Channel::AddTag';">
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
      <input name="php_interface" type="hidden" id="php_interface" value="Channel::AddTag">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['id','devicename','tagid','tagname','tagdesc','webshow'],'actstep']" >
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