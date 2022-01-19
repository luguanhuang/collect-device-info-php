<?php
//****************** [Class] NetConfig对象 ******************

/**
 * 网络配置对象
 * 1.LAN口设置
 * 2.WAN口设置
 * 3.DNS设置
 * 4.客票代理设置
 * 5.远程管理代理
*/

//该类必须运行于 PHP5.0 及以上的平台
if ( intval(PHP_VERSION) < 5 ){ exit("<p>Run \"NetConfig\" invite promotion your PHP arrives at 5.0 the above editions</p>");}

if (!class_exists('AtherFrameWork')){ require(dirname(__FILE__)."/AtherFrameWork.php"); }

class NetConfig extends AtherFrameWork{
	
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
	public static function _build()		{return '11.11.21';}			//版本
	public static function _create()	{return '11.11.21';}			//创建
	public static function _classname()	{return __CLASS__;}				//名称
	public static function _developer()	{return "OldFour";}				//开发者
	public static function _copyright()	{return "Aether.CORP";}			//公司
	
	//__________________  只写属性  ________________
	
	
	//__________________  可读写属性  ________________
	
	
	//__________________  私有方法  ________________
	
	protected function get_proxyfield(){
		return array('port'=>"",'server'=>"",'ptype'=>"");
	}
	
	protected function get_proxytickets(){
		//预置默认值
		$defs = $this->get_proxyfield();
		//定义必备的key
		$keys = array_keys($defs);
		//验证配置文件
		$content= $this->file_content(_GLO_FILE_PROXY_,"客票代理配置文件",2510,$interr,$strerr);
		if ($content===false){return $this->result_set($interr,$strerr);}
		//匹配配置文件
		preg_match_all('/(^|[\r\n])[\t\ ]*(port[\t\ ]+\d+[\t\ ]*([\r\n]+([\t\ ]*interface|server|ptype)[\t\ ]*[0-9a-zA-Z\.\:]*)+)/i',$content, $matche);
		//print_r($matches);
		//return null;
		//分析结果
		$result = array();
		$item	= array();
		$field	= array();
		if ($matche){
			$keys = array_keys($keys);
			foreach ($matche[2] as $segment ){
				$fword  = substr($segment,0,1);
				if ($fword=="#" || $fword==";"){ continue; }
				$segment= str_replace("\r", "\n",$segment);
				$segment= str_replace("\t", " ", $segment);
				$lines	= explode("\n", $segment);
				$item	= array();
				foreach ($lines as $line){
					$line = trim($line);
					if($line==""){continue;}
					$field= explode(" ", trim($line), 2);
					$item[$field[0]] = isset($field[1]) ? trim($field[1]) : "";
				}
				//将默认值与结果合并(找出交集->$item的key一定存在于$defs中,再合并$defs->则必要的元素一定存在)
				$result[] = array_merge($defs,array_intersect_key($item,$defs));
			}
			unset($field);	$field	= NULL;
			unset($item);	$item	= NULL;
			unset($matche);	$matche = NULL;
		}
		unset($defs);	$defs = NULL;
		unset($keys);	$keys = NULL;
		//self::$logger->debug( '代理：'.print_r($matche,true) );
		//print_r($result);
		return $this->result_struct(
			array(
				"stateId"	=> -250,
				"message"	=> "获取客票代理服务器配置完成",
				"result"	=> $result
			)
		);
	}
	
	protected function get_remotefield(){
		return array('port'=>"",'server'=>"");
	}
	
	protected function get_remoteadmins(){
		//预置默认值
		$defs = $this->get_remotefield();
		//定义必备的key
		$keys = array_keys($defs);
		//验证配置文件
		$content= $this->file_content(_GLO_FILE_REMOTEADM_,"远程管理配置文件",3010,$interr,$strerr);
		if ($content===false){return $this->result_set($interr,$strerr);}
		//匹配配置文件
		preg_match_all('/(^|[\r\n])[\t\ ]*(port[\t\ ]+\d+[\t\ ]*([\r\n]+([\t\ ]*interface|server|ptype)[\t\ ]*[0-9a-zA-Z\.\:]*)+)/i',$content, $matche);
		//print_r($matches);
		//return null;
		//分析结果
		$result = array();
		$item	= array();
		$field	= array();
		if ($matche){
			$keys = array_keys($keys);
			foreach ($matche[2] as $segment ){
				$fword  = substr($segment,0,1);
				if ($fword=="#" || $fword==";"){ continue; }
				$segment= str_replace("\r", "\n",$segment);
				$segment= str_replace("\t", " ", $segment);
				$lines	= explode("\n", $segment);
				$item	= array();
				foreach ($lines as $line){
					$line = trim($line);
					if($line==""){continue;}
					$field= explode(" ", trim($line), 2);
					$item[$field[0]] = isset($field[1]) ? trim($field[1]) : "";
				}
				//将默认值与结果合并(找出交集->$item的key一定存在于$defs中,再合并$defs->则必要的元素一定存在)
				$result[] = array_merge($defs,array_intersect_key($item,$defs));
			}
			unset($field);	$field	= NULL;
			unset($item);	$item	= NULL;
			unset($matche);	$matche = NULL;
		}
		unset($defs);	$defs = NULL;
		unset($keys);	$keys = NULL;
		//self::$logger->debug( '代理：'.print_r($matche,true) );
		//print_r($result);
		return $this->result_struct(
			array(
				"stateId"	=> -3000,
				"message"	=> "获取远程管理服务器配置完成",
				"result"	=> $result
			)
		);
	}

	
	//__________________  公有方法  ________________
	
