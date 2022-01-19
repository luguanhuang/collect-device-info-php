// Javascript:cls_controls-----------------------

//parent!=window && parent.$_C && parent.$_C.classname()=="ODFCtrl" ? parent.$_C : 

$_C = new function (){

	//__________________  构造/析构函数  ________________

	function __construct(){
		
		if (document.execCommand){try{document.execCommand("BackgroundImageCache",false,true);}catch($error){}}	//强制缓存背景图
		
		var $i="0000"; while( typeof(window[$Str_ClassID+"-"+$i])!="undefined" ){$i=parseInt(Math.random()*8999+1000);}
		$Str_ClassID = $Str_ClassID +"-"+ $i; $Str_Object = "window['"+ $Str_ClassID +"']";	window[$Str_ClassID] = $this;
	
		$Obj_MarkDiv = document.createElement("Div");
		$Obj_MarkDiv.id = $Str_Prefix+"MarkLayer";
		$Obj_MarkDiv.style.cssText = "top: 0; left: 0; position: absolute; z-Index: 1008; display: none; background: #000; opacity: .5; filter: alpha(opacity=50);"

		$Obj_Vessel = document.createElement("Div");
		$Obj_Vessel.id = $Str_Prefix+"Vessel";
		$Obj_Vessel.style.cssText = "top: 0; left: 0; position: absolute; z-Index: 1008; display: none";

		$Obj_Frame = document.createElement("iframe");	$Obj_Frame.src = "javascript:false";
		$Obj_Frame.scrolling	= "no";					$Obj_Frame.frameBorder	= 0;
		$Obj_Frame.style.cssText= "width: 100%; height: 100%; opacity: 0; filter: alpha(opacity=0);"

		//控件HTML代码
		$Ary_AltHTML = new Array();
		$Ary_AltHTML[0] = '<div style="width: 400px;">'
		// $Ary_AltHTML[1] = '	<div style="background: #77c9f0; margin: 0 1px; height: 1px; overflow: hidden;"></div>';
		// $Ary_AltHTML[2] = '	<div style="border: 1px solid #77c9f0; border-right: 2px solid #77c9f0; border-top: none; background: #77c9f0;">';
		// $Ary_AltHTML[3] = '		<div style="border: 1px solid #77c9f0; border-bottom: 1px solid #77c9f0;">';
		$Ary_AltHTML[4] = '			<div id="'+$Str_Prefix+'HANDLE" style="padding: 6px; font-size: 16px; background: #00b0a8; -webkit-border-top-left-radius: 4px; -moz-border-top-left-radius: 4px; -o-border-top-left-radius: 4px; border-top-left-radius: 4px; -webkit-border-top-right-radius: 4px; -moz-border-top-right-radius: 4px; -o-border-top-right-radius: 4px; border-top-right-radius: 4px;">';
		$Ary_AltHTML[5] = '				<div style="float: right; margin: 1px; margin-left: 12px; -margin-left: 9px; padding: 1px; cursor: default;" onclick="{tag:close}">';
		$Ary_AltHTML[6] = '					<div style="width: 13px; text-align: center; line-height: 9px; padding-top: 4px; font-size: 16px; color: #fff; cursor: pointer;">&times;</div>';
		$Ary_AltHTML[7] = '				</div>';
		$Ary_AltHTML[8] = '				<div style="font-size: 14px; height: 20px; line-height: 20px; overflow: hidden; white-space: nowrap; color: #fff; text-align: left;">{tag:title}</div>';
		$Ary_AltHTML[9] = '			</div>';
		$Ary_AltHTML[10] = '		</div>';
		// $Ary_AltHTML[11] = '		<div style="background: #77c9f0; margin: 0 1px; height: 1px; overflow: hidden;"></div>';
		$Ary_AltHTML[12] = '		<div style=" width: 400px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -o-box-sizing: border-box; box-sizing: border-box; padding: 10px 40px 20px 40px; background: #fff; -webkit-border-bottom-right-radius: 4px; -moz-border-bottom-right-radius: 4px; -o-border-bottom-right-radius: 4px; border-bottom-right-radius: 4px; -webkit-border-bottom-left-radius: 4px; -moz-border-bottom-left-radius: 4px; -o-border-bottom-left-radius: 4px; border-bottom-left-radius: 4px;">';
		// $Ary_AltHTML[13] = '			<div style="float: left; font-size: 52px; color: #FF582F; line-height: 60px; font-weight: bold; margin-right: 35px; -margin-right: 32px;">{tag:icon}</div>';
		$Ary_AltHTML[14] = '			<table border="0" cellspacing="0" cellpadding="0"  align="center" style="padding: 40px 0;" remark="376-1-3-2-26-32-40-35"><tr><td style="font-size:'+ $Int_Size +'px; line-height: 1.5; color: #008880; word-wrap: break-word; overflow: hidden;">{tag:message}</td></tr></table>';
		$Ary_AltHTML[15] = '			<div style="clear: both; text-align: center; margin: 5px 0 10px 0;">';
		$Ary_AltHTML[16] = '				<input name="" type="button" value="confirm" accesskey="Y" style="width: 76px; height: 28px; color: #fff; background: #00b0a8; border: none; border: none; -webkit-border-radius: 2px; -moz-border-radius: 2px; -o-border-radius: 2px; border-radius: 2px; cursor: pointer;" onclick="{tag:ontrue}"/>';
		$Ary_AltHTML[17] = '			</div>';
		// $Ary_AltHTML[18] = '		</div>';
		// $Ary_AltHTML[19] = '		<div style="background: #77c9f0; margin: 0 1px; height: 1px; overflow: hidden;"></div>';
		// $Ary_AltHTML[20] = '	</div>';
		$Ary_AltHTML[21] = '</div>';
				
		$Ary_CfmHTML = $Ary_AltHTML.concat();
		$Ary_CfmHTML[16] = '				<input name="" type="button" value="Y" accesskey="Y" style="width: 76px; height: 28px; margin-right: 10px; color: #fff; background: #00b0a8; border: none; -webkit-border-radius: 2px; -moz-border-radius: 2px; -o-border-radius: 2px; border-radius: 2px; cursor: pointer;" onclick="{tag:onyes}"/>&nbsp;<input name="" type="button" value="N" accesskey="Y" style="width: 76px; height: 28px; margin-right: 10px; color: #fff; background: #999; border: none; -webkit-border-radius: 2px; -moz-border-radius: 2px; -o-border-radius: 2px; border-radius: 2px; cursor: pointer;" onclick="{tag:onno}"/>';
		
		$Ary_DlgHTML = $Ary_AltHTML.concat();
		$Ary_DlgHTML[16] = '				<input name="" type="button" value="Y" accesskey="Y" style="width: 76px; height: 28px; margin-right: 10px; color: #fff; background: #00b0a8; border: none; -webkit-border-radius: 2px; -moz-border-radius: 2px; -o-border-radius: 2px; border-radius: 2px; cursor: pointer;" onclick="{tag:onyes}"/>&nbsp;<input name="" type="button" value="N" accesskey="Y" style="width: 76px; height: 28px; margin-right: 10px; color: #fff; background: #999; border: none; -webkit-border-radius: 2px; -moz-border-radius: 2px; -o-border-radius: 2px; border-radius: 2px; cursor: pointer;" onclick="{tag:onno}"/>&nbsp;<input name="" type="button" value="取消(C)" accesskey="Y" style="height: 24px; width:70px;" onclick="{tag:oncannel}"/>';
		//加载皮肤
		if (loadskin()){loadstyle();loadscript();}
		$Bln_Enabled = true;
	}
	
	function __destruct(){}
	
	//拖动函数
	function DragLayer($title,$body) {
		var $titlebar	= getObject($title);if (!$titlebar || !$titlebar.nodeName || $titlebar.nodeName=="BODY"){return false;}
		var $bodybar	= getObject($body);	if (!$bodybar || !$bodybar.nodeName || $bodybar.nodeName=="BODY"){return false;}
		var $deltaX,	$deltaY;
		var $oldmove,	$oldup;
		//2级
		if (document.addEventListener){$titlebar.addEventListener("mousedown",clickHandler,true);}//DOM事件模型
		else if(document.attachEvent){$titlebar.attachEvent("onmousedown",clickHandler);}//IE5+事件模型
		else{$titlebar.onmousedown = clickHandler;}//IE5- 事件模型
		$titlebar.style.cursor = "move";
		if ($bodybar.style.position.toLowerCase()!="absolute"){$bodybar.style.position = "absolute";}
		
		function clickHandler($event){
			if (!$event){$event=window.event;}
			var $lScroll = parseInt(document.documentElement.scrollLeft)	//body滚动条左滚长度
			var $tScroll = parseInt(document.documentElement.scrollTop)		//body滚动条上滚长度
			if (!$lScroll){$lScroll = parseInt(document.body.scrollLeft);}
			if (!$tScroll){$tScroll = parseInt(document.body.scrollTop);}
			$deltaX = $event.clientX+ $lScroll;
			$deltaY = $event.clientY+ $tScroll;
			var $obj_offset,$int_offset;
			if ($bodybar.style.left===""){
				$int_offset = 0;  $obj_offset = $bodybar;
				while($obj_offset && $obj_offset.nodeName!="BODY"){
					$int_offset += parseInt($obj_offset.offsetLeft); $obj_offset = $obj_offset.parentNode;
				}
				$bodybar.style.left = $int_offset+"px";
			}
			$deltaX -= parseInt($bodybar.style.left);
			
			if ($bodybar.style.top===""){
				$int_offset = 0; $obj_offset = $bodybar;
				while($obj_offset && $obj_offset.nodeName!="BODY"){
					$int_offset += parseInt($obj_offset.offsetTop); $obj_offset = $obj_offset.parentNode;
				}
				$bodybar.style.top = $int_offset+"px";
			}
			$deltaY -= parseInt($bodybar.style.top);
			
			if (document.addEventListener) {//DOM2事件模型
				document.addEventListener("mousemove", moveHandler, true);
				document.addEventListener("mouseup", upHandler, true);
			}
			else if (document.attachEvent) {//IE5+事件模型
				document.attachEvent("onmousemove", moveHandler);
				document.attachEvent("onmouseup", upHandler);
			}
			else {//IE4事件模型
				$oldmove	= document.onmousemove;	document.onmousemove = moveHandler;
				$oldup		= document.onmouseup;	document.onmouseup = upHandler;
			}
			//禁止冒泡
			if ($event.stopPropagation){$event.stopPropagation();}/*DOM2*/else{$event.cancelBubble=true;}//IE
			if ($event.preventDefault){$event.preventDefault();}/*DOM2*/else{$event.returnValue = false;}//IE
			if ($Bln_Alpha){$bodybar.style.filter="alpha(opacity=50)"; $bodybar.style.opacity=0.5;}
		}
	
		function moveHandler($event) {
			if (!$event){$event = window.event;}
			var $lScroll = parseInt(document.documentElement.scrollLeft)	//body滚动条左滚长度
			var $tScroll = parseInt(document.documentElement.scrollTop)		//body滚动条上滚长度
			if (!$lScroll){$lScroll = parseInt(document.body.scrollLeft);}
			if (!$tScroll){$tScroll = parseInt(document.body.scrollTop);}
			$bodybar.style.left = ($event.clientX+ $lScroll - $deltaX) + "px";
			$bodybar.style.top = ($event.clientY+ $tScroll - $deltaY) + "px";
			if (window.getSelection){window.getSelection().removeAllRanges();}
			else if (document.selection){document.selection.empty();}
			if ($event.stopPropagation){$event.stopPropagation();}
			else{$event.cancelBubble = true;}
		}
	
		function upHandler($event) {
			if (!$event){$event = window.event;}
			if (document.removeEventListener) {//DOM2
				document.removeEventListener('mouseup', upHandler, true);
				document.removeEventListener('mousemove', moveHandler, true);
			}
			else if (document.detachEvent) { //IE5+
				document.detachEvent("onmousemove", moveHandler);
				document.detachEvent("onmouseup", upHandler);
			}
			else {//IE4
				document.onmouseup = $oldmove;
				document.onmousemove = $oldup;
			}
			if ($Bln_Alpha){$bodybar.style.filter = "alpha(opacity=100)";$bodybar.style.opacity=1;}
			if ($event.stopPropagation){$event.stopPropagation();}
			else {$event.cancelBubble = true;}
		}
	}
	
	//__________________  私有变量  ________________

	var $this			= this,		$error			= null,		$Int_Error		= 0,		$Str_Error		= "";
	var $Bln_Enabled	= false,	$Bln_Loading	= null,		$Bln_Alpha		= true;
	var $Obj_MarkDiv	= null,		$Obj_Vessel		= null,		$Obj_Frame		= null;
	var $Obj_Custom		= null,		$Aty_Custom		= [],		$Fun_Custom		= null;
	var $Obj_Intent		= null,		$Obj_Backing	= null,		$Str_CloneTxt	= null;
	var $Ary_AltHTML	= null,		$Ary_CfmHTML	= null,		$Ary_DlgHTML	= null;
	var $Bln_Opening	= false,	$Str_Opening	= "";
	var $Obj_Alert		= null,		$Fun_Alert		= null;															//Alert控件
	var $Obj_Confirm	= null,		$Fun_Confirm1	= null,		$Fun_Confirm2	= null;								//Confirm控件
	var $Obj_Prompt		= null,		$Fun_Prompt1	= null,		$Fun_Prompt2	= null;								//Prompt控件
	var $Obj_Msgdlog	= null,		$Fun_Msgdlog1	= null,		$Fun_Msgdlog2	= null,		$Fun_Msgdlog3	= null;	//Msgdlog控件
	
	var $Str_Browser	= getBrowserName();		$Str_VarFix	= ":VARIABLE";
	var $Str_Prefix		= "ODFControls_",		$Str_Title	= "Prompt info";
	var $Str_ClassID	= "435A8043-B50A-F4D2",	$Str_Object	= "window['"+ $Str_ClassID +"']";
	var $Str_Align		= "left",				$Int_Size	= 13;
	var $Int_WGap		= 0,					$Int_HGap	= 0;
	var $Str_PURL		= "",	/*当前目录的URL*/	$Str_Path	= "";	/*所在目录的相对路径*/
	var $Str_KDir		= "",	/*皮肤所在目录*/	$Str_Imgs	= "";	/*皮肤图片所在目录*/
	var $Str_Skin		= null,	/*皮肤名称*/		$Str_Style	= null;	/*皮肤样式名称*/
	var $Str_Script 	= "";	/*皮肤代码*/		$Ary_Args	= new Array();//回调函数的参数
	
	//__________________  只读属性  ________________
	
	this.version	= function (){return '3.1';}				//版本
	this.build		= function (){return '11.11.29';}			//版本
	this.create		= function (){return '10.01.20';}			//创建
	this.classname	= function (){return "ODFCtrl";}			//名称
	this.developer	= function (){return "OldFour";}			//开发者
	this.copyright	= function (){return "www.oldfour.com";}	//公司
	
	this.Enabled	= function (){return $Bln_Enabled;}
	this.Object		= function (){return window[$Str_ClassID];}
	
	this.Path		= function (){return $Str_Path;}
	this.Images 	= function (){return $Str_Imgs;}
	
	this.Errno		= function (){return $Int_Error;}
	this.Error		= function (){return $Str_Error;}

	//__________________  私有方法  ________________
	
		//集百家函数
	function strval($val)	{return $val==null ? "" : $val.toString();}
	function intval($val)	{return !$val || isNaN($val) ? 0 : Math.floor($val);}
	function isarray($obj)	{return $obj!=null && (Object.prototype.toString.call($obj) === '[object Array]');}
	function isForm($obj)	{var $form = getObject($obj); return $form && $form.nodeName && $form.nodeName=="FORM" ? $form : false;}
	
	function isFunction($fun){
		var $str_func	= null;
		var $ary_str	= null;
		if ( typeof($fun)=="function" || (typeof($fun)=="object" && $fun!==null) ){return $fun;}
		if ( typeof($fun)=="string" ){
			$str_func = $fun.toString().replace(/^([^\(\ ]*)[\s\S]*$/,"$1");
			if ($str_func ==""){return null;}
			try{
				var $obj_func  = eval($str_func),$str_type = typeof($obj_func);
				if ( $str_type=="function" || ($str_type=="object" && $str_func!="null") ){return $obj_func;}
			}
			catch($error){return false;}
		}
		return false;
	}
	
	function isPermit(){
		if (!$Bln_Enabled || $Bln_Opening || $Str_Opening ){return;}
		if ($Bln_Loading){return true;}
		//添加marklayer
		$Obj_MarkDiv.appendChild($Obj_Frame);
		document.body.appendChild($Obj_MarkDiv);$Obj_MarkDiv = document.getElementById($Obj_MarkDiv.id);
		document.body.appendChild($Obj_Vessel);	$Obj_Vessel = document.getElementById($Obj_Vessel.id);
		//DOM事件模型
		if (window.addEventListener){
			window.addEventListener("resize",$this.resize,true);
			window.addEventListener("scroll",$this.scroll,true);
		}
		//IE5+事件模型
		else if(window.attachEvent){
			window.attachEvent("onresize",$this.resize);
			window.attachEvent("onscroll",$this.scroll);
		}
		//IE5- 事件模型
		else{
			window.onresize = $this.resize;
			window.onscroll = $this.scroll;
		}
		$Bln_Loading = true;	
		return true;
	}
	
	function getBrowserName(){
		var $appName=navigator.appName.toLowerCase();
		if ($appName=="microsoft internet explorer"){return "ie";}
		else if ($appName=="netscape"){return "ne";}
		else if ($appName=="opera"){return "opera";}
		else{return "unknow";}
	}
	function getObject($id){
		if ($id==null){return false;}
		if (typeof($id)!="string"){return $id.nodeName ? $id : null;}
		var $obj_element = document.getElementById($id);
		if (!$obj_element){
			$obj_element = document.getElementsByName($id);
			$obj_element = $obj_element.length ? $obj_element[0] : null;
		}
		return $obj_element;
	}
	function getCmdArg($index){
		if (!isarray($Ary_Args)){ return null; }
		$index = Math.min(intval($index),0);
		return typeof($Ary_Args[$index])=='undefined' ? null : $Ary_Args[$index];
	}
	function setGapValue($val,$type){
		$val=intval($val);
		if ($val<=0 || $Str_Browser=="opera"){return 0;} else if($Str_Browser=="ie"){return $val;}
		return strval($type).substring(0,1).toLowerCase() =="w" ? $val+4 : $val+8;
	}
	function MoveToCenter(){
		if (!$Bln_Enabled || !$Bln_Opening || !$Str_Opening ){return;}
		var $obj = document.getElementById($Str_Prefix+$Str_Opening.toString());
		if (!$obj){return;}
		
		$Obj_MarkDiv.style.width	= "1px"; $Obj_MarkDiv.style.height	= "1px";
		$Obj_Vessel.style.width		= "1px"; $Obj_Vessel.style.height	= "1px";

		var $wScroll = parseInt(document.body.scrollWidth)+$Int_WGap;		//body宽度(必须加上差值)
		var $hScroll = parseInt(document.body.scrollHeight)+$Int_HGap;		//body高度(必须加上差值)
		
		var $wClient = parseInt(document.documentElement.clientWidth);		//screen可用宽度
		var $hClient = parseInt(document.documentElement.clientHeight);		//screen可用高度
		var $lScroll = parseInt(document.documentElement.scrollLeft);		//body滚动条左滚长度
		var $tScroll = parseInt(document.documentElement.scrollTop);		//body滚动条上滚长度
		if (!$wClient){$wClient = parseInt(document.body.clientWidth);}
		if (!$hClient){$hClient = parseInt(document.body.clientHeight);}
		if (!$lScroll){$lScroll = parseInt(document.body.scrollLeft);}
		if (!$tScroll){$tScroll = parseInt(document.body.scrollTop);}

		var $wDiv = Math.max($wClient,$wScroll);
		var $hDiv = Math.max($hClient,$hScroll);
		
		$Obj_MarkDiv.style.width	= $wDiv+"px";
		$Obj_MarkDiv.style.height	= $hDiv+"px";
		$Obj_MarkDiv.style.display	= "block";
		
		$Obj_Vessel.style.left		= $lScroll+"px";
		$Obj_Vessel.style.top		= $tScroll+"px";
		$Obj_Vessel.style.width		= $wClient+"px";
		$Obj_Vessel.style.height	= $hClient+"px";
		$Obj_Vessel.style.display	= "block";
		var	$int_mtop = $hClient-parseInt($obj.offsetHeight) > 100 ? 50 : 0;
		$obj.style.left= Math.max(($wClient-parseInt($obj.offsetWidth))/2,0)+"px";
		$obj.style.top = Math.max(($hClient-parseInt($obj.offsetHeight))/2-$int_mtop,0)+"px";
		$obj.style.display = "block";
	}
	
	function formatMessgae($str){
		$str = strval($str); if ($str==""){return "";}
		//取第一个\r\n
		var	$str_title = null, $str_mess = $str, $int_warp = $str.indexOf("\r\n");
		if ($int_warp!=-1){$str_title = $str.substring(0,$int_warp); $str_mess = $str.substring($int_warp+2);}
		//信息部分的CSS
		$str_mess = $str_mess.replace(/\r\n/g,"\n");
		$str_mess = $str_mess.replace(/[\r\n]/g,"<br>");
		if ($Str_Align=="indent"){$str_mess="<div style=\"text-align:left;text-indent:26px;\">"+ $str_mess +"</div>";}
		else if ($Str_Align=="center"){$str_mess="<div style=\"text-align:center;\">"+ $str_mess +"</div>";}
		else if ($Str_Align=="right"){$str_mess="<div style=\"text-align:right;\">"+ $str_mess +"</div>";}
		else {$str_mess = "<div style=\"text-align:left;\">"+ $str_mess +"</div>";}
		//标题部分
		if ($str_title!==null){$str_mess = "<div style=\"margin-bottom:4px;\">"+ $str_title +"</div>"+$str_mess;}
		//返回结果
		return $str_mess;
	}
	
	/*皮肤函数*/
	function loadskin(){
		var $str_pageurl= window.location.href.replace(/[\#\?][\s\S]*/,"").replace(/[^\/]+$/,"");						//即时固定
		var $obj_script	= document.getElementsByTagName("script")[document.getElementsByTagName("script").length-1];	//即时可变
		var $str_sscr	= $obj_script.getAttribute('src');
		if ($str_sscr==null || $str_sscr==""){$str_sscr=$str_pageurl;}
		//如果有参数，优先从参数中获取 $Str_Skin 和 $Str_Style
		if ($str_sscr.indexOf("?")!==-1){
			var $ary_search = $str_sscr.replace(/^[^\?]*\?/,"").split("&");
			var $i,$s;
			for ($i=0;$i<$ary_search.length;$i++){
				$s = $ary_search[$i].toLowerCase();
				if ($s=="skin" || $s.substring(0,5)=="skin="){$Str_Skin = $ary_search[$i].replace(/^skin\=?/,"");}
				else if($s=="sstyle" || $s.substring(0,7)=="sstyle="){$Str_Style = $ary_search[$i].replace(/^sstyle\=?/,"");}
			}
		}
		$Str_PURL	= $str_pageurl;														//即时固定
		$Str_Path	= $str_sscr.replace(/[\#\?][\s\S]*/,"").replace(/[^\/]+$/,"");		//即时可变
		if ($Str_Skin==null){$Str_Skin = $obj_script.getAttribute('skin');}
		if ($Str_Style==null){$Str_Style = $obj_script.getAttribute('sstyle');}
		if ($Str_Skin!=null){
			var $str_skin = $Str_Skin.toString().toLowerCase();
			if ($str_skin=="" || $str_skin=="0" || $str_skin=="false"){$Str_Skin=false;}
			else{
				if ($str_skin=="." || $str_skin=="1" || $str_skin=="true"){$Str_Skin="";}
				var $dir = /^function\s+__construct\s*\(/i.test(loadskin.caller.toString()) ? "cUI/" : "";
				$Str_KDir = $Str_Skin=="" ? $Str_Path+$dir : $Str_Path+$dir+$Str_Skin+"/";
				$Str_Imgs = $Str_KDir+"images/";
			}
		}
		if ($Str_Style!=null){
			var $str_style = $Str_Style.toString().toLowerCase();
			if ($str_style=="" || $str_style=="0" || $str_style=="false"){$Str_Style=false;}
			else if($str_style=="." || $str_style=="1" || $str_style=="true"){$Str_Style="style.css";}
			else if($str_style.substring($str_style.length-4)!=".css"){$Str_Style=$Str_Style+".css";}
		}
		return $Str_Skin!==null && $Str_Skin!==false;
	}
	
	function loadstyle(){
		if ($Str_Style===null || $Str_Style===false){return;}
		var $obj_thtml,$obj_thead,$obj_tlink
		var $obj_thead = document.getElementsByTagName('head');
		if (!$obj_thead.length){
			$obj_thtml = document.getElementsByTagName('html'); if (!$obj_thtml.length){return false;}
			$obj_thead = [document.createElement('HEAD')];
			$obj_thtml[0].insertBefore($obj_thead[0],$obj_thtml[0].childNodes[0]);
		}
		$obj_tlink = document.createElement("link");	$obj_tlink.type = "text/css";
		$obj_tlink.href = $Str_KDir+$Str_Style; 		$obj_tlink.rel  = "stylesheet"
		$obj_thead[0].appendChild($obj_tlink);
	}
	
	function loadscript(){
		if ($Str_Skin===null || $Str_Skin===false ){return;}
		var $obj_ajax, $str_ajax;
		try{$obj_ajax = new ActiveXObject("Msxml2.XMLHTTP");}		//如果支持 Msxml2.XMLHTTP
		catch ($error) {
			try {$obj_ajax = new ActiveXObject("Microsoft.XMLHTTP");}//如果支持 Microsoft.XMLHTTP
			catch ($error){
				try {$obj_ajax = new XMLHttpRequest();}//如果支持 XMLHttpRequest
				catch($error){$Int_Error = 10;$Str_Error = "自定义皮肤：创建 XMLHTTP 对象失败";return false;}
			}
		}
		$str_ajax = $Str_KDir+"skin.js";
		if (/^(http\:\/\/|[a-z]\:[\\\/]|file\:\/{2,}[a-z][\|\:]\/)/i.test($str_ajax)==false){$str_ajax=$Str_PURL+$str_ajax;}
		//如果是请求本地文件，那么请求结束后([readyState]等于4),[status]是等于0(不是200)
		$obj_ajax.open("GET",$str_ajax,true);
		$obj_ajax.setRequestHeader("Content-Type","text/html;");
		$obj_ajax.onreadystatechange = function(){
			if($obj_ajax.readyState==4) {
				if(!$obj_ajax.status||$obj_ajax.status==200){
					$Str_Script=$obj_ajax.responseText;
					try{ setskin((new Function("return ("+$Str_Script+")()")).call($this));}
					catch($error){
						$Int_Error=16;
						$Str_Error="自定义皮肤：UI文件有错误 ("+ $error.description.replace(/\s+$/g,"")+")";
					}
					return true;
				}
				if($obj_ajax.status==500){		$Int_Error=12;	$Str_Error="自定义皮肤：服务器发生错误(500)";}
				else if ($obj_ajax.status==403){$Int_Error=13;	$Str_Error="自定义皮肤：服务器拒绝访问(403)";}
				else if ($obj_ajax.status==404){$Int_Error=14;	$Str_Error="自定义皮肤：UI文件不存在(404)";}
				else{ $Int_Error=15; $Str_Error="自定义皮肤：读取UI文件失败("+ $obj_ajax.status +")"; }
				return false;
			}
		}
		try{$obj_ajax.send(null);return true;}
		catch($error){$Int_Error=11;$Str_Error="自定义皮肤：发送 XMLHTTP 请求失败 ("+ ($error.description.replace(/\s+$/g,"")) +")";return false;}
	}
	
	function setskin(){
		var $ary_ui = [];
		if (arguments.length>1){
			$ary_ui[0] = [];
			$ary_ui[0]['type'] = strval(arguments[0]);
			$ary_ui[0]['html'] = isarray(arguments[1]) ? arguments[1] : [arguments[1]];
		}
		else if (!isarray(arguments[0])){return false;}
		else{
			var $x=0,$y=0;
			for (var $x = 0;$x<arguments[0].length;$x++){
				if (!isarray(arguments[0][$x])){continue;}
				$ary_ui[$y]= arguments[0][$x];
				if (typeof $ary_ui[$y]['type']== "undefined"){$ary_ui[$y]['type'] = "alert";}
				if (typeof $ary_ui[$y]['html']== "undefined"){$ary_ui[$y]['html'] = [''];}
				else if(!isarray($ary_ui[$y]['html'])){$ary_ui[$y]['html'] = [$ary_ui[$y]['html']];}
				$y++;
			}
		}
		for (var $i = 0; $i<$ary_ui.length;$i++){
			switch($ary_ui[$i]['type']){
				case "msgbox":;
				case "alert" :	$Ary_AltHTML = $ary_ui[$i]['html']; break;
				case "confirm": $Ary_CfmHTML = $ary_ui[$i]['html']; break;
				case "dilog":	$Ary_DlgHTML = $ary_ui[$i]['html']; break;
				default: return false;
			}
		}
		return true;
	}
	
	//__________________  公有方法  ________________
	
	this.func_num_args	= function (){ return isarray($Ary_Args) ? $Ary_Args.length : -1; }
	this.func_get_args	= function (){ return isarray($Ary_Args) ? $Ary_Args : null;}
	this.func_get_arg	= function ($index){
		if (!isarray($Ary_Args)){return null;}
		$index= intval($index);
		if ($index<0){return null;} else if ($index>=$Ary_Args.length){return null;}
		return $Ary_Args[$index];
	}
	
	//设置拖动时是否半透明
	this.setalpha = function ($alpha){
		$Bln_Alpha = !!$alpha;
	}

	//设置回调函数
	this.command = function ($name,$func){
		var $obj_func = isFunction($func); if (!$obj_func){return false;}
		$name = strval($name).toLowerCase();
		switch($name){
			case "msgboxtrue"		:;
			case "alerttrue"		: $Fun_Alert	= $obj_func; return true;
			case "msgdlogyes" 		: $Fun_Msgdlog1	= $obj_func; return true;
			case "msgdlogno" 		: $Fun_Msgdlog2	= $obj_func; return true;
			case "msgdlogcancel"	: $Fun_Msgdlog3	= $obj_func; return true;
			case "promptok" 		: $Fun_Prompt1	= $obj_func; return true;
			case "promptcancel" 	: $Fun_Prompt2	= $obj_func; return true;
			case "confirmyes" 		: $Fun_Confirm1	= $obj_func; return true;
			case "confirmno" 		: $Fun_Confirm2	= $obj_func; return true;
		}
		return false;
	}
	//设置回调函数的参数
	this.parameter = function ($index,$value){
		if (arguments.length==1){$value=arguments[0];$index=-1;}//只有1个参数
		if (!isarray($Ary_Args)){$Ary_Args = new Array();}
		if (isarray($index)){ $Ary_Args = isarray($value) ? $value : [$value];}				//重新再来(批量添加)
		if ($index==null){$index=-1;}else{$index = intval($index);}							//不指定下标添加
		if ($index<-1){return false;}
		if ($index==-1){$Ary_Args[$Ary_Args.length]=$value;}else{$Ary_Args[$index]=$value;}//添加到最后
		return true;
	}
	//设置对象属性
	this.property = function ($name,$value){
		$name = strval($name).toLowerCase();
		switch ($name){
			case "align": if (/^(left)|(right)|(center)|(indent)$/i.test($value)){$Str_Align = $value; return true;} break;
			case "size": if (/^[1-9][0-9]?((px)|(pt))?$/i.test($value)){$Int_Size = $value;return true;} break;
			case "title":if (!/([\<\>\'\"\#\&\|])/gi.test($value)){$Str_Title=$value;return true;} break;
			case "wgap"	: $Int_WGap = setGapValue($value,'w');return true;
			case "hgap"	: $Int_HGap = setGapValue($value,'h');return true;
		}
		return false;
	}
	/*函数与参数的优先设定
	函数	$func==null(包括不指定) 时表示继续使用之前的函数
		$func=="" || $func==false 时表示清空函数，不使用函数
	参数	arguments小于等于2个时 表示继续使用之前的参数
		arguments大于2个且第三个等于[]时表示清空参数
		arguments大于2个且第三个不等于[]使用新的参数
	*/
	this.MsgBox = function (){
		var $ary_arg = [];for(var $i=0;$i<arguments.length;$i++){$ary_arg[$i]=arguments[$i];}
		return this.Alert.apply(null,$ary_arg);
	}
	this.reMsgBox = function (){this.reAlert();}
	this.Alert = function ($mess,$func,$otherargs){
		if (!isPermit()){return;}
		var $message = arguments[0], $function = arguments[1], $str_opentype = "ALERT";
		if (arguments.length>1){$Fun_Alert = isFunction($func);}
		if ($Fun_Alert && arguments.length>2){
			$Ary_Args = new Array();
			if ( !isarray(arguments[2]) || arguments[2].length>0 ){
				for(var $i=2;$i<arguments.length;$i++){$Ary_Args[$i-2] = arguments[$i];}
			}
		}
		var $str_html = $Ary_AltHTML.join("\r\n");
			$str_html = $str_html.replace('{tag:handle}',$Str_Prefix+"HANDLE");		//皮肤接口
			$str_html = $str_html.replace('{tag:close}', $Str_Object+".reAlert()");	//皮肤接口
			$str_html = $str_html.replace('{tag:ontrue}',$Str_Object+".reAlert()");	//皮肤接口
			$str_html = $str_html.replace('{tag:object}',$Str_Object);
			$str_html = $str_html.replace('{tag:title}', $Str_Title);
			$str_html = $str_html.replace('{tag:icon}', '&Oslash;');
			$str_html = $str_html.replace('{tag:message}',formatMessgae($message));

		$Obj_Alert = document.createElement("DIV");
		$Obj_Alert.id = $Str_Prefix+$str_opentype;		$Obj_Alert.innerHTML = $str_html;
		$Obj_Vessel.appendChild($Obj_Alert);			$Obj_Alert = document.getElementById($Str_Prefix+$str_opentype);
		$Str_Opening = $str_opentype;					$Bln_Opening = true;
		DragLayer($Str_Prefix+"HANDLE",$Str_Prefix+$str_opentype);
		MoveToCenter();
	}
	this.reAlert = function (){ this.exit(); if ($Fun_Alert){$Fun_Alert.apply(null,$Ary_Args);} }
	
	this.Confirm = function ($mess,$funcok,$funcno,$otherargs){
		if (!isPermit()){return;}
		var $message		= arguments[0];
		var $funcok			= arguments[1];
		var $funcno			= arguments[2];
		var $str_opentype	= "CONFIRM";
		var $int_arglen		= arguments.length;
		if ($int_arglen>1){$Fun_Confirm1= isFunction($funcok);}//如果设置了函数(不管是否为空)则替换$Fun_Confirm1
		if ($int_arglen>2){$Fun_Confirm2= isFunction($funcno);}//如果设置了函数(不管是否为空)则替换$Fun_Confirm2
		if (($Fun_Confirm1 || $Fun_Confirm2) && arguments.length>3){
			$Ary_Args = new Array();
			if ( !isarray(arguments[3]) || arguments[3].length>0 ){
				for(var $i=3;$i<arguments.length;$i++){$Ary_Args[$i-3] = arguments[$i];}
			}
		}
		var $str_html = $Ary_CfmHTML.join("\r\n");
			$str_html = $str_html.replace('{tag:handle}',$Str_Prefix+"HANDLE");			//皮肤接口
			$str_html = $str_html.replace('{tag:close}', $Str_Object+".reConfirm(1)");	//皮肤接口
			$str_html = $str_html.replace('{tag:onyes}',$Str_Object+".reConfirm('yes')");//皮肤接口
			$str_html = $str_html.replace('{tag:onno}',	$Str_Object+".reConfirm('n')");	//皮肤接口
			$str_html = $str_html.replace('{tag:object}',$Str_Object);
			$str_html = $str_html.replace('{tag:title}',$Str_Title);
			$str_html = $str_html.replace('{tag:icon}','?');
			$str_html = $str_html.replace('{tag:message}',formatMessgae($message));

		$Obj_Confirm = document.createElement("DIV");
		$Obj_Confirm.id = $Str_Prefix+$str_opentype;		$Obj_Confirm.innerHTML	= $str_html;
		$Obj_Vessel.appendChild($Obj_Confirm);				$Obj_Confirm = document.getElementById($Str_Prefix+$str_opentype);
		$Str_Opening = $str_opentype;						$Bln_Opening = true;
		DragLayer($Str_Prefix+"HANDLE",$Str_Prefix+$str_opentype);	MoveToCenter();
	}
	this.reConfirm	= function ($type){
		this.exit();
		$type = strval($type).substring(0,1).toLowerCase();
		if ($type=="y")		{if ($Fun_Confirm1){$Fun_Confirm1.apply(null,$Ary_Args)}}
		else if($type=="n")	{if ($Fun_Confirm2){$Fun_Confirm2.apply(null,$Ary_Args)}}
	}
	
	this.Msgdlog = function ($mess,$funcyes,$funcno,$funccan,$otherargs){
		if (!isPermit()){return;}
		var $message		= arguments[0];
		var $funcyes		= arguments[1];
		var $funcno			= arguments[2];
		var $funccan		= arguments[3];
		var $str_opentype	= "MSGDLOG";
		var $int_arglen		= arguments.length;
		if ($int_arglen>1){$Fun_Msgdlog1 = isFunction($funcyes);}	//如果设置了函数(不管是否为空)则替换$Fun_Msgdlog1
		if ($int_arglen>2){$Fun_Msgdlog2 = isFunction($funcno);}	//如果设置了函数(不管是否为空)则替换$Fun_Msgdlog2
		if ($int_arglen>3){$Fun_Msgdlog3 = isFunction($funccan);}	//如果设置了函数(不管是否为空)则替换$Fun_Msgdlog3
		if (($Fun_Msgdlog1 || $Fun_Msgdlog2 || $Fun_Msgdlog3) && $int_arglen>4){
			$Ary_Args = new Array();
			if ( !isarray(arguments[4]) || arguments[4].length>0 ){
				for(var $i=4;$i<arguments.length;$i++){$Ary_Args[$i-4] = arguments[$i];}
			}
		}
		var $str_html = $Ary_DlgHTML.join("\r\n");
			$str_html = $str_html.replace('{tag:handle}',	$Str_Prefix+"HANDLE");			//皮肤接口
			$str_html = $str_html.replace('{tag:close}',	$Str_Object+".reMsgdlog('c')");	//皮肤接口
			$str_html = $str_html.replace('{tag:onyes}',	$Str_Object+".reMsgdlog('y')");	//皮肤接口
			$str_html = $str_html.replace('{tag:onno}',		$Str_Object+".reMsgdlog('n')");	//皮肤接口
			$str_html = $str_html.replace('{tag:oncannel}',	$Str_Object+".reMsgdlog('c')");	//皮肤接口
			$str_html = $str_html.replace('{tag:object}',	$Str_Object);
			$str_html = $str_html.replace('{tag:title}',	$Str_Title);
			$str_html = $str_html.replace('{tag:icon}','?');
			$str_html = $str_html.replace('{tag:message}',formatMessgae($message));

		$Obj_Msgdlog = document.createElement("DIV");
		$Obj_Msgdlog.id = $Str_Prefix+$str_opentype;		$Obj_Msgdlog.innerHTML	= $str_html;
		$Obj_Vessel.appendChild($Obj_Msgdlog);				$Obj_Msgdlog = document.getElementById($Str_Prefix+$str_opentype);
		$Str_Opening = $str_opentype;						$Bln_Opening = true;
		DragLayer($Str_Prefix+"HANDLE",$Str_Prefix+$str_opentype);	MoveToCenter();
	}
	this.reMsgdlog	= function ($type){
		this.exit();
		$type = strval($type).substring(0,1).toLowerCase();
		if ($type=="y")			{if ($Fun_Msgdlog1){$Fun_Msgdlog1.apply(null,$Ary_Args);}}
		else if ($type=="n")	{if ($Fun_Msgdlog2){$Fun_Msgdlog2.apply(null,$Ary_Args);}}
		else if ($type=="c")	{if ($Fun_Msgdlog3){$Fun_Msgdlog3.apply(null,$Ary_Args);}}
	}
	
	this.Prompt	= function (){
		if (!isPermit()){return;}
	}
	this.rePrompt	= function ($type){
		this.exit();
		$type = strval($type).substring(0,1).toLowerCase();
		if ($type=="o") 	{if ($Fun_Prompt1){$Fun_Prompt1.apply(null,$Ary_Args);}}
		else if($type=="c") {if ($Fun_Prompt2){$Fun_Prompt2.apply(null,$Ary_Args);}}
	}

	this.Custom = function ($hanleid,$content,$func,$args){
		if (!isPermit()){return;}
		$hanleid = strval($hanleid); $type = (typeof($content)).toLowerCase();
		if ($hanleid=="" || $content == null){return;}
		if ($type!="object" || !$content.nodeName){
			$content=strval($content); if ($content==""){return;}else{$type="string";}
		}
		else if ($content.nodeName=="BODY"){return;}
		var $int_arglen	= arguments.length;
		if ($int_arglen>2){$Fun_Custom = isFunction($func);}
		if ($int_arglen>3 && $Fun_Custom){
			$Ary_Args = new Array();
			if ( !isarray(arguments[3]) || arguments[3].length>0 ){
				for(var $i=3;$i<arguments.length;$i++){$Ary_Args[$i-3] = arguments[$i];}
			}
		}
		$Aty_Custom = null;	//清空前调函数
		var $str_opentype = "CUSTOM";
		$Obj_Custom = document.createElement("SPAN");
		$Obj_Custom.id = $Str_Prefix+$str_opentype;
		$Obj_Custom.style.position = "absolute";
		if ($type=="string"){$Obj_Custom.innerHTML = $content;}
		else{
			var $str_mode = strval($content.getAttribute('appendmode')).toLowerCase();
			if ($str_mode=='move' || $str_mode=='show'){
				//备份/克隆
				$Str_CloneTxt		= null;
				$Obj_Backing		= $content.cloneNode(true);
				$Obj_Intent			= document.createElement('INPUT');
				$Obj_Intent.type	= "hidden";
				//显示
				var $cloneNode = $content.cloneNode(true);
				$Obj_Custom.appendChild($cloneNode);
				if ($str_mode=='show'){$cloneNode.style.display="block";}
				//替换节点
				$content.parentNode.replaceChild($Obj_Intent,$content);
			}
			else{
				$Str_CloneTxt		= $content.innerHTML;
				$Obj_Intent			= $content;
				$Obj_Intent.innerHTML	= '';
				$Obj_Custom.innerHTML	= $Str_CloneTxt;
			}
		}
		$Obj_Vessel.appendChild($Obj_Custom);			$Obj_Custom = document.getElementById($Str_Prefix+$str_opentype);
		$Str_Opening = $str_opentype;					$Bln_Opening = true;
		DragLayer($hanleid,$Str_Prefix+$str_opentype);	MoveToCenter();
	}
	this.reCustom = function (){
		if ($Aty_Custom){
			var $x,$y,$args;
			for ($x=0;$x<$Aty_Custom.length;$x++){
				if (isarray($Aty_Custom[$x])){
					if (typeof($Aty_Custom[$x][0])!="function"){continue;}
					$args = $Aty_Custom[$x].length>1 ? $Aty_Custom[$x].slice(1) : [];
					$Aty_Custom[$i] = $Aty_Custom[$x][0].apply(null,$args);
				}
			}
		}
		this.exit();
		if (!$Fun_Custom){return}
		if (arguments.length > 0 ){ $Ary_Args = []; for (var $i=0;$i<arguments.length;$i++){ $Ary_Args[$i] = arguments[$i] } }
		$Fun_Custom.apply(null,$Ary_Args);
	}
	//自定义关闭前运行的方法
	this.befCustom = function (){
		if (arguments.length<1){return false;}
		$Aty_Custom=[]; for(var $i=0;$i<arguments.length;$i++){$Aty_Custom[$i]=argumenets[$i];}
	}
	this.befValue = function (){return $Aty_Custom;}
	
	this.setskin = function (){
		if (arguments.length<1 || typeof(arguments[0])!="function" ){return false;}
		loadskin();
		if ($Str_Skin===false){return false;}
		if ($Str_Skin==null){$Str_Skin=""; $Str_KDir=$Str_Path; $Str_Imgs=$Str_KDir+"images/";}
		if ($Str_Style==null){$Str_Style="style.css";}
		loadstyle();
		setskin((arguments[0]).call(this));
	}

	//对象事务函数
	this.remove	= function (){MoveToCenter()}
	this.resize = function (){MoveToCenter()}
	this.scroll = function (){MoveToCenter()}
	this.exit = function(){
		if (!$Bln_Enabled || !$Bln_Opening || !$Str_Opening){return;}
		var $obj = document.getElementById($Str_Prefix+$Str_Opening.toString());
		if (!$obj){return;}
		if ($Str_Opening == "CUSTOM" && $Obj_Intent && $Obj_Intent.nodeName){
			if ($Str_CloneTxt!=null){$Obj_Intent.innerHTML = $Str_CloneTxt;}
			else if ($Obj_Backing && $Obj_Backing.nodeName){$Obj_Intent.parentNode.replaceChild($Obj_Backing,$Obj_Intent);}
			$Str_CloneTxt = null; $Obj_Backing = null ; $Obj_Intent = null; 
		}
		$Obj_Vessel.style.display = "none"; $Obj_MarkDiv.style.display = "none"; $Obj_Vessel.removeChild($obj);
		$Str_Opening = "";	$Bln_Opening = false;
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
	this.redirect = function (){
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