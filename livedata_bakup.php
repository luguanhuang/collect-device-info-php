
<script>
window.onload = function () {
//console.log(window.location.href)//此处会打印出当前页面的href值，为
let url = window.location.href.split('?');
//console.log(url[1]);//打印出来是一个数组
}
</script>

<?php

require_once 'testtmp.php';
require("services/AtherFrameWork.php");
//require("submitlivedata.php");
global $Obj_Frame;
global $Ary_Result;

TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "livedata",0);
$var=explode("&",$_SERVER["QUERY_STRING"]);

$devname=explode("=",$var[1]);
TLOG_MSG("livedata: func begin22 data=".$devname[0]." devname=".$devname[1]);
$Obj_Frame = new AtherFrameWork();
$Ary_Result= $Obj_Frame->load_page("Channel::getChannelInfo",$devname[1],false);

/*if (is_array($Ary_Result['result']['tab']))
{
	foreach($Ary_Result['result']['tab'] as $k=>$row)
	{
		TLOG_MSG("chid=$row['chid'] tagid=$row['tagid'] tagname=$row['tagname'] tagdata=$row['tagdata']");
	}
}*/
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="css.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style> 
        .black_overlay{ 
            display: none; 
            position: absolute; 
            top: 0%; 
            left: 0%; 
            width: 100%; 
            height: 100%; 
            background-color: black; 
            z-index:1001; 
            -moz-opacity: 0.8; 
            opacity:.80; 
            filter: alpha(opacity=88); 
        } 
        .white_content { 
            display: none; 
            position: absolute; 
            top: 25%; 
            left: 25%; 
            width: 30%; 
            height: 30%; 
            padding: 20px; 
            border: 10px solid orange; 
            background-color: white; 
            z-index:1002; 
            overflow: auto; 
        } 
    </style> 
</head>
<body style="text-align: left;">
<button id="mainpage" name="mainpage" class="tablink" onclick="MainPage(this)">MainPage</button>
<button id="livetrend" name="livetrend" class="tablink" onclick="livetrend(Livetrenddata)">Livetrend</button>
<button id="Historical" name="Historical" class="tablink" onclick="">Historical</button>
<button id="Alarm" name="Alarm" class="tablink" onclick="">Alarm</button>
<button id="Report" name="Report" class="tablink" onclick="ReportPage(this)">Report</button>


<div id="Livetrenddata" class="tabcontent"> hello this is test</div>


<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				
		?>
		
		<button id='<?=$devname[1]?><?=$row['ch']?>' name='<?=$row['ch']?>' class="tablink" onclick="openPage('<?=$row['ch']?>', this, 'red')"><?=$devname[1]?>_Channel<?=$row['ch']?></button>
		
		
		
 <?php }
		}
		?>


<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				
		?>
		
		<div id="<?=$row['ch']?>" class="tabcontent"></div>
		<h3></h3> 
		
 <?php }
	}
	?>

<?php
      require('footer.html');
      require('loadjs.html');
    ?>
	
	 <div id="light" class="white_content">
	 <tr>
		<td colspan="2" style="padding: 0; border: 0;">
            <table>
				<tr id="checkhide" style="display:none">
				  <td class="t">Write data：</td>
				 <!-- <td class="c"><input class="input" id="checkdata" name="checkdata" type="checkbox"></td>-->
				 	<td style="text-align:left;"> <label class="switch"><input id="checkdata" name="checkdata" type="checkbox"><span class="slider round"></span></label></td>
				</tr>
			
			
				<tr id="datahide" style="display:none">
                      <td class="t">Write data：</td>
                      <td class="c"><input class="input" id="data" name="data" type="text" value=""></td>
                </tr>
				<tr id="passwdhide" style="display:none">
                      <td class="t">Write Password：</td>
                      <td class="c"><input class="input" id="passwd" name="passwd" type="text" value=""></td>
                </tr>
                <input style="display:none" class="input" id="ids" name="ids" type="text" value="">
				<tr id="btnhide" style="display:none">
                      <td class="t"><input class="btn" id="btnsave" type="button" value="save" name="btnsave" onclick="savedata()"></td>
					  <td class="c"><input class="btn" id="btnreset" type="button" value="close" onclick="closeDialog()"></td>
                </tr>
				
            </table> 
		</td>
		</tr>
        </div> 
        <div id="fade" class="black_overlay"></div> 
		<div id="ReportData" class="tabcontent"></div>
		<h3></h3> 
    <script type="text/javascript" src="js/route.js"></script>

<script>
var cnt = 0;
var curids = "";

