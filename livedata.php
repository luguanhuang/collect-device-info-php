
<script>

window.onload = function () 
{
//console.log(window.location.href)//此处会打印出当前页面的href值，为
	/*if (maintimeid > 0)
	{
		clearInterval(maintimeid);
	}
	
	var pageName = 1
	maintimeid = setInterval(_reqConnData(pageName),30000);*/
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
TLOG_MSG("livedata: func begin22 data=".$devname[0]." devname=".$devname[1]." devicedesc=".$_REQUEST['devicedesc']." templatelocation=".$_REQUEST['templatelocation']." data=".$_SERVER["QUERY_STRING"]);
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
<link type="text/css" rel="stylesheet" href="jquery.simple-dtpicker.css" />
<link type="text/css" rel="stylesheet" href="public.css" /> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="js/route.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>

</head>
<body style="text-align: left;background:#f6f6f6">
<button id="mainpage" name="mainpage" class="tablink" onclick="MainPage(this)"><?=$devname[1]?></button>
<button id="livetrend" name="livetrend" class="tablink" onclick="livetrend(this)">livetrend</button>
<button id="Historical" name="Historical" class="tablink" onclick="">Historical</button>
<button id="Alarm" name="Alarm" class="tablink" onclick="">Alarm</button>
<button id="Report" name="Report" class="tablink" onclick="ReportPage(this)">Report</button>

<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				
		?>
		
		<button id='<?=$devname[1]?><?=$row['ch']?>' name='<?=$row['ch']?>' class="tablink" onclick="openPage('<?=$row['ch']?>', this, 'red')"><?=$row['chdesc']?></button>
		
		
		
 <?php }
		}
		?>


<?php
		if (is_array($Ary_Result['result']['data'])){
			foreach($Ary_Result['result']['data'] as $k=>$row){
				
		?>
		
		<div style="text-align:left" id="<?=$row['ch']?>" class="tabcontent"></div>
		<h3></h3> 
		
 <?php }
	}
	?>

