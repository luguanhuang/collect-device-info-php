// JavaScript Document

function LanConf_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["ip"]			= new Array(7,	15,	'IP地址',		"ip");
		$ary_element["mask"]		= new Array(0,	15,	'子网掩码',		SelectRegRule('mask'));
		$ary_element["broadcast"]	= new Array(7,	15,	'广播地址',		"ip");
		//$ary_element["netgate"]	= new Array(0,	15,	'网关地址',		"ip");
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	$_A.mode	= "post";
	$_A.remode	= "html";
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	
	$_A.send(
		$form,
		function(){},
		null
	)

	//此处不显示loading，因为是采用异步发送，不等待服务器处理直接返回提示
	$_C.Alert('保存配置命令发送完成。',null);
	return false;
}

function DSNConf_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["dns1"]		= new Array(7,	15,	'首选DNS服务器',		"ip");
		$ary_element["dns2"]		= new Array(7,	15,	'备选DNS服务器',		"ip");
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
}


function SoftUpdateConf_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["serverip"]		= new Array(7,	15,	'服务器ip',		"ip");
		$ary_element["port"]		= new Array(1,	5,		'端口号',		[1,65535]);
		$ary_element["loglevel"]		= new Array(1,	2,		'日志级别',		[1,10]);
		$ary_element["logcount"]		= new Array(1,	3,		'日志数量',		[1,10]);
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit($form,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
}


function WlanType_Select($value){
	var $getform	= $("frm0");
	var $conflist	= $("ConfList");
	var $selected	= $conflist ? $_G.strval($conflist.getAttribute('selected')) : null;
	var $selvalue	= $_G.strval($value);
	if (!$getform || $selected===null || $selvalue=="" || $selvalue==$selected){return false;}
	//已经打开过的
	var $tartable	= $('ConfTable'+$selvalue);
	var $seltable	= $('ConfTable'+$selected);
	if ($tartable){
		if ($seltable){ $seltable.style.display="none"; }
		$tartable.style.display="block";
		$conflist.setAttribute('selected',$selvalue);
		//初始化下拉菜单(火狐下可能下来菜单的默认选中项目不正确)
		WlanType_SelInitial($selvalue);
		return false;
	}
	//写入值
	$getform.wlantype.value = $selvalue;
	//提交数据
	return AjaxSubmit($getform,{"remode":"html","backcall":WlanType_SelReturn,"backargs":[$conflist,$selvalue]});
}

function WlanType_SelReturn($list,$value){
	if (!$list){return false;}
	var $selected	= $_G.strval($list.getAttribute('selected'));
	var $selvalue	= $_G.strval($value);
	if ($selvalue == $selected){return false;}
	//显示所选的
	var $rehtml		= $_A.result()[3];
	var $rematch	= /\<bdo([^\>]+)\>\s*\<div[^\>]+\>([\s\S]+)\<\/div\>\s*\<\/bdo\>/i.exec($rehtml);
	if (!$rematch){ return false; }
	//隐藏原来的
	var $seltable= $('ConfTable'+$selected);
	if ($seltable){ $seltable.style.display="none"; }
	//标记当前的
	$list.setAttribute('selected',$selvalue);
	//显示
	var $newdiv	= document.createElement("DIV"); 
		$newdiv.setAttribute('id','ConfTable'+$selvalue);
		$newdiv.innerHTML = $rematch[2];
		$list.appendChild($newdiv);
	//初始化下拉菜单(火狐下可能下来菜单的默认选中项目不正确)
	WlanType_SelInitial($selvalue);
}

function WlanType_SelInitial($value){
	var $form = $('frm'+$value);
	if (!$form || !$form.wlan){ return false; }
	$_G.initial($form.wlan);
}

function WlanConf_Validate($form){
	if (!$form || !$form.wlan){ return false; }
	var $int_type = $_G.intval($form.wlan.value)
	//验证表单
	var	$ary_element = new Array();
	if ($int_type==1){
		$ary_element["ip"]			= new Array(7,	15,	'IP地址',		"ip");
		$ary_element["mask"]		= new Array(0,	15,	'子网掩码',		SelectRegRule('mask'));
		$ary_element["netgate"]		= new Array(7,	15,	'网关地址',		"ip");
		$ary_element["broadcast"]	= new Array(7,	15,	'广播地址',		"ip");
	}
	else if ($int_type==2){
		$ary_element["user"]		= new Array(1,	255,'拨号帐号',		true);
		$ary_element["pwd"]			= new Array(6,	15,	'拨号密码',		true);
	}
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	//验证其他的
	if ($int_type==2){
		if ($_G.regexp(/^[\<\>\'\\"\|\`\#\&]+$/,$form.user.value)){
			$_C.Alert("拨号帐号不可含有 &lt; &gt; ' \" | ` # &amp; 等特殊符,号！",$_C.focus,$form.user);
			return false;
		}
	}
	
	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function ($wlan){
				$wlan = $_G.intval($wlan);
				if ($wlan!=2 && $wlan!=4){
					$_C.Alert($_A.result()[3],null);
				}
				else{
					var $msg = $_A.result()[3]+" 您是否要立即拨号？";
					if ($wlan==4){ $msg += "<br>提示：3G拨号过程需要一段时间，您需要耐心等待。"; }
					$_C.Confirm(
						$msg,
						function (){
							var $btn = $('DialConnect_'+$wlan);
							if ($btn){Net_dialConnect($btn);}
						},
						null
					)
				}
			},
			"backargs":[$int_type]
		}
	);
}

