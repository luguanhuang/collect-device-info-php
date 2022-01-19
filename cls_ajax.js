// JavaScript Document

var $_A = new function (){
	
	//__________________  构造/析构函数  ________________
	
	function __construct(){
		try{$Obj_Ajax = new ActiveXObject("Msxml2.XMLHTTP");}			//如果支持 Msxml2.XMLHTTP
		catch ($error) {
			try {$Obj_Ajax = new ActiveXObject("Microsoft.XMLHTTP"); }	//如果支持 Microsoft.XMLHTTP
			catch ($error){
				try {$Obj_Ajax = new XMLHttpRequest();}					//如果支持 XMLHttpRequest
				catch($error){$Int_Error=1; $Str_Error="创建 XMLHTTP 对象失败"; return false;}
			} 
		}
		$enabled = true;
	}
	function __destruct(){}
	
	//__________________  私有变量  ________________
	
	var $this		= this,			$error		= null,		$enabled	= false;
	var $Int_Error	= 0,			$Str_Error	= "",		$Bln_isSend	= false,	$Bln_Load	= false;
	var $Obj_Ajax	= false,		$Obj_Form	= null,		$Ary_Element= null,		$Ary_Result	= null;
	//传递进来的对象 / 提交的document.getElementById()对象	/ iframe提交时的document.frames[]对象 / 局部更新的对象
	var $Obj_Self	= null,			$Obj_Target	= null,		$Obj_Iframe	= null,		$Str_Zone	= null;
	var $Str_Method	= "",			$Str_ReMode	= "",		$Bln_Phase	= true,		$Bln_Alauto	= true;
	//对象的状态 / 状态描述 / Send之后返回的内容
	var $Int_Status= -1,			$Str_Status	= "",		$Str_Text 	= "";
	var $Obj_LoadFun= null,			$Ary_LoadArg= null,		$Str_LoadTye= "",		$Str_LoadCss= null;
	var $Obj_CmdFun	= null,			$Ary_CmdArg	= null;		$Obj_SubFun	= null,		$Ary_SubArg	= null;
	
	var $Ary_Sending= new Array();
		$Ary_Sending["s1"]		= "准备链接数据源....";		$Ary_Sending["s2"]	= "正在链接数据源....";
		$Ary_Sending["s3"]		= "正在读取数据....";			$Ary_Sending["s4"]	= "读取数据完成.";
		$Ary_Sending["e403"]	= "数据源拒绝访问";			$Ary_Sending["e404"]= "无法找到数据源";
		$Ary_Sending["e100"]	= "发送 XMLHTTP 请求失败";	$Ary_Sending["e500"]= "读取数据发生错误";
		$Ary_Sending["eunk"]	= "读取数据失败";
	
	//__________________  只读属性  ________________
	
	this.version	= function (){return '1.8';}				//版本
	this.build		= function (){return '11.11.29';}			//版本
	this.create		= function (){return '10.07.19';}			//创建
	this.classname	= function (){return "ODFAjax";}			//名称
	this.developer	= function (){return "OldFour";}			//开发者
	this.copyright	= function (){return "www.oldfour.com";}	//公司
	
	this.Errno		= function (){return $Int_Error;}
	this.Error		= function (){return $Str_Error;}
	
	this.status 	= function (){return $Int_Status;}
	this.response	= function (){return $Str_Text;}
	this.result		= function (){return $Ary_Result;}
	
	this.isopen 	= function (){return $enabled;}
	this.isOpen 	= function (){return this.isopen();}
	this.IsOpen 	= function (){return this.isopen();}
	this.issend		= function (){return $Bln_isSend;}
	this.isSend		= function (){return this.issend();}
	this.IsSend		= function (){return this.issend();}
	
	//__________________  可读写属性  ________________
	
	this.phase		= true;		//工作方式(true:异步;false:同步)
	this.mode		= "get";	//提交的方式
	this.load		= false;	//是否显示Load
	
	this.loadfun	= null;		//显示Load的Div或函数
	this.loadarg	= null;		//显示Load函数的参数
	this.loadcss	= null;		//显示LoadDIV的Css
	
	this.form		= false;	//POST提交时的Form
	this.element	= "*"		//POST提交时的表单控件
	
	this.command	= "";		//回调函数(表达式)
	this.cmdarg		= "";		//回调函数的参数
	
	this.debug		= false;	//是否调试模式
	this.alauto		= true;		//是否自动分析返回结果
	this.remode		= null;		//返回数据模式

	//__________________  私有方法  ________________
	
	//基本函数
	function intval($val){return !$val || isNaN($val) ? 0 : Math.floor($val);}
	function strval($string){return $string==null ? "" : (new String($string)).toString();}
	function isnumeric($val){return /^(0)|(-?[1-9][0-9]*)$/.test($val);}
	function isarray($obj){return $obj!=null && (Object.prototype.toString.call($obj) === '[object Array]');}
	function isForm($obj){var $form = getObject($obj); return $form && $form.nodeName && $form.nodeName=="FORM" ? $form : false;}

	function isFunction($fun){
		var $str_func	= null;
		var $ary_str	= null;
		if ( typeof($fun)=="function" || (typeof($fun)=="object" && $fun!==null) ){return $fun;}
		if ( typeof($fun)=="string" ){
			$str_func = $fun.toString().replace(/^([^\(\ ]*)[\s\S]*$/,"$1");
			if ($str_func ==""){return null;}
			try{
				var $obj_func  = eval($str_func), $str_type = typeof($obj_func);
				if ( $str_type=="function" || ($str_type=="object" && $str_func!="null") ){ return $obj_func; }
			}
			catch($error){return false;}
		}
		return false;
	}
	
	function getObject($str){	//只返回一个
		if ($str==null){return false;}
		if (typeof($str)!="string"){return $str.nodeName ? $str : null;}
		var $obj_element = document.getElementById($str);
		if (!$obj_element){
			$obj_element = document.getElementsByName(this.loadfun);
			$obj_element = $obj_element.length ? $obj_element[0] : null;
		}
		return $obj_element;
	}
	
	function getCmdArg($index){
		if (!isarray($Ary_CmdArg)){ return null; }
		$index = Math.min(intval($index),0);
		return typeof($Ary_CmdArg[$index])=='undefined' ? null : $Ary_CmdArg[$index];
	}

	function getRequestBody(){
		if (!$Obj_Form){return null;}
		var	$ary_elem = new Array(),$has=false,$name="",$node="";
		//1:获取所有要读取的控件的名称
			//null/空/*时:读取全部
		if ($Ary_Element==null || typeof($Ary_Element)=="string"){
			if ($Ary_Element!=null && $Ary_Element!="" && $Ary_Element!="*"){return "";}
			//获取所有控件名称（区分大小写）
			for ($i=0;$i<$Obj_Form.elements.length;$i++){
				$name = strval($Obj_Form.elements[$i].name);
				if ( $name == "" ){ continue; }
				if ( typeof($ary_elem[$name])=="undefined" ){ $ary_elem[$name]=$name; $has=true;}
			}
		}
		else{
			//获取指定控件名称（区分大小写）
			for (var $el in $Ary_Element){
				if ($Obj_Form.elements[$Ary_Element[$el]]!=null){
					$name = strval($Obj_Form.elements[$i].name);
					if ( $name == "" ){ continue; }
					if ( typeof($ary_elem[$name])=="undefined" ){$ary_elem[$name]=$name;$has=true;}
				}
			}
		}
		if (!$has){return null;}
		
		//2:读取控件的值保存进数组
		var $el="",$i=0;
		var $ary_value	= new Array();
		var $ary_obj	= new Array();
		for ($el in $ary_elem){
			$name = $ary_elem[$el];
			if ($name==""  || !$Obj_Form.elements[$name] ){continue;}
			if (!$Obj_Form.elements[$name].length){$ary_obj = [$Obj_Form.elements[$name]];}
			else if($Obj_Form.elements[$name][0].nodeName.toUpperCase()=="OPTION"){$ary_obj=[$Obj_Form.elements[$name]];}
			else{ $ary_obj = $Obj_Form.elements[$name];}
			$ary_value[$i] = $el+"="+getRequestValue($ary_obj);
			$i++;
		}
		return $ary_value.join("&");
	}
	
	function getRequestValue($obj){
		if (!$obj){return "";}
		var $array	= new Array();
		var $value	= "";
		var $type	= "";
		var $x=0,$y=0;
		for ($x=0;$x<$obj.length;$x++){
			if ($obj[$x].type.toLowerCase()=="radio"){
				if($obj[$x].checked != true){continue;}
				$value = $obj[$x].value;
			}
			else if ($obj[$x].type.toLowerCase()=="checkbox"){
				if($obj[$x].checked != true){continue;}
				$value = $obj[$x].value;
			}
			else{ $value = $obj[$x].value; }
			$array[$y] = $this.urlencode($value);
			$y++;
		}
		return $array.join(",");
	}
	
	function showLoading(){
		//禁用 || null || 不是函数也不是node
		if (!$Bln_Load || $Obj_LoadFun==null || ($Str_LoadTye!="function" && !$Obj_LoadFun.nodeName) ){return false;}
		if ($Str_LoadTye=="function"){$Obj_LoadFun.apply(null,$Ary_LoadArg);return true;}
		$Obj_LoadFun.innerHTML = $Str_Text;
		if (!$Str_LoadCss){return true;}//指定没有指定Loading的css
		if ($Int_Status==1){				//如果是发起状态
			//备份原来的css
			var $str_ocss	= $Obj_LoadFun.getAttribute('classStyle');
			var $str_class	= strval($Obj_LoadFun.className);
			if ($str_ocss==null){$Obj_LoadFun.setAttribute('classStyle',$str_class);}
			//直接覆盖Css的
			if ($Str_LoadCss.substring(0,1)!="+"){$Obj_LoadFun.className = $Str_LoadCss; return true;}
			//追加Css的(需要还原)
			$Obj_LoadFun.className = ($str_class+" "+$Str_LoadCss.substring(1)).replace(/^\s+/,"");
		}
		else if ($Int_Status==4){			//结束状态
			$Obj_LoadFun.className = strval($Obj_LoadFun.getAttribute('classStyle'));
		}
	}
	
	function debug(){
		var $str_detxt	= $Str_Text;
			$str_detxt	= $str_detxt.replace(/\</g,"&lt;");
			$str_detxt	= $str_detxt.replace(/\>/g,"&gt;");
		var $ary_detxt	= new Array();
			$ary_detxt[0]	= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
			$ary_detxt[1]	= '<html xmlns="http://www.w3.org/1999/xhtml">';
			$ary_detxt[2]	= '	<title>Ajax Debug</title>';
			$ary_detxt[3]	= '	<body style="background-color:#CBE1EF;margin:0px;padding:12px;">';
			$ary_detxt[4]	= '		<div style="border:1px solid #4A6C8E;">'
			$ary_detxt[5]	= '			<h4 style="font-size:16px;font-weight:bold; color:#FFFFFF; height:20px; line-height:20px;background-color:#5C87B2;border-bottom:1px solid #4A6C8E;margin:0px;padding:4px 6px 4px 6px;">Ajax Debug</h4>'
			$ary_detxt[6]	= '			<div style="background-color:#FFFFFF;padding:6px; font-size:14px; line-heigth:20px;">'
			$ary_detxt[7]	= '				<div style="padding-bottom:4px;"><label style="float:left; display:inline; width:80px; height:20px; text-align:right;padding-right:8px;-padding-right:5px;">Errno:</label><div style="height:20px;color:red;font-weight:bold;">'+ $Int_Error +'</div></div>'
			$ary_detxt[8]	= '				<div style="padding-bottom:4px;"><label style="float:left; display:inline; width:80px;height:20px; text-align:right;padding-right:8px;-padding-right:5px;">Error:</label><div style="height:20px;">'+ $Str_Error +'</div></div>'
			$ary_detxt[9]	= '				<div style="padding-bottom:4px;"><label style="float:left; display:inline; width:80px; height:20px; text-align:right;padding-right:8px;-padding-right:5px;">Response:</label><div style="height:380px;"><textarea style="width:642px;height:372px;border:1px solid #98B0C9;color:#4F4F4F;">'+ $str_detxt +'</textarea></div></div>'
			$ary_detxt[10]	= '			</div>'
			$ary_detxt[11]	= '		</div>'
			$ary_detxt[12]	= '	</body>'
			$ary_detxt[13]	= '</html>'
		var $ary_size = new Array();
			$ary_size['w'] = 780; $ary_size['l'] = (window.screen.width-$ary_size['w'])/2;
			$ary_size['h'] = 500; $ary_size['t'] = (window.screen.height-$ary_size['h'])/2-20;
		var $obj_debug	= window.open("about:blank","ajax_debug","alwaysRaised=yes,toolbar=no, menubar=no, location=no, status=no,scrollbars=no,resizable=no,width="+ $ary_size['w'] +"px,height="+ $ary_size['h'] +"px,left="+ $ary_size['l'] +",top="+$ary_size['t']+"px");
		if ($obj_debug && $obj_debug.document){$obj_debug.document.write($ary_detxt.join("\r\n"));}
			return false;
	}
	
	//初始化提交环境
	function SendInitial($object){
		if (!$object || !$object.nodeName){return;} else {$Obj_Self = $object;}
		$Int_Error		= 0;		$Str_Error		= "";
		$Str_Target		= "";		$Str_Request	= "";
		$Str_Text		= "";		$Ary_Result		= new Array();
		//创建局部变量
		var	$tarsubwin 	= strval($Obj_Self.getAttribute("submitwin"));
		
		console.log("tarsubwin="+$tarsubwin);
		var	$indexof	= $tarsubwin.indexOf(":");
		var $retrunmode	= strval($Obj_Self.getAttribute("returnmode"));
		//截取变量
		$Str_Request	= $tarsubwin.substring(0,$indexof);
		$Str_Target 	= $tarsubwin.substring($indexof+1);
		$Str_ReMode		= $retrunmode == "" ? $this.remode : $retrunmode;
		//如果为空
		if ($Str_Target==""){$Str_Target= strval($Obj_Self.getAttribute("target")); }
		//Ajax窗口
		if (/^ajax$/i.test($Str_Target)){
			$Str_SubType= "ajax"; $Obj_Target = self; $Obj_Self.setAttribute("target","_self");
		}
		//提交后本窗口不能对其再操作
		else if (/^(_?self)|(_?top)|(_?parent)|(_blank)|(window)$/i.test($Str_Target)){
			$Str_SubType= "window";
			$Obj_Target	= window;
			$Obj_Self.setAttribute("target",$Str_Target);
			if ($Str_Target == "_blank"){$Obj_Target=null;}
			else{
				var $obj_target = null;
				var $str_target = $Str_Target.toLowerCase().replace(/^_/,"");
				try{ $obj_target = eval($str_target); if($obj_target.document && $obj_target.location){$Obj_Target=$obj_target;} } catch($error){ $Obj_Target = self; }
			}
		}
		//iframes窗口(没有指明或指明都可以)
		else if (/^iframe$/i.test($Str_Target)){
			var $atttar = strval($Obj_Self.getAttribute("target"));	//获取真正的target
			if (!window.frames[$atttar]){
				$atttar = "submitiframe_"+parseInt(Math.random()*899999+100000);
				var $obj_frame = document.createElement('iframe');
					$obj_frame.id = $atttar;		$obj_frame.src = "about:blank";
					$obj_frame.scrolling = "no";	$obj_frame.frameBorder = "0";
					$obj_frame.marginHeight = "0";	$obj_frame.marginWidth = "0";
					$obj_frame.vspace = "0";		$obj_frame.hspace = "0";
					$obj_frame.width = "0";			$obj_frame.height= "0";
					document.body.appendChild($obj_frame);
					document.getElementById($atttar).contentWindow.window.name = $atttar;
					$Obj_Self.setAttribute("target",$atttar);
			}
			$Str_Target = $atttar;
			$Obj_Target	= document.getElementById($Str_Target);
			$Obj_Iframe = window.frames[$Str_Target];
			$Str_SubType = "iframe";
		}
		//frame窗口
		else{
			var $ary_win = $Str_Target.split(".");
			var $str_win = "parent";
			for (var $i=0;$i<$ary_win.length;$i++){
				try{ 
					$Obj_Target = eval($str_win);
					if ($Obj_Target && $Obj_Target.document && $Obj_Target.location){$str_win += "."+$ary_win[$i];}
					else{$Obj_Target = null; break;}
				}
				catch($error){$Obj_Target = null; break;}
			}
			if (!$Obj_Target){ $Str_SubType="window"; $Obj_Self.setAttribute("target","_blank");}
			else if ($Obj_Target==window){$Str_SubType="window"; $Obj_Self.setAttribute("target","_self");}
			else{ $Str_SubType="frame"; $Obj_Self.setAttribute("target",$str_win); }
		}
		var $property = $Obj_Self.nodeName == "A" ? "href" : "action";
		//获取原来action地址
		var $str_action = "";
		if ($Obj_Self.getAttribute("submitact")!=null){$str_action = $Obj_Self.getAttribute("submitact");}
		else{$str_action= $Obj_Self.getAttribute($property); $Obj_Self.setAttribute("submitact",$str_action);}
		//action地址加上参数
		if ($Str_Request!=""){
			if($str_action.indexOf('?') == -1){$str_action += '?'+$Str_Request+'='+$Str_SubType;}
			else if ($str_action.substring($str_action.length-1)=="?"){$str_action += $Str_Request+'='+$Str_SubType;}
			else {$str_action += '&'+ $Str_Request + '=' + $Str_SubType;}
		}
		$Obj_Self.setAttribute($property,$str_action);
	}
	
	function SendAjax($url,$search){
		if (!$enabled){return false;}

		var $str_url = strval($url).replace(/\#[\s\S]*$/,"");							//去掉#后面部分
		if ($str_url==""){$str_url = window.location.pathname+window.location.search;}	//去掉#后面部分
		
		var	$str_search = "";			//保存字符型形式的URL参数
		var $ary_search = new Array();	//保存数字型形式的URL参数
		var $int_search	= 0;
		
		if (($p=$str_url.indexOf('?'))!=-1){
			$str_search = $str_url.substring($p+1).replace(/^((\?+\&*)|(\&+))/,"");
			$str_url	= $str_url.substring(0,$p);
			if ($str_url==""){$str_url = window.location.pathname;}
		}
		//先处理第二个参数部分
			//如果是数组形式的转换为到 $ary_search
		if (isarray($search)){
			var $el;
			for($el in $search){
				if (/^(0|[1-9][0-9]*)$/.test($el)){
					if ( ($p = $search[$el].indexOf("=")) <1){continue;}//没有等号或等号在第一位，视为无效
					$ary_search[$int_search]=$search[$el].substring(0,$p)+"="+ $this.urlencode($search[$el].substring($p+1));
				}
				else{$ary_search[$int_search] = $el+"="+ $this.urlencode($search[$el]);}
				$int_search++;
			}
		}
			//如果是字符形式的处理后与原来的$str_search合并
		else{
			var $str_temp = strval($search).replace(/^((\?+\&*)|(\&+))/,'');//合并
			if ($str_temp!=''){
				if ($str_search==''){$str_search = $str_temp;} else{$str_search +='&'+$str_temp; }
			}
		}
	
		//如果以字符型的URL参数不为空
		if ($str_search!=''){
			var $i=0, $l=0, $p=-1, $v="";
			var	$ary_temp	= $str_search.split('&');
			var	$ary_value	= [];
			var $ary_keys	= [];
			for ($i=0;$i<$ary_temp.length;$i++){
				//获取等号位置
				$p=$ary_temp[$i].indexOf("=");
				//没有等号或等号在第一位，视为上一个参数部分的
				if ( $p<1 ){
					if(!$l){continue;}
					$ary_value[$l-1] += "&"+$ary_temp[$i];
				}
				else{
					$ary_keys[$l]	= $ary_temp[$i].substring(0,$p);
					$ary_value[$l]	= $ary_temp[$i].substring($p+1);
					$l++;
				}
			}
			if ($l>0){
				for($i=0;$i<$l;$i++){$ary_search[$int_search] = $ary_keys[$i]+"="+ $this.urlencode($ary_value[$i]); $int_search++;}
			}
			
		}
		//最终合并
		if ($ary_search.length){$str_url+='?'+$ary_search.join("&");}
		$ary_search = null;
			//测试
		var $str_mode	= strval($Str_Method).toLowerCase();
			$str_mode	= $str_mode == "post" ? "post" : "get";
		if ($str_mode == "post"){
			if ((typeof($Obj_Form)!="object") && !$Obj_Form){
				$Int_Error = 20; $Str_Error = "使用 POST 模式发送时必须指定一个数据表单"; return false;
			}
			$Obj_Form = getObject($Obj_Form);
			if (!$Obj_Form || $Obj_Form.nodeName.toUpperCase()!="FORM"){
				$Obj_Form = document.forms[0];
				if (!$Obj_Form){ $Int_Error = 21; $Str_Error = "指定的数据表单无效"; return false; }
			}
			if (!isarray($this.element)){
				var $str_ele = strval($this.element);
				$Ary_Element = ($str_ele == "" || $str_ele=="*") ? "*" : $str_ele.split(",");
			}
			else{
				$Ary_Element = $this.element;
			}
		}
		
		$Bln_Load = !!$this.load;
		if ($Bln_Load){
			//实时获取loading函数
			$Obj_LoadFun = isFunction($this.loadfun);
			//是函数的
			if ($Obj_LoadFun){
				$Str_LoadTye	= "function";
				$Ary_LoadArg	= isarray($this.loadarg) ? $this.loadarg : new Array($this.loadarg);
			}
			else{
				if (typeof($this.loadfun)=="string" && strval($this.loadfun)==""){
					$Int_Error = 30;
					$Str_Error = "指定用于显示状态时必须同时指定一个用于处理状态的函数或控件";
					return false;
				}
				$Obj_LoadFun = getObject($this.loadfun);
				if (!$Obj_LoadFun){
					$Int_Error = 31;
					$Str_Error = "指定用于显示发送状态的控件不存在";
					return false;
				}
				else if (("/BODY/TD/DIV/P/SPAN/FONT/B/U/I/A/").indexOf("/"+ ($obj_loadfun.nodeName) +"/")==-1){
					$Int_Error = 32;
					$Str_Error = "指定用于显示发送状态的控件不是可插入文本的控件";
					return false;
				}
				$Str_LoadTye = "tagnode";
				$Str_LoadCss = $this.loadcss==null ? null : strval($this.loadcss).replace(/(^[\s\ ]+)|([\s\ ]+$)/g,"");
				if ($Str_LoadCss=="+"){$Str_LoadCss = null;}
			}
			showLoading();
		}
		var $str_head = $str_mode == "get" ? "text/html;" : "application/x-www-form-urlencoded";
		var $str_send = $Obj_Form && $Obj_Form.nodeName && $Obj_Form.nodeName=='FORM' ? getRequestBody() : null;
		//如果存在$str_send且$str_mode为'get'模式
		if ($str_send && $str_mode=='get'){
			var $int_spos	= $str_url.indexOf('?');
			var $int_last	= $str_url.length-1;
			if ($int_spos == -1){$str_url+="?"+$str_send;}			//不含“?”
			else if($int_spos==$int_last){$str_url += $str_send;}	//第一个“?”是最后的字符
			else if($str_url.substring($int_last)=="&"){$str_url += $str_send;}
			else {$str_url += "&"+$str_send;}
			$str_send = null;
		}
		
		console.log("str_mode="+$str_mode+" str_url="+$str_url+" Bln_Phase="+!!$Bln_Phase);
		
		$Obj_Ajax.open($str_mode,$str_url,!!$Bln_Phase);
		$Obj_Ajax.setRequestHeader("Content-Type",$str_head);
		try{
			var $is_ffox = /\s+firefox\/[1-9]+(\.\d+)*$/i.test(navigator.userAgent);
			if (!$is_ffox || $Bln_Phase){$Obj_Ajax.onreadystatechange=complete;}	//非火狐 || 非异步
			$Obj_Ajax.send($str_send);
			if ($is_ffox && !$Bln_Phase){ complete();}								//火狐 且为 异步
		}
		catch($error){
			$Int_Status = 100;	/*自定义状态*/ 	$Str_Status = $Ary_Sending["e100"];		$Str_Text = $error.description;
			$Int_Error	= $Int_Status;			$Str_Error	= $Str_Status;
			return $this.debug ? debug() : false;
		}
		$Bln_isSend = true;
		return true;
	}
	
	function complete() {
		var $int_ready,$str_skey;	//请求的状态，状态对应的数组
			$int_ready = $Obj_Ajax.readyState;
		switch($int_ready){
			case 4:
				//如果是请求本地文件，那么请求结束后([readyState]等于4),[status]是等于0(不是200)
				if (!$Obj_Ajax.status || $Obj_Ajax.status==200){$Int_Status = 200; $str_skey="s4";}
				else{ $Int_Status = $Obj_Ajax.status; $str_skey="e"+$Int_Status; }
				$Bln_isSend = false;
				break;
			default:
				$Int_Status = $Obj_Ajax.readyState
				$str_skey = "s"+$Obj_Ajax.readyState
		}
		if ($Ary_Sending[$str_skey]){$Str_Status = $Ary_Sending[$str_skey];}
		else{$Str_Status=$Ary_Sending["eunk"]+"(ERROR:"+ $Int_Status +")";}
		if ($int_ready!=4){ $Str_Text = $Str_Status;}	//未完成时，返回内容等于状态描述
		else{$Str_Text = $Obj_Ajax.responseText;}		//完成时，返回内容等于实际返回的内容
		if ($int_ready==4){
			showLoading();
			//自动分析
			if ($Bln_Alauto){$this.analy();if (!$Ary_Result['result'] && $this.debug){return debug();}/*调试模式*/}
			if ($Obj_CmdFun=isFunction($Obj_CmdFun)){$Obj_CmdFun.apply(null,$Ary_CmdArg);}
			return true;
		}
	}
	
	function SendForm($form){
		
		if (!$form || !$form.nodeName || $form.nodeName!='FORM'){return false;}
		//初始化环境
		SendInitial($form);
		//iframe/frame/window提交的
		if ($Str_SubType=="iframe" || $Str_SubType=="frame" || $Str_SubType=="window"){
			//iframe必须创建onload事件
			if ($Str_SubType=="iframe"){
				if (window.addEventListener){$Obj_Target.addEventListener("load",SendReturn,true);}
				else if(window.attachEvent){$Obj_Target.attachEvent("onload",SendReturn);}
				else{$Obj_Target.onload = SendReturn;}
			}
			//frame必须创建事件
			/*
			else if ($Str_SubType=="frame"){
				if (typeof(document.onreadystatechange)=="undefined"){$Obj_Iframe.onload=SendReturn;}
				else{$Obj_Iframe.document.onreadystatechange = SendReturn;}
			}
			*/
			return true;
		};
		//ajax提交的(一定不自动分析，回调函数一定等于内部函数"SendReturn")
		if ($enabled){
			var $act = $form.attributes.getNamedItem('action');
				$act = $act && $act.nodeValue ? $act.nodeValue : "";
			$Bln_Phase	= $this.phase;	$Bln_Alauto = false;		$Str_Method = $form.method;	$Obj_Form=$form;
			$Ary_CmdArg = new Array();	$Obj_CmdFun = SendReturn;	$Ary_Element= "*";			SendAjax($act);
		}
		return false;
	}
	
	function SendLink($object){
		//验证对象
		if (!$object || !$object.nodeName || (",A,INPUT,SELECT,").indexOf(","+$object.nodeName+",")==-1){return false;}
		if ($object.nodeName=="INPUT" && (!$object.type || !/^(button|checkbox|radio)$/i.test($object.type))){return false;}
		//初始化环境
		SendInitial($object);
		//iframe/frame提交的
		if ($Str_SubType=="iframe" || $Str_SubType=="frame" || $Str_SubType=="window"){
			//iframe必须创建onload事件
			if ($Str_SubType=="iframe"){
				if (window.addEventListener){$Obj_Target.addEventListener("load",SendReturn,true);}
				else if(window.attachEvent){$Obj_Target.attachEvent("onload",SendReturn);}
				else{$Obj_Target.onload = SendReturn;}
			}
			//frame必须创建事件
			/*
			else if ($Str_SubType=="frame"){
				if (typeof(document.onreadystatechange)=="undefined"){$Obj_Iframe.onload=this.returnresult;}
				else{$Obj_Iframe.document.onreadystatechange = this.returnframe;}
			}
			*/
			if ($object.nodeName!="A"){
				if ($Str_SubType=="iframe"){$Obj_Target.src = $object.action;}
				else if($Str_Target=="_blank"){window.open($object.action);}
				else{$Obj_Target.location = $object.action;}
			}
			return true;
		}
		var $href = $object.nodeName == "A" ? $object.getAttribute("href") : $object.getAttribute("action");
		//ajax提交的(一定不自动分析，回调函数一定等于内部函数"SendReturn")
		if ($enabled){
			$Bln_Phase	= $this.phase;	$Bln_Alauto= false;		$Str_Method	="get"; 	$Obj_Form=null;
			$Ary_CmdArg = new Array(); 	$Obj_CmdFun=SendReturn;	$Ary_Element=null;		SendAjax($href);
		}
		return false;
	}

	function SendReturn(){
		//对象内部分析返回结构全部继承analy方法的，使用4个元素分析，返回时只返回3个元素(失败/成功,错误代码,错误描述)
		$Ary_Result = new Array(0,0,0,"");
		//自动分析时才进行分析
		if ($Str_SubType=="ajax"){$this.analy();}
		else if($Str_SubType=="iframe"){
			if ($Obj_Iframe.location.href.toLowerCase()=="about:blank"){ return false; }
			if(window.removeEventListener){$Obj_Target.removeEventListener("load",SendReturn,true);}
			else if(window.detachEvent){$Obj_Target.detachEvent("onload",SendReturn);}
			else{$Obj_Target.onload = "";}
			//与Ajax的返回值的分析存在的区别：1.没有发送数据时无法区分;2.发送不成功也无法区分
			$Str_Text = $Obj_Iframe.document.body.innerHTML;
			$Obj_Iframe.location.href = "about:blank";	//将地址重置
			$mode = strval($Str_ReMode).toLowerCase();
			if ($mode=="html")		{$Ary_Result[2] = -1;  $Ary_Result[3] = $Str_Text; $Ary_Result[0]=1;}
			else if ($Str_Text=="")	{$Ary_Result[2] = 101; $Ary_Result[3] = "服务器端返回的内容为空";}
			else if ($mode=="js")	{
				try{eval($Str_Text);$Ary_Result[2] = -1;	$Ary_Result[3] = "complete"; $Ary_Result[0] = 1;}
				catch($error){		$Ary_Result[2] = 102;	$Ary_Result[3] = $error.description ;}
			}
			else if ($mode=="json")	{
				try{ $Ary_Result[2] = -1;	$Ary_Result[3] = eval("("+ $Str_Text +")"); $Ary_Result[0] = 1;}
				catch($error){				$Ary_Result[2] = 103; $Ary_Result[3] = $error.description ;}
			}
			else{
				$mode = "normal";
				var $arytmp = $Str_Text.split(",");
				if ($arytmp.length<2) {$Ary_Result[2] = 104; $Ary_Result[3] = "服务器端返回的数组长度不匹配"+$Str_Text;}
				else if (!isnumeric($arytmp[0])){$Ary_Result[2] = 105; $Ary_Result[3] = "服务器端返回的数值不匹配2";}
				else {//到此表示返回的值是标准值
					$Ary_Result[2]=$arytmp[0]; $Ary_Result[3]=$arytmp[1]; $Ary_Result[0]=1;
					var $x=2;$y=4; for ($x=2;$x<$arytmp.length;$x++){$Ary_Result[$y]=$arytmp[$x];$y++;}
				}
				$arytmp = null;
			}
		}
		//如果有回调函数
		if ($Obj_SubFun=isFunction($Obj_SubFun)){
			//将指定的参数放到最前一起返回
			var $ary_args = $Ary_SubArg;
			if (!$Ary_SubArg || !$Ary_SubArg.length){$ary_args = [$Ary_Result[0],$Ary_Result[1],$Ary_Result[2]];}
			else{$ary_args.push($Ary_Result[0]);$ary_args.push($Ary_Result[2]); $ary_args.push($Ary_Result[3]);}
			$Obj_SubFun.apply(null,$ary_args);
			$ary_args = null;
			return $Ary_Result[0]<0;
		}
		//如果没有回调函数
		return $Int_Status==200;
	}
	
	function UpdateReturn(){
		if (!$Ary_Result[0]){return false;}
		var $obj_zone = getObject($Str_Zone);
		if (!$obj_zone){return false;}
		if ($Str_Text == ""){$obj_zone.innerHTML = ""; return true;}
		
		var $ary_zone = [strval($obj_zone.name),strval($obj_zone.id)];
		if ($ary_zone[0]=="" && $ary_zone[1]==""){return false;}
		//标准化
		var $str_html = $Str_Text;
			$str_html = $str_html.replace(/\<bdo([^\>]+)id\=(\"([^\"\>]+)\"|\'([^\'\>]+)\'|([^\ \'\"\>][^\ \>]*))/gi, "<bdo$1id=\"$3$4$5\"");
			$str_html = $str_html.replace(/\<bdo([^\>]+)name\=(\"([^\"\>]+)\"|\'([^\'\>]+)\'|([^\ \'\"\>][^\ \>]*))/gi, "<bdo$1name=\"$3$4$5\"");
		var $ary_post = [null,null];
		if ($ary_zone[0]!=""){$ary_post[0]="id=\""+ $ary_zone[0] +"\"";}
		if ($ary_zone[1]!=""){$ary_post[1]="name=\""+ $ary_zone[1] +"\"";}
		//截取
		var $ary_mat=[],$str_mat="",$bln_mat=false,$str_cut="";
		while($ary_mat){
			$ary_mat = /\<bdo([^\>]+)\>([\s\S]+)\<\/bdo\>/gi.exec($str_html)
			if ($ary_mat){
				$str_mat = $ary_mat[1];	//取出属性部分
				if ($ary_zone[0] && $str_mat.indexOf($ary_zone[0])!=-1){$str_cut=$ary_mat[2];break;}
				if ($ary_zone[1] && $str_mat.indexOf($ary_zone[1])!=-1){$str_cut=$ary_mat[2];break;}
				$str_html = $ary_mat[2];
			}
		}
		$obj_zone.innerHTML = $str_cut;
		return true;
	}
	
	//__________________  公有方法  ________________
	
	this.urlencode = function ($str){
		if (!$enabled){return "";}
		if ( ($str=strval($str)) ==""){return "";}
		var	$str_url = encodeURIComponent($str);
			$str_url = $str_url.replace(/\~/g,'%7E'); $str_url = $str_url.replace(/\'/g,'%27');
			$str_url = $str_url.replace(/\!/g,'%21'); $str_url = $str_url.replace(/\*/g,'%2A');
			$str_url = $str_url.replace(/\(/g,'%28'); $str_url = $str_url.replace(/\)/g,'%29'); 
		return $str_url;
	}

	//$url的参数可以通过3种方式来传递
	//1.直接写在 $url 后面
	//2.以字符型赋值到第二个参数
	//3.以数组型赋值到第二个参数(推荐！！！)
	this.request = function ($url,$search){
		//事先获取是否存在回调函数
		$Obj_CmdFun = this.command;		$Obj_Form	= this.form;
		$Str_Method	= this.mode;		$Str_ReMode = this.remode;
		$Bln_Phase	= this.phase;		$Bln_Alauto = this.alauto;
		//如果指定了回调函数
		if ($Obj_CmdFun){$Ary_CmdArg = isarray($this.cmdarg) ? $this.cmdarg : new Array($this.cmdarg);}
		//如果指定了FORM
		if ($Obj_Form){$Ary_Element=$this.element}else{$Ary_Element = null;}
		SendAjax($url,$search);
		return false;
	}
	
	this.abort	= function (){
		if (!$enabled){return false;}
		try{$Obj_Ajax.abort()}catch($error){return false;}
	}
	
	this.clearact = function ($object){
		if ($object && $object.getAttribute("submitact")){$object.removeAttribute("submitact");return true;}
		return false;
	}
	
	this.analy = function ($mode){
		$Ary_Result	= new Array(0,$Int_Status);
		$mode = $mode==null ? $Str_ReMode : $mode;
		$mode = strval($mode).toLowerCase();
		if ($Int_Status==100)		{$Ary_Result[2] = 100; $Ary_Result[3] = $Str_Status;}
		else if ($Int_Status!=200)	{$Ary_Result[2] = 101; $Ary_Result[3] = $Str_Status;}
		else if ($mode=="html")		{$Ary_Result[2] = -1;  $Ary_Result[3] = $Str_Text; $Ary_Result[0]=1;}
		else if ($Str_Text=="")		{$Ary_Result[2] = 102; $Ary_Result[3] = "服务器端返回的内容为空";}
		else if ($mode=="js")		{
			try{eval($Str_Text); $Ary_Result[2] = -1; $Ary_Result[3] = "complete"; $Ary_Result[0] = 1;}
			catch($error){$Ary_Result[2] = 103; $Ary_Result[3] = $error.description ;}
		}
		else if ($mode=="json")		{
			$Ary_Result[4] = $Str_Text;
			try{ $Ary_Result[2] = -1; $Ary_Result[3] = eval("("+$Str_Text+")"); $Ary_Result[0] = 1;}
			catch($error){$Ary_Result[2] = 104; $Ary_Result[3] = $error.description ;}
		}
		else{
			$mode = "normal";
			var $arytmp = $Str_Text.split(",");
			
			if ($arytmp.length<2) {$Ary_Result[2] = 105; $Ary_Result[3] = "服务器端返回的数组长度不匹配";}
			else if (!isnumeric($arytmp[0])){$Ary_Result[2] = 106; $Ary_Result[3] = "服务器端返回的数值不匹配1";}
			else {//到此表示返回的值是标准值
				$Ary_Result[2]=$arytmp[0]; $Ary_Result[3]=$arytmp[1]; $Ary_Result[0]=1;
				var $x=2;$y=4; for ($x=2;$x<$arytmp.length;$x++){$Ary_Result[$y]=$arytmp[$x];$y++;}
			}
			$arytmp = null;
		}
		$Ary_Result['result']	= $Ary_Result[0]; $Ary_Result['status']= $Ary_Result[1];
		$Ary_Result['errno']	= $Ary_Result[2]; $Ary_Result['error'] = $Ary_Result[3];
		if (!$Ary_Result[0]){$Int_Error = $Ary_Result[2]; $Str_Error = $Ary_Result[3];}
		return $Ary_Result;
		/*
		返回值说明：
		$aryrs['result']/[0]:表示最终处理是否成功(请求失败或返回结果不匹配都是0)
		$aryrs['status']/[1]:ajax执行最终的状态
		$aryrs['status']/[1]!=200:	$aryrs['errno']/[2]:对象错误代码
									$aryrs['error']/[3]:对象错误描述
		$aryrs['status']/[1]==200:
			标准模式:		$aryrs['errno']/[2]:目标页面的执行结果代码
						$aryrs['error']/[3]:目标页面执行结果描述
			HTML模式:	$aryrs['errno']/[2]: -1
						$aryrs['error']/[3]: html代码
			JS模式:		$aryrs['errno']/[2]: -1
						$aryrs['error']/[3]: "complete"
			JSON模式:	$aryrs['errno']/[2]: -1
						$aryrs['error']/[3]: 执行结果的对象
		*/
	}
	
	/*特殊发送部分*/
	this.send = function($object,$command,$args){
		if (!$object || !$object.nodeName){return false;}	//验证参数
		//事先获取回调函数
		if (arguments.length>1){$Obj_SubFun = arguments[1];} else {$Obj_SubFun = this.command;}
		if (arguments.length>2){
			$Ary_SubArg=[];
			var $x=0,$y=0; for ($x=2;$x<arguments.length;$x++){$Ary_SubArg[$y]=arguments[$x];$y++;}
		}
		else{
			$Ary_SubArg= isarray(this.cmdarg) ? this.cmdarg : new Array(this.cmdarg);
		}
		return $object.nodeName=='FORM' ? SendForm($object) : SendLink($object);
	}
	
	this.upzone = function($object,$zone){
		if (!$object || !$object.nodeName){return;}
		$Str_Zone = $zone;
		var $str_act = $object.TagName=='A' ? $object.getAttribute('href') : $object.getAttribute('action');
		if ( ($str_act=strval($str_act))=="" ){return;}
		$Str_Method = strval($object.getAttribute('method')).toLowerCase();
		$Obj_Form	= $object.TagName == "FORM" && $Str_Method=="post" ? $Obj_Form=$object : null;
		$Bln_Phase	= false;
		$Ary_CmdArg = [];
		$Str_ReMode	= "html";
		$Bln_Alauto =  true;
		$Obj_CmdFun = UpdateReturn;
		SendAjax($str_act);
		return $Ary_Result;
	}
	
	//辅助函数
	this.focus = function (){
		var $element=getObject(getCmdArg()); if($element){try{$element.focus()}catch($error){return;}}
	}
	this.alert	= function (){ alert(strval(getCmdArg())); }
	this.open	= function (){
		var $url = strval(getCmdArg()); $url=="" || $url==":" ? window.open("about:blank") : window.open($url);
	}
	this.close	= function (){window.close();}
	this.reload = function (){
		var $win = getCmdArg();
		!$win || typeof($win)!="object" || !$win.location ? window.location.reload() : $win.location.reload();
	}
	this.redirect= function (){
		var $url = getCmdArg(); 
		var $win = getCmdArg(1);
		if( $url=="" || $url==":"){$url="about:blank"};
		!$win || typeof($win)!="object" || !$win.location? window.location.href = $url : $win.location.href = $url;
	}
	this.submit		= function (){
		var $form = isForm(getCmdArg());
		if ($form && ( !$form.onsubmit || ($form.onsubmit && $form.onsubmit())) ){$form.submit();}
	}
	this.onsubmit	= function (){var $form = isForm(getCmdArg());if($form){$form.onsubmit();}}
	this.reset		= function (){var $form = isForm(getCmdArg());if($form){$form.reset();}}
	this.remove		= function (){
		var $node = getObject(getCmdArg()); 
		if (!$node || !$node.nodeName || $node.nodeName =="BODY" || $node.nodeName=="HTML"){return false;}
		var $hand = intval(getCmdArg(1));
		if ($hand<0){$node.parentNode.removeChild($node);} else if(!$hand){ $node.style.display = "none"; }
	}
	
	__construct();
	
}