	/* 
	获取 LANIP
	number: 1600
	*/
	public function getLanIP($getall=false){
		if (!$this->user_popedom(array(__METHOD__, __CLASS__."::setLanIP"))){return $this->Ary_Popedom;}
		$lines	= $this->file_array(_GLO_FILE_IP_,"IP配置文件",1600,$interr,$strerr);
		if ($lines===false){return $this->result_set($interr,$strerr);}
		$fields	= array();
		$result = array();
		foreach ($lines as $line){
			$line	= trim(preg_replace('/[\s\n\r]/', "", $line));
			if (substr($line,0,1)=="#" || $line==""){ continue; }	//过滤空行和注释行	
			$fields = explode("|", $line);
			if(trim($fields[0]) == "eth0"){continue;}				//过滤WLAN静态IP
			$length = sizeof($fields);
			for($l=$length; $l<5; $l++){$fields[$l] = NULL;}
			//只返回一个
			if (!$getall){
				if ($fields[2]==""){ $fields[2] = parent::_STR_MASK_DEF_; }
				$result = array(
					"ifname"	=>	$fields[0],
					"ip"		=>	$fields[1],
					"mask"		=>	$fields[2],
					"broadcast"	=>	$fields[3],
					"netgate"	=>	$fields[4]
				);	
			}
			else{
				if ($fields[2]==""){ $fields[2] = parent::_STR_MASK_DEF_; }
				$result[] = array(
					"ifname"	=>	$fields[0],
					"ip"		=>	$fields[1],
					"mask"		=>	$fields[2],
					"broadcast"	=>	$fields[3],
					"netgate"	=>	$fields[4]
				);
			}
		}
		unset($lines);	$lines = NULL;
		unset($fields);	$fields= NULL;
		//var_dump($result);
		return $this->result_struct(
			array(
				'stateId'	=> -160,
				'message'	=> '获取IP配置完成', 
				'result'	=> $result	/*只返回一个IP*/
			)
		);
	}
	