function livetrend(pageName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

function creElement(createtype,type,style,name,classname,value)
{
	var input1 = document.createElement(createtype);
	input1.setAttribute('type', type);
	input1.setAttribute('style', style);
	input1.setAttribute('name', name);
	input1.setAttribute('id', name);
	
	input1.setAttribute('class', classname);
	input1.setAttribute('className', classname);
	input1.setAttribute('value', value);
	input1.setAttribute('disabled', 'True');  //设置文本为只读类型  
	return input1;
}

function reqData(pageName) 
{
	console.log("reqData pageName="+pageName);
	
	
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	postData = {"cmd":"updatedata","devname":"<?=$devname[1]?>","channelid":pageName};
	//这里需要将json数据转成post能够进行提交的字符串  name1=value1&name2=value2格式
	postData = (function(value){
	　　for(var key in value){
	　　　　oStr += key+"="+value[key]+"&";
	　　};
	
		oStr = oStr.substr(0, oStr.length - 1);  
	　　return oStr;
	}(postData));
	//这里进行HTTP请求
	try{
	　　oAjax = new XMLHttpRequest();
	}catch(e){
	　　oAjax = new ActiveXObject("Microsoft.XMLHTTP");
	};
	//post方式打开文件
	oAjax.open('post','submitlivedata.php?='+Math.random(),true);
	//post相比get方式提交多了个这个
	oAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//post发送数据
	oAjax.send(postData);
	oAjax.onreadystatechange = function(){
	　　//当状态为4的时候，执行以下操作
	　　if(oAjax.readyState == 4){
	　　　　try{
				json = JSON.parse(oAjax.responseText);
				
				for(var i=0;i<json.result.data.length;i++)
				{
					//document.getElementById(json.result.data[i].ch).innerHTML = "";
				}
				
				var dtype = 0;
				var slaveid = 0;
				
				var funcode = 0;
				var countreg = 0;
				for(var i=0;i<json.result.tab.length;i++)
				{
					var currentid = '<?=$devname[1]?>';
					currentid += ",";
					currentid += pageName;
					var tagid = 0;
					for(var j=0;j<json.result.data.length;j++)
					{
						if (json.result.tab[i].chid == json.result.data[j].ch)
						{
							dtype = json.result.data[j].dtype;
							slaveid = json.result.data[j].slaveid;
							funcode = json.result.data[j].funcode;
							if ((funcode == 1 || funcode == 2) && dtype ==1)
							{ 
								funcode = 5;
							}
							else if((funcode == 3 || funcode ==4) && (dtype ==2 || dtype ==3))
							{
								funcode = 6;
							}
							else
							{ 
								funcode =16;
							}
							
							countreg = json.result.data[j].startreg+json.result.tab[i].tagid-1;
							tagid = json.result.tab[i].tagid;
							
							break;
						}
					}
					var btn1 = document.getElementById(pageName);
					var currentid = '<?=$devname[1]?>';
					currentid += ",";
					currentid += dtype;
					
					currentid += ",";
					currentid += slaveid;
					
					currentid += ",";
					currentid += funcode;
					
					currentid += ",";
					currentid += countreg;
					
					if (dtype == 1)
					{
						
						
						nametmp = "tagdata_"+pageName+String(json.result.tab[i].tagid);
						docdata = document.getElementById(nametmp);
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						docdata.value = String(json.result.tab[i].tagdata);
						
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							if (json.result.tab[i].coiltype == 1)
							{
								if (json.result.tab[i].tagdata == 0)
									docdata.style.background = "#FF0000";
								else
									docdata.style.background = "#00FF00";
							}
							else
							{
								if (json.result.tab[i].tagdata == 1)
									docdata.style.background = "#FF0000";
								else
									docdata.style.background = "#00FF00";
							}
						}
						
						
					}
					else
					{
						
						
						
						nametmp = "tagdata_"+pageName+String(json.result.tab[i].tagid);
						var name = String(json.result.tab[i].tagname) + "("+String(json.result.tab[i].tagdesc+")");
						docdata = document.getElementById(nametmp);
						if (!(!json.result.tab[i].tagdata && 
							typeof(json.result.tab[i].tagdata)!="undefined" 
							&& json.result.tab[i].tagdata!=0))
						{
							docdata.value = json.result.tab[i].tagdata;
							//console.log("data="+json.result.tab[i].tagdata);
							//input4.setAttribute('value', String());
						}
						
						
					}
					
					if (json.result.tab[i].writeenable == 1)
					{
						
					}
					
					 var br = document.createElement("br");  
					  btn1.insertBefore(br,null);  
				}
				
	　　　　}catch(e){
				console.log("'你访问的页面出错了");
	　　　　　　//alert('你访问的页面出错了');
	　　　　};
	　　};
	};
	
	//console.log("curcnt="+curcnt);
	for (var i=0;i<cnt;i++)
	 {
		 //console.log("key="+s_keySearch.key_index[i]+
			//" key_name="+s_keySearch.key_name[i]);
	 }
	
}

