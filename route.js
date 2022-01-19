// JavaScript Document

function Route_Delete($id){
	$_C.Confirm(
		"Are you sure to delete this device？",
		function ($route){
			var $form	= document.forms['frm'];
			 var i;
			 //alert("length="+form.length);
			//for (i = 0; i < form.length ;i++) 
			{
				//alert("data="+form.elements[i].value);
			}	
			if (!$form){ return false; }
			var $int_id	 = $_G.intval($route);
			var $obj_row = $('row_'+$int_id);
			var $ary_conf= ["macid","user","ptype","servip","servport","retry","timeout","polltime","connected","active"]
			var $obj_conf= null, $obj_value=null, $k;
			
			/*for($k in $ary_conf){
				
				$obj_value = $($ary_conf[$k]+"_"+$int_id);
				//alert("return false11="+$form.elements[$ary_conf[$k]+"_"+$int_id]);
				$data = "macid"+"_"+$int_id;
			//alert("data222="+$data);
			alert("test222="+document.forms['frm'][$data].value);
				$obj_conf = $form.elements[$ary_conf[$k]];
				//alert("return false="+$obj_value+" $int_id="+$int_id+" id="+$id+" obj_conf="+$obj_conf);
				if (!$obj_value || !$obj_conf)
				{
					alert("return false;");
					return false; 
				}
				
			}*/
			
			//$obj_conf.value = ;
			$form.elements['id'] = $int_id;
			
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
		$id
	)
	return false;
}

function Company_Delete($id){
	$_C.Confirm(
		"Are you sure to delete this company？",
		function ($route){
			var $form	= document.forms['frm'];
			 var i;
			 //alert("length="+form.length);
			//for (i = 0; i < form.length ;i++) 
			{
				//alert("data="+form.elements[i].value);
			}	
			if (!$form){ return false; }
			var $int_id	 = $_G.intval($route);
			var $obj_row = $('row_'+$int_id);
			var $ary_conf= ["macid","user","ptype","servip","servport","retry","timeout","polltime","connected","active"]
			var $obj_conf= null, $obj_value=null, $k;
			
			/*for($k in $ary_conf){
				
				$obj_value = $($ary_conf[$k]+"_"+$int_id);
				//alert("return false11="+$form.elements[$ary_conf[$k]+"_"+$int_id]);
				$data = "macid"+"_"+$int_id;
			//alert("data222="+$data);
			alert("test222="+document.forms['frm'][$data].value);
				$obj_conf = $form.elements[$ary_conf[$k]];
				//alert("return false="+$obj_value+" $int_id="+$int_id+" id="+$id+" obj_conf="+$obj_conf);
				if (!$obj_value || !$obj_conf)
				{
					alert("return false;");
					return false; 
				}
				
			}*/
			
			//$obj_conf.value = ;
			$form.elements['id'].value = $int_id;
			
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
		$id
	)
	return false;
}

function Company_Validate($form){
	//alert("Company_Validate func begin");
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
		
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	//alert("Company_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding company？",
					function (){$frm.reset(1);},
					function (){window.location.href='company.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Group_Validate($form){
	//alert("Group_Validate func begin");
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
		
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	//alert("Group_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding group？",
					function (){$frm.reset(1);},
					function (){window.location.href='group.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Station_Validate($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding station？",
					function (){$frm.reset(1);},
					function (){window.location.href='station.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Device_Validate($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding device？",
					function (){$frm.reset(1);},
					function (){window.location.href='deviceset.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Channel_Validate($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding Channel？",
					function (){$frm.reset(1);},
					function (){window.location.href='deviceset.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Channel_Setting($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	$ary_element["id"]	= new Array(1,	null,	'id',		false);

	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue edit channel？",
					function (){$frm.reset(1);},
					function (){window.location.href='channel.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Tag_Setting($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	$ary_element["id"]	= new Array(1,	null,	'id',		false);

	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue edit channel？",
					function (){$frm.reset(1);},
					function (){window.location.href='channel.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function ChannelAdd_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	$row = $_G.intval($row);
	
	var $elm, $e, $ary_name = ['id','devname','dtype','slaveid','funcode','startreg','countreg','status','groupname','stationname','companyname'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
		//alert("Channel_Seting1 " + $tagform.elements[$ary_name[$e]].value);
	}
	
	//alert("Channel_Seting end1");
	//$tagform.elements['id'].value = $row;
	return true;
}

function Tag_Add($row){
	
	var $form = document.forms.addfrm;
	//$elm = $('devname'+"_"+$row);
	//alert("Station_Seting: func begin row2="+$elm.value);
	//
	if (!ChannelAdd_GetRowConf($row,$form)){return false;}
	//alert("Station_Seting: func begin row21="+$row);
	$form.submit();
}

/*function Tag_Add($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	alert("Station_Validate func begin111111");
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding Tag？",
					function (){$frm.reset(1);},
					function (){window.location.href='channel.php';}
				)
			},
			"backargs":[$form]
		}
	);
}*/

function Device_Setting($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	$ary_element["id"]	= new Array(1,	null,	'id',		false);

	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue edit device？",
					function (){$frm.reset(1);},
					function (){window.location.href='device.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Station_Setting($form){
	//alert("Station_Validate func begin111111"+document.getElementById("php_interface").value);
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
	
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["stationname"]	= new Array(1,	null,	'stationname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	$ary_element["id"]	= new Array(1,	null,	'id',		false);

	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue edit station？",
					function (){$frm.reset(1);},
					function (){window.location.href='station.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Group_setting_Validate($form){
	//alert("Station_Validate func begin");
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
		
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["companyname"]	= new Array(1,	null,	'companyname',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	$ary_element["groupname"]	= new Array(1,	null,	'groupname',		false);
	$ary_element["id"]	= new Array(1,	null,	'id',		false);
	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue edit group？",
					function (){$frm.reset(1);},
					function (){window.location.href='group.php';}
				)
			},
			"backargs":[$form]
		}
	);
}


function Station_Validate($form){
	//alert("Station_Validate func begin");
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	
		
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	var	$ary_element = new Array();
	$ary_element["macid"]	= new Array(1,	null,	'macid',		false);
	$ary_element["user"]	= new Array(1,	null,	'user',		false);
	$ary_element["ptype"]	= new Array(1,	null,	'ptype',		false);
	$ary_element["servip"]	= new Array(1,	null,	'servip',		false);
	$ary_element["servport"]	= new Array(1,	null,	'servport',		false);
	$ary_element["retry"]	= new Array(1,	null,	'retry',		false);
	$ary_element["timeout"]	= new Array(1,	null,	'timeout',		false);
	$ary_element["polltime"]	= new Array(1,	null,	'polltime',		false);
	$ary_element["connected"]	= new Array(1,	null,	'connected',		false);
	$ary_element["active"]	= new Array(1,	null,	'active',		false);
	//alert("Station_Validate mac="+$ary_element["macid"]);	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding device？",
					function (){$frm.reset(1);},
					function (){window.location.href='station.php';}
				)
			},
			"backargs":[$form]
		}
	);
}


function Route_Validate($form){
	if (!$form){ return false; }
	//alert("Route_Validate: func begin");
	//验证表单
	var	$ary_element = new Array();
		
	
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	if ($form.elements['type'].value == "net")
	{
		$ary_element["ip"]		= new Array(7,	15,		'网段',			"ip");
		$ary_element["type"]	= new Array(1,	null,	'路由类型',		false);
		$ary_element["mask"]	= new Array(0,	null,	'子网掩码',		SelectRegRule('mask'));
		$ary_element["netgate"]	= new Array(1,	null,	'网关IP地址',		"ip");
		$ary_element["ifname"]	= new Array(1,	null,	'接口名称',		false);
	}
	else
	{
		$ary_element["ip"]		= new Array(7,	15,		'网段',			"ip");
		$ary_element["type"]	= new Array(1,	null,	'路由类型',		false);
		$ary_element["ifname"]	= new Array(1,	null,	'接口名称',		false);
	}
	
	//alert("value=" + $form.tagName + " value=" + $form.elements['type'].value);
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" 您是否要继续添加路由器？",
					function (){$frm.reset(1);},
					function (){window.location.href='route.php';}
				)
			},
			"backargs":[$form]
		}
	);
}

function Company_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	$row = $_G.intval($row);
	
	var $elm, $e, $ary_name = ['companyname','status'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	
	$tagform.elements['id'].value = $row;
	return true;
}

function CompanyEdit_GetRowConf($tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	
	
	var $elm, $e, $ary_name = ['companyname','active','id'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	
	
	return true;
}

function Company_Seting($row){
	
	var $form = document.forms.frm2;
	//alert("Company_Seting: func begin row2="+$row);
	if (!Company_GetRowConf($row,$form)){return false;}
	
	$form.submit();
}

function Group_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	$row = $_G.intval($row);
	
	var $elm, $e, $ary_name = ['name','status','companyname'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	
	$tagform.elements['id'].value = $row;
	return true;
}

function Group_Seting($row){
	
	var $form = document.forms.frm2;
	//alert("Company_Seting: func begin row2="+$row);
	if (!Group_GetRowConf($row,$form)){return false;}
	
	$form.submit();
}

function Station_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	$row = $_G.intval($row);
	
	var $elm, $e, $ary_name = ['name','status','companyname'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	
	$tagform.elements['id'].value = $row;
	return true;
}

function Station_Seting($row){
	
	var $form = document.forms.frm2;
	//alert("Station_Seting: func begin row2="+$row);
	if (!Station_GetRowConf($row,$form)){return false;}
	
	$form.submit();
}

function Device_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	$row = $_G.intval($row);
	
	var $elm, $e, $ary_name = ['devname','status','companyname','macid','ptype','servip','servport','retry','timeout','polltime','groupname','stationname','socktype'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
	}
	
	$tagform.elements['id'].value = $row;
	return true;
}

function Device_Seting($row){
	//alert("Device_Seting");
	var $form = document.forms.frm2;
	//alert("Station_Seting: func begin row2="+$row);
	if (!Device_GetRowConf($row,$form)){return false;}
	
	$form.submit();
}

function Channel_GetRowConf($row, $tagform)
{
	if (!$tagform || !$tagform.tagName || $tagform.tagName.toLowerCase()!="form"){ return false; }
	
	$row = $_G.intval($row);
	
	var $elm, $e, $ary_name = ['id','devname','dtype','slaveid','funcode','startreg','countreg','status','groupname','stationname','companyname'];
	for($e in $ary_name){
		
		$elm = $($ary_name[$e]+"_"+$row);
		
		if (!$elm || !$tagform.elements[$ary_name[$e]])
		{
			
			return false; 
		}
		
		
		$tagform.elements[$ary_name[$e]].value = $elm.value;
		//alert("Channel_Seting1 " + $tagform.elements[$ary_name[$e]].value);
	}
	
	//alert("Channel_Seting end1");
	//$tagform.elements['id'].value = $row;
	return true;
}

function Channel_Seting($row){
	//alert("Channel_Seting");
	var $form = document.forms.frm2;
	//$elm = $('devname'+"_"+$row);
	//alert("Station_Seting: func begin row2="+$elm.value);
	//
	if (!Channel_GetRowConf($row,$form)){return false;}
	//alert("Station_Seting: func begin row21="+$row);
	$form.submit();
}

function Tag_Seting($row){
	
	var $form = document.forms.editfrm;
	//$elm = $('devname'+"_"+$row);
	//alert("Station_Seting: func begin row2="+$elm.value);
	//
	if (!Channel_GetRowConf($row,$form)){return false;}
	//alert("Station_Seting: func begin row21="+$row);
	$form.submit();
}

function Company_Edit($form)
{
	
if (!$form){ return false; }
	
	//验证表单
	/*var	$ary_element = new Array();
	$ary_element["sip"]		= new Array(7,	15,		'IP地址',			"ip");
	$ary_element["mask"]	= new Array(0,	null,	'子网掩码',		SelectRegRule('mask'));
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}*/
	
	if (!CompanyEdit_GetRowConf($form))
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
	
	//提交数据
	/*return AjaxSubmit(
		$form,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding company？",
					function (){$frm.reset(1);},
					function (){window.location.href='company.php';}
				)
			},
			"backargs":[$form]
		}
	);*/
	
	return AjaxSubmit($form,
			{
				"backcall": function()
				{
					var $str_list = "company.php";
					$_C.Alert($_A.result()[3],function (){window.location.href=$str_list;})
					
				},	
				"backargs":[$form]
			});
}


/*function gradeChange($obj)
{
	//代表的是选中项的index索引
	var $form = document.forms.frm2;
	//alert("Company_Seting: func begin row2="+$row);
	if (!Company_GetRowConf($row,$form)){return false;}
	
	$form.submit();
	alert($obj);
}*/


function gradeChange(){
	//发送数据
	
	/*return AjaxSubmit(
		$document.forms.frm,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding company？",
					function (){$frm.reset(1);},
					function (){window.location.href='company.php';}
				)
			},
			"backargs":[$document.forms.frm]
		}
	);*/
	//提交数据
	/*return AjaxSubmit(
		document.forms.frm,
		{
			"backcall":function(document.forms.frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding device？",
					function (){document.forms.frm.reset(1);},
					function (){window.location.href='station.php';}
				)
			},
			"backargs":[document.forms.frm]
		}
	);*/
	
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		document.forms.frm,
		function (){
			var $result = $_A.result();
		//	alert($result);
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				var tmp = $result[4].substr(1);
				/*
				var selectdata=document.getElementById('groupname'); 
				alert("test "+selectdata.length);
				for (i=select.options.length-1;i>=0;i--)
				for(var i=0;i<selectdata.length;i++) {
				  selectdata.options.remove(i);
				}  

				alert("test "+selectdata.length);*/
				var selectdata=document.getElementById('groupname'); 
				selectdata.options.length = 0;
				var data = tmp.split('|');
				//alert(tmp+" "+data.length);
				selectdata.options.add(new Option("select group name","-1"));
				for (var i=0; i<data.length-1; i++)
				{
					var res = data[i].split(':');
					selectdata.options.add(new Option(res[1],res[0]));
				}
				
				// $document.forms.frm.elements['php_interface'].value = "Station::addStation";
				  //selectdata.options.add(new Option("海淀区","2"));
				//alert("["+tmp+"]");
				
				//$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				alert("testttt2");
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}

			
			if ($result[3]["stateId"]>=0){
				alert("testttt3");
				return false;
			}
			else{
				//输出返回结果
				alert("testttt4");
				if ($result[3]["result"]!=""  && $result[3]["result"]!=null){
				//document.forms.Adslresult.Adslmessage.value=$result[3]["result"];
				//document.forms.Adslresult.Adslmessage.scrollTop = document.forms.Adslresult.Adslmessage.scrollHeight;
				}
				//setTimeout("getEthconfigInfo()",2000)
			}
		}
	);
	//返回
	return true;
}