	/* 
	保存 LANIP
	number: 1700
	interface: 011
	*/
	public function setLanIP($param){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		//参数
		$keys	= array(
			'ip'		=>	array('name'=>'IP地址', 	'rule'=>parent::_REG_IPADD_),
			'mask'		=>	array('name'=>'子网掩码','rule'=>parent::_REG_IPMASK_, 'default'=>parent::_STR_MASK_DEF_),
			'broadcast'	=>	array('name'=>'广播地址','rule'=>parent::_REG_IPADD_),
			//'netgate'	=>	array('name'=>'默认网关','rule'=>parent::_REG_IPADD_, 'default'=>''),
		);
		$param	= $this->validateArgs($param,$keys,1700,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		$sendarg = _GLO_FILE_IP_."|".$param['ip']."|". $param['mask'] ."|".$param['broadcast'];
		//exit($sendarg);
		//发送socket
		$result	= $this->socket_send(11,$sendarg);
		$message= !$result['state'] ? "保存LAN口配置失败：".$result['errtxt']:"保存LAN口配置成功";
		//写入日志
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -170 : 1706),$message);
	}
	
	/* 获取所有配置的类型 */
	public static function getWlanTypes(){
		static $ary_list;
		if (!isset($ary_list)){$ary_list = parent::config2array(_GLO_DIALUP_TYPES_);}
		return $ary_list;
	}
	
	/* 获取所有网卡类型 */
	public static function getLanTypes(){
		static $ary_list;
		if (!isset($ary_list)){$ary_list = parent::config2array(_GLO_NETCONFING_LANTYPE_);}
		return $ary_list;
	}
	
	/*
	获取 WLAN 配置
	number: 1800
	*/
	public function getWlanConf(){
		if (!$this->user_popedom(array(__METHOD__,__CLASS__."::setWlanConf"))){return $this->Ary_Popedom;}
		//获取当前全局配置
		$gloconf = $this->get_globalConf(1800,$this->Int_Error,$this->Str_Error);
		if ($gloconf===false){return $this->result_set();}
		//如果未指定参数/获取指定的参数为empty
		$wlan = !func_num_args() || !func_get_arg(0) ? NULL : strval(max(intval(func_get_arg(0)),1));
		if (!isset($wlan)){$wlan = !isset($gloconf['wlan']) ? "0" : strval($gloconf['wlan']);}
		if (array_key_exists($wlan,$this->getWlanTypes())===false){return $this->result_set(1806, "不支持当前所设置的WLAN类型");}
		//1.静态IP
		//2.ADSL拨号
		//3.DHCP
		//4.3G拨号
		if ($wlan=="1"){
			$lines	= $this->file_array(_GLO_FILE_IP_,"WAN IP配置文件",1810,$interr,$strerr);
			if ($lines===false){return $this->result_set($interr,$strerr);}
			//默认值
			$result = array(
				"ifname"	=>	"",
				"ip"		=>	"",
				"mask"		=>	"",
				"broadcast"	=>	"",
				"netgate"	=>	"",
			);
			foreach ($lines as $line){
				if (substr($line,0,1)=="#" || $line==""){continue;}	//过滤空行和注释行	
				$fields = explode("|", $line);
				$length = sizeof($fields);
				if( trim($fields[0]) != 'eth0'){ continue; }
				for ($l=$length; $l<5; $l++){$fields[$l]=NULL;}
				//只返回一个结果
				$result = array_combine(array_keys($result), $fields);
				break;
			}
			//网关
			if (trim($result["mask"])==""){$result["mask"]=parent::_STR_MASK_DEF_;}
			//再获取当前路由设置里面的路由地址
			if ( ($content=$this->file_content(_GLO_FILE_ROUTE_,"路由配置文件"))!==false ){
				if (preg_match("/(^|[\r\n])net\|0\.0\.0\.0\|0\.0\.0\.0\|(([0-9]{1,3}\.){3}[0-9]{1,3})\|[\w\-]+([\r\n]|$)/",$content,$match)){
					$result["netgate"] = $match[2];
					unset($match); $match = NULL;
				}
			}
		}
		elseif ($wlan=="2"){
			$content=$this->file_content(_GLO_FILE_PPPOE_ACCOUNT_,"ADSL帐号配置文件",1810,$interr,$strerr);
			if ($content===false){ return $this->result_set($interr,$strerr); }
			$result = array("user"=>"","pwd"=>"");
			if(preg_match('/[^#]\s*USER\s*\=\s*\'(.*?)\'/', $content, $match)){$result["user"]=$match[1];}
			unset($match); $match = NULL;
		}
		else{
			$result = array('g3type' => !isset($gloconf['g3type']) ? "" : $gloconf['g3type']);
		}
		//合并并返回数据
		$result['wlan']	= $wlan;
		return $this->result_struct(
			array(
				"stateId"	=> -180,
				"message"	=> "获取WLAN配置完成",
				"result"	=> $result
			)
		);
	}
	
	/*
	保存 WAN 配置
	number: 1900
	interface: 060
	*/
	public function setWlanConf($param){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		//验证参数
		$keys	= array("wlan"=>array("name"=>"WAN类型","rule"=>parent::_REG_POSINT_));
		$param	= $this->validateArgs($param,$keys,1900,$interr,$strerr);
		if (!$param){ return $this->result_set($interr, $strerr);}
		//验证WLAN类型
		$param["wlan"] = strval($param["wlan"]);
		if (array_key_exists($param["wlan"],$this->getWlanTypes())===false){
			return $this->result_set(1906, "不支持当前所设置的WAN类型");
		}
		//1.静态IP
		//2.ADSL拨号
		//3.DHCP
		//4.3G拨号
		if ($param['wlan']=="1"){
			$timeout= NULL;
			$keys	= array(
				"ip"		=>	array("name"=>"IP地址", "rule"=>parent::_REG_IPADD_),
				"mask"		=>	array("name"=>"子网掩码","rule"=>parent::_REG_IPMASK_,	"default"=>parent::_STR_MASK_DEF_),
				"netgate"	=>	array("name"=>"网关地址","rule"=>parent::_REG_IPADD_),
				"broadcast"	=>	array("name"=>"广播地址","rule"=>parent::_REG_IPADD_)
			);
			$param=$this->validateArgs($param,$keys,1910,$interr,$strerr);
			if (!$param){ return $this->result_set($interr, $strerr); }
			$senddata=_GLO_FILE_GLOBAL_SWITCH_."|".$param['wlan']."|".$param['ip']."|".$param['netgate']."|".$param['mask']."|".$param['broadcast'];
		}
		elseif ($param['wlan']=="2"){
			$timeout= NULL;
			$keys	= array(
				"user"		=>	array("name"=>"拨号用户名", "rule"=>parent::_REG_EXCTACT_),
				"pwd"		=>	array("name"=>"拨号密码"),
			);
			$param	= $this->validateArgs($param,$keys,1910,$interr,$strerr);
			if (!$param){ return $this->result_set($interr, $strerr); }
			if (!preg_match(parent::_REG_PASSWORD_,$param['pwd'])){
				return $this->result_set(1906, "拨号密码不能含有 &lt; &gt; ' &quot; ` 等特殊字符");
			}
			$senddata = _GLO_FILE_GLOBAL_SWITCH_."|".$param['wlan']."|".$param['user']."|".$param['pwd'];
		}
		elseif ($param['wlan']==3){
			$timeout	= _GLO_SOCKET_WANDHCP_;
			$senddata	= _GLO_FILE_GLOBAL_SWITCH_."|".$param['wlan'];
		}
		else{
			$timeout= NULL;
			$keys	= array("lantype" => array("name"=>"网卡类型","rule"=>array_keys(self::getLanTypes())));
			$param	= $this->validateArgs($param,$keys,1910,$interr,$strerr);
			if ( !$param ){ return $this->result_set($interr, $strerr); }
			$senddata = _GLO_FILE_GLOBAL_SWITCH_."|".$param['wlan']."|".$param['lantype'];
		}
		//发送socket
		$result	= $this->socket_send(60,$senddata, $timeout);
		$message= !$result['state'] ? "保存WAN配置失败：".$result['errtxt'] : "保存WAN配置成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -190 : 1916),$message);
	}
	
	
	/*
	获取WAN状态
	number: 2000
	interface: 122
	*/
	public function getWanStatus(){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$result	= $this->socket_send(122,"",_GLO_SOCKET_WANSTATE_);
		$message= !$result['state'] ? "获取WAN口状态失败：".$result['errtxt'] : "获取WAN口状态成功";
		//$this->log($this->Ary_Session['user'],$message);
		if (!$result['state']){return $this->result_set(2000,$message);}
		$result["request"] = iconv("gb2312","utf-8//IGNORE",$result["request"]);
		$redata = explode("|",$result["request"]);
		$state	= array(
			"type"		=> isset($redata[1]) ? $redata[1] : "",
			"ip"		=> isset($redata[2]) ? $redata[2] : "",
			"mask"		=> isset($redata[3]) ? $redata[3] : "",
			"broadcast"	=> isset($redata[4]) ? $redata[4] : "",
			"dns1"		=> isset($redata[5]) ? $redata[5] : "",
			"dns2"		=> isset($redata[6]) ? $redata[6] : "",
			"message"	=> isset($redata[7]) ? $redata[7] : "",
		);
		unset($redata); $redata = NULL;
		return $this->result_struct(
			array(
				"stateId"	=> -200,
				"message"	=> $message,
				"result"	=> $state
			)
		);
	}
	
	/*
	获取WAN状态
	number: 2000
	interface: 122
	*/
	public function serverstate(){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$result	= $this->socket_send(180,"",_GLO_SOCKET_WANSTATE_);
		$message= !$result['state'] ? "获取认证服务状态失败：".$result['errtxt'] : "获取认证服务状态成功";
		//$this->log($this->Ary_Session['user'],$message);
		if (!$result['state']){return $this->result_set(2000,$message);}
		$result["request"] = iconv("gb2312","utf-8//IGNORE",$result["request"]);
		$redata = explode("|",$result["request"]);
		$state	= array(
			"message"	=> isset($redata[1]) ? $redata[1] : "",
		);
		unset($redata); $redata = NULL;
		return $this->result_struct(
			array(
				"stateId"	=> -200,
				"message"	=> $message,
				"result"	=> $state
			)
		);
	}
	
