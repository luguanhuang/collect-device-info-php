$ = function ($id,$byname){
	$id = $id == null ? "" : new String($id).toString();
	$byname = !!$byname;
	if ($id==""){ return $byname ? [] : null; }
	return $byname ? document.getElementsByName($id) : document.getElementById($id);
}

function AjaxSubmit($object,$conf){
	
	if (!$object){ return false; }
	var $backcall,$backargs;
	if (!$_G.isobject($conf) && !$_G.isarray($conf)){
		$backcall = $_G.isfunction($conf);
		$conf = $backcall ? {"backcall":$backcall} : {"remode":$conf}
	}
	//配置参数
	$backcall	= typeof($conf["backcall"])=="undefined" ? null : $conf["backcall"];
	$backargs	= typeof($conf["backargs"])=="undefined" ? null : $conf["backargs"];
	$_A.mode	= typeof($conf["mode"])=="undefined" ? "GET" : $conf["mode"];
	$_A.remode	= typeof($conf["remode"])=="undefined" ? "normal" : $conf["remode"];
	$_A.phase	= typeof($conf["phase"])=="undefined" ? false : $conf["phase"];
	$_A.load	= typeof($conf["load"])=="undefined" ? true : $conf["load"];
	//提交模式
	var $subwin = $_G.strval($object.attributes['submitwin'].nodeValue,1);
	//如果 不load | 不是IE
	if (!$_A.load || !document.all){
		
		console.log("222");
		$_A.loadfun	= !$_A.load ? function (){} : AjaxLoading;
		return $_A.send($object, AjaxReturn, $backcall, $backargs);
	}
	//如果是load + 是ajax + 是IE
	else{
		
		console.log("111");
		$_A.loadfun	= function (){};	//必须指定一个空函数
		AjaxLoading();					//显示Loading
		console.log("subwin="+$subwin);
		if ($subwin!="ajax"){
			return $_A.send($object, AjaxReturn, $backcall, $backargs);
		}
		else{
			setTimeout(function(){$_A.send($object, AjaxReturn, $backcall, $backargs)},300);
			return false;
		}
	}
}

function AjaxLoading($hwd){
	var $obj_loading= $('ConfLoading');
	if (!$obj_loading){ return false; }
	var $bln_isload	= $_G.intval($obj_loading.getAttribute('isloading'));
	if (!$bln_isload){
		$obj_loading.setAttribute('isloading',1);
		$_C.Custom('ConfLoadhead',$obj_loading);
	}
	else{
		$obj_loading.setAttribute('isloading',0);
		$_C.reCustom();
	}
}

function AjaxReturn($backcall,$backargs){
	if ($_A.load && document.all){AjaxLoading();}
	var $isobject	= $_G.isobject($backargs);
	var $silence	= null;
	var $validargs	= null;
	if (!$isobject || typeof($backargs['silence'])=="undefined"){$silence= false;}
	else{$silence = !!$backargs['silence']; delete $backargs['silence'];}
	if (!$isobject || typeof($backargs['necessary'])=="undefined"){$validargs = "";}
	else{ $validargs = $backargs['necessary']; delete $backargs['necessary']; }
	
	var $result = $_A.result();
	if (!$result[0]){
		if (!$silence){$_C.exit(); $_C.Alert($result[3],null);}
		return false;
	}
	
	var $remode		= $_G.strval($_A.remode,1);
	var $backcall	= $_G.isfunction($backcall);

	//验证必要参数
	switch($remode){
		case "json":
			if ($result[2]>=0){
				if (!$silence){$_C.exit(); $_C.Alert($result[3],null);}
				return false;
			}
			var $a=[],$e;
			if ($validargs){
				if ($_G.isobject($validargs)){
					for($e in $validargs){ $a[$e] = $validargs[$e]; }
				}
				else if (!$_G.isarray($validargs)){
					$a = $_G.strval($validargs).split(",")
				}
				$a.unshift($result[3]);
				if (!$_G.aryexists.apply($_G,$a)){
					if (!$silence){$_C.exit();$_C.Alert("返回的结果参数不完整。",null);}
					return false;
				}
			}
			break;
		case "html":
			//pass
			break;
		default:
			$result[2] = $_G.isnumeric($result[2]) ? $_G.intval($result[2]) : false;
			if ($result[2]===false || $result[2]>0){ if(!$silence){$_C.Alert($result[3],null);} return false; }
	}
	if ($backcall){
		if ($isobject){
			$backargs	= $_G.toarray($backargs,true);
		}
		else{
			$backargs = $_G.trim($backargs)
			$backargs = $backargs=="" ? [] : [$backargs];
		}
		if (!$backargs.length){ $backcall.call(null); }
		else{ $backcall.apply(null,$backargs); }
	}
}

function SelectRegRule($rule){
	$rule = $_G.strval($rule,1);
	switch($rule){
		case "mask":
			return /^(((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})|\d|[1-2]\d|3[0-2])$/;
		case "mac":
			return /^([\da-fA-F]{2}\:){5}([\da-fA-F]{2})$/;
		case "ipport":
			return /^((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})\:[1-9]\d*?$/;
		case "renormal":
			return /^\-?(0|[1-9]\d*)\,[^\<\>\'\"]+$/;
		default:
			return /^[a-zA-Z][\w]*$/;
	}
	
}