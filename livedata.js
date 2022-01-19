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

function Tag1Chg()
{
	var tag1=document.getElementById('tag1'); 
	var index = tag1.selectedIndex;
	var text = tag1.options[index].text; // 选中文本
	var value = tag1.options[index].value; // 选中值
	console.log("Tag1Chg text="+text+" value="+value);
	
	var oStr = '';
	var postData = {};
	var oAjax = null;
	//post提交的数据
	console.log("data info1");
	postData = {"cmd":"gettagdata","devname1":value};
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
				/*for(var i=0;i<json.result.tab.length;i++)
				{
					var tag1=document.getElementById('tag1'); 
					var tag2=document.getElementById('tag2'); 
					var tag3=document.getElementById('tag3'); 
					var tag4=document.getElementById('tag4'); 
					
					
					//console.log("tagid="+json.result.tab[i].tagid+" name="+json.result.tab[i].tagname);
					//tag1.options.add(new Option("select group name","-1"));
					if (json.result.tab[i].tagname && json.result.tab[i].tagname != "")
					{
						var tmpid = String(json.result.tab[i].chid) + "," + String(json.result.tab[i].tagid);
						tag1.options.add(new Option(String(json.result.tab[i].tagname),String(tmpid)));
						tag2.options.add(new Option(String(json.result.tab[i].tagname),String(tmpid)));
						tag3.options.add(new Option(String(json.result.tab[i].tagname),String(tmpid)));
						tag4.options.add(new Option(String(json.result.tab[i].tagname),String(tmpid)));
					}
				}*/
			}
			catch(e)
			{
				console.log("'你访问的页面出错了");
	　　　　};
		};
	}
}

function Tag2Chg()
{
	console.log("Tag2Chg");
}

function Tag3Chg()
{
	console.log("Tag3Chg");
}

function Tag4Chg()
{
	console.log("Tag4Chg");
}
