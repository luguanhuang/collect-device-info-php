// JavaScript Document

function load_start(){
	$_A.mode	= "GET";
	$_A.remode	= "json";
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	load_layer(1);
	setTimeout(load_lan,200);
}

function load_lan(){
	//LAN口配置	
	var $form = document.forms.LanForm;
	if (!$form){
		load_tun();
	}
	else{
		$_A.command = function(){
			var $result = validate_return();
			if ($result){
				var $arykey	= {
					"lan_netgate":	"netgate",
					"lan_ip":		"ip",
					"lan_mask":		"mask",	
					"lan_broadcast":"broadcast"
				}
				response_value($arykey,$result['result']);
				var $box = $('LanForm');
				if ($box){ $box.style.display = "block"; }
			}
			load_tun();
		}
		$_A.send($form);
	}
}

function load_tun(){
	//TUN口配置
	var $form = document.forms.TunForm;
	if (!$form){
		load_wan();
	}
	else{
		$_A.command = function(){
			var $result = validate_return();
			if ($result){
				var $arykey	= {
					"tun_type"		:	"type",
					"tun_ip"		:	"ip",
					"tun_mask"		:	"mask",	
					"tun_broadcast"	:	"broadcast",
					"tun_dns1"		:	"dns1",
					"tun_dns2"		:	"dns2"
				}
				response_value($arykey,$result['result']);
				var $box = $('TunForm');
				if ($box){ $box.style.display = "block"; }
			}
			load_wan();
		}
		$_A.send($form);
	}
}

function load_wan(){
	//TUN口配置
	var $form = document.forms.WanForm;
	if (!$form){
		load_wconf();
	}
	else{
		$_A.send(
			$form,
			function(){
				var $result = validate_return();
				if ($result){
					var $arykey	= {
						"wan_type"		:	"type",
						"wan_ip"		:	"ip",
						"wan_mask"		:	"mask",	
						"wan_broadcast"	:	"broadcast",
						"wan_dns1"		:	"dns1",
						"wan_dns2"		:	"dns2",
						"wan_message"	:	"message"
					}
					response_value($arykey,$result['result']);
					var $box = $('WanForm');
					if ($box){ $box.style.display = "block"; }
				  if($result['result']['type']=='ADSL' || $result['result']['type']=='3G'){
					$('wan_broadcasttitle').innerHTML = "TPT地址：";
					//document.all
				  }
				}
				load_wconf();
			},
			null
		);
	}
}

function load_wconf(){
	var $form = document.forms.WConfForm;
	if (!$form){
		load_over();
	}
	else{
		$_A.send(
			$form,
			function($tp){
				var $result = validate_return();
				if ($result){
					$tp = $_G.intval($tp);
					var $wlan	= $tp ? ","+$tp+"," : ","+$_G.intval($result['result']['wlan'])+",";
					var $crow	= [
						[$('tr_netgate'), 'wan_netgate', "netgate",	"1"],
						[$('tr_dailuser'),'wan_dailuser',"user",	"2"],
						[$('tr_lantype'), 'wan_lantype', "g3type",	'4'],
					];
					var $arykey = {};
					var $i;
					for($i in $crow){
						if (!$crow[$i][0]){ continue; }
						if ((","+$crow[$i][3]+",").indexOf($wlan)==-1){
							$crow[$i][0].style.display = "none";
						}
						else{
							$arykey[$crow[$i][1]] = $crow[$i][2];
							$crow[$i][0].removeAttribute("style");
						}
					}
					response_value($arykey,$result['result']);
				}
				load_over();
			}
		);
	}
}

function load_info($settime){
	$settime = $_G.intval($settime);
	//TUN口配置
	var $form = document.forms.SysInfoForm;
	if (typeof(window['$_AA'])=="undefined"){ $_AA = new $_A.constructor(); }
	if ($form){
		$_AA.mode	= "GET";
		$_AA.remode	= "json";
		$_AA.phase	= true;
		$_AA.load	= false;
		$_AA.loadfun= null;
		$_AA.command = function(){
			var $result = validate_return($_AA.result());
			if ($result){
				var $arykey	= {
					"system_cpu_total"	:	"",
					"system_cpu_use"	:	"",
					"system_cpu_percent":	"cpuinfo_str",
					"system_mem_total"	:	"memtotal",
					"system_mem_use"	:	"memuse",
					"system_mem_percent":	"memrate",
					"system_hd_total"	:	"disktotal",
					"system_hd_use"		:	"diskuse",
					"system_hd_percent"	:	"diskrate"
				}
				response_value($arykey,$result['result']);
				var $box = $('SysInfoForm');
				if ($box){ $box.style.display = "block"; }
			}
			if ($settime){setTimeout("load_info("+ $settime +")",$settime*1000);}
		}
		$_AA.send($form);
	}
}

function load_over(){
	load_layer(0);
	$settime = 5;
	setTimeout("load_info("+ $settime +")",$settime*1000);
}

function load_layer($show){
	var $load = $('ConfLoading');
	if (!$load){ return false; }
	if ($show){
		$load.style.display = "block";
	}
	else{
		$load.style.display = "none";
	}
}

function validate_return(){
	var $result;
	if (!arguments.length){$result = $_A.result();}
	else{ $result=arguments[0]; if(!$_G.isarray($result) || $result.length<4){return false;} }
	if (!$result[0] || $result[2]>=0){ return false; }
	if (!$_G.aryexists($result[3],'state','stateId','message','result')){return false;}
	if (!$result[3]['state']){ return false; }
	return $result[3];
}

function SecClient_Restart($button){
	$_C.Confirm(
		"您确定要重启系统？",
		function ($object){
			if (!$object){return false;}
			return AjaxSubmit($object,{"backcall":function(){$_C.Alert($_A.result()[3],null)},"backargs":null});
		},
		null,
		$button
	);
	return false;
}


function SecClient_serverstate($button){
	$_C.Confirm(
		"您确定查看服务状态吗？",
		function ($object){
			if (!$object){return false;}
			return AjaxSubmit($object,{"remode":"json","backcall":function(){$_C.Alert($_A.result()[3]["message"],serverstate)},"backargs":null});
		},
		null,
		$button
	);
	return false;
}

function serverstate(){
	
	$result=$_A.result()[3];
	if ($result){
		var $arykey	= {
				"wan_messagec"	:	"message"
		}
		response_value($arykey,$result['result']);
	  }
}
	

function SecClient_serverstate2($button){
	$_C.Confirm(
		"您确定查看服务状态吗？",
		function ($object){
			if (!$object){return false;}
			return AjaxSubmit($object,{"remode":"json","backcall":function(){$_C.Alert($_A.result()[3]["message"],serverstate2)},"backargs":null});
		},
		null,
		$button
	);
	return false;
}

function serverstate2(){
	
	$result=$_A.result()[3];
	if ($result){
		var $arykey	= {
				"wan_messagey"	:	"message"
		}
		response_value($arykey,$result['result']);
	  }
}
	

function response_value($key,$value){
	if ((!$_G.isarray($key) && !$_G.isobject($key)) || (!$_G.isarray($value) && !$_G.isobject($value))){ return false; }
	var $k,$e,$v;
	for($k in $key){
		$e = $($k);
		if (!$e){ continue; }
		$v = typeof($value[$key[$k]])=="undefined" ? "" : $value[$key[$k]];
		if ($v==""){ $v = "&nbsp;" }
		$e.innerHTML = $v;
	}
}