function _reqData(pageName){
 
       return function(){
             reqData(pageName);
       }
}

function SetStyle(pageName,elmnt)
{
	<?php
	if (is_array($Ary_Result['result']['data'])){
		foreach($Ary_Result['result']['data'] as $k=>$row){
			
	?>
	if (<?=$row['ch']?> != pageName)
		document.getElementById(<?=$row['ch']?>).innerHTML = "";
	<?php }
	}
	?>
	var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = '#008880';
}

function WriteData() 
{
	console.log("WriteData: func begin");
	
}

function closeDialog()
{
	document.getElementById('light').style.display='none';
	document.getElementById('fade').style.display='none';
	document.getElementById('datahide').style.display='none';
	document.getElementById('passwdhide').style.display='none';
	document.getElementById('btnhide').style.display='none';
}


var dtype = 0;

function savedata()
{
	console.log("key="+document.getElementById('ids').value);
	var key = document.getElementById('ids').value;
	var value = "";
	for (var i=0;i<cnt;i++)
	 {
		 if (key == s_keySearch.key_index[i])
		 {
			console.log("key="+s_keySearch.key_index[i]+
			" key_name="+s_keySearch.key_name[i]); 
			value = s_keySearch.key_name[i];
			break;
		 }
	 }
	var tmpdata=value;
	var data = 0;
	if (dtype == 1)
	{
		var info = document.getElementById('checkdata');
		if (info.checked)
			data = 1;
		else
			data = 0;
		
		tmpdata += ",";
		tmpdata += data;
	}
	else
	{
		data = document.getElementById('data');
		tmpdata += ",";
		tmpdata += data.value;
	}
	var passwd = document.getElementById('passwd');
	console.log("savedata passwd="+passwd.value + " chid="+tmpdata);
	
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	//postData = {"cmd":"updatedata","devname":"<?=$devname[1]?>","channelid":pageName};
	postData = {"cmd":"writedata","chid":tmpdata};
	//这里需要将json数据转成post能够进行提交的字符串  name1=value1&name2=value2格式
	postData = (function(value){
	　　for(var key in value){
	　　　　oStr += key+"="+value[key]+"&";
	　　};
	
		oStr = oStr.substr(0, oStr.length - 1);  
	　　return oStr;
	}(postData));
	//这里进行HTTP请求
	try{
	　　oAjax = new XMLHttpRequest();
	}catch(e){
	　　oAjax = new ActiveXObject("Microsoft.XMLHTTP");
	};
	//post方式打开文件
	oAjax.open('post','submitlivedata.php?='+Math.random(),true);
	//post相比get方式提交多了个这个
	oAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//post发送数据
	oAjax.send(postData);
	
	oAjax.onreadystatechange = function()
	{
	　　//当状态为4的时候，执行以下操作
	　　if(oAjax.readyState == 4)
		{
	　　　　try
			{
				json = JSON.parse(oAjax.responseText);
				console.log("data info"+json.message);
				$_C.exit();$_C.Alert(json.message,null);
				//console.log("length="+json.result.data.length);
			}
			catch(e)
			{
				console.log("'你访问的页面出错了");
	　　　　　　//alert('你访问的页面出错了');
	　　　　};
		};
	}
}

var s_keySearch = 
{
	key_name:Array(),
	key_index:Array()
};

function ReportPage(elmnt) 
{
	console.log("test22");
	<?php
	if (is_array($Ary_Result['result']['data'])){
		foreach($Ary_Result['result']['data'] as $k=>$row){
			
	?>
		document.getElementById(<?=$row['ch']?>).innerHTML = "";
	<?php }
	}
	?>
	var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  document.getElementById('ReportData').style.display = "block";
  elmnt.style.backgroundColor = '#008880';
	
	document.getElementById('ReportData').innerHTML = "";
	
	var btn1 = document.getElementById('ReportData');
	var input5 = document.createElement('input');
	input5.setAttribute('type', 'button');
	input5.setAttribute('name', 'Report_button');
	input5.setAttribute('id', 'Report_button');
	input5.setAttribute('class', 'btn');
	input5.setAttribute('value', 'download file');
	input5.onclick = function() 
	{ 

		window.location.href="tcpdumpexport.php?<?=$devname[1]?>";
	}	
	
	btn1.insertBefore(input5,null);
	
}

