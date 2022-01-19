<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("NetConfig::getSoftUpdateinfo");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>软件升级版本 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav"><div><span></span>软件升级</div></caption>
    <tr>
      <td class="t">更新时间：</td>
      <td class="c"><?=$Ary_Result['result']['softtime']?></td>
    </tr>
    <tr>
      <td class="t">最新版本：</td>
      <td class="c"><?=$Ary_Result['result']['softvion']?></td>
    </tr>
    
    <tr>
      <td class="t">序列号：</td>
      <td class="c"><?=$Ary_Result['result']['softid']?></td>
    </tr>
    
  </table>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/netcfg.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>