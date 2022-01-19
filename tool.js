// JavaScript Document

$Bln_IsPing		= false;
$Bln_IsTelnet	= false;
$Bln_IsAdsl		= false;
$Int_TimeOut	= 0;
$Obj_FormPing	= null;
$Obj_FormResult	= null;
$Obj_FormAdsl	= null;

function Ping_Validate($form){
	//全局变量
	window['$Obj_FormPing'] = document.forms.pingsend;
	//验证全局状态
	if ($Bln_IsPing){ return false; }
	if (!$Obj_FormPing){ return false; }
	//验证表单
	var	$ary_element = new Array();
		$ary_element["ip"]			= new Array(1,	null,	'目标地址',		/^(((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})|([\w\-]+\.)*[\w\-]+)$/);
		$ary_element["times"]		= new Array(1,	null,	'连接次数',		'>0');
		$ary_element["delay"]		= new Array(1,	null,	'延时',			'>0');
		
	$_G.Form	= $Obj_FormPing;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	//提交表单
	return Ping_Send();
}

function Ping_Send(){
	if ($Bln_IsPing){ return false; }
	if (!$Obj_FormPing){ return false; }
	
	//锁定
	Ping_Lock(true);
	
	$_A.mode	= 'GET';
	$_A.remode	= 'normal';
	$_A.phase	= false;
	$_A.load	= true;
	
	var $pingsub = function (){
			$_A.send(
				$Obj_FormPing,
				function (){
					AjaxLoading();
					var $result = $_A.result();
					if (!$result[0] || $result[2]>=0 ){
						//解锁
						Ping_Lock(false);
						//反馈信息
						$_C.Alert($result[3],null);
						return false;
					}
					//开始定时获取结果
					clearInterval($Int_TimeOut);
					$Int_TimeOut = setInterval('Ping_GetResult()',500);
					//显示浮动层(全新显示)
					Ping_Open();
				}
			);
		}
	
	//如果不是IE
	if (!document.all){
		$_A.loadfun	= AjaxLoading;
		$pingsub();
	}
	else{
		$_A.loadfun	=function (){};	//必须指定一个空函数
		AjaxLoading();				//显示Loading
		setTimeout($pingsub,300);
	}
	
	return false;
}

function Ping_GetResult(){
	if (!$Bln_IsPing){ Ping_Stop(); return false; }
	if (!$Obj_FormResult){Ping_Stop(); return false;}
	//发送数据
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		$Obj_FormResult,
		function (){
			var $result = $_A.result();
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				Ping_Close();
				$_C.Alert($result[3],Ping_Lock, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				Ping_Close();
				$_C.Alert("返回的结果参数不完整。",Ping_Lock, false);
				return false;
			}
			//测试
			//$Obj_FormResult.pingmessage.value = $_G.strval($result[3]["result"]);
			//结束了/有错误
			if ($result[3]["stateId"]>=0){
				//暂停
				Ping_Stop();
			}
			else{
				//输出返回结果
				$Obj_FormResult.pingmessage.value = $_G.strval($result[3]["result"]);
				$Obj_FormResult.pingmessage.scrollTop = $Obj_FormResult.pingmessage.scrollHeight;
			}
		}
	);
	//返回
	return true;
}

//停止（停止不一定就要关闭layer，所以能跟关闭layer合并）
function Ping_Stop(){
	//暂停
	$_A.abort();
	clearInterval($Int_TimeOut);
	//解锁
	Ping_Lock(false);
}

//锁定/解锁（锁定不一定就要显示layer，所以不能跟显示layer合并）
function Ping_Lock($lock){
	$lock = !!$lock;
	//重置标记
	if (typeof(window['$Bln_IsPing'])!='undefined') {$Bln_IsPing = $lock; }
	//激活/屏蔽控件
	if (typeof(window['$Obj_FormPing'])!='undefined'&&$Obj_FormPing.pingstart){$Obj_FormPing.pingstart.disabled=$lock;}
}

//打开
function Ping_Open($message){
	//退出层
	$_C.exit();
	//隐藏原表单
	$('PingSend').style.display = "none";
	//显示layer
	$_C.Custom('PingHead',$('PingResult'));
	window['$Obj_FormResult'] = document.forms.pingresult;
	if ($Obj_FormResult.pingmessage){$Obj_FormResult.pingmessage.value = $_G.strval($message)}
}

//关闭
function Ping_Close(){
	//退出层
	$_C.exit();
	//停止
	Ping_Stop()
	//显示原表单
	$('PingSend').style.display = "block";
}


function Telnet_Validate($form){
	if ($Bln_IsTelnet){ return false; }
	if (!$form){ return false; }
	//验证表单
	var	$ary_element = new Array();
		$ary_element["ip"]			= new Array(1,	null,	'目标IP',	"ip");
		$ary_element["port"]		= new Array(1,	null,	'端口号',	[1,65535]);
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	//锁定
	Telnet_Lock(true);
	//发送
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= false;
	$_A.load	= true;
	
	var $telnetsub = function (){
		$_A.send(
			$form,
			function (){
				AjaxLoading();
				var $result = $_A.result();
				if (!$result[0] || $result[2]>=0){
					$_C.Alert($result[3],Telnet_Lock, false);
					return false;
				}
				//验证返回结果
				if (!$_G.aryexists($result[3],"state","stateId","message","result")){
					$_C.Alert("返回的结果参数不完整。",Telnet_Lock, false);
					return false;
				}
				if ($result[3]['stateId']>=0){
					$_C.Alert($result[3]["message"],Telnet_Lock, false);
					return false;
				}
				//加载结果窗口
				Telnet_Open($result[3]['result']);
			}
		);
	}
	
	//如果不是IE
	if (!document.all){
		$_A.loadfun	= AjaxLoading;
		$telnetsub();
	}
	else{
		$_A.loadfun	=function (){};	//必须指定一个空函数
		AjaxLoading();				//显示Loading
		setTimeout($telnetsub,300);
	}
	return false;
}