function MainPage(elmnt) 
{
	console.log("test");
	<?php
	if (is_array($Ary_Result['result']['data'])){
		foreach($Ary_Result['result']['data'] as $k=>$row){
			
	?>
		document.getElementById(<?=$row['ch']?>).innerHTML = "";
	<?php }
	}
	?>
	
	elmnt.style.backgroundColor = '#008880';
	var btn1 = document.getElementById("mainpage");
	
}

function reqDataBegin(pageName) 
{
	console.log("reqDataBegin pageName="+pageName);
	
	
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	postData = {"cmd":"updatedata","devname":"<?=$devname[1]?>","channelid":pageName};
	//这里需要将json数据转成post能够进行提交的字符串  name1=value1&name2=value2格式
	postData = (function(value){
	　　for(var key in value){
	　　　　oStr += key+"="+value[key]+"&";
	　　};
	
		oStr = oStr.substr(0, oStr.length - 1);  
	　　return oStr;
	}(postData));
	//这里进行HTTP请求
	try{
	　　oAjax = new XMLHttpRequest();
	}catch(e){
	　　oAjax = new ActiveXObject("Microsoft.XMLHTTP");
	};
	//post方式打开文件
	oAjax.open('post','submitlivedata.php?='+Math.random(),true);
	//post相比get方式提交多了个这个
	oAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//post发送数据
	oAjax.send(postData);
	oAjax.onreadystatechange = function(){
	　　//当状态为4的时候，执行以下操作
	　　if(oAjax.readyState == 4){
	　　　　try{
				json = JSON.parse(oAjax.responseText);
				
				for(var i=0;i<json.result.data.length;i++)
				{
					//document.getElementById(json.result.data[i].ch).innerHTML = "";
				}
				
				var dtype = 0;
				var slaveid = 0;
				
				var funcode = 0;
				var countreg = 0;
				for(var i=0;i<json.result.tab.length;i++)
				{
					var currentid = '<?=$devname[1]?>';
					currentid += ",";
					currentid += pageName;
					var tagid = 0;
					for(var j=0;j<json.result.data.length;j++)
					{
						if (json.result.tab[i].chid == json.result.data[j].ch)
						{
							dtype = json.result.data[j].dtype;
							slaveid = json.result.data[j].slaveid;
							funcode = json.result.data[j].funcode;
							if ((funcode == 1 || funcode == 2) && dtype ==1)
							{ 
								funcode = 5;
							}
							else if((funcode == 3 || funcode ==4) && (dtype ==2 || dtype ==3))
							{
								funcode = 6;
							}
							else
							{ 
								funcode =16;
							}
							
							countreg = json.result.data[j].startreg+json.result.tab[i].tagid-1;
							tagid = json.result.tab[i].tagid;
							
							break;
						}
					}
					var btn1 = document.getElementById(pageName);
					var currentid = '<?=$devname[1]?>';
					currentid += ",";
					currentid += dtype;
					
					currentid += ",";
					currentid += slaveid;
					
					currentid += ",";
					currentid += funcode;
					
					currentid += ",";
					currentid += countreg;
					
					if (dtype == 1)
					{
						var nametmp = "tagid_"+pageName+String(json.result.tab[i].tagid);
						//console.log("nametmp="+nametmp);
						var input = creElement('input','text','width:30px; height=25px',
							nametmp,'input',String(json.result.tab[i].tagid));
						
						btn1.insertBefore(input,null);
						nametmp = "tagname_"+pageName+String(json.result.tab[i].tagid);
						input = creElement('input','text','width:350px; height=25px',
							nametmp,'input',String(json.result.tab[i].tagname) + "("+String(json.result.tab[i].tagdesc+")"));
						
						btn1.insertBefore(input,null);
						
						var input4 = document.createElement('input');
						input4.setAttribute('style', 'width:80px; height=25px');
						input4.setAttribute('type', 'text');
						nametmp = "tagdata_"+pageName+String(json.result.tab[i].tagid);
						input4.setAttribute('name', nametmp);
						input4.setAttribute('id', nametmp);
						input4.setAttribute('class', 'input');
						
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							input4.setAttribute('value', String(json.result.tab[i].tagdata));
							if (json.result.tab[i].coiltype == 1)
							{
								if (json.result.tab[i].tagdata == 0)
									input4.style.background = "#FF0000";
								else
									input4.style.background = "#00FF00";
							}
							else
							{
								if (json.result.tab[i].tagdata == 1)
									input4.style.background = "#FF0000";
								else
									input4.style.background = "#00FF00";	
							}
									
						}
						
						input4.setAttribute('disabled', 'True'); //设置文本为只读类型  
						
						
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							/*if (json.result.tab[i].coiltype == 1)
							{
								//if ("1<?=$row['tagdata']?>" != "1")
								
										if (json.result.tab[i].tagdata == 0)
											input4.style.background = "#FF0000";
										else
											input4.style.background = "#00FF00";	
								
								
							}
							else
							{
								
									if (json.result.tab[i].tagdata == 1)
										input4.style.background = "#FF0000";
									else
										input4.style.background = "#00FF00";	
								
								
							}*/
						}
						btn1.insertBefore(input4,null);
					}
					else
					{
						var nametmp = "tagid_"+pageName+String(json.result.tab[i].tagid);
						var input = creElement('input','text','width:30px; height=20px',
							nametmp,'input',String(json.result.tab[i].tagid));
						
						btn1.insertBefore(input,null);
						var nametmp = "tagname_"+pageName+String(json.result.tab[i].tagid);
						input = creElement('input','text','width:260px; height=20px',
							nametmp,'input',String(json.result.tab[i].tagname) + "("+String(json.result.tab[i].tagdesc+")"));
						btn1.insertBefore(input,null);
						var input4 = document.createElement('input');
						input4.setAttribute('style', 'width:80px; height=20px');
						input4.setAttribute('type', 'text');
						var nametmp = "tagdata_"+pageName+String(json.result.tab[i].tagid);
						input4.setAttribute('name', nametmp);
						input4.setAttribute('id', nametmp);
						input4.setAttribute('class', 'input');
						if (!(!json.result.tab[i].tagdata && 
							typeof(json.result.tab[i].tagdata)!="undefined" 
							&& json.result.tab[i].tagdata!=0))
						input4.setAttribute('value', String(json.result.tab[i].tagdata));
						input4.setAttribute('disabled', 'True'); //设置文本为只读类型  
						
						btn1.insertBefore(input4,null);
					}
					
					s_keySearch.key_name[cnt]=currentid;
					s_keySearch.key_index[cnt]= String(pageName) + String(json.result.tab[i].tagid);
					cnt++;
					if (json.result.tab[i].writeenable == 1)
					{
					var nametmp = "btn_"+pageName+String(json.result.tab[i].tagid);
					var input5 = document.createElement('input');
					input5.setAttribute('type', 'button');
					input5.setAttribute('name', nametmp);
					input5.setAttribute('id', nametmp);
					input5.setAttribute('class', 'btn');
					input5.setAttribute('value', 'write');
					input5.onclick = function($tagid) 
					{ 
						if (1 == dtype)
						{
							document.getElementById('light').style.display='block';
							document.getElementById('fade').style.display='block';
							document.getElementById('checkhide').style.display='block';
							document.getElementById('datahide').style.display='none';
							document.getElementById('passwdhide').style.display='block';
							document.getElementById('btnhide').style.display='block';
						}
						else
						{
							document.getElementById('light').style.display='block';
							document.getElementById('fade').style.display='block';
							document.getElementById('datahide').style.display='block';
							document.getElementById('checkhide').style.display='none';
							document.getElementById('passwdhide').style.display='block';
							document.getElementById('btnhide').style.display='block';
						}
						
						document.getElementById('ids').value=String(pageName) + String(json.result.tab[i].tagid);
						console.log("pageName="+pageName+" dtype="+dtype+" tagid="+json.result.tab[i].tagid
						+" currentid="+currentid);
					}	

					btn1.insertBefore(input5,null);
					}

					var br = document.createElement("br");  
					btn1.insertBefore(br,null);  
							 
					}
				
	　　　　}catch(e){
				console.log("'你访问的页面出错了");
	　　　　　　//alert('你访问的页面出错了');
	　　　　};
	　　};
	};
	
	//console.log("curcnt="+curcnt);
	for (var i=0;i<cnt;i++)
	 {
		 //console.log("key="+s_keySearch.key_index[i]+
			//" key_name="+s_keySearch.key_name[i]);
	 }
	
}

var timeids = [];
function openPage(pageName,elmnt,color) 
{	
	//reqData(pageName);
	//console.log("page="+pageName);
	SetStyle(pageName,elmnt);
	
	for (var i=0; i<timeids.length; i++)
	{
		console.log("clearInterval id="+timeids[i]);
		clearInterval(timeids[i]);
	}
	
	timeids.length = 0;
	cnt = 0;
	reqDataBegin(pageName);
	var timeid = setInterval(_reqData(pageName),5000);
	timeids.push(timeid);
	
	var oStr = '';
	var postData = {};
	var oAjax = null;
	
	
}

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>
   

   
</body>
</html> 
