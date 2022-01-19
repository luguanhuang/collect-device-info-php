<?php
require("services/AtherFrameWork.php");
require("services/Config.php");

global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "company",0);
error_reporting(0);
session_start();
$Int_Report	= ini_get('error_reporting');
error_reporting($Int_Report);
$tmp = &$_SESSION[_GLO_SESSION_USERINFO_][0];
$user = &$_SESSION[_GLO_SESSION_USERINFO_][1];
TLOG_MSG("company: func begin name33=".$tmp." user=".$user);
$Obj_Frame = new AtherFrameWork();

$Ary_Result= $Obj_Frame->load_page("Company::getCompanyList",@FuncExt::getnumber('page'),false);
$Ary_Params	= $Ary_Result['result']['pagequery'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>company configure - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>company list</div>
  </div>
  <form id="frm" name="frm" action="submit.php" onsubmit="" submitwin="ajax" method="post">
  <input id="id" name="id" type="hidden" value="" />
  <input id="macid" name="macid" type="hidden" value="" />
  <input id="user" name="user" type="hidden" value="" />
  <input name="ptype" id="ptype"  type="hidden" value=""/>
  <input name="servip" id="servip"  type="hidden" value=""/>
  <input name="servport" id="servport"  type="hidden" value=""/>
  <input name="actstep"  id="actstep" type="hidden" value="del" />
  <div class="op"><a href="companyadd.php">add company</a><div class="clear"></div></div>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td>companyname</td>
          <td>status</td>
          <td>operate</td>
        </tr>
      </thead>
      <tbody>
      	<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				$k = $row['id'];
		?>
        <tr align="center" id="row_<?=$k?>">
          <td><?php
		   echo($row['companyname']); ?><input name="companyname_<?=$k?>" id="companyname_<?=$k?>" type="hidden" value="<?=$row['companyname']?>" /></td>
          
		  <td><?php if ($row['status']=="1") echo('active');
					else echo('deactive'); ?><input name="status_<?=$k?>" id="status_<?=$k?>" type="hidden" value="<?=$row['status']?>" /></td>
          <td><a href="#" submitwin="_self"  onclick="return Company_Seting(<?=$k?>)">modify</a> | <a href="#" onclick="return bot_login(<?=$k?>)">delete</a></td>
        </tr>
        <?php }
		}
		?>
      </tbody>
	  <tfoot>
        <tr>
          <td colspan="3"><div class="page">
		  <?php
		  echo("total ".$Ary_Result['result']['recordcount']." records&nbsp;&nbsp;");
		  echo("".$Ary_Result['result']['absolutepage']."/". $Ary_Result['result']['pagecount'] ." page&nbsp;&nbsp;");
		  if ($Ary_Result['result']['pagecount']>0){
			  if ($Ary_Result['result']['absolutepage']>1){
				  echo('<a href="?page='. $Ary_Result['result']['previouspage'] .'">last page</a>&nbsp;');
			  }
			  echo('the&nbsp;');
			  for($p=$Ary_Result['result']['startpage'];$p<$Ary_Result['result']['endpage']+1;$p++){
				  if ($p==$Ary_Result['result']['absolutepage']){echo('<u>'.$p.'</u>&nbsp;');}
				  else{echo('<a href="?page='.$p.'">'. $p .'</a>&nbsp;');}
			  }
			  echo(' page');
			  if ($Ary_Result['result']['absolutepage']<$Ary_Result['result']['pagecount']){
				  echo('&nbsp;<a href="?page='. $Ary_Result['result']['nextpage'] .'">next page</a>&nbsp;');
			  }
		  }
		  ?>
          </div></td>
        </tr>
      </tfoot>
      <!--
      <tfoot>
        <tr>
          <td colspan="6"><div class="page">共95条记录 第1/4页   第 1 2 3 4 页 下一页 末页</div></td>
        </tr>
      </tfoot>
      -->
    </table>
    <input name="php_interface" type="hidden" id="php_interface" value="Company::delCompany" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="[['id'],'actstep']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
  </form>
</div>

<form id="frm2" name="frm2" action="companyset.php" onsubmit="" submitwin="_self" method="get">
	<input name="companyname" 		id="companyname" 		type="hidden" value="" />
	<input name="status" 		id="status" 		type="hidden" value="" />
	<input name="id" 		id="id" 		type="hidden" value="" />
    
    <input name="php_parameter" type="hidden" id="php_parameter" value="['companyname','status','id']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/route.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>