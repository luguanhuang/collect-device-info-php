<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
global $Bln_UpLoad;

$Obj_Frame	= new AtherFrameWork();
$Ary_Result	= $Obj_Frame->load_page("CertService::getCertList");
//print_r($Ary_Result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>售票终端证书 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>售票终端证书</div>
  </div>
  <form id="frmlist" name="frmlist" method="post" action="submit.php" submitwin="ajax">
    <div class="op"><a href="cert2.php">安全通信证书</a>
      <div class="clear"></div>
    </div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>证书名称</td>
          <td>文件格式</td>
          <td>操作</td>
        </tr>
      </thead>
      <tbody id="certrow_list">
      	<?php
        if (is_array($Ary_Result['result'])){
			foreach($Ary_Result['result'] as $k=>$v){
		?>
        <tr align="center" id="row_<?=$v['name']?>">
          <td><?=$v['name']?></td>
          <td><?=$v['type']?></td>
          <td><a href="#" onclick="return TicketCert_Delete('<?=$v['name']?>')">删除</a></td>
        </tr>
        <?php
			}
		}
		?>
        <tr align="center" id="certrow_templet" style="display:none;">
          <td>{tag:file}</td>
          <td>{tag:extend}</td>
          <td><a href="#" onclick="return TicketCert_Delete('{tag:file}')">删除</a></td>
        </tr>
      </tbody>
      <!--
       <tfoot>
        <tr>
          <td colspan="6"><div class="page">共95条记录 第1/4页   第 1 2 3 4 页 下一页 末页</div></td>
        </tr>
      </tfoot>
      -->
    </table>
    <input name="certfile" type="hidden" id="certfile" value="" />
    <input name="php_interface" type="hidden" id="php_interface" value="CertService::deleteCert" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['certfile']]" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
  <form name="frmupload" id="frmupload" action="submit.php" onsubmit="return CertUpLoad_Validate(this);" submitwin="iframe" method="post" enctype="multipart/form-data">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab2 b" style="width:100%;">
      <caption class="nav">
      <div><span></span>上传证书</div>
      </caption>
      <tr>
        <td align="left" height="80">
        <center id="divloading" style="display:none;">
            <div id="divloadheader">文件上传中，请等待……</div>
            <img src="images/loading1.gif" width="242" height="15" alt="loading..." title="loading..." />
        </center>
        <div id="divloadfile">
          请选择证书文件：<input id="upload_file" name="upload_file" type="file" size="45">
          <input type="submit" id="btnsave" name="btnsave" value="上传" class="btn"/>
          <input type="reset" id="btncancel" name="btncancel" value="取消" class="btn" />
          <input type="hidden" id="upload_fname" name="upload_fname" value="upload_file" />
          <input name="php_interface" type="hidden" id="php_interface" value="CertService::uploadCert" />
          <input name="php_parameter" type="hidden" id="php_parameter" value="['upload_fname']" />
          <input name="php_returnmode" type="hidden" id="php_returnmode" value="json" />
          <div style="padding-top:8px \9;">说明：证书名称由字线、数字、下划线和点组成。</div>
        </div>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/certservice.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
unset($Ary_Group);	$Ary_Group	= NULL;
?>
</body>
</html>