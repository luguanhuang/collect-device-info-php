function intval($v,$renull){
	if ($v==null){return $renull ? null : 0;} else if($v===true){return 1;}
	return /^[-+]?([1-9]\d*|0)(\.\d+)?$/.test($v) ? parseInt($v) : 0;
}

function strval($s,$c){
	$s = ($s==null || $s===false) ? "" : new String($s).toString();
	if ($c==1){return $s.toLowerCase();} else if($c==2){return $s.toUpperCase();}else{return $s;}
}

function hasClass(element, className){  
	var reg = new RegExp('(\\s|^)'+className+'(\\s|$)');     
	return element.className.match(reg); 
} 

function addClass(element, className){  
	if (!this.hasClass(element, className)){element.className += " "+className;}
}  

function removeClass(element, className){     
	if (hasClass(element, className)){ 
		var reg = new RegExp('(\\s|^)'+className+'(\\s|$)');
		element.className = element.className.replace(reg,' ');
	} 
} 

function getFirstChild(obj){
	if (!obj){ return false; }
	var firstDIV;
	for (i=0; i<obj.childNodes.length; i++){
		if (obj.childNodes[i].nodeType==1){
			firstDIV=obj.childNodes[i];
			return firstDIV;
		}
	}
}

/************************ 菜单事件 ************************/

//参数：一级菜单ID、一级菜单的样式、onclick的样式
function hovermenu(id1,style1,style2){
	id1 = strval(id1);
	if (id1==""){ return false; }
    var ArrLinks= document.getElementsByName(id1);	//一级菜单
	var ArrLevel= new Array();						//一级菜单中的连接
	for(var i=0;i<ArrLinks.length;i++){ArrLevel.push(getFirstChild(ArrLinks[i]));}
	for(var i=0;i<ArrLinks.length;i++){
		if (!ArrLevel[i]){continue;}
        ArrLevel[i].index = i;
        ArrLevel[i].onmouseover	= function(){overme		(this,	style1, 1)};
        ArrLevel[i].onmouseout	= function(){outme		(this,	style1,	1)};
		ArrLevel[i].onclick		= function(){clicktop	(this,	ArrLinks, style1, style2)};
		ArrLevel[i].onfocus		= function(){this.blur()};
    }
}

//参数：二级菜单ID、二级菜单的样式、onclick的样式
function submenu(id2,style1,style2){
	id2 = strval(id2);
	if (id2==""){ return false; }
    var ArrDivs	= document.getElementsByName(id2);	//二级菜单
	var ArrLinks= new Array();						//菜单中的连接
	var sublinks,m;
	for(var i=0;i<ArrDivs.length;i++){
		sublinks= ArrDivs[i].getElementsByTagName('A');
		for(m=0;m<sublinks.length;m++){ArrLinks.push(sublinks[m]);}
	}
    for(var i=0;i<ArrLinks.length;i++){
        ArrLinks[i].index = i
        ArrLinks[i].onmouseover	= function(){overme(this,	style1,	style2)};
        ArrLinks[i].onmouseout	= function(){outme(this,	style1,	style2)};
		ArrLinks[i].onclick		= function(){clicksub(this,ArrLinks,style1,	style2)};
		ArrLinks[i].onfocus		= function(){this.blur()};
    }
}
function overme(o,style,level){
	var sname	= intval(level)==1 ? 'level1Index' : 'level2Index';
	var state	= intval(document.body.getAttribute(sname),true);
	if (state!=o.index){addClass(o,style);}
}
function outme(o,style,level){
	var sname	= intval(level)==1 ? 'level1Index' : 'level2Index';
	var state	= intval(document.body.getAttribute(sname),true);
	if (state!=o.index){removeClass(o,style);};
}

function clicktop(o,menutop,style1,style2){
	var objUl	= menutop[o.index].getElementsByTagName('UL');
	var state 	= intval(document.body.getAttribute('level1Index'),true);
	//点击的不是已打开的
	if (state!=o.index){
		//关闭已打开的
		if (state!=null && typeof(menutop[state])!="undefined"){
			var submenu = menutop[state].getElementsByTagName('UL');
			if (submenu.length){
				/*submenu[0].style.display="none";*/
				closeObj(submenu[0]);
			}
		}
		if(objUl.length>0){
	   		objUl[0].style.display="block";
			showObj(objUl[0]);
		}
		//记录当前打开的
		document.body.setAttribute('level1Index',o.index);
		//更换样式
		var slink;
		for(var i=0;i<menutop.length;i++){
			slink = getFirstChild(menutop[i]);
			removeClass(slink,style2);
			removeClass(slink,style1);
		}
		addClass(o,style2);
    }
	//关闭自己
	else{
		if(objUl.length>0){
			/*objUl[0].style.display="none";*/
			closeObj(objUl[0]);
			removeClass(o,style2);
			removeClass(o,style1);
			document.body.removeAttribute('level1Index');
		}
	}
}

function clicksub(o,links,style){
	var state = intval(document.body.getAttribute('level2Index'),true);
	if (state!=o.index){
		if (state!=-1 && typeof(links[state])!="undefined"){removeClass(links[i],style);}
		document.body.setAttribute('level2Index',o.index);
	    addClass(o,style);
	}
}

/************************ 渐变显示和隐藏菜单 ************************/

function showObj(obj){
	if (!obj){ return false; }
	var allhight=obj.getElementsByTagName("li").length*26;
		obj.style.height="1px";
	var changeH = function(){ 	 		
		var obj_h = parseInt(obj.style.height);
		if(obj_h<allhight){
			obj.style.height=(obj_h+Math.ceil((allhight-obj_h)/4))+"px";
			setTimeout(changeH,40);
		}
	}
	setTimeout(changeH,40);
}

function closeObj(obj){
	if (!obj){ return false; }
	//直接关闭，不使用缩拉关闭
	//obj.style.display="none";
	//return true;
	//使用缩拉关闭
	var allhight = obj.getElementsByTagName("li").length*26;
	if (!allhight){ return false; }
	obj.style.overFlow = "hidden";
	var changeH = function (){
		var obj_h	= parseInt(obj.style.height);
			obj_h	= obj_h-Math.ceil(allhight/3);
		if(obj_h>1){
			obj.style.height = obj_h+"px";
			setTimeout(changeH,40);
		}
		else{
			obj.style.display="none";
		}
	}
	setTimeout(changeH,40);
}

function gotoHome(){
	if (!parent.mainFrame){top.location.href = "index.php";}
	else{parent.mainFrame.location.href = 'mainpage.php';}
	return false;
}

function gotoLogout(){
	if (confirm("Are you sure to log out？")){top.location.href = "logout.php";}
}