function groupChange(){
	//发送数据
	
	/*return AjaxSubmit(
		$document.forms.frm,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding company？",
					function (){$frm.reset(1);},
					function (){window.location.href='company.php';}
				)
			},
			"backargs":[$document.forms.frm]
		}
	);*/
	//提交数据
	/*return AjaxSubmit(
		document.forms.frm,
		{
			"backcall":function(document.forms.frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding device？",
					function (){document.forms.frm.reset(1);},
					function (){window.location.href='station.php';}
				)
			},
			"backargs":[document.forms.frm]
		}
	);*/
	
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		document.forms.frm,
		function (){
			var $result = $_A.result();
		//	alert($result);
		
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				
				var tmp = $result[4].substr(1);
				
				var selectdata=document.getElementById('stationname'); 
				selectdata.options.length = 0;
				selectdata.options.add(new Option("select stationname name","-1"));
				//alert(tmp+" "+data.length);
				if (tmp.indexOf("|") > 0)
				{
					var data = tmp.split('|');
					//alert("groupChange: 1213" + data.length);
					
					for (var i=0; i<data.length; i++)
					{
						var res = data[i].split(':');
						selectdata.options.add(new Option(res[1],res[0]));
					}
				}
				else if (tmp.indexOf(":") > 0)
				{
					
					var res = tmp.split(':');
						selectdata.options.add(new Option(res[1],res[0]));
				}
				
				// $document.forms.frm.elements['php_interface'].value = "Station::addStation";
				  //selectdata.options.add(new Option("海淀区","2"));
				//alert("["+tmp+"]");
				
				//$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}

			
			if ($result[3]["stateId"]>=0){
				
				return false;
			}
			else{
				//输出返回结果
				
				if ($result[3]["result"]!=""  && $result[3]["result"]!=null){
				//document.forms.Adslresult.Adslmessage.value=$result[3]["result"];
				//document.forms.Adslresult.Adslmessage.scrollTop = document.forms.Adslresult.Adslmessage.scrollHeight;
				}
				//setTimeout("getEthconfigInfo()",2000)
			}
		}
	);
	//返回
	return true;
}

