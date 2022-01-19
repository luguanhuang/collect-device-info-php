<?php
//验证码 登录
require ("services/Config.php");
require ("services/VerifyCode.php");

//$Int_Width		= @$_REQUEST["width"];
//$Int_Height		= @$_REQUEST["height"];
//$Int_CodeType		= @$_REQUEST["codetype"];
//$Int_CodeSize		= @$_REQUEST["codesize"];

$Obj_IMG = new Cls_Vcode();
$Obj_IMG->session	= _GLO_SESSION_VLOGIN_;
$Obj_IMG->font		= "ArchRival.ttf";
$Obj_IMG->extend	= "png";
$Obj_IMG->codetype	= 3;
$Obj_IMG->codesize	= 4;
$Obj_IMG->size		= 18;
$Obj_IMG->width		= 94;
$Obj_IMG->height	= 20;
$Obj_IMG->color		= "#1F64DC";
$Obj_IMG->brcolor	= "#C70702";
$Obj_IMG->bgcolor	= "#FFFFFF";
$Obj_IMG->border	= 0;
$Obj_IMG->font_w	= 22;
$Obj_IMG->font_x	= 8;
$Obj_IMG->font_y	= 24;
$Obj_IMG->snow		= 100;
$Obj_IMG->disturb	= 4;
$Obj_IMG->writeimage();

if ($Obj_IMG->_error()){
	require ("services/AtherFrameWork.php");
	$Obj_Frame = new AtherFrameWork();
	$Obj_Frame->load_error($Obj_IMG->_error(),$Obj_IMG->_errtext());
	exit();
}
unset($Obj_IMG); $Obj_IMG=NULL;
?>