<?php
      require('footer.html');
      require('loadjs.html');
    ?>
	
	<div id="graph" class="div-levelWhole" style="display:none">
	<table align="left" cellpadding="0" cellspacing="0" border="0" class="tab">
		<tbody>
		 <tr>
		  <td colspan="2" style="padding: 0; border: 0;">
		   <table id="net" border="0">
		   <tr>
		   
		  
		<td class="t">tag name：</td>
		<td class="c">
		<select id="tag1" name="mainpagediv">
		<option value="-1">select tag name</option>
		
	
		</select>
		</td>
		</tr>
		
		<tr>
		   
		  
		<td class="t">tag name：</td>
		<td class="c">
		<select id="tag2" name="mainpagediv">
		<option value="-1">select tag name</option>
		
	
		</select>
		</td>
		</tr>
		
		<tr>
		   
		  
		<td class="t">tag name：</td>
		<td class="c">
		<select id="tag3" name="mainpagediv">
		<option value="-1">select tag name</option>
		
	
		</select>
		</td>
		</tr>
		
		<tr>
		   
		  
		<td class="t">tag name：</td>
		<td class="c">
		<select id="tag4" name="mainpagediv">
		<option value="-1">select tag name</option>
		
	
		</select>
		</td>
		</tr>
		
		
		
		</table>	
		</td>
        </tr> 
        
	  </tbody>
	  </table>
	  
	</div>
	
	
	
	<div id="box" class="div-levelWhole" style="display:none">
		
		<div id = "box-1" class="divOne" style="display:none">
			<img id="image1" class="Onediv-imgSize" src="images/booster1pic.png"/>
			<table border="0" align="right" cellpadding="0" cellspacing="0" class="listtab" style="width:60%;height:30px;">
		 <thead>
		
		  <tr>
			<td width='250px'>tagdesc</td>
			<td width='50px'>value</td>
			<td width='50px'>Action</td>
		 </tr>
		 
		 </thead>
		 <tbody>
		 <?php
		 for ($i=1; $i<9; $i++)
		 {
		?>
			 <tr  id="row1_<?=$i?>" style="display:none">
			 <td width='250px' id="desc1_<?=$i?>">11</td>
			 <td width='50px' id="value1_<?=$i?>">12</td>
			 <td width='50px' id="action1_<?=$i?>">13</td>
			 </tr>
		 <?php
		 }
		 ?>
		 
		 </tbody>
		 </table>
		</div>
		
		<div id = "box-2" class="divTwo" style="display:none">
			<img id="image2" class="Twodiv-imgSize" src="images/booster2pic.png"/>
			<table border="0" align="right" cellpadding="0" cellspacing="0" class="listtab" style="width:60%;height:30px;">
		 <thead>
		 <tr>
			<td width='250px'>tagdesc</td>
			<td width='50px'>value</td>
			<td width='50px'>Action</td>
		 </tr>
		 </thead>
		 <tbody>
		 <?php
		  for ($i=1; $i<9; $i++)
		 {
		?>
			 <tr align="center" id="row2_<?=$i?>" style="display:none">
			 <td width='250px' id="desc2_<?=$i?>"></td>
			 <td width='50px' id="value2_<?=$i?>"></td>
			 <td width='50px' id="action2_<?=$i?>"></td>
			 </tr>
		 <?php
		 }
		 ?>
		 </tbody>
		 </table>
		</div>
		
		<div id = "box-3" class="divThree" style="display:none">
			<img id="image3" class="Threediv-imgSize" src="images/booster3pic.png"/>
			<table border="0" align="right" cellpadding="0" cellspacing="0" class="listtab" style="width:60%;height:30px;">
		 <thead>
		  <tr>
			<td width='250px'>tagdesc</td>
			<td width='50px'>value</td>
			<td width='50px'>Action</td>
		 </tr>
		 </thead>
		 <tbody>
		  <?php
		 for ($i=1; $i<9; $i++)
		 {
		?>
			 <tr align="center" id="row3_<?=$i?>" style="display:none">
			 <td width='250px' id="desc3_<?=$i?>"></td>
			 <td width='50px' id="value3_<?=$i?>"></td>
			 <td width='50px' id="action3_<?=$i?>"></td>
			 </tr>
		 <?php
		 }
		 ?>
		 </tbody>
		 </table>
		</div>
		
		<div id = "box-4" class="divFour" style="display:none">
		<img id="image4" class="Fourdiv-imgSize" src="images/booster4pic.png"/>
		<table border="0" align="right" cellpadding="0" cellspacing="0" class="listtab" style="width:60%;height:30px;">
		 <thead>
		 <tr>
			<td width='250px'>tagdesc</td>
			<td width='50px'>value</td>
			<td width='50px'>Action</td>
		 </tr>
		 </thead>
		 <tbody>
		 <?php
		 for ($i=1; $i<9; $i++)
		 {
		?>
			 <tr  id="row4_<?=$i?>" style="display:none">
			 <td width='250px' id="desc4_<?=$i?>"></td>
			 <td width='50px' id="value4_<?=$i?>"></td>
			 <td width='50px' id="action4_<?=$i?>"></td>
			 </tr>
		 <?php
		 }
		 ?>
		 
		 </tbody>
		</table>
		
			
		</div>
	</div>
	
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
		
		
	
		
		<div id="ReportData" class="tabcontent">
				<div class="container">
      <br>
      <h3 align="center">Report List </h3>
      <br>
        <div class="panel panel-default">
          <div class="panel-heading">
            <form method="post">
              <div class="row">
                <div class="col-md-2">Download Report</div>
                <div class="col-md-2">
                  <input id="date_from" name="searchForm[date_from]" class="text" value="" title="Search date from" placeholder="Date from"> 
                </div>
                <div class="col-md-2">
                <input id="date_to" name="searchForm[date_to]" class="text" value="" title="Search date to" placeholder="Date to"> 
                </div>
                <div class="col-md-2">
                  <select id="report_type" name="report_type" class="form-control input-sm">
                    <option value="1">Daily report</option>
                    <option value="2">Hourly report</option>
                   <!-- <option value="3">monthly report/day</option> -->
                  </select>
                </div>
                <div class="col-md-2">
                  <select id="file_type" name="file_type" class="form-control input-sm">
                    <option value="Xlsx">Xlsx</option>
                    <option value="Xls">Xls</option>
                    <option value="Csv">Csv</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input name="export" class="btn btn-primary btn-sm" value="Export" onclick="exportlist()">
                </div>
              </div></form>
            
          
          <div class="panel-body">
          
          </div>
      </div></div>
     </div>


		</div>
		
		
	<script src="js/jquery-1.11.3.js"></script>
	<script src="js/public.js"></script>
	
	<script src="js/jquery.simple-dtpicker.js"></script>
	
	<script src="js/livedata.js"></script>
	
	<script>

