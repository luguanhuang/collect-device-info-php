// JavaScript Document
$Bln_IsAdsl		= false;
$Div_IsClose		= false;
$Div_IsOk		= false;
$Int_TimeOut	= 0;
$Obj_FormAdsl	= null;
$Obj_FormResult	= null;

function Net_dialConnect($button){
	if (!$button){ return false; }
	Net_dialSubmit($button);
	return false;
}

function Net_dialSubmit($button){
	if (!$button){ return false; }
	return AjaxSubmit(
		$button,{"backcall":Net_dialComplete,"backargs":[$button]}
	);
}

function Net_dialComplete($button){
	if (!$button){ return false; }
	$type	= $_G.strval($button.getAttribute("dailtype"),1);
	$sstate = $_G.strval($button.getAttribute("showstate"),1);
	if ($sstate==""){
		$_C.Alert($_A.result()[3],null);
	}
	else{
		var $msg = $_A.result()[3]+" 是否要查看连接状态？";
		if ($type=="3g"){
			//	$msg+="<br>提示：3G拨号需要几秒钟或更长时间才能完成，必须稍等片刻才能看到连接结果。"	
			$_C.Confirm(
				$msg,
				function (){
					$Div_IsClose=false;
					setTimeout("Adsl_GetResult()",500);
					Adsl_Open();
				},
				null
			);
		}
	}
}

function Net_disConnect($button){
	if (!$button){ return false; }
	$_C.Confirm(
		"您确定要断开拨号连接吗？",
		function (){
			return AjaxSubmit(
				$button,{"backcall":function(){$_C.Alert($_A.result()[3],function (){window.location.href="wan.php"})},"backargs":null}
			);
		},
		null
	);
}

function Adsl_GetResult(){
	//发送数据
	$_A.mode	= 'GET';
	$_A.remode	= 'json';
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	$_A.send(
		document.forms.Adslresult,
		function (){
			var $result = $_A.result();
			if (!$result[0] || $result[2]>=0){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert($result[3],null, false);
				return false;
			}
			//验证返回结果
			if (!$_G.aryexists($result[3],"state","stateId","message","result")){
				//暂停+提示+恢复窗口
				Adsl_Close();
				$_C.Alert("返回的结果参数不完整。",null, false);
				return false;
			}
			//测试
			//$Obj_FormResult.pingmessage.value = $_G.strval($result[3]["result"]);
			//结束了/有错误
			if ($Div_IsClose==true)
			{
				$_C.exit();
				Adsl_Stop();
				return;
			}
			
			if ($result[3]["stateId"]>=0){
				//暂停
				Adsl_Stop();
				$Div_IsOk=true;
			}
			else{
				//输出返回结果
				document.forms.Adslresult.Adslmessage.value=$result[3]["result"];
				document.forms.Adslresult.Adslmessage.scrollTop = document.forms.Adslresult.Adslmessage.scrollHeight;
				setTimeout("Adsl_GetResult()",500)
				$Div_IsOk=false;
			}
		}
	);
	//返回
	return true;
}

//停止（停止不一定就要关闭layer，所以能跟关闭layer合并）
function Adsl_Stop(){
	//暂停
	clearInterval($Int_TimeOut);
	$_A.abort();
	
}


//打开
function Adsl_Open($message){
	//退出层
	$_C.exit();
	//显示layer
	$_C.Custom('AdslHead',$('AdslResult'));
	if (document.forms.Adslresult.Adslmessage){document.forms.Adslresult.Adslmessage.value = $_G.strval($message)}
}

//关闭
function Adsl_Close(){
	
	$Div_IsClose=true;
	
	//退出层
	if ($Div_IsOk)
    	$_C.exit();
	//停止
//	Adsl_Stop()
	//显示原表单
}