function Telnet_Lock($lock){
	$lock = !!$lock;
	//重置标记
	if (typeof(window['$Bln_IsTelnet'])!='undefined') {$Bln_IsTelnet=$lock;}
	//激活/屏蔽控件
	$('telnetstart').disabled = $lock;
}

function Telnet_Open($message){
	//关闭原来的layer
	$_C.exit();
	//隐藏原表单(必须此时才关闭，否则界面编程空白)
	$('TelnetSend').style.display = "none";	//隐藏
	//打开layer窗口
	$_C.Custom('TelnetHead',$('TelnetResult'));
	var $form = document.forms.telnetresult;
	if ($form && $form.telnetmessage){ $form.telnetmessage.value = $_G.strval($message); }
}

function Telnet_Close(){
	//关闭原来的layer
	$_C.exit();
	//解锁
	Telnet_Lock(false);
	//显示原表单
	$('TelnetSend').style.display = "block";
}



function Adsl_Validate($form){
	//全局变量

	window['$Obj_FormAdsl'] = document.forms.Adslsend;
	//验证全局状态
	if ($Bln_IsAdsl){ return false; }
	if (!$Obj_FormAdsl){ return false; }
	
	//验证表单
	var	$ary_element = new Array();
			
	$_G.Form	= $Obj_FormAdsl;
	$_G.Element	= $ary_element;
	

	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	//提交表单

	return Adsl_Send();
}

function Adsl_Send(){
	if ($Bln_IsAdsl){ return false; }
	if (!$Obj_FormAdsl){ return false; }
	
	//锁定
	Adsl_Lock(true);
	
	$_A.mode	= 'POST';
	$_A.remode	= 'json';
	$_A.phase	= false;
	$_A.load	= true;
	var $Adslsub = function (){
			$_A.send(
				$Obj_FormAdsl,
				function (){
					AjaxLoading();
			
					var $result = $_A.result();
					
					if (!$result[3]["state"] || $result[3]["stateId"]>=0 ){
						//解锁
						Ping_Lock(false);
						//反馈信息

						$_C.Alert($result[3],null);
						return false;
					}
					//开始定时获取结果

					clearInterval($Int_TimeOut);

					$Int_TimeOut = setInterval('Adsl_GetResult()',500);
					//显示浮动层(全新显示)
					Adsl_Open();
				}
			);
		}
	
	//如果不是IE
	if (!document.all){
		$_A.loadfun	= AjaxLoading;
		
		$Adslsub();
	}
	else{
		
		$_A.loadfun	=function (){};	//必须指定一个空函数
		AjaxLoading();	//显示Loading
		
		setTimeout($Adslsub,300);
	}
	
	return false;
}

function Adsl_GetResult(){
	if (!$Bln_IsAdsl){ Adsl_Stop(); return false; }
	if (!$Obj_FormResult){Adsl_Stop(); return false;}
	//发送数据
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		$Obj_FormResult,
		function (){
			var $result = $_A.result();
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert($result[3],Adsl_Lock, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",Adsl_Lock, false);
				return false;
			}
			//测试
			//$Obj_FormResult.pingmessage.value = $_G.strval($result[3]["result"]);
			//结束了/有错误
			if ($result[3]["stateId"]>=0){
				//暂停
				Adsl_Stop();
			}
			else{
				//输出返回结果
				$Obj_FormResult.Adslmessage.value = $_G.strval($result[3]["result"]);
				$Obj_FormResult.Adslmessage.scrollTop = $Obj_FormResult.Adslmessage.scrollHeight;
			}
		}
	);
	//返回
	return true;
}

//停止（停止不一定就要关闭layer，所以能跟关闭layer合并）
function Adsl_Stop(){
	//暂停
	$_A.abort();
	clearInterval($Int_TimeOut);
	//解锁
	Adsl_Lock(false);
}

//锁定/解锁（锁定不一定就要显示layer，所以不能跟显示layer合并）
function Adsl_Lock($lock){
	$lock = !!$lock;
	//重置标记
	if (typeof(window['$Bln_IsAdsl'])!='undefined') {$Bln_IsAdsl = $lock; }
	//激活/屏蔽控件
	if (typeof(window['$Obj_FormAdsl'])!='undefined'&&$Obj_FormAdsl.Adslstart){$Obj_FormAdsl.Adslstart.disabled=$lock;}
}

//打开
function Adsl_Open($message){
	//退出层
	$_C.exit();
	//隐藏原表单

	$('AdslSend').style.display = "none";
	//显示layer
	$_C.Custom('AdslHead',$('AdslResult'));
	window['$Obj_FormResult'] = document.forms.Adslresult;
	if ($Obj_FormResult.Adslmessage){$Obj_FormResult.Adslmessage.value = $_G.strval($message)}
}

//关闭
function Adsl_Close(){
	//退出层
	$_C.exit();
	//停止
	Adsl_Stop()
	//显示原表单
	$('AdslSend').style.display = "block";
}
