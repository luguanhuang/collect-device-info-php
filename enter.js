// JavaScript Document

function Login_Validate($form){
	if (!$form){return $form;}
	//验证表单
	var	$ary_element = new Array();
		$ary_element["username"]	= new Array(4,	20,	'username',		SelectRegRule('user'));
		$ary_element["password"]	= new Array(6,	50,	'login password',		true);
		
	$_G.Form	= $form;
	$_G.Element	= $ary_element;
	
	if (!$_G.submit()){$_C.Alert($_G.Error()+"！",$_G.errfocus); return false;}
	
	//验证其他的
	if(!/^[a-z]/i.test($form.username.value)){
		$_C.Alert("Username must start with letter",$_C.focus, $form.username);
		return false;
	}
	if (typeof($form.elements['vcode'])!="undefined"){
		var $res = $_G.validate($form.vcode, '验证码', 4, 4,	"az09");
		if ($res[0]>0){
			$_C.Alert($res[1], $_C.focus, $form.vcode);
			return false;
		}
	}
	
	$_A.mode	= "POST";
	$_A.remode	= "json";
	$_A.phase	= true;
	$_A.load	= false;
	$_A.loadfun	= null;
	
	return $_A.send($form, Login_Return);
}

function Login_Return(){
	var $result = $_A.result();
	if (!$result[0] || $result[2]>=0){ return false; }
	if (!$_G.aryexists($result[3],'state','stateId','message','result')){return false;}
	if (!$result[3]['state']){
		if ($_G.intval($result[3]['result'])){ Login_ChangeVCode('rndimg'); }	//更换验证码
		$_C.Alert($result[3]['message'],null);
		return false;
	}
	else{
		window.location.href = "index.php";
	}
}

//更换验证码
function Login_ChangeVCode($img){
	if (typeof($img)=="string"){$img = $($img);}
	if (!$img || $img.src==null){return;}
	$img.src = $img.src.replace(/\?[\s\S]*$/,'')+'?id='+parseInt(Math.random()*100000);
}