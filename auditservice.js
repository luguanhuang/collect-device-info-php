// JavaScript Document

function AuditLog_Search($form,$type){
	if (!$form){ return false; }
	var $str_param	= $form.elements['php_parameter'] ? $_G.trim($form.elements['php_parameter'].value) : "";
	var $ary_param	= $str_param=="" ? null : $str_param.split(",");
	if (!$ary_param){ return false; }
	var $k,$e,$value,$name,$rule,$isfull;
	for ($k in $ary_param){
		$e = $form.elements[$ary_param[$k]];
		if (!$e){continue;}
		$value	= $_G.trim($e.value);
		$name	= $_G.trim($e.getAttribute('cnname'));
		$isfull	= $_G.intval($e.getAttribute('isfull'));
		$rule 	= $e.getAttribute('rule');	//没有rule属性时则pass
		//如果没有指定名称
		if ($name==""){$name = $ary_param[$k];}
		//如果为空
		if ($value==""){
			if (!$isfull){ continue; }
			$_C.Alert('['+ $name +'] 不可以为空',$_C.focus,$e);
			return false;
		}
		//如果没有指定
		if ($rule==null){ continue; }
		//如果为空
		$rule = $_G.trim($rule,1);
		if ($rule==""){ $rule = "default"; }
		switch($rule){
			case "integer":
				if (!$_G.regexp('int',$value)){
					$_C.Alert('['+ $name +'] 填写错误，必须是整数。',$_C.focus,$e);
					return false;
				}
				break;
			case "word":
				if (!$_G.regexp('az09',$value)){
					$_C.Alert('['+ $name +'] 填写错误，必须是数字、字符或下划线。',$_C.focus,$e);
					return false;
				}
				break;
			case "datetime":
				if (!$_G.isdatetime("|y-m-d h:i|y-m-d|y-m|h:i:s|h:i",$value)){
					$_C.Alert('['+ $name +'] 错误，'+$_G.Error(),$_C.focus,$e);
					return false;
				}
				break;
			case "port":
				if (!$_G.regexp('>0',$value) || $_G.intval($value)>65535){
					$_C.Alert('['+ $name +'] 填写错误，端口号必须是 65535≤ 且 ≥1 。',$_C.focus,$e);
					return false;
				}
				break;
			case "ip":
				if (!$_G.regexp('ip',$value)){
					$_C.Alert('['+ $name +'] 填写错误，请使用IP地址格式',$_C.focus,$e);
					return false;
				}
				break;
			default:
				if (/[\~\`\^\\$\;\&\'\"\<\>\[\]]/.test($value)){
					$_C.Alert('['+ $name +'] 不可含有 ~ ` ^ $ ; &amp; \' &quot; &lt; &gt; [ ] 等特殊字符',$_C.focus,$e);
					return false;
				}
		}
	}
	return true;
}

function AuditLog_ShowOpen($obj){
	if (!$obj){return false;}
	var $state	= $_G.strval($obj.getAttribute('overflow'),1)
	var $display,$title;
	if ($state=="visible"){
		$display= "hidden";
		$title	= "点击查看详细信息";
	}
	else{
		$display= "visible";
		$title	= "点击隐藏详细信息";
	}
	$obj.style.overflow = $display;
	$obj.setAttribute('title',$title);
	$obj.setAttribute('overflow',$display);
}

function AuditLog_Export($type){
	var $form1 = document.forms.SearchForm;
	var $form0 = document.forms.ExportForm;
	if (!$form1 || !$form0){ return false; }
	var $isload= $_G.intval($form0.getAttribute('isExport'));
	var $str_param	= $form1.elements['php_parameter'] ? $_G.trim($form1.elements['php_parameter'].value) : "";
	var $ary_param	= $str_param=="" ? null : $str_param.split(",");
	var $k,$e,$h;
	if (!$isload){
		for ($k in $ary_param){
			if (!$form1.elements[$ary_param[$k]]){continue;}
			$h = document.createElement('INPUT');
			$h.type = "hidden";
			$h.setAttribute('id',$ary_param[$k]);
			$h.setAttribute('name',$ary_param[$k]);
			$form0.appendChild($h);
		}
		$form0.setAttribute('isExport',1);
	}
	for ($k in $ary_param){
		if (!$form1.elements[$ary_param[$k]]){continue;}
		$form0.elements[$ary_param[$k]].value = $_G.strval($form1.elements[$ary_param[$k]].getAttribute('indexval'));
	}
	$_A.mode	= "post";
	$_A.remode	= "html";
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	
	//此处不可显示loading，因为在弹出文件下载时loading窗口不自动关闭
	if (
		$_A.send(
			$form0,
			function (){
				$retxt = $_G.trim($_A.response());
				//弹出下载文件框
				if ($retxt==""){ return true; }
				//返回标准的错误格式
				if (SelectRegRule('renormal').test($retxt)){
					var $int_post	= $retxt.indexOf(",");
					var $int_err	= $retxt.substring(0,$int_post);
					var $str_err	= $retxt.substring($int_post+1);
					$_C.Alert($str_err,null);
					
				}
				else{
					$_C.Alert("导出日志失败，请联系管理员。",null);
				}
				return false;
			},
			null
		)
	)
	{$form0.submit();}
}