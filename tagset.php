<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "tagset",0);

$arrnic=array();

$Obj_Frame = new AtherFrameWork();
$param = $Obj_Frame->load_interargs();
$selectitem="";
$groupitem="";
$webshowcheck="";
$coiltypecheck="";
$writeenablecheck="";

if (1 == $param['status'])
	$webshowcheck="checked";
if (1 == $param['status'])
	$coiltypecheck="checked";
if (1 == $param['status'])
	$writeenablecheck="checked";

$srt="";
$srt .= strval($param['devname']);
$srt .= ",";
$srt .= strval($param['id']);
$tagnames="";


TLOG_MSG("tagset: func begin1111 ".$param['countreg']);
$Ary_Result= $Obj_Frame->load_page("Channel::getTagInfo",$srt,false);
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
    <div class="listwrap">
    <form name="frm" id="frm" action="submit.php" onsubmit="javascript:return Tag_Setting(this);" submitwin="ajax" method="post">
      <table class="listtab" align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
        <caption class="nav">
          <div><span></span>Edit tag</div>
        </caption> 

          <thead>

            <input name="dtype" id="dtype" type="hidden" value="<?=$param['id']?>" />
        <tr align="center">
      <td>Channel ID</td>
      <td>Tag ID</td>
      <td>Tag Name</td>
      <td>Tag Description</td>
	   
      <td>Web show</td>
        
	 
     
		
      <?php

      if($param['dtype']== 1){?>
      <td>IS NC contact</td>
      <?php } ?>
      <td>Write Enable</td>
      <td>reportenable </td>
	  <td>mainpageenable </td>
      <td>excellocation</td> 
		<td>mainpagelocation</td>  
        </tr>
      </thead>
        <tbody>
          <tr>
            <td colspan="2" style="padding: 0; border: 0;">
           <!--   <table id="net" border="0"> -->
			  <input name="id" id="id" type="hidden" value="<?=$param['id']?>" />
			  <input name="devname" id="devname" type="hidden" value="<?=$param['devname']?>" />
			  <input name="countreg" id="countreg" type="hidden" value="<?=$param['countreg']?>" />
				<?php
				$i=0;
			for($i=1; $i<=$param['countreg'];$i++){
				$output = array(
				"tagname"=>"",
				"tagdesc"=>"",
				
				"webshow"=>"",
				"coiltype"=>"",
				
				"writeenable"=>""
				);
				
				
				if ($i<$param['countreg'])
				{
					$tagnames.="'channelid_$i',";
					$tagnames.="'tagid_$i',";
					$tagnames.="'tagname_$i',";
					$tagnames.="'tagdesc_$i',";
					$tagnames.="'webshow_$i',";
					$tagnames.="'coiltype_$i',";
					$tagnames.="'writeenable_$i',";
					$tagnames.="'reportenable_$i',";
					$tagnames.="'excellocation_$i',";
					$tagnames.="'mainpageenable_$i',";
					$tagnames.="'mainpagelocation_$i',";
				}
				else
				{
					$tagnames.="'channelid_$i',";
					$tagnames.="'tagid_$i',";
					$tagnames.="'tagname_$i',";
					$tagnames.="'tagdesc_$i',";
					$tagnames.="'webshow_$i',";
					$tagnames.="'coiltype_$i',";
					$tagnames.="'writeenable_$i'";
					$tagnames.="'reportenable_$i',";
					$tagnames.="'excellocation_$i',";
					$tagnames.="'mainpageenable_$i',";
					$tagnames.="'mainpagelocation_$i',";
				}
				
				$webshowcheck="";
				$coiltypecheck="";
				$writeenablecheck="";
				$reportenable="";
				$mainpageenable="";
				
				foreach($Ary_Result['result']['data'] as $k=>$row)
				{
					
					if ($param['id'] == $row['chid'] && $i == $row['tagid'])
					{
						TLOG_MSG("id=$param[id] chid=$row[chid]  i=$i tagid=$row[tagid]");
						$output['tagname'] = $row['tagname'];
						$output['tagdesc'] = $row['tagdesc'];
						
						
						if (1 == $row['webshow'])
							$webshowcheck="checked";
						if (1 == $row['coiltype'])
							$coiltypecheck="checked";
						if (1 == $row['writeenable'])
							$writeenablecheck="checked";
						if (1 == $row['reportenable'])
							$reportenable="checked";
						if (1 == $row['mainpageenable'])
							$mainpageenable="checked";
						break;
					}
				}
				
		?>
                <tr>
              <!--    <td colspan="2" style="padding: 0; border: 0;"> -->
					
					<!--	<td class="t" style="width:20px; height=5px;">channelid：</td> -->
                      <td><input style="width:20px; height=5px;" class="input" id="channelid_<?=$i?>" name="channelid_<?=$i?>" type="text" value="<?=$param['id']?>" disabled></td>
					
            <!--          <td class="t">tagid：</td> -->
                      <td ><input style="width:20px; height=5px;" class="input" id="tagid_<?=$i?>" name="tagid_<?=$i?>" type="text" value="<?=$i?>" disabled></td>
                    
             <!--         <td class="t">tagname：</td> -->
                      <td class="c"><input style="width:150px; height=5px;" class="input" id="tagname_<?=$i?>" name="tagname_<?=$i?>" type="text" value="<?=$output['tagname']?>"></td>
                    
             <!--         <td class="t">tag desc：</td> -->
                      <td class="c"><input style="width:400px; height=5px;" class="input" id="tagdesc_<?=$i?>" name="tagdesc_<?=$i?>" type="text" value="<?=$output['tagdesc']?>"></td>
                    
					
			  
                      <td class="c"><input style="width:10px; height=5px;" class="input" id="webshow_<?=$i?>" name="webshow_<?=$i?>" type="checkbox" <?=$webshowcheck?> ></td>
					<!--     <td class="t">coiltype：</td> -->
                    <?php  if($param['dtype'] == 1){?>
                      <td class="c"><input style="width:10px; height=5px;" class="input" id="coiltype_<?=$i?>" name="coiltype_<?=$i?>" type="checkbox" <?=$coiltypecheck?> ></td>
                    <?php }?>
				<!--	   <td class="t">writeenable：</td> -->
				
				
                      <td class="c"><input style="width:10px; height=5px;" class="input" id="writeenable_<?=$i?>" name="writeenable_<?=$i?>" type="checkbox" <?=$writeenablecheck?> ></td>
                      <td class="c"><input style="width:10px; height=5px;" class="input" id="reportenable_<?=$i?>" name="reportenable_<?=$i?>" type="checkbox" <?=$reportenable?> ></td>
					  <td class="c"><input style="width:10px; height=5px;" class="input" id="mainpageenable_<?=$i?>" name="mainpageenable_<?=$i?>" type="checkbox" <?=$mainpageenable?> ></td>
                    
					  <td><input style="width:20px; height=5px;" class="input" id="excellocation_<?=$i?>" name="excellocation_<?=$i?>" type="text" value="<?=$row['excellocation']?>" ></td>
					  <td><input style="width:40px; height=5px;" class="input" id="mainpagelocation_<?=$i?>" name="mainpagelocation_<?=$i?>" type="text" value="<?=$row['mainpagelocation']?>" ></td>
					
					
                  </td>
                </tr>
                
				 <?php 
				 //TLOG_MSG("$tagnames=$tagnames");
				}
				?>
				
				
				<tr>
                  <td  class="f" colspan="10">
                    <div class="left130">
                      <input class="btn" id="btnsave" type="submit" value="save" name="btnsave" onclick="document.forms.frm.php_interface.value='Channel::editTag';">
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
      <input name="php_interface" type="hidden" id="php_interface" value="Channel::editTag">
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['countreg',<?=$tagnames?>,'devname'],'actstep']" >
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal">
    </form>
  </div>
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