public function serverstate2(){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$result	= $this->socket_send(181,"",_GLO_SOCKET_WANSTATE_);
		$message= !$result['state'] ? "获取业务服务状态失败：".$result['errtxt'] : "获取业务服务状态成功";
		//$this->log($this->Ary_Session['user'],$message);
		if (!$result['state']){return $this->result_set(2000,$message);}
		$result["request"] = iconv("gb2312","utf-8//IGNORE",$result["request"]);
		$redata = explode("|",$result["request"]);
		$state	= array(
			"message"	=> isset($redata[1]) ? $redata[1] : "",
		);
		unset($redata); $redata = NULL;
		return $this->result_struct(
			array(
				"stateId"	=> -200,
				"message"	=> $message,
				"result"	=> $state
			)
		);
	}
	/*
	PPPOE拨号连接
	number: 2100
	interface: 110
	*/
	public function dialPPPOE(){
		if (!$this->user_popedom(array(__METHOD__, __CLASS__."::offPPPOE"))){return $this->Ary_Popedom;}
		$result	= $this->socket_send(110,"");
		$message= $result['error']>0 ? "发送拨号命令失败：".$result['errtxt'] : "发送拨号命令完成";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['error']<=0 ? -210 : 2100),$message);
	}
	/*
	PPPOE断开连接
	number: 2200
	interface: 111
	*/
	public function offPPPOE(){
		if (!$this->user_popedom(array(__METHOD__, __CLASS__."::dialPPPOE"))){return $this->Ary_Popedom;}
		$result	= $this->socket_send(111,"");
		$message= !$result['state'] ? "断开连接失败：".$result['errtxt'] : "断开连接成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -220 : 2200),$message);
	}
	
	/*
	返回DNS列表
	number: 2300
	*/
	public function getDNS(){
		if (!$this->user_popedom(array(__METHOD__, __CLASS__."::setDNS,"))){return $this->Ary_Popedom;}
		$lines = $this->file_array(_GLO_FILE_PPPOE_DNS_,"DNS 配置文件",2300,$interr,$strerr);
		if ($lines===false){return $this->result_set($interr,$strerr);}
		$number= 1;
		foreach ($lines as $index=>$line){
			$line =  trim(preg_replace('/(\s)|(^[\#\;].+?$)|([a-zA-Z])/', '', $line));
			if($line=="" || substr($line,0,1)=='#'){ continue; }
			$result["dns".$number] = $line;
			$number++;
		}
		unset($lines); $lines = NULL;
		//至少返回2个DNS
		if (!isset($result["dns1"])){$result["dns1"]="";}
		if (!isset($result["dns2"])){$result["dns2"]="";}
		return $this->result_struct(
			array(
				"stateId"	=> -230,
				"message"	=> "获取DNS配置完成",
				"result"	=> $result
			)
		);
	}
	/*
	保存DNS列表
	number: 2400
	interface: 121
	*/
	public function setDNS($param){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$keys	= array(
			'dns1'		=>	array('name'=>'首选DNS服务器', 'rule'=>parent::_REG_IPADD_, 'empty'=>true),
			'dns2'		=>	array('name'=>'备用DNS服务器', 'rule'=>parent::_REG_IPADD_, 'empty'=>true),
		);
		$param	= $this->validateArgs($param,$keys,2400,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		if (!isset($param['dns1'])){ $param['dns1'] = ""; }
		if (!isset($param['dns2'])){ $param['dns2'] = ""; }
		if ( $param['dns1']=="" && $param['dns2']=="" ){return $this->result_set(2406,"DNS服务器地址不能全部为空");}
		$sendarg = $param['dns1']."|".$param['dns2'];
		//发送socket
		$result	= $this->socket_send(121,$sendarg);
		$message= !$result['state']?"保存DNS服务器配置失败：".$result['errtxt']:"保存DNS服务器配置成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -240 : 2406),$message);
	}
	
	
public function getSoftUpdate(){
		if (!$this->user_popedom(array(__METHOD__, __CLASS__."::getSoftUpdate,"))){return $this->Ary_Popedom;}
		$lines = $this->file_array("/usr/local/npclient/etc/npclient.cfg","软件更新配置文件",2300,$interr,$strerr);
		if ($lines===false){return $this->result_set($interr,$strerr);}
		$number= 1;
		foreach ($lines as $index=>$line){
			$line =  trim($line);
			if($line=="" || substr($line,0,1)=='#'){ continue; }
			
			$monip=strstr($line,"monip");
			if (!empty($monip)) 
			{$monip=trim(preg_replace('/monip\s?=\s?/',"",$monip));
			$result["serverip"] = $monip;
			}
		
			
			$monport=strstr($line,"monport");
			if (!empty($monport)) {
			$monport= trim(preg_replace("/monport\s?=\s?/","",$monport));
			$result["port"] = $monport;
			}
			
			$loglevel=strstr($line,"loglevel");
			if (!empty($loglevel)) {
			$loglevel= trim(preg_replace('/loglevel\s?=\s?/',"",$loglevel));
			$result["loglevel"] = $loglevel;
			}
			
		$logcount=strstr($line,"logcount");
			if (!empty($logcount)) {
			 $logcount = trim(preg_replace('/logcount\s?=\s?/',"",$logcount));
			$result["logcount"] = $logcount;
			}
			
		}
		unset($lines); $lines = NULL;
		if (!isset($result["serverip"])){$result["serverip"]="";}
		if (!isset($result["port"])){$result["port"]="";}
		if (!isset($result["loglevel"])){$result["loglevel"]="";}
		if (!isset($result["logcount"])){$result["logcount"]="";}
		return $this->result_struct(
			array(
				"stateId"	=> -230,
				"message"	=> "获取软件更新配置完成",
				"result"	=> $result
			)
		);
	}
	
	
public function getSoftUpdateinfo(){
		if (!$this->user_popedom(array(__METHOD__, __CLASS__."::getSoftUpdate,"))){return $this->Ary_Popedom;}
		$lines = $this->file_array("/usr/local/npclient/etc/npc_upgrade.cfg","软件更新配置文件",2300,$interr,$strerr);
		if ($lines===false){return $this->result_set($interr,$strerr);}
		$number= 1;
		foreach ($lines as $index=>$line){
			$line =  trim($line);
			if($line=="" || substr($line,0,1)=='#'){ continue; }
			
			if ($index==0)
			$result["softtime"]=$line;
			else
			$result["softvion"]=$line;
			
		}
		unset($lines); $lines = NULL;
		if (!isset($result["softtime"])){$result["softtime"]="";}
		if (!isset($result["softvion"])){$result["softvion"]="";}
		
		return $this->result_struct(
			array(
				"stateId"	=> -230,
				"message"	=> "获取软件更新配置完成",
				"result"	=> $result
			)
		);
	}
	
	
	
	/*
	保存DNS列表
	number: 2400
	interface: 121
	*/
	public function setSoftUpdate($param){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$keys	= array(
			'serverip'		=>	array('name'=>'服务器ip', 'rule'=>parent::_REG_IPADD_, 'empty'=>true),
			'port'		=>	array('name'=>'端口', 'rule'=>parent::_REG_POSINT_, 'empty'=>true),
			'loglevel'		=>	array('name'=>'日志级别', 'rule'=>parent::_REG_POSINT_, 'empty'=>true),
			'logcount'		=>	array('name'=>'日志数量', 'rule'=>parent::_REG_POSINT_, 'empty'=>true),
		);
		$param	= $this->validateArgs($param,$keys,2400,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		if (!isset($param['serverip'])){ $param['serverip'] = ""; }
		if (!isset($param['port'])){ $param['port'] = ""; }
		if ( $param['serverip']=="" && $param['port']=="" ){return $this->result_set(2406,"端口和IP不能为空");}
		$sendarg = $param['serverip']."|".$param['port']."|".$param['logcount']."|".$param['loglevel'];
		//发送socket
		$result	= $this->socket_send(179,$sendarg);
		$message= !$result['state']?"保存软件更新配置失败：".$result['errtxt']:"保存软件更新配置成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -240 : 2406),$message);
	}
	
	/*
	返回客票代理列表
	number: 2500
	*/
	public function getProxyTicketList(){
		if (!$this->user_popedom(
			array(__METHOD__, __CLASS__."::getProxyTicket", __CLASS__."::setProxyTicket",__CLASS__."::delProxyTicket")
		)){return $this->Ary_Popedom;}
		return $this->get_proxytickets();
	}

	/*
	返回某个客票代理
	number: 2600
	*/
	//完全由第二个参数决定是否为进入添加，添加时完全忽略第一个参数！！！
	public function getProxyTicket($param=array(),$action="add"){
		//验证权限
		if (!$this->user_popedom(
			array(__METHOD__, __CLASS__."::getProxyTicketList",__CLASS__."::setProxyTicket",__CLASS__."::delProxyTicket")
		)){return $this->Ary_Popedom;}
		//验证参数
		if (func_num_args()==1 && !is_array($param) && !is_object($param)){$action = $param;}
		$action = strtolower(strval($action));
		if ($action=="mod"){
			//定义必备的key
			$keys = array( 'port'=>array('name'=>'端口号',	'min'=>parent::_INT_PORT_MIN_,	'max'=>parent::_INT_PORT_MAX_) );
			//验证
			$param	= $this->validateArgs($param,$keys,2600,$interr,$strerr);
			if (!$param){ return $this->result_set($interr, $strerr); }
			//获取所有记录
			$result = $this->get_proxytickets();
			if (!$result['state']){ return $result; }
			//验证是否存在(以端口为唯一标示)
			$exists = false;
			foreach($result['result'] as $k=>$v){
				if ($v['port']==$param['port']){ $exists=true; $result=$v; break; }
			}
			if (!$exists){return $this->result_set(2606,"指定的客票代理服务器配置不存在");}
			//构造返回结构
			$result['step']	= "mod";
			$result['title']= "编辑客票代理";
		}
		else{
			//预置默认值
			$result = $this->get_proxyfield();
			$result['server']	= "";//$_SERVER['HTTP_HOST'];
			$result['ptype']	= 1;
			$result['step']		= "add";
			$result['title']	= "添加客票代理";
		}
		//返回结果
		return $this->result_struct(
			array(
				"stateId"	=> -260,
				"message"	=> "获取客票代理服务器配置完成",
				"result"	=> $result
			)
		);
	}

	/*
	保存客票代理设置
	number: 2700
	interface: 30-32
	*/
	public function setProxyTicket($param,$action="add"){
		$action = strtolower(strval($action));
		if ($action =="del" ){
			$method = __CLASS__."::delProxyTicket";
			$metnum = "032";
			$title	= "删除客票代理设置";
		}
		elseif ($action =="mod" ){
			$method = __METHOD__;
			$metnum = "031";
			$title	= "修改客票代理设置";
		}
		else{
			$method = __METHOD__;
			$metnum = "030";
			$title	= "添加客票代理设置";
		}
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		#0056|032|/usr/local/transproxy/etc/transproxy.conf|55555
		#0091|031|/usr/local/transproxy/etc/transproxy.conf|55555|192.168.17.150|192.168.5.63:4480|1
		$keys	= $action =="del" ?
			array(
				'port'		=> array('name'=>'端口号',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			)
			:
			array(
				'port'		=>	array('name'=>'端口号',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
				'server'	=>	array('name'=>'远程服务器和端口',	'rule'=>parent::_REG_IPPORT_),
				'ptype'		=>	array('name'=>'协议类型',			'rule'=>explode(",",parent::_STR_PROTOCOL_ALL_)),
			);
		$param	= $this->validateArgs($param,$keys,2700,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		//如果是修改的
		if ($action =="mod"){
			//获取所有记录
			$result = $this->get_proxytickets();
			if (!$result['state']){ return $result; }
			//验证是否存在(以端口为唯一标示)
			$exists = false;
			foreach($result['result'] as $k=>$v){if ($v['port']==$param['port']){ $exists=true; $result=$v; break; }}
			if (!$exists){return $this->result_set(2706,"指定的客票代理服务器配置不存在");}
		}
		if ( $action =="del" ){$sendarg = _GLO_FILE_PROXY_."|".$param['port'];}
		else{ $sendarg=_GLO_FILE_PROXY_."|".$param['port']."|".$_SERVER["SERVER_ADDR"]."|".$param['server']."|".$param['ptype']; }
		//发送socket
		$result	= $this->socket_send($metnum,$sendarg);
		$message= !$result['state'] ? $title."失败：".$result['errtxt']:$title."成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -270 : 2707),$message);
	}
	/*
	删除客票代理设置
	number: 2800
	interface: 30-32
	*/
	public function delProxyTicket($param){
		return $this->setProxyTicket($param,"del");
	}
	
	/*重启客票代理
	number: 2900
	interface:33
	*/
	public function resetProxyTicket(){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$result	= $this->socket_send(33,"");
		$message= !$result['state']?"重启客票代理服务失败：".$result['errtxt']:"重启客票代理服务成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -290 : 2900),$message);
	}
	
	/*
	返回远程管理配置列表
	number: 3000
	*/
	public function getRemoteAdminList(){
		if (!$this->user_popedom(
			array(__METHOD__, __CLASS__."::getRemoteAdmin", __CLASS__."::setRemoteAdmin",__CLASS__."::delRemoteAdmin")
		)){return $this->Ary_Popedom;}
		return $this->get_remoteadmins();
	}

	/*
	返回远程管理配置
	number: 3100
	*/
	//完全由第二个参数决定是否为进入添加，添加时完全忽略第一个参数！！！
	public function getRemoteAdmin($param=array(),$action="add"){
		//验证权限
		if (!$this->user_popedom(
			array(__METHOD__, __CLASS__."::getRemoteAdminList",__CLASS__."::setRemoteAdmin",__CLASS__."::delRemoteAdmin")
		)){return $this->Ary_Popedom;}
		//获取所有记录
		$result = $this->get_remoteadmins();
		if (!$result['state']){ return $result; }
		$counts	= sizeof($result['result']);
		//验证参数
		if (func_num_args()==1 && !is_array($param) && !is_object($param)){$action = $param;}
		$action = strtolower(strval($action));
		if ($action=="mod"){
			//定义必备的key
			$keys = array( 'port'=>array('name'=>'端口号',	'min'=>parent::_INT_PORT_MIN_,	'max'=>parent::_INT_PORT_MAX_) );
			//验证
			$param= $this->validateArgs($param,$keys,3100,$interr,$strerr);
			if (!$param){ return $this->result_set($interr, $strerr); }
			//验证是否存在(以端口为唯一标示)
			$exists = false;
			foreach($result['result'] as $k=>$v){ if ($v['port']==$param['port']){ $exists=true;$result=$v;break; }}
			if (!$exists){return $this->result_set(3106,"指定的远程管理服务器配置不存在");}
			//构造返回结构
			$result['step']		= "mod";
			$result['title']	= "编辑远程管理配置";
			$result['count']	= $counts;
		}
		else{
			//预置默认值
			$result = $this->get_remotefield();
			$result['server']	= "";	//$_SERVER['HTTP_HOST'];
			$result['ptype']	= 1;
			$result['step']		= "add";
			$result['title']	= "添加远程管理配置";
			$result['count']	= $counts;
		}
		//返回结果
		return $this->result_struct(
			array(
				"stateId"	=> -310,
				"message"	=> "获取远程管理配置完成",
				"result"	=> $result
			)
		);
	}

	/*
	保存远程管理配置
	number: 3200
	interface:230-232
	*/
	public function setRemoteAdmin($param,$action="add"){
		$action = strtolower(strval($action));
		if ($action =="del" ){
			$method = __CLASS__."::delRemoteAdmin";
			$metnum = "232";
			$title	= "删除远程管理配置";
		}
		elseif ($action =="mod" ){
			$method = __METHOD__;
			$metnum = "231";
			$title	= "修改远程管理配置";
		}
		else{
			$method = __METHOD__;
			$metnum = "230";
			$title	= "添加远程管理配置";
		}
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		#0056|032|/usr/local/transproxy/etc/transproxy.conf|55555
		#0091|031|/usr/local/transproxy/etc/transproxy.conf|55555|192.168.17.150|192.168.5.63:4480|1
		$keys	= $action =="del" ?
			array(
				'port'		=> array('name'=>'端口号',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			)
			:
			array(
				'port'		=>	array('name'=>'端口号',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
				'server'	=>	array('name'=>'远程服务和端口',	'rule'=>parent::_REG_IPPORT_),
				'ptype'		=>	array('name'=>'协议类型',			'rule'=>explode(",",parent::_STR_PROTOCOL_ALL_)),
			);
		$param	= $this->validateArgs($param,$keys,3200,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		//发送的字符创
		if ( $action =="del" ){
			$sendarg = _GLO_FILE_REMOTEADM_."|".$param['port'];
		}
		else{
			//获取所有记录
			$result = $this->get_remoteadmins();
			if (!$result['state']){ return $result; }
			//如果是修改的
			if ($action =="mod"){
				//验证是否存在(以端口为唯一标示)
				$exists = false;
				foreach($result['result'] as $k=>$v){if ($v['port']==$param['port']){ $exists=true; $result=$v; break; }}
				if (!$exists){return $this->result_set(3206,"指定的远程管理服务器配置不存在");}
			}
			//如果是添加
			else{
				$enabled = sizeof($result['result'])<_GLO_REMOTEADMIN_MAX_;
				if (!$enabled){return $this->result_set(3207,"最多只能配置 ". _GLO_REMOTEADMIN_MAX_ ." 个远程管理服务器");}
			}
			$sendarg=_GLO_FILE_REMOTEADM_."|".$param['port']."|0.0.0.0|".$param['server']."|0";
		}
		//发送socket
		$result	= $this->socket_send($metnum,$sendarg);
		$message= !$result['state'] ? $title."失败：".$result['errtxt']:$title."成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -320 : 3207),$message);
	}
	/*
	删除远程管理配置
	number: 3300
	interface: 232
	*/
	public function delRemoteAdmin($param){
		return $this->setRemoteAdmin($param,"del");
	}
	
	/*重启远程管理
	number: 3400
	interface:233
	*/

	public function resetRemoteAdmin(){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		$result	= $this->socket_send(233,"");
		$message= !$result['state']?"重启远程管理服务器失败：".$result['errtxt']:"重启远程管理服务器成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -340 : 3400),$message);
	}
	
	
	
protected function getsslsetfield(){
		return array('port'=>"",'interface'=>'','server'=>"",'ssltype'=>"",'ccheck'=>"",'stampd'=>"",'hmac'=>"",'logaudit'=>"",'report'=>"",'timeout'=>"",'ptype'=>"");
		//'ssltype','ccheck','stampd','hmac','logaudit','report','timeout','ptype'
	}
	
public function getsslsetlist(){
		//预置默认值
		$defs = $this->getsslsetfield();
		//定义必备的key
		$keys = array_keys($defs);
		//验证配置文件
		$content= $this->file_content("/usr/local/transproxy/etc/sslserver.cfg","远程管理配置文件",3010,$interr,$strerr);
		if ($content===false){return $this->result_set($interr,$strerr);}
		//匹配配置文件
		preg_match_all('/(^|[\r\n])[\t\ ]*(port[\t\ ]+\d+[\t\ ]*([\r\n]+(.|\n)*?([\t\ ]*ptype)[\t\ ]*\d+)+?)/i',$content, $matche);
		//print_r($matches);
		//return null;
		//分析结果
		$result = array();
		$item	= array();
		$field	= array();
		if ($matche){
			$keys = array_keys($keys);
			foreach ($matche[2] as $segment ){
				$fword  = substr($segment,0,1);
				if ($fword=="#" || $fword==";"){ continue; }
				$segment= str_replace("\r", "\n",$segment);
				$segment= str_replace("\t", " ", $segment);
				$lines	= explode("\n", $segment);
				$item	= array();
				foreach ($lines as $line){
					$line = trim($line);
					if($line==""){continue;}
					$field= explode(" ", trim($line), 2);
					$item[$field[0]] = isset($field[1]) ? trim($field[1]) : "";
				}
				//将默认值与结果合并(找出交集->$item的key一定存在于$defs中,再合并$defs->则必要的元素一定存在)
				$result[] = array_merge($defs,array_intersect_key($item,$defs));
			}
			unset($field);	$field	= NULL;
			unset($item);	$item	= NULL;
		//	unset($matche);	$matche = NULL;
		}
		unset($defs);	$defs = NULL;
		unset($keys);	$keys = NULL;
		//self::$logger->debug( '代理：'.print_r($matche,true) );
		//print_r($result);
		return $this->result_struct(
			array(
				"stateId"	=> -3000,
				"message"	=> "获取SSL服务器配置完成",
				"result"	=> $result
			)
		);
	}
	
	
public function getSslSet($param=array(),$action="add"){
		
		//获取所有记录
		$result = $this->getsslsetlist();
		if (!$result['state']){ return $result; }
		$counts	= sizeof($result['result']);
		//验证参数
		if (func_num_args()==1 && !is_array($param) && !is_object($param)){$action = $param;}
		$action = strtolower(strval($action));
		if ($action=="mod"){
			//定义必备的key
			$keys = array( 'port'=>array('name'=>'端口号',	'min'=>parent::_INT_PORT_MIN_,	'max'=>parent::_INT_PORT_MAX_) );
			//验证
			$param= $this->validateArgs($param,$keys,3100,$interr,$strerr);
			if (!$param){ return $this->result_set($interr, $strerr); }
			//验证是否存在(以端口为唯一标示)
			$exists = false;
			foreach($result['result'] as $k=>$v){ if ($v['port']==$param['port']){ $exists=true;$result=$v;break; }}
			if (!$exists){return $this->result_set(3106,"指定的SSL管理服务器配置不存在");}
			//构造返回结构
			$result['step']		= "mod";
			$result['title']	= "编辑SSL管理配置";
			$result['count']	= $counts;
		}
		else{
			//预置默认值
			$result = $this->get_remotefield();
			$result['server']	= "";	//$_SERVER['HTTP_HOST'];
			$result['ptype']	= 1;
			$result['interface']	= "0.0.0.0";
			
			$result['step']		= "add";
			$result['title']	= "添加SSL管理配置";
			$result['count']	= $counts;
		}
		//返回结果
		return $this->result_struct(
			array(
				"stateId"	=> -310,
				"message"	=> "获取SSL管理配置完成",
				"result"	=> $result
			)
		);
	}

	
	/*
	保存远程管理配置
	number: 3200
	interface:230-232
	*/
	public function setSslSet($param,$action="add"){
		$action = strtolower(strval($action));
		if ($action =="del" ){
			$method = __CLASS__."::delSslSet";
			$metnum = "184";
			$title	= "删除SSL管理配置";
		}
		elseif ($action =="mod" ){
			$method = __METHOD__;
			$metnum = "183";
			$title	= "修改SSL管理配置";
		}
		else{
			$method = __METHOD__;
			$metnum = "182";
			$title	= "添加SSL管理配置";
		}
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		#0056|032|/usr/local/transproxy/etc/transproxy.conf|55555
		#0091|031|/usr/local/transproxy/etc/transproxy.conf|55555|192.168.17.150|192.168.5.63:4480|1
		$keys	= $action =="del" ?
			array(
				'port'		=> array('name'=>'端口号',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			)
			:
			array(
				'port'		=>	array('name'=>'端口号',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			  'interface'	=>	array('name'=>'IP',	'rule'=>parent::_REG_IPADD_),
				'server'	=>	array('name'=>'远程服务和端口',	'rule'=>parent::_REG_IPPORT_),
				'ssltype'		=>	array('name'=>'SSL类型',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'ccheck'		=>	array('name'=>'检查证书类型',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'stampd'		=>	array('name'=>'是否签名',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'hmac'		=>	array('name'=>'检查mac地址',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'logaudit'		=>	array('name'=>'日志认证',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'report'		=>	array('name'=>'上报日志',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'timeout'		=>	array('name'=>'超时',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			 'ptype'		=>	array('name'=>'传输类型',			'min'=>parent::_INT_PORT_MIN_,'max'=>parent::_INT_PORT_MAX_),
			);

		$param	= $this->validateArgs($param,$keys,3200,$interr,$strerr);
		if ( !$param ){ return $this->result_set($interr, $strerr); }
		//发送的字符创
		if ( $action =="del" ){
			$sendarg = "/usr/local/transproxy/etc/sslserver.cfg"."|".$param['port'];
		}
		else{
			//获取所有记录
			$result = $this->getsslsetlist();
		//	if (!$result['state']){ return $result; }
			//如果是修改的
			if ($action =="mod"){
				//验证是否存在(以端口为唯一标示)
				$exists = false;
				foreach($result['result'] as $k=>$v){if ($v['port']==$param['port']){ $exists=true; $result=$v; break; }}
				if (!$exists){return $this->result_set(3206,"指定的SSL管理服务器配置不存在");}
			}
			//如果是添加
			else{
				$enabled = sizeof($result['result'])<_GLO_REMOTEADMIN_MAX_;
				if (!$enabled){return $this->result_set(3207,"最多只能配置 ". _GLO_REMOTEADMIN_MAX_ ." 个SSL管理服务器");}
			}
			$sendarg="/usr/local/transproxy/etc/sslserver.cfg"."|".$param['port']."|".$param['interface']."|".$param['server']."|".$param['ssltype']."|".$param['ccheck']."|".$param['stampd']."|".$param['hmac']."|".$param['logaudit']."|".$param['report']."|".$param['timeout']."|".$param['ptype'];
		}
		//发送socket
		$result	= $this->socket_send($metnum,$sendarg);
		$message= !$result['state'] ? $title."失败：".$result['errtxt']:$title."成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -320 : 3207),$message);
	}
	/*
	删除远程管理配置
	number: 3300
	interface: 232
	*/
	public function delSslSet($param){
		return $this->setSslSet($param,"del");
	}
	
	public function setProxyTicket2($param){
		if (!$this->user_popedom(__METHOD__)){return $this->Ary_Popedom;}
		if(empty($param["mobi"])) $param["mobi"]=0;
		if(empty($param["log"])) $param["log"]=0;
		$result	= $this->socket_send(178,$param["log"]."|".$param["mobi"]);
		$message= !$result['state']?"配置失败：".$result['errtxt']:"配置成功";
	//	$message= "配置成功";
		$this->log($this->Ary_Session['user'],$message);
		return $this->result_set(($result['state'] ? -340 : 3400),$message);
	}
	
	
	
protected function get_proxyfield2(){
		return array('dzzf_audit'=>"",'stamped'=>"");
	}
	
	public function get_proxytickets2(){
		
		//验证配置文件
		$content= $this->file_content(_GLO_FILE_PROXY_,"客票代理配置文件",2510,$interr,$strerr);
		if ($content===false){return $this->result_set($interr,$strerr);}
			
		preg_match_all('/(^|[\r\n])[\t\ ]*(dzzf_audit[\t\ ]+\d[\t\ ]*([\r\n]+([\t\ ]*stamped)[\t\ ]*[0-9a-zA-Z\.\:]*)*)/i',$content, $match);
	
		
		$tmps= str_replace("\r", " ",$match[0][0]);
		$tmps= str_replace("\n", " ",$tmps);
		$tmps= str_replace("\t", " ",$tmps);
		$tmp=explode(" ", $tmps);		
				
	return $this->result_struct(
			array(
				"stateId"	=> -251,
				"message"	=> "获取客票代理服务器配置完成",
				"result"	=> array('dzzf_audit'=>$tmp[2],'stamped'=>$tmp[4])
			)
		);
	}
	
}	
?>