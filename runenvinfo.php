<?php
require("services/Hostagentinfo.php");

global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 10240000, "./logs", "runenvinfo",0);
TLOG_MSG("runenvinfo: func begin");
$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("Hostagentinfo::getRunEnvInfo",@FuncExt::getnumber('page'),false);
$Ary_Params	= $Ary_Result['result']['pagequery'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>运行环境信息 - <?=_GLO_PROJECT_FNAME_?></title>
<link type="text/css" rel="stylesheet" href="public.css" />
<link type="text/css" rel="stylesheet" href="css.css" />
</head>
<body>
<div class="listwrap">
  <div class="nav">
    <div><span></span>运行环境信息</div>
  </div>
  
   <div class="op">
    <div style="float:left;padding:3px;">
      <form name="SearchForm" id="SearchForm" action="?" method="get" onsubmit="return AuditLog_Search(this,'<?=$logtype?>')">
        <table cellpadding="0" cellspacing="0" border="0" class="sotab tab2 border-0" style="width: 99%; height: 95%;">
          <tr>
	          <td class="td1">
	            <label><input type="radio" name="enabled" id="enabled" value="0"<?php {echo(' checked');}?>/></label>
	            <span>全部</span>
	            <label><input type="radio" name="enabled" id="enabled" value="1"<?php if ('1' == $Ary_Params['enabled']){echo(' checked');}?>/></label>
	            <span>在线</span>
	            <label><input type="radio" name="enabled" id="enabled" value="2"<?php if ('2' == $Ary_Params['enabled']){echo(' checked');}?>/></label>
	            <span>离线</span>
	          </td>
		        <td class="td2"><span>节点id：</span><input type="text" name="nodeid" id="nodeid" value="<?=(isset($Ary_Params['nodeid'])? $Ary_Params['nodeid']:'')?>" class="input" rule="integer" cnname="节点id" isfull="0"/></td>
	          <td class="td3" colspan="2">
	           	<span>心跳时间：</span><input class="laydate-icon" id="begintime" name="begintime" value="<?=(isset($Ary_Params['begintime'])? $Ary_Params['begintime']:'')?>">
	            <!--<td class="v"><input type="text" name="heartbeat_time" id="heartbeat_time" class="input margin-right" value="<?=(isset($Ary_Params['heartbeat_time'])? $Ary_Params['heartbeat_time']:'')?>" rule="datetime" cnname="心跳时间" isfull="0"/></td>-->
	            <span class="interval">至</span><input class="laydate-icon" id="endtime" name="endtime" value="<?=(isset($Ary_Params['endtime'])? $Ary_Params['endtime']:'')?>">
	          </td>
	          <td class="table-striped td4">
	          	<input type="submit" name="btnsearch" id="btnsearch" class="btn" value="查询" />
	          	<input type="reset" name="btnreset" id="btnreset" class="btn" value="重置" onclick="document.getElementsByTagName('input').value = ''">
	          </td>
          </tr>
        </table>
        <input name="php_parameter" type="hidden" id="php_parameter" value="enabled,nodeid,nodeip,begintime,endtime" remark="用于验证参数"/>
      </form>
    </div>
    <div class="clear"></div>
  </div>
  
  <form id="frm" name="frm" action="#">
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" class="listtab">
      <thead>
        <tr align="center">
          <td width="20%">节点id</td>
          <td width="20%">节点ip</td>
          <td width="20%">运行状态</td>
          <td width="20%">心跳时间</td>
          <td width="20%">主机状态信息</td>
        </tr>
      </thead>
      <tbody>
      	<?php
        if (isset($Ary_Result['result']['data']) && is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$r){
		?>
        <tr align="center" id="row_<?=$k?>">
       <td><input name="nodeid_<?=$k?>" type="hidden" value="<?=isset($r['NODEID'])?$r['NODEID']:''?>" /><?=isset($r['NODEID'])?$r['NODEID']:''?></td>
          <td><input name="nodeip_<?=$k?>" type="hidden" value="<?=isset($r['NODEIP'])?$r['NODEIP']:''?>" /><?=isset($r['NODEIP'])?$r['NODEIP']:''?></td>
          <td><?php
			if (isset($r['SECSTAT']))
          {
              if ($r['SECSTAT']=="3"){ echo('在线'); }
              else{ echo('离线'); }
          }
          else
          {
              echo('离线');
          }
		  ?><input name="onlineflg_<?=$k?>" id="onlineflg_<?=$k?>" type="hidden" value="<?=$r['SECSTAT']?>" /></td>
          <td><input name="heartbeattime_<?=$k?>" type="hidden" value="<?=isset($r['AGENTTIME'])?$r['AGENTTIME']:''?>" /><?=isset($r['AGENTTIME'])?$r['AGENTTIME']:''?></td>
          
          
<div class="modal fade" tabindex="-1" role="dialog" id="modal_<?=$k?>">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">运行环境信息</h4>
      </div>
      
      <div class="modal-body">
        <div class="row row-textarea">
          <div class="col-xs-6"><label class="col-xs-4 text-right">cup使用率</label><span class="col-xs-8 text-left"><?=isset($r['CPUUSERATE'])?$r['CPUUSERATE']:''?></span></div>
          <div class="col-xs-6"><label class="col-xs-4 text-right">内存使用率</label><span class="col-xs-8 text-left"><?=isset($r['MEMUSERATE'])?$r['MEMUSERATE']:''?></span></div>
          <div class="col-xs-6"><label class="col-xs-4 text-right">cpu当前负载</label><span class="col-xs-8 text-left"><?=isset($r['CPULOADAVG'])?$r['CPULOADAVG']:''?></span></div>
          <div class="col-xs-6"><label class="col-xs-4 text-right">操作系统信息	</label><span class="col-xs-8 text-left"><?=isset($r['OPSYSINFO'])?$r['OPSYSINFO']:''?></span></div>
          <div class="col-xs-6"><label class="col-xs-4 text-right">root登录时间</label><span class="col-xs-8 text-left"><?=isset($r['LOGINTIME'])?$r['LOGINTIME']:''?></span></div>
          <div class="col-xs-6"><label class="col-xs-4 text-right">当前登录用户</label><span class="col-xs-8 text-left"><?=isset($r['LOGINUSER'])?$r['LOGINUSER']:''?></span></div>
          <div class="col-xs-12"><label class="col-xs-2 text-right">cup信息</label><span class="col-xs-10 text-left"><?=isset($r['CPUINFO'])?$r['CPUINFO']:''?></span></div>
      </div>
      
      <div class="row row-textarea">
          <div class="form-group col-xs-4">
            <label for="message-text" class="control-label">侦听的tcp进程</label>
            <textarea class="form-control" id="message-text" readonly="readonly" cols="30" rows="8">
            </textarea>
	    <div class="textarea-content">
            <?php
                        if (isset($r['LISTENPROC']))
                        {
                            $redata = explode(";",$r['LISTENPROC']);
                            foreach ($redata as $proc)
                            {
                                if (strstr($proc, "tcp") != NULL)
                                {
                                    $proc = trim($proc, "tcp:");
                                    trim($proc);
                                    $proc = str_replace(array("\r\n", "\r", "\n"), "", $proc);
                                }
                                else
                                {
                                    continue;
                                }
                            
                	   
		            ?>
                        <?=$proc?></br>
            	    
            	       <?php
			             }
		              ?>
		            <?php
			             }
		              ?>
	    	</div>
          </div>
          <div class="form-group col-xs-4">
            <label for="message-text" class="control-label">udp进程</label>
            <textarea class="form-control" id="message-text" readonly="readonly" cols="30" rows="6">
            </textarea>
		<div class="textarea-content">
            <?php
                       if (isset($r['LISTENPROC']))
                       {
                           $redata = explode(";",$r['LISTENPROC']);
                           foreach ($redata as $proc)
                           {
                               if (strstr($proc, "udp") != NULL)
                               {
                                   $proc = trim($proc, "udp:");
                                   trim($proc);
                                   $proc = str_replace(array("\r\n", "\r", "\n"), "", $proc);
                               }
                               else
                               {
                                   continue;
                               }
		            ?>
                        <?=$proc?></br>
            	    
            	        <?php
			                 }
		                  ?>
		              <?php
			             }
		              ?>
	    	</div>
          </div>
          <div class="form-group col-xs-4">
            <label for="message-text" class="control-label">磁盘使用率</label>
            <textarea class="form-control" id="message-text" readonly="readonly" cols="30" rows="8">
            </textarea>
		<div class="textarea-content">
             <?php
                        if (isset($r['DISKUSERATE']))
                        {
                            $redata = explode(";",$r['DISKUSERATE']);
                            foreach ($redata as $proc)
                            {
                                trim($proc);
                                $proc = str_replace(array("\r\n", "\r", "\n"), "", $proc);
                	  
		            ?>
                        <?=$proc?></br>
            	    
                    	    <?php
        			             }
        		          ?>
                     <?php
			             }
		              ?>
          </div>
        </div>
      </div>
      </div>
      
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
      </div>
      
    </div>
  </div>
</div>
          
          <td><!--<b href="runenvdetail.php?nodeid=<?=$r['NODEID']?>">查看</span>-->
          	  <button class="btn btn-primary" data-toggle="modal" data-target="#modal_<?=$k?>" data-whatever="主机状态信息" type="button">查看</button>
          </td>
        </tr>
        <?php
			}
		}
		?>
      </tbody>
     <tfoot>
        <tr>
          <td colspan="8"><div class="page">
		  <?php
		  echo("共".$Ary_Result['result']['recordcount']."条记录&nbsp;&nbsp;");
		  echo("第".$Ary_Result['result']['absolutepage']."/". $Ary_Result['result']['pagecount'] ."页&nbsp;&nbsp;");
		  if ($Ary_Result['result']['pagecount']>0){
			  if ($Ary_Result['result']['absolutepage']>1){
				  echo('<a href="?.page='. $Ary_Result['result']['previouspage'] .$Ary_Result['result']["urlparam"].'">上一页</a>&nbsp;');
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
          </div></td>
        </tr>
      </tfoot>
    </table>
   
  </form>
</div>

<form id="frm1" name="frm1" action="submit.php" onsubmit="" submitwin="ajax" method="post">
	<input name="interface" 		id="interface" 		type="hidden" value="" />
	<input name="php_interface" type="hidden" id="php_interface" value="NetConfig::delBridgeInfo" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="['interface']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<form id="frm2" name="frm2" action="bridgeset.php" onsubmit="" submitwin="_self" method="get">
	<input name="interface" 		id="interface" 		type="hidden" value="" />
    <input name="php_interface" type="hidden" id="php_interface" value="NetConfig::getNicSet" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="['interface']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<?php
require('footer.html');
require('loadjs.html');
?>
<script src="js/jquery-1.11.3.js"></script>
<script src="js/public.js"></script>
<script src="js/netcfg.js"></script>
<script src="js/laydate.js"></script>
<script src="js/date.js"></script>
<script>
$('#modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var recipient = button.data('whatever')
  var modal = $(this)
  modal.find('.modal-title').text('' + recipient)
  /*
  modal.find('.modal-body input').val(recipient)
  */
})
</script>
<?php
unset($Ary_Result); $Ary_Result = NULL;
unset($Obj_Frame);	$Obj_Frame  = NULL;
?>
</body>
</html>