<?php
  require("services/AtherFrameWork.php");
  require("services/LogService.php");
  global $Obj_Frame;
  global $Ary_Result;
  $Obj_Frame = new AtherFrameWork();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Adsl - <?=_GLO_PROJECT_FNAME_?></title>
    <link type="text/css" rel="stylesheet" href="css.css">
  </head>
  <body >
    <div class="nav">
      <div><span></span>系统信息查看</div>
    </div>
    <form method="post" name="Adslresult" id="Adslresult" action="submit.php" submitwin="ajax">
    	<table align="center" cellpadding="0" cellspacing="0" border="0"  border="0" class="tab2 b" style="width: 99%; height: 95%;">   
        <tr>
          <td style="width: 10%; padding: 7px 0;">
            <select style="padding: 3px 0;" name="infotype" id="infotype">
              <option value="170-route">路由信息</option>
              <option value="171-inf">接口信息</option>
              <option value="172-pm">进程信息</option>
              <option value="173-net">网络信息</option>
            </select>
            <input name="exportfile" type="hidden" id="exportfile" value="0">
            <input name="php_interface" type="hidden" id="php_interface" value="LogService::getsysinfo">
            <input name="php_parameter" type="hidden" id="php_parameter" value="[['infotype']]">
            <input name="php_returnmode" type="hidden" id="php_returnmode" value="json">
            <input type="button" id="logbt" name="logbt" value="查看"  onclick="Log_GetLog();" class="btn">
          </td>
        </tr>
        <tr style="width: 100%; height: 100%;">
          <td align="center" id="cmdbox2" style="width: 100%; height: 100%;">
            <textarea style="width: 100%; height: 600px;" name="Adslmessage" id="Adslmessage"></textarea>
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