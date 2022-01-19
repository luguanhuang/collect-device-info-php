// JavaScript Document

$_W = parent!=window && parent.$_W && parent.$_W.classname()=="ODFWin" ? parent.$_W : new function (){
	
	//__________________  构造/析构函数  ________________

	function __construct(){
		
		if (document.execCommand){try{document.execCommand("BackgroundImageCache",false,true);}catch($error){}}	//强制缓存背景图
		
		var $i="0000"; while( typeof(window[$Str_ClassID+"-"+$i])!="undefined" ){$i=parseInt(Math.random()*8999+1000);}
		$Str_ClassID = $Str_ClassID +"-"+ $i; $Str_Object = "window['"+ $Str_ClassID +"']";	window[$Str_ClassID] = $this;
		
		getBrowserName();
		//DOM事件模型
		if (window.addEventListener){
			window.addEventListener("resize",scrollState,true);
			window.addEventListener("scroll",scrollState,true);
		}
		//IE5+事件模型
		else if(window.attachEvent){
			window.attachEvent("onresize",scrollState);
			window.attachEvent("onscroll",scrollState);
		}
		//IE5- 事件模型
		else{
			window.onresize = scrollState;
			window.onscroll = scrollState;
		}
		
		$enabled = true;
		
	}
	
	function __destruct(){}
	
	//拖动函数
	function DragLayer($title,$body) {
		var $titlebar	= getObject($title);if (!$titlebar || !$titlebar.nodeName || $titlebar.nodeName=="BODY"){return false;}
		var $bodybar	= getObject($body);	if (!$bodybar || !$bodybar.nodeName || $bodybar.nodeName=="BODY"){return false;}
		var $deltaX,	$deltaY;
		var $oldmove,	$oldup;
		//2级
		if (document.addEventListener){$titlebar.addEventListener("mousedown",odfwin_clickHandler,true);}//DOM事件模型
		else if(document.attachEvent){$titlebar.attachEvent("onmousedown",odfwin_clickHandler);}//IE5+事件模型
		else{$titlebar.onmousedown = odfwin_clickHandler;}//IE5- 事件模型
		$titlebar.style.cursor = "move";
		if ($bodybar.style.position.toLowerCase()!="absolute"){$bodybar.style.position = "absolute";}
		
		function odfwin_clickHandler($event){
			if (!$event){$event=window.event;}
			var $lScroll = parseInt(document.documentElement.scrollLeft)	//body滚动条左滚长度
			var $tScroll = parseInt(document.documentElement.scrollTop)		//body滚动条上滚长度
			if (!$lScroll){$lScroll = parseInt(document.body.scrollLeft);}
			if (!$tScroll){$tScroll = parseInt(document.body.scrollTop);}
			$deltaX = $event.clientX + $lScroll;
			$deltaY = $event.clientY + $tScroll;
			$deltaX -= parseInt($bodybar.offsetLeft);
			$deltaY -= parseInt($bodybar.offsetTop);
			
			if (document.addEventListener) {//DOM2事件模型
				document.addEventListener("mousemove", odfwin_moveHandler, true);
				document.addEventListener("mouseup", odfwin_upHandler, true);
			}
			else if (document.attachEvent) {//IE5+事件模型
				document.attachEvent("onmousemove", odfwin_moveHandler);
				document.attachEvent("onmouseup", odfwin_upHandler);
			}
			else {//IE4事件模型
				$oldmove	= document.onmousemove;	document.onmousemove = odfwin_moveHandler;
				$oldup		= document.onmouseup;	document.onmouseup = odfwin_upHandler;
			}
			//禁止冒泡
			if ($event.stopPropagation){$event.stopPropagation();}/*DOM2*/else{$event.cancelBubble=true;}//IE
			if ($event.preventDefault){$event.preventDefault();}/*DOM2*/else{$event.returnValue = false;}//IE
			var $el, $id = $bodybar.id;
			for($el in $Ary_Wind){ $Ary_Wind[$el].style.zIndex = $id == $el ? 989 : 987; }
			$bodybar.style.filter = "alpha(opacity=50)";
			$bodybar.style.opacity= 0.5;
		}
	
		function odfwin_moveHandler($event) {
			if (!$event){$event = window.event;}
			var $lScroll = parseInt(document.documentElement.scrollLeft)	//body滚动条左滚长度
			var $tScroll = parseInt(document.documentElement.scrollTop)		//body滚动条上滚长度
			if (!$lScroll){$lScroll = parseInt(document.body.scrollLeft);}
			if (!$tScroll){$tScroll = parseInt(document.body.scrollTop);}
			$bodybar.style.left = ($event.clientX+ $lScroll - $deltaX) + "px";
			$bodybar.style.top = ($event.clientY+ $tScroll - $deltaY) + "px";
			if (window.getSelection){window.getSelection().removeAllRanges();}
			else if (document.selection){document.selection.empty();}
			if ($event.stopPropagation){$event.stopPropagation();} else{ $event.cancelBubble = true;}
		}
	
		function odfwin_upHandler($event) {
			if (!$event){$event = window.event;}
			if (document.removeEventListener) {//DOM2
				document.removeEventListener('mouseup', odfwin_upHandler, true);
				document.removeEventListener('mousemove', odfwin_moveHandler, true);
			}
			else if (document.detachEvent) { //IE5+
				document.detachEvent("onmousemove", odfwin_moveHandler);
				document.detachEvent("onmouseup", odfwin_upHandler);
			}
			else {//IE4
				document.onmouseup = $oldmove;
				document.onmousemove = $oldup;
			}
			$bodybar.style.filter = "alpha(opacity=100)"; $bodybar.style.opacity= 1;
			if ($event.stopPropagation){$event.stopPropagation();} else{$event.cancelBubble = true;}
		}
	}
	
	//__________________  私有变量  ________________
	
	/*
	z-Index :
	活动窗口=989
	状态栏 = 988
	窗口 = 987
	iframe / winbox = 986
	*/

	var $this			= this,					$error		= null,	 					$enabled	= false;
	var $Str_Prefix		= "ODFWinLayer_",		$Str_ClassID= "A80AF067-C12A-F9D0";		$Str_Object	= "";
	var $Int_Error		= 0,		$Str_Error	= "";
	var $Ary_Wind		= [],		$Ary_Mini	= [],		$Ary_Html	= [];
	var $Obj_State		= null,		$Obj_StaBr	= null;
	var $Int_WGap		= 0,		$Int_HGap	= 0;
	
	//__________________  只读属性  ________________
	
	this.version	= function (){return '1.0';}				//版本
	this.build		= function (){return '11.06.15';}			//版本
	this.create		= function (){return '11.06.14';}			//创建
	this.classname	= function (){return "ODFWin";}				//名称
	this.developer	= function (){return "OldFour";}			//开发者
	this.copyright	= function (){return "www.oldfour.com";}	//公司
	
	this.Enabled	= function (){return $enabled;}
	this.Object		= function (){return window[$Str_ClassID];}
	
	this.Errno		= function (){return $Int_Error;}
	this.Error		= function (){return $Str_Error;}
	
	//__________________  私有方法  ________________
	
		//集百家函数
	function strval($val){return $val==null ? "" : $val.toString();}
	function intval($val){return !$val || isNaN($val) ? 0 : Math.floor($val);}
	function isarray($obj){
		if ($obj==null){return false;}
		return new String($obj.constructor).replace(/(function)|([\s]+)/g,"")=="Array(){[nativecode]}" ? true : false;
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
	
	function getBrowserName(){
		var $appName=navigator.appName.toLowerCase();
		if ($appName=="microsoft internet explorer"){return "ie";}
		else if ($appName=="netscape"){return "ne";}
		else if ($appName=="opera"){return "opera";}
		else{return "unknow";}
	}
	
	function setGapValue($val,$type){
		$val=intval($val);
		if ($val<=0 || $Str_Browser=="opera"){return 0;} else if($Str_Browser=="ie"){return $val;}
		return strval($type).substring(0,1).toLowerCase() =="w" ? $val+4 : $val+8;
	}
	
	function getWinID($id){
		$id = strval($id);
		if ($id==""){ return false; }
		if ($id.indexOf($Str_Prefix)!==0){ $id = $Str_Prefix+$id; }
		return $id;
	}
	
	function winExists($winid){
		if (!$enabled){return false;}
		$winid = getWinID($winid);
		if ($winid==""){ $Int_Error = 10; $Str_Error = "没有指定窗口ID"; return false; }
		if (typeof($Ary_Wind[$winid])=="undefined"){ $Int_Error = 11; $Str_Error = "指定的窗口不存在"; return false; }
		return $winid;
	}
	
	function miniExists($winid){
		$winid = winExists($winid);
		if (!$winid){ return false; }
		if (typeof($Ary_Mini[$winid])=="undefined"){ return ""; }
		return $winid;
	}
	
	function deleteState($winid){
		$winid = miniExists($winid);
		if (!$winid){ return false; }
		//如果已经被删除了
		var $obj_state = document.getElementById($Ary_Mini[$winid]);
		if (!$obj_state){ return false; }
		$obj_state.parentNode.removeChild($obj_state);
		$Ary_Mini[$winid] = undefined;
		//如果没了
		if ($Obj_State.getElementsByTagName('DIV').length) { scrollState();}
		else{ $Obj_State.style.display = "none"; }
	}
	
	function scrollState(){
		if (!$Obj_State || $Obj_State.style.display=="none"){ return false; }
		var $wClient = parseInt(document.documentElement.clientWidth);		//screen可用宽度
		var $hClient = parseInt(document.documentElement.clientHeight);		//screen可用高度
		var $tScroll = parseInt(document.documentElement.scrollTop);		//body滚动条上滚长度
		if (!$wClient){$wClient = parseInt(document.body.clientWidth);}
		if (!$hClient){$hClient = parseInt(document.body.clientHeight);}
		if (!$tScroll){$tScroll = parseInt(document.body.scrollTop);}
		$Obj_State.style.width = $wClient+"px";
		$Obj_State.style.height= parseInt($Obj_State.scrollHeight)+"px";
		$Obj_State.style.top = ($hClient-parseInt($Obj_State.style.height)+$tScroll)+"px";
	}

	//__________________  公有方法  ________________
	
	this.setgap = function ($val,$type){
		return setGrapValue($val,$type);
	}
	
	/*
	['source'] 数不是数组时：
		
		1.如果为null或为空，返回错误
		2.如果是节点，窗口代码 = 节点.innerHTML
		3.如果是字符，先尝试通过 getElementById() 获取节点，如果节点存在 窗口代码 = 节点.innerHTML；否则 窗口代码 = 该字符串；
		
	['source'] 为数组时：
		
		1.如果没有元素，返回错误
		2.只有一个元素时，如果元素为节点，以上面情况②进行处理；如果为字符串，先尝试获取已保存的窗口代码，若存在则直接使用相应的窗口代码，否则按上面情况③进行处理
		3.两个元素时，根据第一个元素获取已保存的窗口代码，若存在则直接使用相应的窗口代码，否则将第二个元素按上面情况③进行处理。该情况一定保存窗口代码。
	*/
	this.open = function(){
		if (!arguments.length || arguments[0]==null){ $Int_Error = 100; $Str_Error = "缺少有效的参数"; return false; }
		var $args = arguments[0];
		var $winid	= typeof($args['id'])!="undefined" ? $args['id'] : (typeof($args['window'])!="undefined"?$args['window']:null);
		var $hander	= typeof($args['hander'])!="undefined" ? $args['hander'] : null;
		var $title	= typeof($args['title'])!="undefined" ? strval($args['title']) : "";
		var $source	= typeof($args['source'])!="undefined" ? $args['source'] : null;
		var $isload	= arguments.length>1 ? !!arguments[1] : false;
		//ID大小写区分
		$winid = getWinID($winid);
		if ($winid==""){ $Int_Error = 100; $Str_Error = "没有指定窗口ID"; return false; }
		//当前最小化
		if (typeof($Ary_Mini[$winid])!="undefined"){ this.recover($winid); return true; }		//还原窗口
		//当前"关闭"的
		else if (typeof($Ary_Wind[$winid])!="undefined"){ this.center($winid); return true;}	//重新打开
		//'source':
		var $key,$value,$html,$type,$len;
			//如果不是数组
		if (!isarray($source)){
			$value = $source;
		}
		else{
			$len = $source.length;
			//没有元素
			if (!$len){ $source==null; }
			//多于1个元素(添加新模板或更新模板)
			else if ($len>1) { $key	= $source[0]; $value = $source[1]; }	
			//一个元素且为对象(加载模板)
			else if (typeof($source[0])=="object"){ $value = $source[0]; }
			else{ $key = $source[0]; /*key可能是要获取的窗口代码索引，也可以能是窗口代码或源窗口模板ID(下面进行判断)*/}
		}
		if ($source==null){ $Int_Error = 101; $Str_Error = "窗口源代码无效"; return false; }
			//如果指定了key,且存在窗口代码
		if ($key && typeof($Ary_Html[$key])!="undefined"){
			$html = $Ary_Html[$key];
		}
		else{
			//源为数组，只有一个元素，且该元素为字符
			if ($key && $len==1 && $value==null){ $value = $key; $key = null; }
				//源类型
			if (typeof($value)=="object"){ $type = "object";}
			else{ $type = ($value=getObject($value)) ? "object" : "string"; }
				//源有效性
			if ( $type == "object" ){
				if  (!$value || !$value.nodeName){ $Int_Error = 102; $Str_Error = "窗口源对象不存在"; return false; }
				$html = $value.innerHTML;
			}
			else{
				$html = strval($value);
				if ($html==""){ $Int_Error = 103; $Str_Error = "窗口代码为空"; return false; }
			}
		}
		//替换标签
		var $inner = $html;
			$inner = $inner.replace(/\{tag\:center(\(\))?\}/gi,	$Str_Object+".center('"+ $winid +"')");
			$inner = $inner.replace(/\{tag\:close(\(\))?\}/gi,	$Str_Object+".close('"+ $winid +"')");
			$inner = $inner.replace(/\{tag\:mini(\(\))?\}/gi,	$Str_Object+".mini('"+ $winid +"')");
			$inner = $inner.replace(/\{tag\:recover(\(\))?\}/gi,$Str_Object+".recover('"+ $winid +"')");
			$inner = $inner.replace(/\{tag\:id\}/gi,	$winid.substring($Str_Prefix.length));
			$inner = $inner.replace(/\{tag\:title\}/gi, $title);
		//显示窗口
		var $obj_window = document.createElement("DIV");
			$obj_window.id = $winid;
			$obj_window.style.cssText = "position:absolute;z-Index:986;top:0px;left:0px; margin:0px;padding:0px; overflow:visible; display:none;zoom:1;";
			$obj_window.setAttribute("title", $title=="" ? $winid : $title);

		var $obj_inbox = document.createElement("SPAN");
			$obj_inbox.id = $winid+"_body";
			$obj_inbox.innerHTML = $inner;
			$obj_inbox.style.cssText = "position:absolute;z-Index:987;margin:0px;padding:0px;float:none;display:inherit;"
			
		var $obj_frame = document.createElement("iframe");
			$obj_frame.id 			= $winid+"_frame";		$obj_frame.src 			= "about:blank";
			$obj_frame.frameBorder	= 0;					$obj_frame.scrolling	= "no";	
			$obj_frame.style.cssText= "position:absolute;z-Index:986;opacity:0;"	//IE不能设置其透明度
			
		//显示
		$obj_window.appendChild($obj_inbox);
		$obj_window.appendChild($obj_frame);
		$obj_window.setAttribute('loaded',0);
		document.body.appendChild($obj_window);

		//删除源节点
		if ($type=="object"){ $value.parentNode.removeChild($value); }
		//记录窗口
		$Ary_Wind[$winid] = document.getElementById($winid);
		//保存代码
		if ($key && typeof($Ary_Html[$key])=="undefined"){ $Ary_Html[$key] = $html; }
		//更改句柄ID
		var $str_newhd = strval($hander);
		if ($str_newhd!=""){
			var $obj_title = document.getElementById($str_newhd);
			if ($obj_title){
				$str_newhd = $winid+"_title";
				$obj_title.id = $str_newhd;
				$obj_title = document.getElementById($str_newhd);
			}
		}
		//可移动(新的TitleID，最外层的DIV)
		DragLayer($str_newhd,$winid);
		//不是只预加载
		if (!$isload){this.center($winid);/*窗口居中*/}
		return true;
	}
	//定位
	this.setplace = function($id,$x,$y){
		$id = winExists($id);
		if (!$id){ return false; }

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
		
		//调整大小(只有在显示后才能获取到大小)
		$Ary_Wind[$id].style.display = "block";
		var $loaded = $Ary_Wind[$id].getAttribute('loaded');
		if (!$loaded || $loaded=="0"){
			var $winbody = document.getElementById($id+"_body");
			var $winframe = document.getElementById($id+"_frame");
			var $iwidth	= parseInt($winbody.offsetWidth)+"px";
			var $iheight= parseInt($winbody.offsetHeight)+"px";
			$Ary_Wind[$id].style.width	= $iwidth;
			$Ary_Wind[$id].style.height	= $iheight;
			$winframe.style.width	= $iwidth;
			$winframe.style.height	= $iheight;
			$Ary_Wind[$id].setAttribute('loaded',1)
		}
		
		var $wDiv = Math.max($wClient,$wScroll);
		var $hDiv = Math.max($hClient,$hScroll);
		var	$int_mtop = $hClient-parseInt($Ary_Wind[$id].offsetHeight) > 100 ? 50 : 0;
		
		$x = $x==null ? Math.max(($wClient-parseInt($Ary_Wind[$id].offsetWidth))/2+$lScroll,0) : intval($x);
		$y = $y==null ? Math.max(($hClient-parseInt($Ary_Wind[$id].offsetHeight))/2-$int_mtop+$tScroll,0) : intval($y);
		$Ary_Wind[$id].style.left= $x+"px";
		$Ary_Wind[$id].style.top = $y+"px";
	}
	
	//居中
	this.center = function ($id){
		this.setplace($id,null,null)
	}
	
	//恢复
	this.recover = function ($winid,$x,$y){
		$winid = miniExists($winid);
		if (!$winid){ return false; }
		$Ary_Wind[$winid].style.display = "block";
		this.setplace($winid,$x,$y);
		deleteState($winid);
	}
	
	//最小化
	this.mini = function ($winid){
		$winid = getWinID($winid);
		if (miniExists($winid)!==""){ return false; }
		//查看状态栏是否存在
		$Obj_State = document.getElementById($Str_Prefix+"State");
		$Obj_StaBr = document.getElementById($Str_Prefix+"StaBR");
		if (!$Obj_State){
			$Obj_State = document.createElement("DIV");
			$Obj_State.id = $Str_Prefix+"State";
			$Obj_State.style.cssText = "position:absolute;z-Index:988; zoom:1; top:0px;left:0px; margin:0px;padding:0px; height:24px; overflow:auto; ";
			$Obj_StaBr = document.createElement("BR");
			$Obj_StaBr.id = $Str_Prefix+"StaBR";
			$Obj_StaBr.clear = "all";
			$Obj_State.appendChild($Obj_StaBr);
			document.body.appendChild($Obj_State);
		}
		$Obj_State.style.display = "block";
		//放入状态栏
		var $str_title = $Ary_Wind[$winid].getAttribute('title');
		var $obj_div = document.createElement("DIV");
			$obj_div.id = $winid+"_state";
			$obj_div.title = $str_title;
			$obj_div.style.cssText = "float:left; display:display; margin:0px; border-left:1px solid #FFFFFF; border-top:1px solid #FFFFFF; border-right:1px solid #808080; border-bottom:1px solid #808080; background-color:#DFDFDF; width:100px;height:18px;line-height:18px;overflow:hidden;padding:3px 2px 1px 6px;";
			$obj_div.innerHTML = "<label style=\"float:right;display:inline;margin-left:5px;-margin-left:2px;padding:1px;font-size:11px;color:#AEAFAE;width:11px;height:11px;line-height:12px;overflow:hidden;cursor:pointer;\" title=\"退出\" onclick=\""+ $Str_Object +".close('"+ $winid +"')\" onmouseover=\"this.style.color='#F9EBEB';this.style.backgroundColor='#C13535';\" onmouseout=\"this.style.color='#AEAFAE';this.style.backgroundColor='';\">×</label><label style=\"float:none; display:block; cursor:pointer; font-size:12px; color:#000000; overflow:hidden; word-break:break-all; word-wrap:break-word; \" onclick=\""+ $Str_Object +".recover('"+ $winid +"','"+ parseInt($Ary_Wind[$winid].style.left) +"','"+ parseInt($Ary_Wind[$winid].style.top) +"')\">"+ $str_title +"</label>";
			$Obj_State.insertBefore($obj_div,$Obj_StaBr);
		//状态栏位置
			scrollState();
		//关闭
		$Ary_Mini[$winid] = $winid+"_state";
		$Ary_Wind[$winid].style.display = "none";
	}
	
	//关闭
	this.close = function ($winid){
		$winid = winExists($winid);
		if (!$winid){ return false; }
		$Ary_Wind[$winid].style.display = "none";
		deleteState($winid);
	}
	
	this.getheader = function ($winid){
		$winid = winExists($winid);
		if (!$winid){ return false; }
		return document.getElementById($winid+"_title");
	}
	
	this.getbody = function ($winid){
		$winid = winExists($winid);
		if (!$winid){ return false; }
		return document.getElementById($winid+"_body");
	}
	
	this.getwin = function ($winid){
		$winid = winExists($winid);
		if (!$winid){ return false; }
		return document.getElementById($winid);
	}
	
	//完全卸载
	this.unset = function ($winid){
		$winid = winExists($winid);
		if (!$winid){ return false; }
		deleteState($winid);
		$Ary_Wind[$winid].parentNode.removeChild($Ary_Wind[$winid]);
		delete $Ary_Wind[$winid];
	}
	
	__construct();
}