var cnt = 0;

var date_from = "";
var date_to = "";
function exportlist()
{
       
		window.location.href="reportexport.php?action=exportlist&devname="+"<?=$devname[1]?>"+"&date_from="+$('#date_from').val()+"&date_to="+$('#date_to').val()+"&report_type="+$('#report_type').val()+"&file_type="+$('#file_type').val()+"&devicedesc="+"<?=$_REQUEST['devicedesc']?>"+"&templatelocation="+"<?=$_REQUEST['templatelocation']?>"; 
	//window.location.href="tcpdumpexport.php?<?=$devname[1]?>";
	
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
						var chgdata = document.getElementById("info_"+json.result.tab[i].tagid);
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							
							chgdata.innerHTML = String(json.result.tab[i].tagdata);
						}
						
						
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							
							if (json.result.tab[i].coiltype == 1)
							{
								if (json.result.tab[i].tagdata == 0)
									chgdata.style.background = "#FF0000";
								else
									chgdata.style.background = "#00FF00";
							}
							else
							{
								if (json.result.tab[i].tagdata == 1)
									chgdata.style.background = "#FF0000";
								else
									chgdata.style.background = "#00FF00";
							}
							
						}
						
						
					}
					else
					{
				
						var chgdata = document.getElementById("info_"+json.result.tab[i].tagid);
						
						if (!(!json.result.tab[i].tagdata && 
							typeof(json.result.tab[i].tagdata)!="undefined" 
							&& json.result.tab[i].tagdata!=0))
						{
							chgdata.innerHTML = String(json.result.tab[i].tagdata);
						}
						
						
					}
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
	//if (<?=$row['ch']?> != pageName)
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
  document.getElementById('box').style.display = "none";
   document.getElementById('graph').style.display = "none";
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


var clickdtype = 0;