function ProxyTicket_GetRowConf($row,$tagform){
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['port','server','ptype'];
	for($e in $ary_name){
		$elm = $($ary_name[$e]+"_"+$row);
		if (!$elm || !$tagform.elements[$ary_name[$e]]){ return false; }
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	return true;
}

function ProxyTicket_Seting($row){
	var $form = document.forms.frm2;
	if (!ProxyTicket_GetRowConf($row,$form)){return false;}
	$form.submit();
}

function ProxyTicket_Delete($row){
	var $form = document.forms.frm1;
	if (!ProxyTicket_GetRowConf($row,$form)){return false;}
	$_C.Confirm(
		"客票代理配置记录删除后将不可恢复，您确定要删除该记录？",
		function ($proxy){
			var $form	= document.forms.frm1;
			if (!$form){ return false; }
			var $int_id	 = $_G.intval($proxy);
			var $obj_row = $('row_'+$int_id);
			AjaxSubmit(
				$form,
				{
					"backcall":function($row){
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":null
				},
				$obj_row
			);
			return false;
		},
		null,
		$row
	)
}

function ProxyTicket_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["port"]		= new Array(1,	5,		'端口号',		[1,65535]);
		$ary_element["server"]		= new Array(7,	21,		'远程服务和端口',	SelectRegRule('ipport'));
		$ary_element["ptype"]		= new Array(1,	null,	'协议类型',		">=0");
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,{
			"backcall":function($frm){
				if (!$frm || !$frm.actstep || $frm.actstep.value.toLowerCase()!="add"){
					$_C.Alert(
						$_A.result()[3],
						function (){window.location.href='proxyticket.php';}
					)
				}
				else{
					$_C.Confirm(
						$_A.result()[3]+" 您是否要继续添加客票代理配置？",
						function (){$frm.reset(true);},
						function (){window.location.href='proxyticket.php';}
					)
				}
			},
			"backargs":[$form]
		}
	);
}