function stationChange(){
	//发送数据
	
	/*return AjaxSubmit(
		$document.forms.frm,
		{
			"backcall":function($frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding company？",
					function (){$frm.reset(1);},
					function (){window.location.href='company.php';}
				)
			},
			"backargs":[$document.forms.frm]
		}
	);*/
	//提交数据
	/*return AjaxSubmit(
		document.forms.frm,
		{
			"backcall":function(document.forms.frm){
				$_C.Confirm(
					$_A.result()[3]+" Do you want to continue adding device？",
					function (){document.forms.frm.reset(1);},
					function (){window.location.href='station.php';}
				)
			},
			"backargs":[document.forms.frm]
		}
	);*/
	//alert("test begin");
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		document.forms.frm,
		function (){
			var $result = $_A.result();
		//	alert($result);
		
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				
				var tmp = $result[4].substr(1);
				
				var selectdata=document.getElementById('devname'); 
				selectdata.options.length = 0;
				selectdata.options.add(new Option("select devname name","-1"));
				//alert(tmp+" "+data.length);
				if (tmp.indexOf("|") > 0)
				{
					var data = tmp.split('|');
					//alert("groupChange: 1213" + data.length);
					
					for (var i=0; i<data.length; i++)
					{
						var res = data[i].split(':');
						selectdata.options.add(new Option(res[1],res[1]));
					}
				}
				else if (tmp.indexOf(":") > 0)
				{
					
					var res = tmp.split(':');
						selectdata.options.add(new Option(res[1],res[1]));
				}
				
				// $document.forms.frm.elements['php_interface'].value = "Station::addStation";
				  //selectdata.options.add(new Option("海淀区","2"));
				
				
				//$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}

			
			if ($result[3]["stateId"]>=0){
				
				return false;
			}
			else{
				//输出返回结果
				
				if ($result[3]["result"]!=""  && $result[3]["result"]!=null){
				//document.forms.Adslresult.Adslmessage.value=$result[3]["result"];
				//document.forms.Adslresult.Adslmessage.scrollTop = document.forms.Adslresult.Adslmessage.scrollHeight;
				}
				//setTimeout("getEthconfigInfo()",2000)
			}
		}
	);
	//返回
	return true;
}

function Tag_Show()
{
	//console.log("Tag_Show1 action111 %s", document.getElementById("frm2").action);
	//document.write(document.getElementById("frm2").action);
	//document.getElementById('frm2').action = "livedata.php";  	
	var $form = document.forms.frm2;
	
	//alert("Station_Seting: func begin row2="+$row);
	//if (!Device_GetRowConf($row,$form)){return false;}
	console.log("Tag_Show1 action444");
	$form.submit();
	
	
	//返回
	return false;
	
	
}
