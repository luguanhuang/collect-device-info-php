// JavaScript Document

//1/实用函数扩展, 2/封装DOM常用函数,3/表单函数扩展,4/实用页面特效

var $_G = new function (){
	
	//__________________  构造/析构函数  ________________
	
	function __construct(){}
	function __destruct(){}
	
	//__________________  私有变量  ________________
	
	var $error	= null,	$this	= this,	$Error	= "",	$Etext	= "";	//切换Tag时已选中的记录
	var $Etag	= null,	$Ctag	= [],	$Ebas	= 0,	$Clen	= 0;	//getvalue时选中的有效控件
	var $Agent	= null;	
	
	var $Ctr= /^(select)|(textarea)|(input)|(radio)|(checkbox)$/i
	var $R	= new Array();
		$R["az09"]	= /^[\w_]+$/;																		//0-9a-zA-Z_
		$R["d"]		= /^[0-9]+$/;																		//0-9
		$R["w"]		= /^[a-zA-Z]+$/;																	//a-zA-Z
		$R["dw"]	= /^[0-9a-zA-Z]+$/;																	//0-9a-zA-Z
		$R["pass"]	= /^[\~\!\@\%\^\*\(\)\_\+\-\=\\\\\{\}\[\]\;\:\,\.\?\/a-zA-Z0-9]+$/;					//密码
		$R["email"]	= /^[-_a-zA-Z0-9.]+@([-_a-zA-Z0-9]+\.)+[a-zA-Z0-9]{2,3}$/;							//邮箱
		$R["real"]	= /^(0|[\-\+]?([1-9][0-9]*(\.[0-9]+)?|0\.[0-9]+))$/;								//实数
		$R["int"]	= /^(0|[\-\+]?[1-9][0-9]*)$/;														//整数
		$R[">0"]	= /^[1-9][0-9]*$/;																	//正整数
		$R["<0"]	= /^\-[1-9][0-9]*$/;																//负整数
		$R["<=0"]	= /^(0|\-[1-9][0-9]*)$/;															//非正数
		$R[">=0"]	= /^(0|[1-9][0-9]*)$/;																//非负数
		$R["<>0"]	= /^([1-9][0-9]*|\-[1-9][0-9]*)$/;													//不等于0
		$R["phone"]	= /^(\+[1-9]\d{0,3}\-[1-9]\d{1,2}\-?|(0{1,2}[1-9]\d{1,2}\-0?|0)[1-9]\d{1,2}\-?)?[1-9]\d{6,7}(\-[1-9]\d{0,4})?$/;																										//电话号码
		$R["handset"]	= /^(\+[1-9]\d{0,3}\-?|0(0?[1-9]\d{1,2}\-?)?)?1[35]\d{9}$/;						//手机号码
		$R["sql"]		= /^[^\<\>\'\"\&\`]+$/;															//SQL符号
		$R["html"]		= /([\<\>\'\"\#\&\|])/gi;														//HTML字符
		$R["html-"]		= /([\<\>\'\"\&])/gi;															 //宽松HTML字符
		$R["point"]		= /([\ \`\~\!\@\#\$\%\^\&\*\(\)\_\+\|\-\=\\\{\}\[\]\:\\\"\;\'\<\>\?\,\.\/])/gi;	//全符号
		$R["regexp"]	= /([\^\$\*\?\!\|\<\>\(\)\[\]\{\}\\\\\/\-\+\=\,\.\;])/gi;						//正则表达字符
		$R["file"]		= /^[^\/\\\<\|\>\"\?\:\*\'\&\#]+$/;												//文件名
		$R["path"]		= /^[A-Za-z]\:\\([^\\\/\<\>\|\*\:\?\"\'\&\#]\\?)*$/;							//本地路径
		$R["url"]		= /^(\/|((http\:\/)?\/)?([^\\\/\<\>\|\*\:\?\"\'\s]\/?)+([\?\#][^\s\"\']*)?|[\#\?][^\s\"\']*)$/;
		$R["ip"]		= /^((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})$/;
		$R["varphp"]	= /^\$[a-zA-Z_][a-zA-Z0-9_]{0,243}$/;
		$R["varjs"]		= /^\$?[a-zA-Z_][a-zA-Z0-9_\$]{0,243}$/;
		$R["varvb"]		= /^[a-zA-Z][a-zA-Z0-9_\$]{0,244}$/;
		$R["func"]		= /^\s*(function\s+)?([^\(\ ]*)[\s\S]*$/gi;
	
	//__________________  只读属性  ________________
	
	this.version	= function (){return '3.7';}				//版本
	this.build		= function (){return '11.09.24';}			//版本
	this.create		= function (){return '09.07.26';}			//创建
	this.classname	= function (){return "ODFFunc";}			//名称
	this.developer	= function (){return "OldFour";}			//开发者
	this.copyright	= function (){return "www.oldfour.com";}	//公司
	
	//__________________  只读属性  ________________
	
	this.Errno		= function (){return $Error;}
	this.Error		= function (){return $Etext;}
	//__________________  可读写属性  ________________
	
	this.Form		= null;
	this.Element	= [];
	this.Coexist	= [];

	//__________________  公有方法  ________________
	
	//+++++++++++++++++++++++++  系统函数  +++++++++++++++++++++++++
	
	this.seterror = function ($int){$int = this.intval($int); $Ebas = $int<0 ? 0 : $int;}
	
	//+++++++++++++++++++++++++  判断型函数  +++++++++++++++++++++++++

	this.isdefined	= function ($v){return ($v=this.trim($v))==""?false:typeof(window[$v])!='undefined';}//是否为undefined
	this.isnull		= function ($v){return $v===null}									//是否为null
	this.isvoid		= function ($v){return $v!=="0" && !$v;}							//是否为false(字符“0”为真)
	this.isempty	= function ($v){return this.trim($v)=="";}							//是否为0长度字符
	
	this.isstring	= function ($b){return typeof($b)=="string";}						//是否为字符
	this.isboolean	= function ($b){return typeof($b)=="boolean";}						//是否是布尔值
	this.isnumber	= function ($b){return typeof($b)=="number";}						//是否是数字
	this.isobject	= function ($b){return typeof($b)=="object" && $b!=null;}			//是否是对象
	this.isregexp	= function ($b){													//是否是正则对象
		return $b!=null && (Object.prototype.toString.call($b) === '[object RegExp]');
	}
	this.isarray	= function ($b){														//是否是数组
		return $b!=null && (Object.prototype.toString.call($b) === '[object Array]');
	}
	this.isfunction = function ($f){														//是否是函数
		var $type = typeof($f);
		if ($type=="function"){return $f;} else if($type!="string"){return false;}
		$f = this.trim($f.replace($R["func"],"$2"));
		if ($f==""){return false;}
		try{ $f=eval($f); return typeof($f)=="function" ? $f : false;}catch($error){return false;}
	}
	this.isnumeric	= function ($b){return $R["real"].test($b);}							//是否是数字表达式
	this.isdatetime = function($f,$d){												//是否是时间日期表达式
		if ($d==null){$d=$f; $f="";}
		if (($d=this.trim($d))==""){return false;}
		$f = !this.isarray($f) ? this.strval($f,1).replace(/(^date\()|(\))$/i,"") : $f.join("|").toLowerCase()
		var $r = [];
			$r["y"]				= ["([1-9][0-9]*)",'yyyy'];
			$r["m"]				= ["(1[0-2]|0?[1-9])",'mm'];
			$r["d"]				= ["(3[0-1]|[1-2][0-9]|0?[1-9])",'dd'];
			$r["h"]				= ["(2[0-3]|[0-1]?[0-9])",'hh'];
			$r["i"]				= ["([0-5]?[0-9])",'ii'];
			$r["s"]				= ["([0-5]?[0-9])",'ss'];
			$r["h:i"]			= [$r["h"][0]+"\\:"+$r["i"][0],'hh:ii'];
			$r["i:s"]			= [$r["i"][0]+"\\:"+$r["s"][0],'ii:ss'];
			$r["h:i:s"]			= [$r["h:i"][0]+"\\:"+$r["s"][0],'hh:ii:ss'];
			$r["time"]			= $r["h:i:s"];
			$r["3"]				= $r["h:i:s"];
			$r["y-m"]			= [$r["y"][0]+"\\-"+$r["m"][0],'yyyy-mm'];
			$r["y-m-d"]			= [$r["y-m"][0]+"\\-"+$r["d"][0],'yyyy-mm-dd'];
			$r['date']			= $r["y-m-d"];
			$r["2"]				= $r["y-m-d"];
			$r["y-m-d h:i"]		= [$r["y-m-d"][0]+"\\ "+$r["h:i"][0],'yyyy-mm-dd hh:ii'];
			$r["y-m-d h:i:s"]	= [$r["y-m-d"][0]+"\\ "+$r["h:i:s"][0],'yyyy-mm-dd hh:ii:ss'];
			$r['datetime']		= $r["y-m-d h:i:s"];
			$r['full']			= $r["y-m-d h:i:s"];
			$r['1']				= $r["y-m-d h:i:s"];
		var $fm=[], $re=[], $rl=[], $x=0, $y=0, $hd=-1, $dt=[];
		if (("|"+$f+"|").indexOf("||")==-1){$fm=$f.split("|");}else{$fm=["1","2","3","y-m-d h:i","y-m","h:i","i:s"];}
		for($x=0;$x<$fm.length;$x++){
			if (typeof($r[$fm[$x]])=="undefined" || $r[$fm[$x]][0] in $rl ){}
			$rl[$y]=$r[$fm[$x]][0]; $re[$y]=$r[$fm[$x]][1]; $y++;
		}
		if (!$y){ $rl[$y]=$r['1'][0]; $re[$y]=$r['1'][1]; }	//没有一个匹配的
		var $result = (new RegExp("^("+ ($rl.join("|")) +")$","gi")).test($d);
		if (!$result){$Error=10; $Etext = "格式必须是："+$re.join(", ");}
		else{
			$dt = $d.replace(/(\ .+)?$/,"").split("-"); $dt[1] = parseInt($dt[1]); $dt[2]=parseInt($dt[2]);
			if ($dt.length>2 && $rl.join("").indexOf("-")!=-1){
				if ($dt[1]<0 || $dt[1]>12 || $dt[2]<0 || $dt[2]>31){$result = false;}
				else if (($dt[1]==4 || $dt[1]==6 || $dt[1]==9 || $dt[1]==11) && $dt[2]>30){$result = false;}
				else if ( $dt[1]==2 && ($dt[2]>29 || ( !($dt[0]%400!=0||($dt[0]%100!=0&&$dt[0]%4==0)) && $dt[2]>28 )) ){$result=false;}
				if (!$result){ $Error=11; $Etext = "日期部分的表示式错误"; }
			}
		}
		return $result;
	}
	
	//+++++++++++++++++++++++++  字符串/数字 扩展函数  +++++++++++++++++++++++++	

	//转换为字符串
	this.strval = function ($s,$c){
		$s = ($s==null || $s===false) ? "" : new String($s).toString();
		if ($c==1){return $s.toLowerCase();} else if($c==2){return $s.toUpperCase();}else{return $s;}
	}
	//去掉空格
	this.trim = function ($s,$c){
		return this.strval($s,$c).replace(/(^[\s\　]+)|([\s\　]+$)/i,"");
	}
	//格式化连续字符串
	this.concat = function ($str,$slt,$int){
		if (($str=this.strval($str))==""){return "";}
		
		$slt = this.strval($slt);								//转换字符
		$slt = $slt=="" ? "," : $slt.substring(0,1);			//只取第一个
		if (!$R["point"].test($slt) && $slt!=" "){$slt=","}	//只能是符号或空格
		
		$str = $str.replace((new RegExp("(\\s*\\"+ $slt +"\\s*)+","ig")),$slt);
		$str = $str.replace((new RegExp("(^(\\"+ $slt +")+)|((\\"+ $slt +")+$)","ig")),"");
			
		$int = this.intval($int);
		if ($int>=0){
			if($int>0){$str = $str.replace((new RegExp("(^|\\"+$slt+")0+([1-9][0-9]*|0)","g")),"$1$2",$str);}
			if(!(new RegExp("^((([1-9][0-9]*)|0)(\\"+$slt+"))*(([1-9][0-9]*)|0)$","i")).test($str)){return "";}
			if($int>0){if ((new RegExp("^(0\\"+$slt+")*0$","i")).test($str)){return "";}}
		}
		return $str;
	}
	//转换为数字
	this.intval = function ($v){
		if ($v==null){return 0;} else if($v===true){return 1;}
		return /^[-+]?([1-9]\d*|0)(\.\d+)?$/.test($v) ? parseInt($v) : 0;
	}
	//生成随机数字
	this.random = function($l){
		$l = this.between($l,0,16);
		if (!$l){
			var $d = new Date();
			return (($d.getHours()*60+$d.getMinutes())*60+$d.getSeconds())*1000+$d.getMilliseconds();
		}
		var $i=0,$c=[], $mx = "", $mi="";
		for ($i=0;$i<$l;$i++){$c[$i]="9";}
		$mx = $c.join(""); $mi = parseInt("1"+($mx.replace(/9/g,"0").substring(1)));
		return parseInt(Math.random()*($mx-$mi))+$mi;
	}
	//介于最大值和最小值之间
	this.between = function ($v,$mi,$mx){
		$v  = this.intval($v);
		var $a = arguments.length;
		if($a<=1){return $v;}else if($a==2){return this.intval($mi);} //1参数：返回本身;2参数：返回指定值
		$mi = this.isnull($mi) ? Number.NEGATIVE_INFINITY : this.intval($mi);
		$mx = this.isnull($mx) ? Number.POSITIVE_INFINITY : this.intval($mx);
		if ($mi>$mx){var $t = $mi; $mi = $mx; $mx = $t;}
		if ($v<$mi){return $mi;} else if ($v>$mx){return $mx;} else{return $v;}
	}
	//格式化数字
	this.formatnumber = function ($v,$p){
		if (!$R["real"].test($v)){return 0;}
		if (!($p=parseInt($p))){return Math.floor($v);}
		var $i,$s="", $a = $v.toString().split(".");
		if ($a[1]==null){$a[1]="";}
		if ($a[1].length>=$p){return $a[0]+"."+$a[1].substring(0,$p);}
		for ($i=0;$i<$p-$a[1].length;$i++){$s+="0";}
		return ($a[0]+"."+$a[1]+$s)*1;
	}
	
	//+++++++++++++++++++++++++  数组相关函数  +++++++++++++++++++++++++
	
	this.toarray = function ($a,$r){
		if ($a==null){return null;}
		var $t=this.isarray($a)? "array" : typeof($a),$rs=[],$el,$i=0;
		if ($t=="object" && $a.nodeName && $a.nodeName.toLowerCase()=="form"){
			//key,长度,名称,父节点,tagName,type,节点下标，json元素下标,节点，json
			var $el,$ln,$ne,$p,$tg,$tp,$u,$c,$e;
			for ($el in $a.elements){
				$e	= $a.elements[$el];
				$ln	= $e.length;
				if ($ln && typeof($e[0])=="undefined"){ continue; }
				$ne	= $ln ? $e[0].name : $e.name;
				if ($ne==null || $ne=="" || $ne in $rs){ continue; }
				if ($ln && $e[0].nodeName && $e[0].nodeName.toUpperCase()=='OPTION'){
					$p = $e[0];
					while($p=$p.parentNode){
						$tg = !$p.nodeName ? null : $p.nodeName.toUpperCase();
						if (!$tg || $tg=="BODY"){ break; } if ($tg=="SELECT"){ $rs[$ne]=$p.value; break; }
					}
					continue;
				}
				if (!$ln){ $e = [$e]; }
				$rs[$ne] = []; $u = 0; $c = $e.length;
				for($i=0;$i<$c;$i++){
					$tg = $e[$i].nodeName.toUpperCase();
					if ($tg=="INPUT"){
						$tp = $e[$i].type.toUpperCase();
						if ($tp=="RADIO" || $tp=="CHECKBOX"){ if($e[$i].checked){$rs[$ne][$u]=$e[$i].value;$u++;} continue;}
					}
					$rs[$ne][$u]=$e[$i].value;$u++;
				}
				if (!$u){ $rs[$ne] = null; } else if (!$ln){$rs[$ne] = $rs[$ne][0]; }
			}
			//不需要重置下标
			if (!$r){ return $rs; }
			$a=[]; $i=0; for($el in $rs){$a[$i]=$rs[$el];$i++;} return $a;
		}
		if ($t=="array" || $t=="object"){
			if ($r){for($el in $a){$rs[$i]=$a[$el];$i++;}}							//重置下标
			else{ if($t=="array"){$rs=$a;}else{for($el in $a){$rs[$el]=$a[$el];}} }	//保留下标
			return $rs;
		}
		return this.strval($a).split(this.strval($r));
	}
	this.inarray = function ($a,$v,$c){
		if (!this.isarray($a)){return false;}
		if (typeof($v)!="string" || arguments.length<3){$c=true;}	//要区分大小写
		if (typeof($v)=="string" && !$c){$v=$v.toLowerCase();}
		if ($c){ for($el in $a){ if($a[$el].toLowerCase()==$v){return $el.toString();} }}
		if (!$c){for($el in $a){ if($a[$el]===$v){return $el.toString();} }}
		return "";
	}
	this.arykeys = function ($a){
		if (!this.isarray($a)){return [];}
		var $r=[],$el,$i=0; for ($el in $a){$r[$i]=$el;$i++} return $r;
	}
	this.aryvalues = function ($a){
		if (!this.isarray($a)){return [];}
		var $r=[],$el,$i=0; for ($el in $a){$r[$i]=$a[$el];$i++} return $r;
	}
	this.aryjoin = function ($a,$s){
		if (arguments.length==1){$s=","}
		return (this.aryvalues($a)).join(this.strval($s));
	}
	this.aryfill = function ($s,$l,$v){
		$s  = this.intval($s); if ($s<0){$s=0;}
		$l = this.intval($l); if ($l<1){return [];}
		var $r=[],$i=0; for (var $i=$s;$i<$s+$l;$i++){$r[$i]=$v;} return $r;
	}
	this.arypath = function (){
		var $a=arguments[0],$p=[],$x=1,$y=0,$v="",$e=null,$i=0;
		if (!$a || (!this.isarray($a) && typeof($a)!="object")){ return false; }
		for($x=1;$i<arguments.length;$x++){if (($v=this.trim(arguments[$x]))!=""){$p[$y]=$v; $y++;}}
		if (!$y){ return false; }
		$p=$p.join("/").split("/"); $e=$a;
		while($i<$p.length){$e=$e[$p[$i]];$i++;if(typeof($e)=="undefined"){return false;}}
		return true;
	}
	this.aryexists = function (){
		var $i=1,$k='',$a=arguments[0];
		if (!$a || (!this.isarray($a) && typeof($a)!="object")){ return false; }
		for($i=1;$i<arguments.length;$i++){ $k=this.strval(arguments[$i]); if($k==""||!($k in $a)){return false;}}
		return true;
	}
	
	//+++++++++++++++++++++++++  时间相关函数  +++++++++++++++++++++++++
	
	//计算某一月的天数
	this.monthdays = function ($year,$month,$obj,$n){
		if (!this.isdatetime("y-m",$year+"-"+$month)){return false;}
		var $startday =1,$endday;
		$year	= parseInt($year);
		$month	= parseInt($month);
		if ($month == 4 || $month == 6 || $month == 9 || $month == 11){$endday = 30;}
		else if ($month != 2){$endday=31;}
		else { $endday = $year%400 == 0 || ($year%100 != 0 && $year%4 == 0) ? 29 : 28; }
		var $opt = this.getelement($obj);
		if ($opt.length == null || $opt.nodename!="SELECT"){return $endday;}
		$n = !$n ? 0 : parseInt($n);
		var $obj = $opt.node;
		$obj.options.length = $n;	//clear options;
		for ($i=$startday;$i<$endday+1;$i++){$obj.options[$n+$i-1] = new Option($i+unescape("%u65E5"),$i);}
		return $endday;
	}
	//将datetime字符串转换为stamp
	this.dtstamp = function ($dt){
		var $d = new Date();
		if (($dt=this.strval($dt))==""){return ($d.getTime())/1000;}
		var $par	= $dt.split(" ");
		var $dtm	= new Array();
		if ($par.length==2){$dtm[0]=$par[0].split("-"); $dtm[1]=$par[1].split(":");}
		else if ($dt.indexOf(":")!=-1){$dtm[0]=[$d.getYear(),$d.getMonth(),$d.getDate()]; $dtm[1]=$par[0].split(":");}
		else{$dtm[0] = $par[0].split("-");$dtm[1]=[0,0,0];}
		if ($dtm[0][1]==null){$dtm[0][1]=1;} if ($dtm[0][2]==null){$dtm[0][2]=1;}
		if ($dtm[1][1]==null){$dtm[1][1]=0;} if ($dtm[1][2]==null){$dtm[1][2]=0;}
		var $dtime = $dtm[0].join("-")+" "+$dtm[1].join(":");
		if (!this.isdatetime("y-m-d h:i:s",$dtime) ){return 0;}
		return ((new Date($dtm[0][0],$dtm[0][1]-1,$dtm[0][2],$dtm[1][0],$dtm[1][1],$dtm[1][2])).getTime())/1000;
	}
	//时间比较大小
	this.dtcmp = function($date1,$cmp,$date2){
		$date1	= this.dtstamp($date1);
		$date2	= this.dtstamp($date2);
		$cmp	= this.trim($cmp);
		switch($cmp){
			case "=":; case "==": return $date1=$date2;
			case ">": return $date1>$date2; case ">=": return $date1>=$date2;
			case "<": return $date1<$date2; case "<=": return $date1<=$date2;
			default	: return $date1>$date2;
		}
	}
	//时间增减
	this.dtadd = function ($date,$add,$unit,$fm){
		var $d	= new Date(); $d.setTime(this.dtstamp($date)*1000);
		var $v	= {y:$d.getFullYear(),m:$d.getMonth(),d:$d.getDate(),h:$d.getHours(),i:$d.getMinutes(),s:$d.getSeconds()};
		$add	= this.intval($add);
		$unit	= this.trim($unit,1).substring(0,1);
		$fm		= this.trim($fm,1);
		if ($add){
			if ($v[$unit]==null){$unit="s";} $v[$unit]+=$add;
			$d	=new Date($v.y,$v.m,$v.d,$v.h,$v.i,$v.s);
			$v ={y:$d.getFullYear(),m:$d.getMonth(),d:$d.getDate(),h:$d.getHours(),i:$d.getMinutes(),s:$d.getSeconds()};
		}
		switch($fm){
			case "y"	:; case "m":; case "d":; case "h":; case "i": ; case "d": return $v[$fm];
			case "y-m"	: return $v.y+"-"+$v.m;	case "y-m-d": return $v.y+"-"+$v.m+"-"+$v.d;
			case "h:i"	: return $v.h+":"+$v.i; case "h:i:s": return $v.h+":"+$v.i+":"+$v.s;
			case "^s"	: ;
			case "y-m-d h:i" : return $v.y+"-"+$v.m+"-"+$v.d+" "+$v.h+":"+$v.i;
			case "l"	:;
			case "y-m-d h:i:s" : return $v.y+"-"+$v.m+"-"+$v.d+" "+$v.h+":"+$v.i+":"+$v.s;
			case "w"	: return $d.getDay();			case "ms"	: return $d.getTime();
			case "stamp": return $d.getTime()/1000;		case "local": return $d.toLocaleString();
			default		: return $d.toUTCString();
		}
	}
	//当前的时间戳记
	this.stamp = function(){return Math.round((new Date().getTime())/1000); }
	//当天的秒数
	this.time = function(){return Math.round(this.random(0)/1000);}
	//当天的毫秒数
	this.mtime = function(){return this.random(0);}
	
	
	//+++++++++++++++++++++++++  表单操作函数  +++++++++++++++++++++++++
	
	//是否选择了(如果是select控件，必须是允许选择多项的才有效)
	this.isselect = function ($b){
		if (!this.getValue($b,[])){return false;}
		return !$Clen ? false : true;
	}
	
	//异同比较
	this.valuecmp = function (){
		var $args = null;
		var $alen = arguments.length;
		if ($alen>2){
			var $x,$y=0;$args=[];
			for ($x=1;$x<arguments.lenght;$x++){$args[$y]=arguments[$x];$y++}
		}
		else if ($alen==2){
			$args = ["==",arguments[0],arguments[1]];
		}
		else{
			$args = !$alen ? null : arguments[0];
			if (!this.isarray($args) || $args.length<3){return -1;}
		}
		var $i,$tmp,$case=$args[0];
		if ($case){//大小写区分
			$tmp = this.getvalue($args[2]);
			for ($i=3;$i<$args.length;$i++){if(this.getvalue($args[$i])!=$tmp){return 1;}}
			return 0;
		}
		for ($i=3;$i<$args.length;$i++){
			$tmp = this.getvalue($args[2]).toLowerCase();
			if (this.getvalue($args[$i-1]).toLowerCase()!=$tmp){return 2;}
		}
		return 0;
	}
	
	//综合验证
	this.validate = function($obj,$name,$min,$max,$rule){
		//兼容旧模式
		if ( ($name==null) || ( $R[">=0"].test($name) && typeof($max)=="string") ){
			var $tmp=$max; $max=this.intval($min) ; $min=this.strval($name); $name=this.strval($tmp);
		}
		else{
			$min = this.intval($min); $max = this.intval($max); $name = this.strval($name);
		}
		var $type = typeof($rule);
		if (this.isarray($rule)){$type="array";}else if(this.isregexp($rule)){$type="regexp";}
		
		var $elm= this.getelement($obj,true);
		if ($elm.length==null)	{return $min ? new Array(1,"无法找到 \""+ $name +"\" 控件") : [0, ''];}
		else if(!$Ctr.test($elm.nodename)){return new Array(2,"\""+ $name +"\" 控件不是有效的 FORM 控件");}
		var $val= this.getvalue($elm.node);
		var $len= $elm.length>0 ? $val.length-$Clen+1 : $val.length;
		var $act= $elm.nodename=="SELECT" || $elm.nodename=="CHECKBOX" || $elm.nodename=="RADIO" ? "选择":"输入";

		if ($val==""){return $min==0 ? [0,""] : [3,"请"+$act+$name];}	/*允许为空，成功退出;不允许为空*/
		//验证长度(不限制大小是才验证字符长度)
		if ($type!="array"){
			if ($min>0 && $len<$min){return (new Array(4,$name+"Not less than "+$min+" Characters"));}
			if ($max>0 && $len>$max){return (new Array(5,$name+"Cannot be greater than "+$max+" Characters"));}
		}
		//验证格式
		if ( $type == "boolean"){
			if ( !$rule && $R["html"].test($val) ){return (new Array(6,$name + "Cannot contain characters such as < > \' \" & # | "));}
		}
		else if ( $type == "string" ){
			var $result = true;  $rule = this.trim($rule,1);
			if ( $rule.substring(0,4)=="url:"){
				$rule = $rule.substring($rule.indexOf(":")+1);
				$result = this.mappath($rule,$val);
				if (!$result){return [7,$name+$act+"错误:"+$Etext];}
			}
			else if ( $rule.substring(0,9)=="datetime:" || $rule.substring(0,3)=="dt:" ){
				var $vrule= $rule.substring($rule.indexOf(":")+1).split(",");
				if ( ("" in $vrule) || ("*" in $vrule) ){
					if(!this.isdatetime("",$val)){ return [7,$name+$act+"错误，必须为有效的日期时间格式"];}
				}
				else{
					var $v, $re, $l=$vrule.length
					for($v=0;$v<$vrule.length;$v++){ if($re=this.isdatetime($vrule[$v],$val)){break;} }
					if (!$re){return [7,$name+$act+"错误，"+$Etext];}
				}
			}
			else {
				if ($rule==""){$rule="!html";}
				var $vre = $rule.substring(0,1)!="!";
				if (!$vre){ $rule = $rule.substring(1); }
				var $msg=$act+"错误", $let = $vre ? "必须" : "不能"
				if ($rule=="html"){$msg = $let+"含有 < > \' \" & # | 等字符"; }
				else if($rule=="html-"){$msg = $let+"含有 < > \' \" & | 等字符"; }
				if ($R[$rule]==null || ($R[$rule].test($val))!=$vre){return [7,$name+$msg];}
			}
		}
		else if ( $type == "regexp" ){
			try{ if (!$rule.test($val)){return (new Array(7,$name+$act+"错误"));} }
			catch($error){return (new Array(7,$name+"验证的正则表达式错误"));}
		}
		else if ( $type == "array" ){
			if ( !$R["int"].test($val) ){return (new Array(7,$name+$act+"错误"));}
			$rule[0] = this.isnull($rule[0]) ? Number.NEGATIVE_INFINITY : this.intval($rule[0]);
			$rule[1] = this.isnull($rule[1]) ? Number.POSITIVE_INFINITY : this.intval($rule[1]);
			var $imax = Math.max($rule[0],$rule[1]);
			var $imin = Math.min($rule[0],$rule[1]);
			$val = this.intval($val);
			if ($imax==$imin && $val != $imax){return new Array(8, $name+"必须等于 "+$imax);}
			if ( $val < $imin){return new Array(8, $name+"必须 ≥"+$imin);}
			else if ($val > $imax){return new Array(8, $name+"必须 ≤"+$imax);}
		}
		return (new Array(0,""));
	}
	
	//表单提交前验证
	this.submit = function (){
		var $obj_form = this.getobject(this.Form);
		if (!$obj_form){$Error = 1;$Etext = "不存在表单，数据验证失败";return false;}
		if (!$obj_form.nodeName || $obj_form.nodeName.toUpperCase()!="FORM"){$Error=2;$Etext="指定的表单不是有效的表单对象";return false}
		this.seterror(0); this.Form = $obj_form; /*返回为接口，外部可以直接从属性获取表单控件*/
		var $el,$i,$node,$value,$result;
		for ($el in this.Element){
			$Ebas++;
			$node	= $obj_form.elements[$el];
			$value	= this.Element[$el];
			if($value.length==3){$value[3]=false;}else if($value.length<3){$value=["undefined",1,null,false];}
			if (!$node){$result = [1,"表单中不存在 \""+ $el +"\" 的控件"];}
			else{
				if (typeof($value[3])=="string" && $value[3].indexOf("|")!=-1){
					var $r,$rule = $value[3].split("|");
					for ($r=0;$r<$rule.length;$r++){
						$result = this.validate($node,$value[0],$value[1],$value[2],$rule[$r],$value[4]);
						if (!$result[0]){break;}
					}
				}
				else{
					$result = this.validate($node,$value[0],$value[1],$value[2],$value[3],$value[4]);
				}
				if (!$result[0]){continue}else{$result[0]++;}//如果正确了就下一位,否则错误代码往上递增
			}
			if ($result[0] > 0){
				if (typeof($value[4])!="undefined" && $value[4]){continue;}
				$Error	= $Ebas*10+$result[0]-1;
				$Etext	= $result[1];
				if ($result[0]>=3){$Etag = $node.length &&  $node.nodeName!="SELECT" ? $node[0] : $node;}
				return false;
			}
		}
		if (this.isarray(this.Coexist)){
			for ($i=0;$i<this.Coexist.length;$i++){
				$re = this.valuecmp(this.Coexist[$i]);
				if ($re==-1 || $re==0){continue;}else{$Ebas++;}
				$Error = $Ebas*10+$re-1; $Etext	= this.Coexist[$i][1]; return false;
			}
		}
		return true;
	}
	//错误控件获取焦点
	this.errnode	= function ($getatt){
		if (!$Etag || !$Etag.nodeName || !$Ctr.test($Etag.nodeName)){return null;}
		$getatt = this.trim($getatt);
		if ($getatt=="id"){return $Etag.id;}else if ($getatt=="name"){return $Etag.name;}else{return $Etag;}
	}
	this.errfocus	= function (){
		if ($Etag && $Etag.nodeName && $Ctr.test($Etag.nodeName)){try{$Etag.focus();}catch($error){}}
	}
	
	//+++++++++++++++++++++++++  DOM 获取函数  +++++++++++++++++++++++++
	
	//获取node
	this.node = function ($cond,$zone,$rearray){
		if (arguments.length==1){$rearray=true;}
		else if(arguments.length==2){
			if ($zone!=null && $zone.getElementsByTagName){$rearray=true;}
			else{$rearray=!!$zone; $zone = document.body;}
		}
		var $rsdef = $rearray ? [] : null;
		if (($cond=this.trim($cond))==""){return $rsdef;}
		if ($zone==null){$zone=document.body;}else{$zone=this.getobject($zone);}
		if (!$zone || !$zone.getElementsByTagName){return $rsdef;}
		$cond = $cond.replace(/([\s\>])\s+/,"$1").replace(/[\s]+\>$/,"").replace(/([^\ \>])([\.\#\$\:])/,"$1|$2");
		var $mkey=this.random(8), $cary=$cond.split(" "), $node=[],$nl=0;
		find(0,$zone); return !$node ? $rsdef : $node;
		
		function find($level,$pnode){
			if ($pnode==null || !$pnode.getElementsByTagName){return false;}
			if (($level=$this.intval($level))<0 || $level>$cary.length-1){return false;}
			var $acond = $cary[$level].split("|"), $lcond=$acond.length;
			var $fc,$fw,$ft,$tagreg=/^[a-zA-Z]/;
			$fc = $acond[0].substring(0,1); if ($fc==">"){$acond[0]=$acond[0].substring(1);}
			$fw = $acond[0].substring(0,1); $ft = $tagreg.test($fw) ? $acond[0] : $acond[0].substring(1);
			var $hcl=$fc!=">" ? 0 : 1,$child=[],$tag=[],$t,$att,$attval;
			if ($fc==">" && !$pnode.hasChildNodes()){return false;}
			if ($fw=="#"){$att="id";}else if($fw=="$"){$att="name";}else if($fw=="."){$att="className";}
			else if($tagreg.test($fw)){$att="tagName";$ft=$ft.toUpperCase();}else{return false;}
			if (!$hcl){$tag=document.all ? $pnode.all : $pnode.getElementsByTagName('*');}
			else if($pnode.hasChildNodes){$tag=$pnode.childNodes;}
			for ($t=0;$t<$tag.length;$t++){
				if (!$tag[$t].getAttribute){continue;}
				$attval= $att=="tagName" ? $tag[$t].tagName : $tag[$t].getAttribute($att);
				if ($attval==$ft){$child.push($tag[$t]);}
			}
			if (!$child.length){return false;}

			var $i,$l,$ppost,$pvalue,$key;
			for ($i=1;$i<$lcond;$i++){
				$fw = $acond[$i].substring(0,1); $ft = $acond[$i].substring(1);
				for ($l=$child.length-1;$l>-1;$l--){
					if ($fw=="#" && $child[$l].id==$ft){continue;}
					if ($fw=="$" && $child[$l].name==$ft){continue;}
					if ($fw=="." && (" "+ $child[$l].className + " ").indexOf(" "+ $ft +" ")!=-1){continue;}
					if ($tagreg.test($fw) && $child[$l].tagName && $child[$l].tagName==$fw+$ft){continue;}
					if ($fw==":"){
						$ppost = $fw.indexOf("=");
						if ($ppost>0){
							$pname = $fw.substring(0,$ppost);
							$pvalue = $fw.substring(0,$ppost+1);
							$att = $child[$l].getAttribute($pname);
							if ($att!=null && $att.toLowerCase()==$pvalue){continue;}
						}
					}
					$child.splice($i,1);
				}
			}
			if (!$child.length){return false;}
			else if($level<$cary.length-1){for($i=0;$i<$child.length;$i++){find($level+1,$child[$i]);}return true;}
			if (!$rearray){$node = $child[0];return true;}
			for($i=0;$i<$child.length;$i++){
				$key = $child[$i].getAttribute('ODFFindNode');
				if ($key==null || $key!=$mkey){$child[$i].setAttribute('ODFFindNode',$mkey);$node[$nl]=$child[$i];$nl++;}
			}
			return true;
		}
	}
	
	//获取对象
	this.getObject = function ($obj,$zone,$array){
		if (arguments.length==2 && typeof($zone)=="boolean"){$array=!!$zone; $zone=document; }
		return this.getobject($obj,$zone,$array);
	}
	this.getobject = function ($obj,$zone,$array){
		if (arguments.length==2 && typeof($zone)=="boolean"){$array=!!$zone; $zone=document; }
		else { $zone = $zone && $zone.document ? $zone.document : document; }
		var $name;
		if (typeof($obj)=="object" && $obj!=null && $obj.nodeName){
			if (!$array){return $obj;}
			$name=this.strval($obj.getAttribute('name'));
			return $name=="" ? [$obj] : $zone.getElementsByName($name);
		}
		if ( ($name=this.trim($obj))=="" ){return null;}
		if ( $array ){
			$obj = $zone.getElementsByName($name);	if ($obj.length){ return $obj; }
			$obj = $zone.getElementById($name);		return $obj ? [$obj] : null;
		}
		else{
			$obj = $zone.getElementById($name);		if ($obj){return $obj;}
			$obj = $zone.getElementsByName($name);	return $obj.length ? $obj[0] : null;
		}
	}
	//验证控件是否存在且有效(返回一个对象{node:节点节点,nodename:节点名称,len:长度(0:"obj"不是数组;>0:"obj"是数组)})
	this.getElement = function ($obj,$array){return this.getelement($obj,$array);}
	this.getelement = function ($obj,$array){
		var $ars = {'node':null,'nodename':null, 'length':null};
		if ($obj != null && typeof($obj)!="object"){
			var $strid	= $obj.toString();
				$obj = document.getElementsByName($strid);
				if(!$obj.length){$obj=document.getElementById($strid);}//防止火狐使用 getElementsByName 获取不到
		}
		if (!$obj){ return $ars;}
		$ars.node	= $obj.length ? $obj : new Array($obj);
		$ars.length = $ars.node.length;
		//如果存在"type"属性
		if ($ars.node[0].type){
			var $type = $ars.node[0].type.toUpperCase();
			$ars.nodename = $type=="RADIO" || $type=="CHECKBOX" ? $type : $ars.node[0].nodeName;
		}
		else{
			$ars.nodename = $ars.node[0].nodeName;
			if ($ars.nodename=="OPTION"){
				var $sel=false;$parent=null,$node=$ars.node[0];
				while ($parent = $node.parentNode){
					if (!$parent.nodeName || $parent.nodeName=="BODY"){break;}
					else if ($parent.nodeName=="SELECT"){$sel= true; break;}
					else {$node = $parent;}
				}
				if ($sel){$ars.node=[$parent];$ars.nodename="SELECT";$ars.length=1;}
				else{$ars.node = $ars.nodename = $ars.length = null;return $ars;}
			}
		}
		//"obj"：如果不是表单控件，且为单节点则为节点本身；如果是表单控件或多节点，则由参数$array控制
		if ((!$ars.nodename || !$Ctr.test($ars.nodename)) && $ars.length==1 ){
			$ars.length = 0; $ars.node = $ars.node[0] ; return $ars;
		}
		//表示只取一个
		if (!$array){ $ars.length= 0 ; $ars.node = $ars.node[0];}
		return $ars;
	}
	//取表单控件的值
	this.getValue = function ($obj,$slt){return this.getvalue($obj,$slt);}
	this.getvalue = function ($obj,$slt){
		var $element = this.getelement($obj,true);
		if ($element.length == null){return "";}
		var $obj=$element.node, $type=$element.nodename, $value=new Array();
		var $x=$y=$z=0;
		//重置有效控件长度
		$Clen = $obj.length;
		for ($x=0;$x<$obj.length;$x++){
			if ($type=="SELECT"){$value[$z] = $obj[$x].value; }
			else if ($type!="CHECKBOX" && $type!="RADIO"){$value[$z] = $obj[$x].value; $z++;}
			else if ($obj[$x].checked){$value[$z] = $obj[$x].value; $z++;}
			else{$Clen--;}
		}
		if ($slt && $slt.constructor==Array){$slt = $value; return $value;}
		$slt = this.strval($slt,1);
		return $slt=="" ? $value.join(",") : $value.join($slt);
	}
	
	//+++++++++++++++++++++++++  DOM 操作函数  +++++++++++++++++++++++++
	
	//添加事件(支持多个控件)
	this.addevent = function ($obj,$event,$function){
		if (typeof($obj)!="object"){this.getobject($obj,null,true)}else if($obj && $obj.tagName){$obj=[$obj];}
		if (!$obj || !$obj.length){return false;}
		var $pty,$arg,$fun,$evt,$onevt,$_onevt,$_len;
		if (($onevt= this.trim($event))==""){return false;}
		if (!this.isarray($function)){$fun=$function;$arg=[];}
		else if ($function.length<1){return false;}
		else {$fun=$function[0]; $arg = $function.slice(1);}
		$pty = this.isfunction($fun); if(!$pty){return false;}
		$evt = $onevt.replace(/^on/i,"");
		$_onevt = "_"+$onevt;
		for (var $i=0;$i<$obj.length;$i++){
			if (!$obj[$i].tagName){continue;}
			if (!$obj[$i][$_onevt]){$obj[$i][$_onevt]=[];} $obj[$i][$_onevt].push($pty); $_len=$obj[$i][$_onevt].length-1; 
			//[公用函数返回匿名函数]:使用该方法是为了在添加事件时直接执行公用函数，将局部变量作为参数传递给匿名函数。
			$fun = function($object,$protype,$ubound,$args){
				return function(){
					if (!$object || !$object[$protype] || typeof($object[$protype][$ubound])!="function"){return;}
					//[apply]:使用该方法是为了能传递参数($args)，将第一个参数指定为$object，可使回调函数this指向控件本身
					$object[$protype][$ubound].apply($object,$args);
				}
			}
			if(window.addEventListener){$obj[$i].addEventListener($evt,$fun($obj[$i],$_onevt,$_len,$arg),true);}
			else if(window.attachEvent){$obj[$i].attachEvent($onevt,$fun($obj[$i],$_onevt,$_len,$arg));}
			else{$obj[$i][$onevt]=$fun($obj[$i],$_onevt,$_len,$arg)}
		}
		return $i ? true : false ;
	}
	//删除事件(支持多个控件)
	this.delevent = function ($obj,$event,$function){
		if (typeof($obj)!="object"){this.getobject($obj,null,true)}else if($obj && $obj.tagName){$obj=[$obj];}
		if (!$obj || !$obj.length){return false;}
		var $fun,$pty,$evt,$onevt,$_onevt,$p;
		if (($onevt= this.trim($event))==""){return false;}
		$fun = this.funname($function); if($fun==""){return false;}
		$pty = eval($fun); $evt = $onevt.replace(/^on/i,""); $_onevt = "_"+$onevt;
		for (var $i=0;$i<$obj.length;$i++){
			if (!$obj[$i].tagName){continue;}
			if ($obj[$i][$_onevt] && this.isarray($obj[$i][$_onevt])){
				for ($p in $obj[$i][$_onevt]){ if ($obj[$i][$_onevt][$p]==$pty){$obj[$i][$_onevt][$p]=null;} }
			}
			if(window.removeEventListener){$obj[$i].removeEventListener($evt,$pty,true);}
			else if(window.dttachEvent){$obj[$i].dttachEvent($onevt,$pty);}
			else{$obj[$i][$onevt]="";}
		}
		return $i ? true : false ;
	}
	//创建node
	this.newnode = function ($tag,$proty){
		if (($tag=this.trim($tag).toUpperCase())==""){return false;}
		var $element = document.createElement($tag),$el,$type;
		if (!$proty || typeof $proty !="object"){return $element;}
		if (typeof $proty == "object"){
			for ($el in $proty){
				$type = typeof($proty[$el]);
				if ($type!="string" && $type!="number" && $type!="boolean"){continue;}
				if ($el=="html"){try{$element.innerHTML=$proty[$el]}catch($error){}}
				else if($el=="style"){$element.style.cssText = $proty[$el];}
				else{$element.setAttribute($el,$proty[$el])}
			}
		}
		if(this.isarray($proty["event"]) && $proty["event"].length>1){
			this.addevent($element,$proty["event"][0],$proty["event"].slice(1));
		}
		return $element;
	}
	
	//添加node(0:最前,int:某一位,''/'*':最后;'<':之前,'>':之后)
	this.addnode = function ($tag,$target,$place,$proty){
		if (!($target=this.getobject($target))){return false;}
		if ($tag==null || ( typeof($tag)!="object" && ($tag=this.trim($tag))=="" ) ){return false;}
		var $spl = this.trim($place).substring(0,1);
		if (typeof($tag)!="object"){ $tag = this.newnode($tag,$proty); if (!$tag){return false;} }
		if($spl=="<"){ $target.parentNode.insertBefore($tag,$target); }
		else if($spl==">"){$target.nextSibling ? $target.parentNode.insertBefore($tag,$target.nextSibling):$target.parentNode.appendChild($tag);}
		else if($spl=="*" || $spl=="" || !$target.hasChildNodes()){$target.appendChild($tag);}
		else{
			var $sint = this.intval($place)-1,$child=[],$x=0,$y=0;
			for ($x=0;$x<$target.childNodes.length;$x++){
				if($target.childNodes[$x].nodeType==1){$child[$y]=$target.childNodes[$x];$y++;}
			}
			if ($sint<0){$sint=0;}
			$sint>=$target.childNodes.length ? $target.appendChild($tag) : $target.insertBefore($tag,$child[$sint]);
		}
		if($proty && typeof($proty["event"])!='undefined' && this.isarray($proty["event"]) && $proty["event"].length>1){
			this.addevent($tag,$proty["event"][0],$proty["event"].slice(1));
		}
		return true;
	}
	//删除节点
	this.delnode = function ($tag){
		if (!($tag=this.getobject($tag))){return false;}
		return $tag.nodeName=="BODY" || $tag.nodeName=="HTML" ? false :  !!($tag.parentNode.removeChild($tag));
	}
	//克隆节点
	this.copynode = function ($tag,$target,$place){
		if (!($tag=this.getobject($tag))){return false;}
		var $new = $tag.cloneNode(true);
		return $place===false || $place==null ? $new : this.addnode($new,$target,$place);
	}
	//移动节点
	this.movenode = function ($tag,$target,$place){
		if (!($tag=this.getobject($tag))){return false;}
		var $new = this.copynode($tag,null,null);
		if (this.addnode($new,$target,$place)){ $tag.parentNode.removeChild($tag); return true;}else{return false;}
	}
	//替换节点
	this.renode = function ($tag,$target){
		if (!($tag=this.getobject($tag))){return false;}
		if (!($target=this.getobject($target))){return false;}
		var $new = this.copynode($tag);
		if (this.addnode($new,$target,"<")){ $target.parentNode.removeChild($target); return true;}else{return false;}
	}
	//子节点
	this.child = function ($tag){
		if (!($tag=this.getobject($tag))){return false;}
		if (!$tag.hasChildNodes()){return false;}
		var $rs = [],$x=0,$y=0;
		for ($x=0;$x<$tag.childNodes.length;$x++){if ($tag.childNodes[$x].nodeType==1){$rs[$y]=$tag.childNodes[$x];$y++;}}
		return $rs;
	}
	//设置/获取属性
	this.att = function ($tag,$attri){
		if (!($tag=this.getobject($tag)) || $attri==null){return false;}
		if (typeof($attri)!="object"){
			$attri= (this.strval($attri)).replace(/[\,\;\ ]+/g,",").replace(/(^\,+)|(\,$)/g,"");
			if($attri==""){return "";}else{$attri=$attri.split(",");}
		}
		var $el,$att,$has=0,$rs=[];
		for ($el in $attri){
			if (this.isnumeric($el)){
				$att=this.trim($attri[$el]);
				if($att=="html"){$rs[$att]=$tag.innerHTML;} else if($att=="style"){$rs[$att]=$tag.style.cssText;}
				else if($att=="css"){$rs[$att]=$tag.className;} else{$rs[$att]=this.strval($tag.getAttribute($att));}
				$has++;
			}
			else{
				$att=this.trim($el);
				if($att=="html"){$tag.innerHTML = this.strval($attri[$el]);}
				else if($att=="style"){$tag.style.cssText = this.strval($attri[$el]);}
				else if($att=="css"){$attri[$el]==null?tag.removeAttribute("className"):$tag.className=this.strval($attri[$el]);}
				else if($att!="type"){$attri[$el]==null?$tag.removeAttribute($att) : $tag.setAttribute($att,$attri[$el]);}
			}
		}
		if (!$has){return true;}else if ($has==1){return $rs[$att];}else{return $rs;}
	}
	//设置/删除style属性
	this.style = function ($tag,$attri){
		if (!($tag=this.getobject($tag)) || $attri==null){return false;}
		var $style = $tag.style;
		if ($style == null){return false;}
		if (typeof($attri)!="object"){
			$attri = (this.strval($attri)).replace(/[\,\;\ ]+/g,",").replace(/(^\,+)|(\,$)/g,"");
			if($attri==""){return null;}else if ($attri=="*"){return $style.cssText;}else{$attri=$attri.split(",");}
		}
		var $el,$pos,$uwd,$att,$att0,$get,$has=0,$rs=[];
		for ($el in $attri){
			if (this.isnumeric($el)){$att=this.trim($attri[$el]);$has++;$get=true;}else{$att=this.trim($el);$get=false;}
			$pos=$att.indexOf("-");
			if($pos>0){$uwd=$att.substr($pos+1,1).toUpperCase();$att=$att.toLowerCase().replace(/\-[a-z]/i,$uwd);}
			$att0 = $att;
			if($att=="float"){ $att = typeof($style.styleFloat)=="undefined" ? "cssFloat" : "styleFloat"; }
			if($get){$rs[$att0]=this.strval($style[$att]);} else{$style[$att]=$attri[$el];}
		}
		if (!$has){return true;}else if ($has==1){return $rs[$att0];}else{return $rs;}
	}
	//获取/设置class名称
	this.css = function ($tag,$css){
		if (!($tag=this.getobject($tag))){return "";}
		if (arguments.length==1){return $tag.className;}
		var $css = this.trim($css), $cn=$tag.className , $fw = $css.substring(0,1);
		if ($fw=="-"){$tag.className = this.trim( (" "+$cn+" ").replace(" "+($css.substring(1))+" ", " ") ); }
		else if($fw=="+"){$tag.className = this.trim( $cn+" "+($css.substring(1)) ); }
		else {$tag.className=$css.substring(1);}
		return $tag.className;
	}
	
	//+++++++++++++++++++++++++  实用特效函数  +++++++++++++++++++++++++

	//初始化对象(以第一个控件的类型为标准，逐个初始化)
	this.initial = function ($object,$strval,$slt){
		var $obj = this.getelement($object,true);
		if ($obj.length == null){return;}
		if ($strval==null){$strval=$obj.node[0].getAttribute("indexval");}
		var $x,$y,$comp;
		if ($obj.nodename=="SELECT" || $obj.nodename=="CHECKBOX" || $obj.nodename=="RADIO"){
			$strval = this.strval($strval,1); 
			if ($obj.nodename=="SELECT"){
				for ($x=0;$x<$obj.node[0].options.length;$x++){
					if ($obj.node[0].options[$x].value.toLowerCase()==$strval){$obj.node[0].options[$x].selected=true;break;}
				}
			}
			else{
				$slt = this.strval($slt).toLowerCase();
				$comp = $slt + $strval + $slt;
				for ($x=0;$x<$obj.length;$x++){
					if ($obj.node[$x].checked=="undefined"){continue;}
					if (($slt!=""&&$comp.indexOf($slt+$obj.node[$x].value+$slt)!=-1) || ($slt=="" && $comp==$obj.node[$x].value)){
						$obj.node[$x].checked = true; if ($obj.nodename="radio"){break;}
					}
				}
			}
		}
		else{
			$strval = this.strval($strval); for ($x=0;$x<$obj.length;$x++){$obj.node[$x].value=$strval;}
		}
	}
	
	this.initform = function ($form,$iniobj){
		$form = this.getobject($form);
		if (!$form || !$form.nodeName || $form.nodeName.toUpperCase()!="FORM"){return false;}
		if ( !this.isarray($iniobj) && !this.isobject($iniobj) ){ return false; }
		for(var $el in $iniobj){!isNaN(parseInt($el)) ? this.initial($iniobj[$el]):this.initial($el,$iniobj[$el]);}
		return true;
	}
	
	//全选
	this.selectall = function ($obj,$chkid,$txtid){
		if (typeof($obj)=="object" && $obj!=null && $obj.nodeName){
			if ($obj.id){$obj=$obj.id;}else if ($obj.name){$obj=$obj.name;}
			else{$obj.name="selectall_"+this.random();$obj=$obj.name;}
		}
		var $obj	= this.getElement($obj); 			if (!$obj.node){return;}
		var $chk	= this.getElement($chkid,true);		if (!$chk.node){return;}
		var $tid	= this.getElement($txtid,false);
		var $tag	= $obj.nodename;
		var $blnstate	= $obj.node.getAttribute("selectstate");							//当前的状态
		var $selected	= !$blnstate || $blnstate=="0" || $blnstate=="false"? true : false;	//将要改变的状态
		var $hasstate	= true;
		var $statetxt	= "";
		if ($blnstate===null && ($tag=="CHECKBOX" || $tag=="RADIO") ){
			$hasstate= false; $blnstate = $obj.node.checked; $selected = $blnstate;
		}
		if($chk.nodename!="SELECT"){for($i=0;$i<$chk.length;$i++){$chk.node[$i].checked = $selected;}}
		else{$chk=$chk.node[0];var $i=0; for($i=0;$i<$chk.options.length;$i++){$chk.options[$i].selected=$selected;}}
		if ($hasstate){$obj.node.setAttribute("selectstate",$selected);}
		//显示文本
		$statetxt = $selected ? $obj.node.getAttribute("UnSelectText") : $obj.node.getAttribute("SelectedText")
		if (!$statetxt){return;}
		else if($tid.node && /^li|label|font|a|span|div|p$/i.test($tid.nodename)){$tid.node.innerHTML=$statetxt;}
		else if($tag=="BUTTON" || $tag=="A"){$obj.node.innerHTML = $statetxt;}
		else if($tag=="INPUT" && $obj.node.type && /^button|submit$/i.test($obj.node.type)){$obj.node.value=$statetxt;}
	}
	//切换标签
	//{tag:对应(只有2个元素时表示使用ID，使用下标对应),selected:选中时使用的class("{xxx:yyy;}"表示为style文本),unselsect:不选中时使用的class(同样支持style文本),event:切换事件(默认onlick),mode:显示模式(0只有一个显示,1:可多个显示),display:显示时的模式(默认为空),open(默认打开的项目)}
	this.selecttag = function ($obj){
		if (!$obj){return false;}
		if (typeof $obj.tag =="undefined"){return false;}			if (typeof $obj.mode =="undefined"){$obj.mode=0;}
		if (typeof $obj.selected =="undefined"){$obj.selected="";}	if (typeof $obj.unselect =="undefined"){$obj.unselect="";}
		if (typeof $obj.event =="undefined"){$obj.event="onclick";}	if (typeof $obj.open =="undefined"){$obj.open="";}
		if (!this.isarray($obj.tag)){ $obj.tag = this.strval($obj.tag).split(","); }
		if ($obj.tag.length % 2 ==1) {$obj.tag.pop();}
		var $i=0,$rnd = "@"+this.random(6),$evt = $obj.event.replace(/^on/i,""),$onevt="on"+$evt ;
		var $tag=[], $box=[],$func = function(){selecttag(this);};

		//ID对应
		if ($obj.tag.length==2){
			$box = this.getobject($obj.tag[1],null,true);
			$tag = this.getobject($obj.tag[0],null,true);
			for ($i=0;$i<$box.length;$i++){$box[$i].style.display="none";}
			if (!$tag){return false;}
			for ($i=0;$i<$tag.length;$i++){
				if(window.attachEvent){$tag[$i].attachEvent($onevt,(function($obj){return function(){selecttag($obj)}})($tag[$i]))}
				else if(window.addEventListener){$tag[$i].addEventListener($evt,$func,false);}
				else{$tag[$i][$onevt]=$func;}
				$tag[$i].setAttribute('ODFChangeTagID',$rnd+":"+$i);
			}
		}
		else{
			$ttag=null,$tbox=null,$tname=[],$t=0;
			for ($i=0;$i<$obj.tag.length;$i+=2){
				$tbox = this.getobject($obj.tag[$i]);
				$ttag = this.getobject($obj.tag[$i]);
				if ($tbox){$tbox.style.display="none";}
				if ($ttag){
					if(window.attachEvent){$ttag.attachEvent($onevt,(function($obj){return function(){selecttag($obj)}})($ttag))}
					else if(window.addEventListener){$ttag.addEventListener($evt,$func,false);}
					else{$ttag[$onevt]=$func;}
					$tag[$t]=$ttag; $tname[$t]=$obj.tag[$i]; $tag[$t].setAttribute('ODFChangeTagID',$rnd+":"+$t);
				}
				$t++;
			}
		}
		var $open=this.strval($obj.open), $iopen=this.intval($obj.open)-1, $openobj=null;
		if ($open!=""){
			if (this.isnumeric($open)){$openobj=$tag[$open];}
			else if($obj.tag.length>2 && (","+($tname.join(","))+",").indexOf(","+$open+",")!=-1 && ($ttag=this.getobject($open)) ){$openobj=$ttag;}
		}
		$obj.opening = $obj.mode ? [] : null; $Ctag[$rnd] = $obj; if($openobj){selecttag($openobj);}
		return true;
		
		function selecttag(){
			if (arguments.length<1 || !arguments[0].nodeName){return false;}
			var $cid = $this.strval(arguments[0].getAttribute('ODFChangeTagID'));
			var $aid = $cid.split(":");
			if ($aid.length<2 || $aid[0]=="" || $aid[1]===""){return false;}
			if (typeof $Ctag[$aid[0]] == "undefined"){return;}
			var $tag,$mode,$uncss,$edcss;
			var $box,$boxed,$div,$dived,$tsid,$opend,$opat,$cname;
			if (!$this.isarray($tag=$Ctag[$aid[0]].tag)){return false;}
			$tsid = $this.intval($aid[1]);
			if ($tsid<0){$tsid=0;}
			$edcss	= $this.strval($Ctag[$aid[0]].selected);$uncss	= $this.strval($Ctag[$aid[0]].unselect);
			$mode	= $this.intval($Ctag[$aid[0]].mode);	$opend	= $Ctag[$aid[0]].opening;
			$opat	= !$mode ? $opend : $opend[$tsid];		$opat	= $opat==null ? -1 : $this.intval($opat);
			if ($tag.length==2){
				$div	= $this.getobject($tag[0],null,true);
				$box	= $this.getobject($tag[1],null,true);
				$boxed	= $opat<0 || !$box || !$box[$opat] ? null : $box[$opat];	//box
				$dived	= $opat<0 || !$div || !$div[$opat] ? null : $div[$opat];	//tag
				$div	= !$div || !$div[$tsid] ? null : $div[$tsid];	//div
				$box	= !$box || !$box[$tsid] ? null : $box[$tsid];	//box
			}
			else{
				$boxed	= $this.getobject($tag[$opat*2+1]);	//box
				$dived	= $this.getobject($tag[$opat*2]);	//tag
				$box	= $this.getobject($tag[$tsid*2+1]);	//box
				$div	= arguments[0];
			}
			//只允许打开一个：不是打开自己；可打开多个：目前不是打开的
			if ( (!$mode && $opat!=$tsid) || ($mode && $opat<0)){
				if($box){$box.style.display=$this.strval($Ctag[$aid[0]]['display']);}
				if (/^\{[^\}]*\}$/.test($edcss)){$div.style.cssText = $edcss.substring(1,$edcss.length-1);}
				else if($edcss.substring(0,1)=="+"){$cname=$this.trim($div.className);$div.className=$cname+" "+($edcss.substring(1));}
				else if($edcss.substring(0,1)=="-"){$cname=" "+$div.className+" ";$cname=$cname.replace(" "+$edcss.substring(1)+" ", " "); $div.className=$this.trim($cname);}
				else{$div.className=$edcss;}
			}
			//只允许打开一个：不是打开自己；可打开多个：目前是打开的
			if ( (!$mode && $opat!=$tsid) || ($mode && $opat>-1)){
				if ($boxed){$boxed.style.display="none";}
				if ($dived){
					if (/^\{[^\}]*\}$/.test($uncss)){$dived.style.cssText = $uncss.substring(1,$uncss.length-1);}
					else if ($uncss.substring(0,1)=="+"){$cname=$this.trim($dived.className);$dived.className=$cname+" "+($uncss.substring(1));}
					else if ($uncss.substring(0,1)=="-"){$cname=" "+$dived.className+" "; $cname=$cname.replace(" "+$uncss.substring(1)+" ", " "); $dived.className=$this.trim($cname); }
					else{$dived.className=$uncss;}
				}
			}
			if ($mode){ $opend[$tsid] = $opat<0 ? $tsid :null;} else if($opat!=$tsid){$opend=$tsid;}
			$Ctag[$aid[0]].opening = $opend; return true;
		}
	}
	
	//+++++++++++++++++++++++++  图片相关函数  +++++++++++++++++++++++++
	
	//按比例计算出缩放尺寸
	this.zoom = function ($size,$normal){
		if (!this.isarray($normal)){$normal = $normal.replace(/[\,\|\/\-\ ]/,"*").split("*");}
		if (!this.isarray($size)){$size = $size.replace(/[\,\|\/\-\ ]/,"*").split("*");}
		$normal[0] = $normal[0]!=null ? Math.max(this.intval($normal[0]),0) : 0;
		$normal[1] = $normal[1]!=null ? Math.max(this.intval($normal[1]),0) : 0;
		$size[0] = $size[0]!=null ? Math.max(this.intval($size[0]),0) : 0;
		$size[1] = $size[0]!=null ? Math.max(this.intval($size[1]),0) : 0;
		var $w,$h;
		if ( $size[0]<=0 || $size[1]<=0 ){$w=0;$h=0;}
		else{
			if ($normal[0]<=0){ $normal[0] = $size[0]; }
			if ($normal[1]<=0){ $normal[1] = $size[1]; }
			var $caclew = $normal[0] ? $size[0]/$normal[0] : 0;
			var $cacleh = $normal[1] ? $size[1]/$normal[1] : 0;
			var $caclei	= Math.max($caclew,$cacleh);
			if ($caclei>1){$w=$size[0]/$caclei; $h=$size[1]/$caclei;} else{$w=$size[0]; $h=$size[1];}
		}
		$normal = null; $size = null;
		$result = new Array($w,$h); $result['width'] = $w; $result['height'] = $h;
		return $result;
	}
	//按比例缩放图片
	this.imgzoom = function ($m){
		if (!this.isarray($m)){ $m = this.getobject($m,true); }
		if (!$m){ return false; }
		var $i,$w,$h,$mw,$mh,$img;
		for($i=0;$i<$m.length;$i++){
			$img = $m[$i];
			if (!$img || !$img.nodeName || $img.nodeName.toUpperCase()!="IMG"){continue;}
			$w = $img.width ? parseInt($img.width) : 0;
			$h = $img.height ? parseInt($img.height) : 0;
			$mw= $img.getAttribute('maxwidth');
			$mh= $img.getAttribute('maxheight');
			//如果指定了大小或存在缓存(在IE下缓存图片就会被直接载入，且载入缓存图片时readyState没有变化)
			if ($img.complete/*可能缓存,若缓存则$w和$h一定存在*/ || ($w && $h)){
				//尺寸都有且小于最大值则不需要处理
				if ($w<$mw && $h<$mh){continue;}
				var $size = this.zoom([$w,$h],[$mw,$mh]);
				$img.width = $size[0]; $img.height = $size[1];
			}
			else{
				$img.onerror=$img.onload=$img.onreadystatechange=function(){
					if($img&&$img.readyState&&$img.readyState!='loaded'&&$img.readyState!='complete'){return false;}
					//$img.onerror =$imgonload = $img.onreadystatechange =  null;
					var $gw = $img.width ? parseInt($img.width) : 0;
					var $gh = $img.height ? parseInt($img.height) : 0;
					var $size = $this.zoom([$gw,$gh],[$mw,$mh]);
					$img.width = $size[0]; $img.height = $size[1];
				};
			}
		}
    }
	//滚动滚轮缩放图片
	this.imgwheel = function ($m){
		$m = !this.isarray($m) ? this.getobject($m,true) : $m;
		if (!$m || !$m.length){ return false; }
		var $wheelevt = /Firefox/i.test(navigator.userAgent) ? "DOMMouseScroll" : "mousewheel";
		if (window.attachEvent){			//if IE (and Opera depending on user setting)
			for(var $i=0;$i<$m.length;$i++){
				if ($m[$i] && $m[$i].nodeName && $m[$i].nodeName=="IMG"){$m[$i].attachEvent("on"+$wheelevt,wheelfun($m[$i]));}
			}
		}
		else if (window.addEventListener){	//WC3 browsers
			for(var $i=0;$i<$m.length;$i++){
				if ($m[$i] && $m[$i].nodeName && $m[$i].nodeName=="IMG"){$m[$i].addEventListener($wheelevt,wheelfun($m[$i]),false);}
			}
		}
		/*创建闭包函数*/
		function wheelfun($node){
			var $img = $node;
			return function(){
				if (!$img){return false;}                               //对象不存在
				$event = arguments[0] ? arguments[0] : window.event;   	//事件
				var $z = ($event.detail ? $event.detail / 3 : $event.wheelDelta/120); $z = (10+$z)/10;
				if ($z==1 || $z<=0){return false;}
				var $w = parseInt($img.offsetWidth), $h = parseInt($img.offsetHeight) ;
				$img.width = $w * $z; $img.height = $h * $z;
				return false;
			}
		};
	}
	
	//+++++++++++++++++++++++++  正则表达式函数  +++++++++++++++++++++++++
	
	//正则函数
	this.RegExp	= function (){
		return this.regexp.apply(this,this.toarray(arguments));
	}
	this.regexp	= function (){
		var $l = arguments.length, $reg,$str,$rpl, $rs,$re,$r;
		if ($l<1){return $R['az09'];}
		$reg=arguments[0];
		if (!this.isregexp($reg)){$reg=this.strval($reg);$reg=$R[$reg] ? $R[$reg] : $R['az09'];}
		if ($l<2){return $reg;}
		$str = this.strval(arguments[1]); $rpl=arguments[2];
		if ($rpl==null){return $reg.test($str);}
		var $rstr=$reg.toString().replace(/^\/([\s\S]*)\/[gi]*$/,"$1");
		var $case=$reg.ignoreCase ? "i" : "";
		if ($rpl===false || $rpl===0){
			$reg=new RegExp($rstr,$case);
			if (!($rs=$reg.exec($str))){return null;}
			else{$re=$rs.concat();$re["result"]=true;$re["index"]=$rs["index"];}
			return $re;
		}
		if ($rpl===true || $rpl===1){
			$reg=new RegExp($rstr,"g"+$case);
			$re=[];$r=0;while( ($rs=$reg.exec($str))!=null ){$re[$r]=$rs.concat();$r++;} return !$r? null : $re;
		}
		$reg=new RegExp($rstr,$case);
		return $str.replace($reg,this.strval($rpl));
	}
	
	//+++++++++++++++++++++++++  其他杂项函数  +++++++++++++++++++++++++
	
	//获取 原型类型为function 的表达式
	this.funname = function ($func){
		var $strfun = this.strval($func).replace($R["func"],"$2");
		if ($strfun==""){return "";}
		return typeof(eval($func))!="function" ? "" : $strfun;
	}
	
	//验证路径
	this.mappath = function ($fm,$path,$rpl){
		var $args = arguments.length;
		if ($args==1){$path=$fm;$fm="";$rpl=false;}else if($args==2 && this.isboolean($path)){$rpl=$path;$path=$fm;$fm="";}
		$path=this.strval($path).toLowerCase(); $fm=this.strval($fm).toLowerCase().replace(/^url\:?/,"");
		var $par = new Array(1,1);
		//不得带有?参数
		if ($fm.indexOf("-?")!=-1){if($rpl){$path=$path.replace(/\?[\s\S]+$/gi,"");}else{$par[0]=0;} $fm=$fm.replace("-?","");}
		//不得带有#瞄点
		if ($fm.indexOf("-#")!=-1){if($rpl){$path=$path.replace(/\#[\s\S]+$/gi,"");}else{$par[1]=0;} $fm=$fm.replace("-#","");}
		if ($par[0]==0){ if (/\?.*?$/gi.test($path) ){$Error=1; $Etext="不可含有URL参数"; return false;}}
		if ($par[1]==0){ if (/\#.*?$/gi.test($path) ){$Error=2; $Etext="不可含有瞄点名称"; return false;}}
		var $ptl = $path.substring(0,7);
		if ($path!=""){
			if ($fm=="!http"&&$ptl =="http://"){$Error=4;$Etext="不可使用 http:// 开头";return false;}//要求相对路径(不得以http://开头)
			if ($fm=="http"&&$ptl !="http://"){$Error=5; $Etext="必须使用 http:// 开头";return false;}//要求绝对路径(必须以http://开头)
			if ($fm=="+http" && $ptl !="http://"){$path="http://"+$path;}		//要求相对路径(如果不以http://开头)
			if ($fm=="-http" && $ptl =="http://"){$path=$path.substring(7);}	//要求绝对路径(如果不以http://开头)
			if (!$R["url"].test($path)){$Error=6;$Etext="格式错误";return false;}
		}
		else if($fm=="http" || $fm=="!http"){ $Error=3; $Etext="不可为空"; return false ;}
		return $rpl ? $path : true;
	}
	
	//动态加载js
	
	//添加style
	
	//获取浏览器类型和版本
	this.browser = function (){
		if ($Agent!=null){ return $Agent; }
		var $str_broinfo= navigator.userAgent;
		var $ary_regexp	= /\s+(MSIE)\s+([1-9]+)(\.\d+)?\;/i.exec($str_broinfo);
		if (!$ary_regexp){ $ary_regexp = /\s*(firefox|safari|opera|chrome)\/([1-9]+)(\.\d+)?/i.exec($str_broinfo); }
		$Agent = [];
		if (!$ary_regexp){ $Agent['name'] = 'Unknow'; $Agent['version']= 0;}
		else{ $Agent['name'] = (RegExp.$1).toUpperCase(); $Agent['version']= parseInt(RegExp.$2);}
		return $Agent;
	}
	
	__construct();
}