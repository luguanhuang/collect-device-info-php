// JavaScript Document

function DateTime_Validate($form){
	if (!$form){return false;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["datetime"]	= new Array(1,	19,	'日期时间',	"datetime:y-m-d h:i:s");
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	var $timestamp = $_G.dtstamp($form.datetime.value);		//设置的时间戳
	var $timestart = (new Date()).getTime()					//开始提交时的时间

	//提交数据
	return AjaxSubmit(
		$form,
		{
			"backcall":function($stamp,$start){
				var $int_stamp	= $_G.intval($stamp)
				var $int_start	= $_G.intval($start)
				var $int_end	= (new Date()).getTime();				//响应后的时间
				var $int_ttime	= $int_stamp+($int_start-$int_end)/1000	//当前应当现实的时间
				DateTime_ReStart($int_ttime);
				$_C.Alert($_A.result()[3],null);
			},
			"backargs":	[$timestamp,$timestart]
		}
	);
}

/*top页面加载时运行，且只运行一次*/
function DateTime_StartCount($value){
	window['$Glo_Int_ReTime'] = 0;
	if (DateTime_ReStart($value)){$Glo_Int_ReTime = setInterval('DateTime_Refresh()',1000);}
}

function Data_Refresh()
{
	console.log("Data_Refresh()");
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	//postData = {"name1":"value1","name2":"value2"};
	postData = {"cmd":"updatedata"};
	//这里需要将json数据转成post能够进行提交的字符串  name1=value1&name2=value2格式
	postData = (function(value){
	　　for(var key in value){
	　　　　oStr += key+"="+value[key];
	　　};
	　　return oStr;
	}(postData));
	//这里进行HTTP请求
	try{
	　　oAjax = new XMLHttpRequest();
	}catch(e){
	　　oAjax = new ActiveXObject("Microsoft.XMLHTTP");
	};
	//post方式打开文件
	oAjax.open('post','submitlivedata.php?'+"updatedata",true);
	//post相比get方式提交多了个这个
	oAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//post发送数据
	oAjax.send(postData);
	oAjax.onreadystatechange = function(){
	　　//当状态为4的时候，执行以下操作
	　　if(oAjax.readyState == 4){
	　　　　try{
	　　　　　　alert(oAjax.responseText);
	　　　　}catch(e){
	　　　　　　alert('你访问的页面出错了');
	　　　　};
	　　};
	};
}

/*top页面加载时运行，且只运行一次*/
function LoadData()
{
	//setInterval('Data_Refresh()',5000);
}

function DateTime_ReStart($value){
	if (parent==window || !parent.topFrame || !parent.topFrame.document){return false;}
	var $span = parent.topFrame.document.getElementById('datetime');
	if (!$span){ return false; }
	$value = DateTime_ToString($value);
	$span.setAttribute('value', $value['timestamp']);
	$span.innerHTML = $value['datetime'];
	return true;
}

function DateTime_Refresh(){
	var $span = parent.topFrame.document.getElementById('datetime');
	if (!$span){
		if (typeof(window['$Glo_Int_ReTime'])!="undefined"){clearInterval($Glo_Int_ReTime);}
		return false;
	}
	var $value = DateTime_ToString($span.getAttribute('value'),1);
	$span.setAttribute('value', $value['timestamp']);
	$span.innerHTML =  $value['datetime'];
	return true;
}

function DateTime_ToString($value,$isadd){
	if (!$value){ $value = 0 }
	else if ($value===true){ $value = 1; }
	else{ $value = isNaN($value) ? 0 : parseInt($value); }
	$value += $isadd ? 1 : 0;
	var $D	= new Date(); $D.setTime($value*1000);
	var $m = $D.getMonth()+1;	if ($m<10){ $m = "0"+$m; }
	var $d = $D.getDate();	 	if ($d<10){ $d = "0"+$d; }
	var $h = $D.getHours();		if ($h<10){ $h = "0"+$h; }
	var $i = $D.getMinutes();	if ($i<10){ $i = "0"+$i; }
	var $s = $D.getSeconds();	if ($s<10){ $s = "0"+$s; }
	return { "timestamp": $value, "datetime":$D.getFullYear()+"-"+$m+"-"+$d+" "+$h+":"+$i+":"+$s};
}