function ProxyTicket_Restart($button){
	$_C.Confirm(
		"您确定要重新启动客票代理服务器？",
		function ($object){
			if (!$object){return false;}
			return AjaxSubmit($object,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
		},
		null,
		$button
	);
	return false;
}


function ProxyTicket_Set($form){
	$_C.Confirm(
		"您确定要设置吗？",
		function ($frm){
			if (!$frm){return false;}
			return AjaxSubmit($frm,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":[$form]});
		},
		null,
		$form
	);
	return false;
}


function RemoteAdmin_GetRowConf($row,$tagform){
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['port','server'];
	for($e in $ary_name){
		$elm = $($ary_name[$e]+"_"+$row);
		if (!$elm || !$tagform.elements[$ary_name[$e]]){ return false; }
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	return true;
}

function RemoteAdmin_Seting($row){
	var $form = document.forms.frm2;
	if (!RemoteAdmin_GetRowConf($row,$form)){return false;}
	$form.submit();
}

function RemoteAdmin_Delete($row){
	var $form = document.forms.frm1;
	if (!RemoteAdmin_GetRowConf($row,$form)){return false;}
	$_C.Confirm(
		"远程管理配置记录删除后将不可恢复，您确定要删除该记录？",
		function ($proxy){
			var $form	= document.forms.frm1;
			if (!$form){ return false; }
			var $int_id	 = $_G.intval($proxy);
			var $obj_row = $('row_'+$int_id);
			AjaxSubmit(
				$form,
				{
					"backcall":function($row){
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":null
				},
				$obj_row
			);
			return false;
		},
		null,
		$row
	)
}

function RemoteAdmin_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["port"]		= new Array(1,	5,		'端口号',		[1,65535]);
		$ary_element["server"]		= new Array(7,	21,		'远程服务和端口',	SelectRegRule('ipport'));
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,{
			"backcall":function($frm){
				var $str_list = "remoteadmin.php";
				if (!$frm || !$frm.actstep || $frm.actstep.value.toLowerCase()!="add"){
					$_C.Alert(
						$_A.result()[3],
						function (){window.location.href=$str_list;}
					)
				}
				else{
					var $limit = $frm.limit
					var $count = 0, $max=0;
					if ($limit){$count = $_G.intval($limit.value); $max=$_G.intval($limit.getAttribute("maxval"));}
					$count++;
					if ($count>=$max){
						$_C.Alert( $_A.result()[3], function (){window.location.href=$str_list;} )
					}
					else{
						$limit.value = $count;
						$_C.Confirm(
							$_A.result()[3]+" 您是否要继续添加远程管理配置？",
							function (){$frm.reset(true);},
							function (){window.location.href=$str_list;}
						)
					}
				}
			},
			"backargs":[$form]
		}
	);
}

function RemoteAdmin_Restart($button){
	$_C.Confirm(
		"您确定要重新启动远程管理服务器？",
		function ($object){
			if (!$object){return false;}
			return AjaxSubmit($object,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
		},
		null,
		$button
	);
	return false;
}

function SslSet_Restart($button){
	$_C.Confirm(
		"您确定要重新启动SSL管理服务器？",
		function ($object){
			if (!$object){return false;}
			return AjaxSubmit($object,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
		},
		null,
		$button
	);
	return false;
}



function SslSet_GetRowConf($row,$tagform){
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['port','interface','server','ssltype','ccheck','stampd','hmac','logaudit','report','timeout','ptype'];
	for($e in $ary_name){
		$elm = $($ary_name[$e]+"_"+$row);
		if (!$elm || !$tagform.elements[$ary_name[$e]]){ return false; }
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	return true;
}

function SslSet_Seting($row){
	var $form = document.forms.frm2;
	if (!RemoteAdmin_GetRowConf($row,$form)){return false;}
	$form.submit();
}

function SslSet_Delete($row){
	var $form = document.forms.frm1;
	if (!RemoteAdmin_GetRowConf($row,$form)){return false;}
	$_C.Confirm(
		"SSL管理配置记录删除后将不可恢复，您确定要删除该记录？",
		function ($proxy){
			var $form	= document.forms.frm1;
			if (!$form){ return false; }
			var $int_id	 = $_G.intval($proxy);
			var $obj_row = $('row_'+$int_id);
			AjaxSubmit(
				$form,
				{
					"backcall":function($row){
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":null
				},
				$obj_row
			);
			return false;
		},
		null,
		$row
	)
}

function SslSet_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
	
	 $ary_name = ['port','interface','server','ssltype','ccheck','stampd','hmac','logaudit','report','timeout','ptype'];
	 
	
		$ary_element["port"]		= new Array(1,	5,		'端口号',		[1,65535]);
		$ary_element["interface"]	= new Array(6,	21,		'本地IP',	'ip');
		$ary_element["server"]		= new Array(7,	300,		'远程服务和端口','');
		$ary_element["ssltype"]		= new Array(1,	5,		'SSL类型',		[0,3]);
		$ary_element["ccheck"]		= new Array(1,	5,		'检查证书类型',		[0,1]);
		$ary_element["stampd"]		= new Array(1,	5,		'是否签名',		[0,1]);
		$ary_element["hmac"]		= new Array(1,	5,		'检查mac地址',		[0,1]);
		$ary_element["logaudit"]	= new Array(1,	5,		'检查mac地址',		[0,1]);
		$ary_element["report"]		= new Array(1,	5,		'上报日志',		[0,1]);
		$ary_element["timeout"]		= new Array(1,	5,		'超时',		[1,99999999]);
		$ary_element["ptype"]		= new Array(1,	5,		'传输类型',		[0,3]);

	

		if ($form.actstep.value.toLowerCase()!="add"){
	for($e in $ary_name){
	//	if (!$form.elements[$ary_name[$e]]){ return false; }
		
		getSelectItems("_server");
		$form.elements[$ary_name[$e]].value = $form.elements['_'+$ary_name[$e]].value;
	//	alert($form.elements[$ary_name[$e]].value);
	}
		}
		else
		{
			getSelectItems("server");
		}
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,{
			"backcall":function($frm){
				var $str_list = "sslset.php";
				if (!$frm || !$frm.actstep || $frm.actstep.value.toLowerCase()!="add"){
					$_C.Alert(
						$_A.result()[3],
						function (){window.location.href=$str_list;}
					)
				}
				else{
					var $limit = $frm.limit
					var $count = 0, $max=0;
					if ($limit){$count = $_G.intval($limit.value); $max=$_G.intval($limit.getAttribute("maxval"));}
					$count++;
					if ($count>=$max){
						$_C.Alert( $_A.result()[3], function (){window.location.href=$str_list;} )
					}
					else{
						$limit.value = $count;
						$_C.Confirm(
							$_A.result()[3]+" 您是否要继续添加SSL管理配置？",
							function (){$frm.reset(true);},
							function (){window.location.href=$str_list;}
						)
					}
				}
			},
			"backargs":[$form]
		}
	);
}


function getSelectItems(name)    
{      
	selectObj=document.getElementById("serverlist");
	document.getElementById(name).value="";
     for(var i=0;i<selectObj.options.length;i++)    
      {    
    	 if (i>0)document.getElementById(name).value=document.getElementById(name).value+";";
    	 document.getElementById(name).value=document.getElementById(name).value+selectObj.options[i].text;
      }                      
}    

function HSUpateItem(selectObj,itemText,itemValue)    
{      
     for(var i=0;i<selectObj.options.length;i++)    
      {    
         if(selectObj.options[i].value == itemValue)    
          {    
              selectObj.options[i].text = itemText;    
             break;    
          }    
      }       
         
}    
   
  
function InsertItem(seleid,itemValue)    
{     
	if (document.getElementById("serveritem").value=="") return;

	$result=$_G.validate(document.getElementById("serveritem"),'远程服务和端口',7,25,SelectRegRule('ipport'))
	if ($result[0]) {
		$_C.Alert(
				"远程服务和端口格式错误！",
				function (){});
	return;
	}
	
	
	selectObj=document.getElementById("serverlist");
	itemValue=document.getElementById("serveritem").value;
	
	for(var i=0;i<selectObj.options.length;i++)    
    {    
       if(selectObj.options[i].value == itemValue)    
        {    
    	   $_C.Alert(
   				"远程服务和端口已存在！",
   				function (){});
           return;    
        }    
    }
     var varItem = new Option(itemValue,itemValue);    
      selectObj.options.add(varItem);    
      document.getElementById("serveritem").value="";
}    
     
function DeleteItem()    
{      
	selectObj=document.getElementById("serverlist");
	itemValue=document.getElementById("serveritem").value;
     for(var i=0;i<selectObj.options.length;i++)    
      {    
         if(selectObj.options[i].value == itemValue)    
          {    
              selectObj.remove(i);
              document.getElementById("serveritem").value="";
             break;    
          }    
      }
    
}    
   
   

function GetCurText(){    
	selectObj=document.getElementById("serverlist")
var index = selectObj.options.selectedIndex;    
	document.getElementById("serveritem").value=selectObj[index].text;    
  
}    

function Nic_GetRowConf($row,$tagform){
	alert("Nic_GetRowConf: func begin");
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	alert("Nic_GetRowConf: func begin 1");
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['port','server'];
	alert("Nic_GetRowConf: func begin 2");
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		alert("Nic_GetRowConf: func begin 3 elm=" + $elm + " $e=" + $e + " arrayname=" + $ary_name[$e] + " row=" + $row);
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			alert("Nic_GetRowConf: false");
			return false; 
		}
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	return true;
}

function NicSet_Validate($form){
	if (!$form){ return false; }
	//验证表单
	var	$ary_element = new Array();
		$ary_element["server"]		= new Array(7,	15,		'ip地址',			"ip");
		//$ary_element["mask"]		= new Array(7,	15,		'子网掩码',			"mask");
		$ary_element["mask"]	= new Array(0,	null,	'子网掩码',		SelectRegRule('mask'));
		
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	//if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	return AjaxSubmit($form,
		{
			"backcall": function()
			{
				var $str_list = "nic.php";
				$_C.Alert($_A.result()[3],function (){window.location.href=$str_list;})
				
			},	
			"backargs":null
		});
}

function Bridge_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['interface'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			return false; 
		}
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	
	return true;
}

function Bridge_Delete($row){
	var $form = document.forms.frm1;
	if (!Bridge_GetRowConf($row,$form)){return false;}
	$_C.Confirm(
		"桥记录删除后将不可恢复，您确定要删除该记录？",
		function ($proxy){
			//var $form	= document.forms.frm1;
			if (!$form){ return false; }
			
			var $int_id	 = $_G.intval($proxy);
			var $obj_row = $('row_'+$int_id);
			
			AjaxSubmit(
				$form,
				{
					"backcall":function($row){
						if ($row){
							$_C.Alert($_A.result()[3],null);
							$row.parentNode.removeChild($row);
						}
						else{
							$_C.Alert($_A.result()[3], function (){ window.location.reload(true); } );
						}
					},
					"backargs":null
				}
			);
			return false;
		},
		null,
		$row
	)
}

function BridgeSet_GetRowConf($tagform){
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	var $elm, $e, $ary_name = ['nic'];
	var resnic = "";
	var j=0;
	var total = 0;
	var data = "";
	for (j=0; j<100; j++)
	{
		data = "nic_" + j;
		var checks = document.getElementsByName(data); 
		if (0 == checks.length)
		{
			break;
		}
		
		total++;
	}
	
	 /*for(i=0;i<checks.length-1;i++)
	 {
	        if(checks[i].checked)
	        {
	        	alert("BridgeSet_GetRowConf: value=111"+checks[i].value);
	        	resnic = resnic+ checks[i].value + ",";
	        }
	 }*/
	
	for($e in $ary_name)
	{
		var i=0;
		for (i=0; i<total; i++)
		{
			$elm = $($ary_name[$e]+"_"+i);
			
			if ($elm.checked)
			{
				resnic = resnic+ $elm.value;
				if (4 != i)
				{
					resnic = resnic + ",";
				}
			}
		}
		
		$tagform.elements[$ary_name[$e]].value = resnic;
	}
	
	 //$tagform.elements['nic'].value = resnic;
	if (resnic.length == 0) 
	{
		alert("请选择物理接口");
		return false;
	}
	return true;
}

function Bridge_Set($form)
{
if (!$form){ return false; }
	
	//验证表单
	var	$ary_element = new Array();
	$ary_element["sip"]		= new Array(7,	15,		'IP地址',			"ip");
	$ary_element["mask"]	= new Array(0,	null,	'子网掩码',		SelectRegRule('mask'));
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	if (!BridgeSet_GetRowConf($form))
	{
		return false;
	}
	
	/*if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	//验证其他数据
	if (($form.sport.value!="" || $form.dport.value!="") ){
		var $str_ptype = $_G.strval($form.ptype.value,1);
		if ($str_ptype=="icmp"){
			$_C.Alert("使用ICMP协议时不可指定源端口或目标端口",null);
			return false;
		}
		else if ($str_ptype=="all"){
			$_C.Alert("指定源端口或目标端口时，必须使用UDP/TCP协议",null);
			return false;
		}
	}*/

	//提交数据
	/*return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3],
					function (){window.location.href='firewallrule.php';}
				)
			},
			"backargs":[$form]
		}
	);*/
	
	return AjaxSubmit($form,
			{
				"backcall": function()
				{
					var $str_list = "bridge.php";
					$_C.Alert($_A.result()[3],function (){window.location.href=$str_list;})
					
				},	
				"backargs":null
			});
}

function Bridge_Add($form)
{
	if (!$form){ return false; }
	
	//验证表单
	var	$ary_element = new Array();
	$ary_element["name"]		= new Array(1,	20,		'网桥名称',		true);
	$ary_element["sip"]		= new Array(7,	15,		'IP地址',			"ip");
	$ary_element["mask"]	= new Array(0,	null,	'子网掩码',		SelectRegRule('mask'));
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	if (!BridgeSet_GetRowConf($form))
	{
		return false;
	}
		
	return AjaxSubmit($form,
			{
				"backcall": function()
				{
					var $str_list = "bridge.php";
					$_C.Alert($_A.result()[3],function (){window.location.href=$str_list;})
					
				},	
				"backargs":null
			});
}

/*function Bridge_GetRowConf($row,$tagform){
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['interface'];
	for($e in $ary_name){
		$elm = $($ary_name[$e]+"_"+$row);
		if (!$elm || !$tagform.elements[$ary_name[$e]]){ return false; }
		//alert("interface="+$elm.value);
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	return true;
}*/

function Bridge_Seting($row){
	//alert("Bridge_Seting: func begin row="+$row);
	var $form = document.forms.frm2;
	if (!Bridge_GetRowConf($row,$form)){return false;}
	$form.submit();
}

function Nic_GetRowConf($row,$tagform){
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	$row = $_G.intval($row);
	var $elm, $e, $ary_name = ['name'];
	for($e in $ary_name){
		$elm = $($ary_name[$e]+"_"+$row);
		if (!$elm || !$tagform.elements[$ary_name[$e]]){ return false; }
		//alert("interface="+$elm.value);
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	return true;
}

function Nic_Seting($row){
	//alert("Bridge_Seting: func begin row="+$row);
	var $form = document.forms.frm2;
	if (!Nic_GetRowConf($row,$form)){return false;}
	$form.submit();
}