function savedata()
{
	
	var key = document.getElementById('ids').value;
	var value = "";
	for (var i=0;i<cnt;i++)
	 {
		// console.log("key111="+s_keySearch.key_index[i]+
			//" key_name="+s_keySearch.key_name[i]+" key="+key);
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
	if (clickdtype == 1)
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


var timeids = [];
function ReportPage(elmnt) 
{
	for (var i=0; i<timeids.length; i++)
	{
		console.log("clearInterval id="+timeids[i]);
		clearInterval(timeids[i]);
	}
	
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
  
   document.getElementById('box').style.display = "none";
	 document.getElementById('graph').style.display = "none";
	
}


function setautoValue(tagid,dtype,pageName) 
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
	
	//document.getElementById('ids').value=String(pageName) + String(json.result.tab[i].tagid);
	document.getElementById('ids').value=String(pageName) + String(tagid);
	clickdtype = dtype;
	console.log("tagid="+tagid);
	
}

var maintimeid = 0;

function reqMainData(pageName)
{
	cnt = 0;
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	postData = {"cmd":"getmain","devname":"<?=$devname[1]?>"};
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
	oAjax.open('post','submitother.php?='+Math.random(),true);
	//post相比get方式提交多了个这个
	oAjax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//post发送数据
	oAjax.send(postData);
	oAjax.onreadystatechange = function()
	{
	　　//当状态为4的时候，执行以下操作
	　　if(oAjax.readyState == 4)
		{
			//console.log("mainpagelocation="+oAjax.responseText);
			json = JSON.parse(oAjax.responseText);
			var mainpagediv = 0;
			for(var i=0;i<json.result.data.length;i++)
			{
				//console.log("mainpagediv="+json.result.data[i].mainpagediv);
				mainpagediv = json.result.data[i].mainpagediv;
				//document.getElementById(json.result.data[i].ch).innerHTML = "";
			}
			
			for(var i=1;i<=mainpagediv;i++)
			{
				var id = "box-"+ String(i);
				var image = "image"+ String(i);
				document.getElementById(String(id)).style.display='block';
				if (1 == mainpagediv)
					document.getElementById(String(id)).className="divOneCenter";
				else if (2 == mainpagediv)
				{
					if (1 == i)
						document.getElementById(String(id)).className="divOneLeft";
				}
				
				
				if (1 == i)
				{
					
					if (1 == mainpagediv)
						document.getElementById(String(image)).className = "Onediv-imgSize-center";
					else if (2 == mainpagediv)
						document.getElementById(String(image)).className = "Onediv-imgSize-left";
					else if (3 == mainpagediv)
					{
						document.getElementById(String(id)).className="divOneCenterTop";
						document.getElementById(String(image)).className = "Onediv-imgSize-top";
					}
						
					document.getElementById(String(image)).src = String("images/"+json.result.data[0].pic1filelocation);
				}
				else if (2 == i)
				{
					if (2 == mainpagediv)
					{
						document.getElementById(String(id)).className="divTwoRight";
						document.getElementById(String(image)).className = "Twodiv-imgSize-Right";
					}
					else if (3 == mainpagediv)
					{
						document.getElementById(String(id)).className="divThree";
						document.getElementById(String(image)).className = "Threediv-imgSize";
						//document.getElementById(String(image)).className = "Twodiv-imgSize-Right";
					}
					document.getElementById(String(image)).src = String("images/"+json.result.data[0].pic2filelocation);
					console.log("pic2filelocation="+json.result.data[0].pic2filelocation + " image="+image);
					
				}
				else if (3 == i)
				{
					if (3 == mainpagediv)
					{
						document.getElementById(String(id)).className="divFour";
						document.getElementById(String(image)).className = "Fourdiv-imgSize";
					}
					document.getElementById(String(image)).src = String("images/"+json.result.data[0].pic3filelocation);
					console.log("pic3filelocation="+json.result.data[0].pic3filelocation + " image="+image);
				}
				else if (4 == i)
				{
					document.getElementById(String(image)).src = String("images/"+json.result.data[0].pic4filelocation);
					console.log("pic4filelocation="+json.result.data[0].pic4filelocation+ " image="+image);
				}
				
			}
			
			for(var i=0;i<json.result.tab.length;i++)
			{
				
				var dtype = 0;
				var tagid = 0;
				
				var funcode = 0;
				var countreg = 0;
				var slaveid = 0;
				
				for(var j=0;j<json.result.data.length;j++)
				{
					if (json.result.data[j].ch == json.result.tab[i].chid)
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
							
							countreg = Number(json.result.data[j].startreg)+Number(json.result.tab[i].tagid)-1;
							
							break;
					}
				}
				
				var currentid = '<?=$devname[1]?>';

				currentid += ",";
				currentid += String(json.result.tab[i].chid);
				
				currentid += ",";
				currentid += dtype;
				
				currentid += ",";
				currentid += slaveid;
				
				currentid += ",";
				currentid += funcode;
				
				currentid += ",";
				currentid += countreg;
				s_keySearch.key_name[cnt]=currentid;
				s_keySearch.key_index[cnt]= String(json.result.tab[i].chid) + String(json.result.tab[i].tagid);
				cnt++;
				var data = json.result.tab[i].mainpagelocation.split(",");
				//console.log("mainpagelocation="+json.result.tab[i].mainpagelocation+" tagdata="+json.result.tab[i].tagdata+" tagname="+json.result.tab[i].tagname+" tagdesc="+json.result.tab[i].tagdesc+" writeenable="+json.result.tab[i].writeenable);
				
				var id = "row"+data[0]+"_"+data[1];
				var desc = "desc"+data[0]+"_"+data[1];
				var value = "value"+data[0]+"_"+data[1];
				var action = "action"+data[0]+"_"+data[1];
				//console.log("1="+data[0]+" 2="+data[1]+" id1="+id);
				
				if (dtype == 1)
				{
					document.getElementById(String(id)).style = '';
					document.getElementById(String(desc)).innerHTML=String(json.result.tab[i].tagdesc);
					document.getElementById(String(desc)).style = "width:250px; height:25px";
					//document.getElementById(String(value)).innerHTML=String(json.result.tab[i].tagdata);
					if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							document.getElementById(String(value)).style = "width:50px; height:25px";
							if (json.result.tab[i].coiltype == 1)
							{
								if (json.result.tab[i].tagdata == 0)
									document.getElementById(String(value)).style.background = "#FF0000";
								else
									document.getElementById(String(value)).style.background = "#00FF00";
							}
							else
							{
								if (json.result.tab[i].tagdata == 1)
									document.getElementById(String(value)).style.background = "#FF0000";
								else
									document.getElementById(String(value)).style.background = "#00FF00";	
							}
							
							document.getElementById(String(value)).innerHTML = String(json.result.tab[i].tagdata);
						}
					
					
					
					if (json.result.tab[i].writeenable == 1)
					{
							document.getElementById(String(action)).innerHTML="<input type='button' class='btn' value='write'> ";
							document.getElementById(String(action)).style = "width:50px; height:25px";
							
								
							
							
							var alldata = String(json.result.tab[i].tagid) + ","+String(dtype) + ","+String(json.result.tab[i].chid);
							//console.log("alldata="+alldata);
							
							document.getElementById(String(action)).setAttribute("onclick", "javascript:setautoValue("+alldata+")");
							//document.getElementById(String(action)).style = "width:150px; height=25px";
					}
					else
					{
						document.getElementById(String(action)).innerHTML="";
					}
				}
				else
				{
					document.getElementById(String(id)).style = '';
					document.getElementById(String(desc)).innerHTML=String(json.result.tab[i].tagdesc);
					document.getElementById(String(desc)).style = "width:250px; height:25px";
					document.getElementById(String(value)).innerHTML=String(json.result.tab[i].tagdata);
					document.getElementById(String(value)).style = "width:50px; height:25px";
					if (json.result.tab[i].writeenable == 1)
					{
							document.getElementById(String(action)).innerHTML="<input type='button' class='btn' value='write'> ";
							document.getElementById(String(action)).style = "width:50px; height:25px";
							var alldata = String(json.result.tab[i].tagid) + ","+String(dtype) + ","+String(json.result.tab[i].chid);
							//console.log("alldata="+alldata);
							
							document.getElementById(String(action)).setAttribute("onclick", "javascript:setautoValue("+alldata+")");
							//document.getElementById(String(action)).style = "width:150px; height=25px";
					}
					else
					{
						document.getElementById(String(action)).innerHTML="";
					}
				}
				
				
			}
		}
	}	
}

