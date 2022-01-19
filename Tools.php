<?php
//****************** [Class] 系统管理对象 ******************

//该类必须运行于 PHP5.0 及以上的平台
if ( intval(PHP_VERSION) < 5 ){ exit("<p>Run \"Tools\" invite promotion your PHP arrives at 5.0 the above editions</p>");}

if (!class_exists('AtherFrameWork')){ require(dirname(__FILE__)."/AtherFrameWork.php"); }

class Tools extends AtherFrameWork{
	
	//__________________  构造/析构函数  ________________
	
	/**/
	function __construct(){
		parent::__construct();
	}
	
	
	function __destruct(){
		parent::__destruct();
	}
	
	//__________________  私有变量  ________________
	
	
	//__________________  只读属性(用方法代替)  ________________
	
	public static function _version()	{return '1.0';}					//版本
	public static function _build()		{return '11.11.25';}			//版本
	public static function _create()	{return '11.11.25';}			//创建
	public static function _classname()	{return __CLASS__;}				//名称
	public static function _developer()	{return "OldFour";}				//开发者
	public static function _copyright()	{return "Aether.CORP";}			//公司
	
	//__________________  只写属性  ________________
	
	
	//__________________  可读写属性  ________________
	
	
	//__________________  私有方法  ________________
	

	//__________________  公有方法  ________________
	
	
	
	/*
	SendPing
	number: 1600
	interface: 133
	*/
	public function sendPing($param){
		if (!$this->user_popedom()){return $this->Ary_Popedom;}
		$keys	= array(
			"ip"	=> array("name"=>"Ping目标地址",	"rule"=>"/^(((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})|([\w\-]+\.)*[\w\-]+)$/"),
			"times"	=> array("name"=>"Ping次数",		"rule"=>parent::_REG_POSINT_,	"default"=>5),
			"delay"	=> array("name"=>"Ping延时时间",	"rule"=>parent::_REG_POSINT_,	"default"=>5)
		);
		$param	= $this->validateArgs($param,$keys,1600,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		$result = $this->socket_send(133, session_id().'|'.$param['ip'].'|'.$param['times'].'|'.$param['delay']);
		//此处使用 error 来判断是否成功
		$message= $result["error"]>0 ? "Ping目标IP失败：".$result['errtxt'] : "Ping目标IP成功";
		//$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result["error"]<=0?-160:1606),$message);
	}

	/*
	getPing
	number: 1700
	*/
	public function getPing(){
		if (!$this->user_popedom()){return $this->Ary_Popedom;}
		$pinglog = _GLO_PATH_TOOLS_RESULT_."ping-".session_id().".log";
		$pingres = $this->file_content($pinglog,"Ping结果日志文件",1700,$interr,$strerr);
		if ($pingres===false){return $this->result_set($interr,$strerr);}
		return $this->result_struct(
			array(
				"stateId"	=> -170,
				"message"	=> "获取Ping结果成功",
				"result"	=> $pingres
			)
		);
	}

	
	public function sendAdsl(){
		if (!$this->user_popedom()){return $this->Ary_Popedom;}
	//	$keys	= array();
	//	$param	= $this->validateArgs($param,$keys,1600,$interr,$strerr);
	//	if ( !$param ){ return $this->result_set($interr, $strerr); }
		$result = $this->socket_send(135, session_id());
		//此处使用 error 来判断是否成功
		$message= $result["error"]>0 ? "adsl调用失败：".$result['errtxt'] : "adsl调用成功";
		//$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result["error"]<=0?-160:1606),$message);
	}

	/*
	getPing
	number: 1700
	*/
	public function getAdsl(){
		if (!$this->user_popedom()){return $this->Ary_Popedom;}
		$adsllog = "/var/wv3g.log";
		$adslres = $this->file_content($adsllog,"adsl结果日志文件",1700,$interr,$strerr);
		if ($adslres===false){return $this->result_set($interr,$strerr);}
		FuncExt::error_report(0);
		$adslres = iconv("gb2312","utf-8//IGNORE",$adslres);
		FuncExt::error_report(true);
		return $this->result_struct(
			array(
				"stateId"	=> -170,
				"message"	=> "获取Ping结果成功",
				"result"	=> $adslres
			)
		);
	}
	
	/*
	Telnet
	number: 1800
	interface: 134
	*/
	public function sendTelnet($param){
		if (!$this->user_popedom()){return $this->Ary_Popedom;}
		$keys	= array(
			"ip"	=> array("name"=>"Telnet目标地址",	"rule"=>parent::_REG_IPADD_),
			"port"	=> array("name"=>"Telnet目标端口",	"min"=>parent::_INT_PORT_MIN_,"max"=>parent::_INT_PORT_MAX_),
		);
		$param	= $this->validateArgs($param,$keys,1800,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		//发送socket
		$result = $this->socket_send(134, $param['ip'].'|'.$param['port']);
		$message= !$result['state'] ? "Telnet目标IP失败：".$result['errtxt'] : "Telnet目标IP成功";
		//处理返回结果
		$result["request"] = iconv("gb2312","utf-8//IGNORE",$result["request"]);
		$telnet = strpos($result["request"],"|")!==false ? substr(strrchr($result["request"],"|"),1) : $result["request"];
		//写入日志
		//$this->log($this->Ary_Session['user'],$message);
		//返回结果
		if (!$result['state']){ return $this->result_set(1806,$message); }
		return $this->result_struct(
			array(
				"stateId"	=> -180,
				"message"	=> $message,
				"result"	=> $telnet
			)
		);
	}
	
	
	public static function getLogTypes(){
	if (!$this->user_popedom()){return $this->Ary_Popedom;}
		static $ary_list;
		if (!isset($ary_list)){$ary_list = parent::config2array(_GLO_FILE_LOGLIST_);}
		return $ary_list;
	}

	
	
public function getLog($param){
if (!$this->user_popedom()){return $this->Ary_Popedom;}
		if (!$this->user_popedom()){return $this->Ary_Popedom;}
		$adsllog = $param['logtype'];
		$adslres = $this->file_content($adsllog,"adsl结果日志文件",1700,$interr,$strerr);
		if ($adslres===false){return $this->result_set($interr,$strerr);}
		FuncExt::error_report(0);
		$adslres = iconv("gb2312","utf-8//IGNORE",$adslres);
		FuncExt::error_report(true);
		return $this->result_struct(
			array(
				"stateId"	=> -170,
				"message"	=> "获取Ping结果成功",
				"result"	=> $adslres
			)
		);
	}
}
?>