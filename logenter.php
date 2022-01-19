<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;
global $Ary_Params;

TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "logenter",0);
TLOG_MSG("logenter: func begin");

$Obj_Frame	= new AtherFrameWork();
$Ary_Result	= $Obj_Frame->load_page("AuditService::getLog",array('login',NULL),false);
$Ary_Params	= $Ary_Result['result']['pagequery'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录日志 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<?php $logtype="login";?>
<div class="listwrap">
  <div class="nav">
    <div><span></span>用户登录日志</div>
  </div>
  <div class="op">
    <div style="float:left;padding:3px;">
      <form name="SearchForm" id="SearchForm" action="?" method="get" onsubmit="return AuditLog_Search(this,'<?=$logtype?>')">
        <table cellpadding="0" cellspacing="0" border="0" class="sotab">
          <tr>
            <td class="r">登录IP：</td>
            <td class="v"><input type="text" name="clientIp" id="clientIp" class="input" value="<?=(isset($Ary_Params['clientIp'])?$Ary_Params['clientIp']:'')?>" rule="ip" cnname="客户端IP" isfull="0" indexval="<?=(isset($Ary_Params['clientIp'])?$Ary_Params['clientIp']:'')?>"/></td>
            <td class="r">登录时间：</td>
            <td class="v"><input type="text" name="loginTime" id="loginTime" value="<?=(isset($Ary_Params['loginTime'])?$Ary_Params['loginTime']:'')?>" class="input dt" rule="datetime" cnname="登录时间" isfull="0" indexval="<?=(isset($Ary_Params['loginTime'])?$Ary_Params['loginTime']:'')?>"/></td>
            <td class="v"><input type="submit" name="btnsearch" id="btnsearch" class="btn" value="查询" />
              <input type="reset" name="btnreset" id="btnreset" class="btn" value="重置" />
              <input name="php_parameter" type="hidden" id="php_parameter" value="clientIp,loginTime" />
              </td>
          </tr>
        </table>
      </form>
    </div>
    <div class="clear"></div>
  </div>
  <form id="ExportForm" method="post" action="logexport.php" submitwin="iframe" style="display:none">
    <input name="php_parameter" type="hidden" id="php_parameter" value="['exporttype',['clientIp','loginTime']]" />
    <input name="exporttype" type="hidden" id="exporttype" value="<?=$logtype?>"/>
  </form>
  <form id="DeleteForm" name="DeleteForm" method="post" action="logdelete.php" submitwin="ajax" onsubmit="javascript:return AuditLog_Delete('<?=$logtype?>');">
   <?php $d = intval(!!_GLO_LOG_DEL_ENABLED_); ?>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="40" class="display<?=$d?>">选择</td>
          <td width="98">登录IP</td>
          <td width="128">登录时间</td>
          <td>描&nbsp;述</td>
        </tr>
      </thead>
      <tbody>
      	<?php
        if (isset($Ary_Result['result']['loglist']) && is_array($Ary_Result['result']['loglist'])){
			foreach($Ary_Result['result']['loglist'] as $k=>$r){
		?>
        <tr align="center" id="row_<?=$k?>">
          <td class="display<?=$d?>"><input id="logid" name="logid" type="checkbox" value="<?=$k?>" /></td>
          <td><input name="clientIp_<?=$k?>" type="hidden" value="<?=$r['clientIp']?>" /><?=$r['clientIp']?></td>
          <td><input name="loginTime_<?=$k?>" type="hidden" value="<?=$r['loginTime']?>" /><?=$r['loginTime']?></td>
          <td class="longtxt"><div onclick="AuditLog_ShowOpen(this)" title="点击查看详细信息"><?=$r['des']?></div></td>
        </tr>
        <?php
			}
		}
		?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="8" align="left">
          <div class="page">
		  <?php
		  echo("共".$Ary_Result['result']['recordcount']."条记录&nbsp;&nbsp;每页".$Ary_Result['result']['pagesize']."条&nbsp;&nbsp;");
		  echo("第".$Ary_Result['result']['absolutepage']."/". $Ary_Result['result']['pagecount'] ."页&nbsp;&nbsp;");
		  if ($Ary_Result['result']['pagecount']>0){
			  if ($Ary_Result['result']['absolutepage']>1){
				  echo('<a href="?'. $Ary_Result['result']["urlparam"] .' page='. $Ary_Result['result']['previouspage'] .'">上一页</a>&nbsp;');
			  }
			  echo('第&nbsp;');
			  for($p=$Ary_Result['result']['startpage'];$p<$Ary_Result['result']['endpage']+1;$p++){
				  if ($p==$Ary_Result['result']['absolutepage']){echo('<u>'.$p.'</u>&nbsp;');}
				  else{echo('<a href="?'. $Ary_Result['result']["urlparam"] .' page='.$p.'">'. $p .'</a>&nbsp;');}
			  }
			  echo('页');
			  if ($Ary_Result['result']['absolutepage']<$Ary_Result['result']['pagecount']){
				  echo('&nbsp;<a href="?'. $Ary_Result['result']["urlparam"] .' page='. $Ary_Result['result']['nextpage'] .'">下一页</a>&nbsp;');
			  }
		  }
		  ?>
          </div>
          </td>
        </tr>
        <tr>
          <td class="button" colspan="8"><?php if ($d){?><input type="button" name="SelectAll" value="全选" id="SelectAll" onclick="$_G.selectall(this,'logid',this)"  class="btn" SelectedText="全选" UnSelectText="反选" /><input type="submit" name="btnDel" id="btnDel" value="删除所选" class="btn" /><input type="button" name="btnClean" id="btnClean" value="清空日志" class="btn" onclick="return AuditLog_Clear('<?=$logtype?>');" action="submit.php?ftag=<?=$logtype?>&php_interfac=AuditService::delget_logfile&php_parameter=['ftag']&php_returnmode=normal" submitwin="ajax"/><?php }?><input type="button" name="btnExport" id="btnExport" title="保存数据到html文件" value="导出日志" class="btn" onclick="return AuditLog_Export('<?=$logtype?>');" /></td>
        </tr>
      </tfoot>
    </table>
    <input name="deleteparams" type="hidden" id="deleteparams" value="clientIp,loginTime" />
    <input name="deletedata" type="hidden" id="deletedata" value=""/>
    <input name="deletetype" type="hidden" id="deletetype" value="<?=$logtype?>"/>
  </form>
</div>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/auditservice.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Ary_Params);	$Ary_Params	= NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>