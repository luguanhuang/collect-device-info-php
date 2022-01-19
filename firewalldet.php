<?php
require("services/AtherFrameWork.php");

global $Obj_Frame;
global $Ary_Result;

$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("FireWall::getFirewallRule",FuncExt::getnumber('id'),false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看防火墙规则 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<form name="frm" id="frm" action="submit.php" submitwin="ajax" method="post">
  <table align="center" cellpadding="0" cellspacing="0" border="0" class="tab">
    <caption class="nav">
    <div><span></span>查看防火墙规则</div>
    </caption>
    <tbody>
      <tr>
        <td class="t">源端口：</td>
        <td class="c"><input id="sport" name="sport" type="hidden" value="<?=$Ary_Result['result']['sport']?>"/><?=($Ary_Result['result']['sport']==""?"-":$Ary_Result['result']['sport'])?></td>
      </tr>
      <tr>
        <td class="t">源IP：</td>
        <td class="c"><input id="sip" name="sip" type="hidden" value="<?=$Ary_Result['result']['sip']?>"/><?=($Ary_Result['result']['sip']==""?"-":$Ary_Result['result']['sip'])?></td>
      </tr>
      <tr>
        <td class="t">源子网掩码：</td>
        <td class="c"><input name="smask" type="hidden" id="smask" value="<?=$Ary_Result['result']['smask']?>" /><?=($Ary_Result['result']['smask']==""?"-":$Ary_Result['result']['smask'])?></td>
      </tr>
      <tr>
        <td class="t">源MAC地址：</td>
        <td class="c"><input name="smac" type="hidden" id="smac" value="<?=$Ary_Result['result']['smac']?>" /><?=($Ary_Result['result']['smac']==""?"-":$Ary_Result['result']['smac'])?></td>
      </tr>
      <tr>
        <td class="t">目标端口：</td>
        <td class="c"><input name="dport" type="hidden" id="dport" value="<?=$Ary_Result['result']['dport']?>" /><?=($Ary_Result['result']['dport']==""?"-":$Ary_Result['result']['dport'])?></td>
      </tr>
      <tr>
        <td class="t">目标IP：</td>
        <td class="c"><input name="dip" type="hidden" id="dip" value="<?=$Ary_Result['result']['dip']?>" /><?=($Ary_Result['result']['dip']==""?"-":$Ary_Result['result']['dip'])?></td>
      </tr>
      <tr>
        <td class="t">目标子网掩码：</td>
        <td class="c"><input name="dmask" type="hidden" id="dmask" value="<?=$Ary_Result['result']['dmask']?>" /><?=($Ary_Result['result']['dmask']==""?"-":$Ary_Result['result']['dmask'])?></td>
      </tr>
      <tr>
        <td class="t">规则链：</td>
        <td class="c"><input name="link" type="hidden" id="link" value="<?=$Ary_Result['result']['link']?>" /><?
		if ($Ary_Result['result']['link']=="INPUT"){echo("输入");}
		elseif ($Ary_Result['result']['link']=="FORWARD"){echo("转发");}
		elseif ($Ary_Result['result']['link']==""){echo("-");}
		else{echo($Ary_Result['result']['link']);}
		?>
        </td>
      </tr>
      <tr>
        <td class="t">动作：</td>
        <td class="c">
        <input name="action" type="hidden" id="action" value="<?=$Ary_Result['result']['action']?>" /><?
		if ($Ary_Result['result']['action']=="ACCEPT"){echo("接受");}
		elseif ($Ary_Result['result']['action']=="DROP"){echo("丢弃");}
		elseif ($Ary_Result['result']['action']==""){echo("-");}
		else{echo($Ary_Result['result']['action']);}
		?>	
        </td>
      </tr>
      <tr>
        <td class="t">协议类型：</td>
        <td class="c"><input name="ptype" type="hidden" id="ptype" value="<?=$Ary_Result['result']['ptype']?>" /><?php
			if ($Ary_Result['result']['ptype']=="all"){echo("所有");}
			elseif ($Ary_Result['result']['ptype']==""){echo("-");}
			else{echo($Ary_Result['result']['ptype']);}
			?>
        </select></td>
      </tr>
      <tr>
        <td colspan="2" class="f">
      		<div class="left130">
            <input name="按钮" type="button" class="btn" id="btnreset" value="删除" onclick="FireWall_Delete(this.form)"/>
            <input type="button" id="btnreset" value="返回" class="btn" onclick="window.location.href='firewallrule.php'"/>
            </div>
        </td>
      </tr>
    </tbody>
  </table>
  <input name="actstep" type="hidden" value="del" />
  <input name="php_interface" type="hidden" id="php_interface" value="FireWall::setFirewallRule" />
  <input name="php_parameter" type="hidden" id="php_parameter" value="[['sport','sip','smask','smac','dport','dip','dmask','link','action','ptype'],'actstep']" />
   <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>
<?php
require('footer.html');
require('loadjs.html');
?>
<script type="text/javascript" src="js/firewall.js"></script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>