<?php
require("services/AtherFrameWork.php");
require("services/LogService.php");
global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "configfile",0);
TLOG_MSG("configfile: func begin");

$Obj_Frame = new AtherFrameWork();
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adsl - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body >
<div class="nav">
    <div><span></span>配置查看</div>
  </div>

  <form id="frmlist" name="frmlist" method="post" onsubmit="return UpLoad_Validate(this);" action="submit.php" submitwin="iframe" enctype="multipart/form-data">
     
          请选择配置文件：<input id="upload_file" name="upload_file" type="file" size="20">
          <input type="submit" id="btnsave" name="btnsave" value="上传" onclick="document.forms.frmlist.php_interface.value='LogService::uploadCfg';" class="btn"/>
          <input type="reset" id="btncancel" name="btncancel" value="取消" class="btn" />
          <input type="hidden" id="upload_fname" name="upload_fname" value="upload_file" />
    
    <input name="exportfile" type="hidden" id="exportfile" value="0" />
       <input name="php_interface" type="hidden" id="php_interface" value="LogService::getconfig" />
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['logtype','Adslmessage','upload_file','upload_fname']]" />
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" />
  </form>
  
<form method="post"  name="Adslresult" id="Adslresult" action="submit.php" submitwin="ajax" method="post">
	<table align="center" cellpadding="0" cellspacing="0" border="0"  border="0" class="tab2 b" style="width:99%;height:95%;">   
    <tr>
      <td style="width:10%">
      
     <select name="logtype" id="logtype" onchange="document.forms.Adslresult.savebt.disabled='';document.forms.Adslresult.php_interface.value='LogService::getconfig'; Log_GetLog();"  >
      		<?php
            foreach($Ary_List['logtype'] as $key=>$value){
			?>
            <option value="<?=$value?>"><?=$key?></option>
          	<?php
			}
		  	?>
      </select>
       
       <input type="button" id="logbt" name="logbt" value="查看"  onclick="document.forms.Adslresult.savebt.disabled='';document.forms.Adslresult.php_interface.value='LogService::getconfig'; Log_GetLog();" class="btn" />
    <input type="button" id="savebt" name="savebt" disabled="disabled" value="保存"   onclick="document.forms.Adslresult.php_interface.value='LogService::setconfig'; Log_GetLog();"  class="btn" />   
    
    
    <center id="divloading" style="display:none;">
            <div id="divloadheader">文件上传中，请等待……</div>
            <img src="images/loading1.gif" width="242" height="15" alt="loading..." title="loading..." />
    </center>
          
          <input name="exportfile" type="hidden" id="exportfile" value="0" />
       <input name="php_interface" type="hidden" id="php_interface" value="LogService::getconfig" />
      <input name="php_parameter" type="hidden" id="php_parameter" value="[['logtype','Adslmessage','upload_file','upload_fname']]" />
      <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" />
    </td>
    </tr>
    <tr style="width:100%;height:100%;" >
      <td align="center" id="cmdbox2" style="width:100%;height:100%;">
      <textarea style="width:100%;height:600px;" name="Adslmessage" id="Adslmessage"></textarea>
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