function _reqMainData(pageName){
 
       return function(){
             reqMainData(pageName);
       }
}

function gettaginfo()
{	
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	console.log("data info");
	postData = {"cmd":"gettaginfo","devname":"<?=$devname[1]?>"};
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
	oAjax.open('post','submitgraph.php?='+Math.random(),true);
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
				for(var i=0;i<json.result.tab.length;i++)
				{
					var tag1=document.getElementById('tag1'); 
					var tag2=document.getElementById('tag2'); 
					var tag3=document.getElementById('tag3'); 
					var tag4=document.getElementById('tag4'); 
					
					
					console.log("tagid="+json.result.tab[i].tagid+" name="+json.result.tab[i].tagname);
					//tag1.options.add(new Option("select group name","-1"));
					if (json.result.tab[i].tagname && json.result.tab[i].tagname != "")
					{
						tag1.options.add(new Option(String(json.result.tab[i].tagname),String(json.result.tab[i].tagid)));
						tag2.options.add(new Option(String(json.result.tab[i].tagname),String(json.result.tab[i].tagid)));
						tag3.options.add(new Option(String(json.result.tab[i].tagname),String(json.result.tab[i].tagid)));
						tag4.options.add(new Option(String(json.result.tab[i].tagname),String(json.result.tab[i].tagid)));
					}
					
					/*tag2.options.add(new Option(json.result.tab[i].chid,
						json.result.tab[i].tagname);
					tag3.options.add(new Option(json.result.tab[i].chid,
						json.result.tab[i].tagname);
					tag4.options.add(new Option(json.result.tab[i].chid,
						json.result.tab[i].tagname);*/



					
				}
				//console.log("data info"+json.message);
				//$_C.exit();$_C.Alert(json.message,null);
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


function livetrend(elmnt) 
{
	for (var i=0; i<timeids.length; i++)
	{
		console.log("clearInterval id="+timeids[i]);
		clearInterval(timeids[i]);
	}
	
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

  document.getElementById('box').style.display = "none";
   document.getElementById('graph').style.display = "block";
  elmnt.style.backgroundColor = '#008880';
  if (maintimeid > 0)
	{
		clearInterval(maintimeid);
		maintimeid = 0;
	}
  
	gettaginfo();
}

function MainPage(elmnt) 
{
	for (var i=0; i<timeids.length; i++)
	{
		console.log("clearInterval id="+timeids[i]);
		clearInterval(timeids[i]);
	}
	
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

  document.getElementById('box').style.display = "block";
   document.getElementById('graph').style.display = "none";
  elmnt.style.backgroundColor = '#008880';
	if (maintimeid > 0)
	{
		clearInterval(maintimeid);
	}
	
	var pageName = 1;
	reqMainData(pageName);
	maintimeid = setInterval(_reqMainData(pageName),5000);
	
}

function reqDataBegin(pageName) 
{
	var btn1 = document.getElementById(pageName);
	
	//console.log("nametmp="+nametmp);
	
	console.log("reqDataBegin pageName11="+pageName);
	cnt = 0;
	
	var oStr = '';
	var write = 0;
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
				var mycars = new Array();
				mycars[0] = "ID";
				mycars[1] = "Tag Name(Tag Description)";
				mycars[2] = "Data";
				mycars[3] = "Action";
				
				
				var table = document.createElement("table");
				
				table.setAttribute("border", "0");
				table.setAttribute("align", "left");
				table.setAttribute("cellpadding", "0");
				table.setAttribute("cellspacing", "0");
			//	table.setAttribute("width", "50%");
				table.setAttribute('style', 'width:40%; height=30px');
				table.setAttribute("class", "listtab");
					 btn1.appendChild(table);   
				
				var tableright = document.createElement("table");
				
				tableright.setAttribute("border", "0");
				tableright.setAttribute("align", "right");
				tableright.setAttribute("cellpadding", "0");
				tableright.setAttribute("cellspacing", "0");
			//	table1.setAttribute("width", "50%");
				tableright.setAttribute('style', 'width:40%; height:30px');
				tableright.setAttribute("class", "listtab");
					 btn1.appendChild(tableright);   
				
				
				var thead = table.createTHead();
				var tbody = table.createTBody();
				var tr = document.createElement("tr");
				for (var i = 0; i < 4; i++) {
					th = document.createElement("td");
					th.setAttribute('style', 'color:fff; background:#008880;');
					th.innerHTML = mycars[i];
					tr.appendChild(th);
				}
				
				thead.appendChild(tr);
				
				var theadright = tableright.createTHead();
				var tbody1 = table.createTBody();
				var tr = document.createElement("tr");
				for (var i = 0; i < 4; i++) {
					th = document.createElement("td");
					th.setAttribute('style', 'color:fff; background:#008880;');
					th.innerHTML = mycars[i];
					tr.appendChild(th);
				}
				
				theadright.appendChild(tr);
				
				var dtype = 0;
				var slaveid = 0;
				
				var funcode = 0;
				var countreg = 0;
				var tagid = 0;
				for(var i=0;i<json.result.tab.length;i++)
				{
					var currentid = '<?=$devname[1]?>';
					currentid += ",";
					currentid += pageName;
					
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
							
							
							countreg = Number(json.result.data[j].startreg)+Number(json.result.tab[i].tagid)-1;
							//console.log("startreg="+json.result.data[j].startreg+" tagid="+json.result.tab[i].tagid+" countreg="+countreg);
							tagid = json.result.tab[i].tagid;
							
							break;
						}
					}
					
					var currentid = '<?=$devname[1]?>';

					currentid += ",";
					currentid += pageName;
					
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
						var tr = document.createElement("tr");
						td = document.createElement("td");
						td.setAttribute('style', 'width:30px; height=25px');
						td.innerHTML = String(json.result.tab[i].tagid);
						tr.appendChild(td);
						
						td = document.createElement("td");
						td.setAttribute('style', 'width:350px; height=25px');
						
						td.innerHTML = String(json.result.tab[i].tagname) + "("+String(json.result.tab[i].tagdesc+")");
						tr.appendChild(td);
						
						td = document.createElement("td");
						td.setAttribute('id', "info_"+String(json.result.tab[i].tagid));
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							td.innerHTML = String(json.result.tab[i].tagdata);
							
							if (json.result.tab[i].coiltype == 1)
							{
								if (json.result.tab[i].tagdata == 0)
									td.style.background = "#FF0000";
								else
									td.style.background = "#00FF00";
							}
							else
							{
								if (json.result.tab[i].tagdata == 1)
									td.style.background = "#FF0000";
								else
									td.style.background = "#00FF00";	
							}
							
						}
						
						
						td.setAttribute('style', 'width:80px; height=25px');
						tr.appendChild(td);
						
						var td1 = document.createElement("td");
						td1.setAttribute('style', 'width:80px; height=25px');
						
					
						
						
						if (json.result.tab[i].writeenable == 1)
						{
							td1.innerHTML = "<input type='button' class='btn' value='write'> ";
							 td1.value="1";
							tagid = String(json.result.tab[i].tagid);
							//var alldata = String(json.result.tab[i].tagid) + ",";
							var alldata = String(json.result.tab[i].tagid) + ","+String(dtype) + ","+String(pageName);
							console.log("alldata="+alldata);
							//td1.setAttribute("onclick", "javascript:setautoValue("+tagid+","+pageName+","+dtype")");
							td1.setAttribute("onclick", "javascript:setautoValue("+alldata+")");
							
							
							
							
						}
							
						else
								td1.innerHTML = "";
						
						
						tr.appendChild(td1);
						
						//thead.appendChild(tr);
						if (i >= 0 && i < json.result.tab.length/2)
						{
							thead.appendChild(tr);
						}
						else 
							theadright.appendChild(tr);
					}
					else
					{
						var tr = document.createElement("tr");
						td = document.createElement("td");
						td.innerHTML = String(json.result.tab[i].tagid);
						td.setAttribute('style', 'width:30px; height=25px');
						tr.appendChild(td);
						
						td = document.createElement("td");
						td.innerHTML = String(json.result.tab[i].tagname) + "("+String(json.result.tab[i].tagdesc+")");
						td.setAttribute('style', 'width:350px; height=25px');
						tr.appendChild(td);
						
						td = document.createElement("td");
						if (!(!json.result.tab[i].tagdata && 
						typeof(json.result.tab[i].tagdata)!="undefined" 
						&& json.result.tab[i].tagdata!=0))
						{
							td.innerHTML = String(json.result.tab[i].tagdata);
						}
						td.setAttribute('style', 'width:80px; height=25px');
						td.setAttribute('id', "info_"+String(json.result.tab[i].tagid));
						
						tr.appendChild(td);
						
						td = document.createElement("td");
						td.setAttribute('style', 'width:80px; height=25px');
						if (json.result.tab[i].writeenable == 1)
						{
							td.innerHTML = "<input type='button' class='btn' value='write'> ";
							
							tagid = String(json.result.tab[i].tagid);
							var alldata = String(json.result.tab[i].tagid) + ","+String(dtype) + ","+String(pageName);
							console.log("alldata="+alldata);
							
							td.setAttribute("onclick", "javascript:setautoValue("+alldata+")");
							
						}
							
						else
								td.innerHTML = "";
						
						
						
						tr.appendChild(td);
						
						//thead.appendChild(tr);
						if (i >= 0 && i < json.result.tab.length/2)
						{
							thead.appendChild(tr);
						}
						else 
							theadright.appendChild(tr);
						
					}
					
					s_keySearch.key_name[cnt]=currentid;
					s_keySearch.key_index[cnt]= String(pageName) + String(json.result.tab[i].tagid);
					cnt++;
							 
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

$('#date_from').appendDtpicker({
	"closeOnSelected": true,
        "current": "",
        "autodateOnStart": false,
       // "futureOnly": true,
        "minuteInterval": 5
	}); 
$('#date_to').appendDtpicker({
	"closeOnSelected": true,
        "autodateOnStart": false,
       // "futureOnly": true,
        "minuteInterval": 5
	}); 

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>
   

   
</body>
</html> 