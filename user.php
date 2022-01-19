<?php
//****************** [Class] 路由对象 ******************

//该类必须运行于 PHP5.0 及以上的平台
if ( intval(PHP_VERSION) < 5 ){ exit("<p>Run \"Station\" invite promotion your PHP arrives at 5.0 the above editions</p>");}

if (!class_exists('AtherFrameWork')){ require(dirname(__FILE__)."/AtherFrameWork.php"); }
require_once 'tlog.php';
//require_once '/var/www/html/htdocs/dao/IMerchantsResult.DB.php';
require_once '/var/www/html/htdocs/dao/IMerchantsResult.DB.php';
class User extends AtherFrameWork{
	
	//__________________  构造/析构函数  ________________
	
	/**/
	function __construct(){
		$shandanDBFlg = 1;
		parent::__construct();
	}
	
	public $shandanDBFlg;
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
	
	public function getAddUserList($page){
		TLOG_MSG("User::getAddUserList: func begin");
		$urlparam = "";
	    $pagequery = array();
	    $output = array("data"=>array(),
	        "pagequery"=>array(),
	        "totalNum"=>0,
	        "retCode"=>0,
	        "sErrMsg"=>"");
		
		if (intval($page) <= 0)
	    {
	        $page = 1;
	    }
		
		$merchantsResult_DB = new IMerchantsResult_DB($this->shandanDBFlg);
		$ret =  $merchantsResult_DB->getCompanyDetail($page);
		if ($ret["result"] != 0)
	    {
	        $output["retCode"] = $ret["result"];
	        $output["sErrMsg"] = $ret["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		if(is_array($ret["data_list"]))
		{
			foreach($ret["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["companyname"] = $item["companyname"];
	            $retItem["status"] = $item["status"];
				$retItem["created_date"] = $item["created_date"];
				$output["data"][] = $retItem;
			}
		}
		$output["totalNum"] = $ret["totalNum"];
		
		$ret =  $merchantsResult_DB->getGroupDetail(1);
		if ($ret["result"] != 0)
	    {
	        $output["retCode"] = $ret["result"];
	        $output["sErrMsg"] = $ret["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		if(is_array($ret["data_list"]))
		{
			foreach($ret["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["name"] = $item["name"];
				$output["groupinfo"][] = $retItem;
			}
		}
		
		$ret =  $merchantsResult_DB->getStationName("");
		if ($ret["result"] != 0)
	    {
	        $output["retCode"] = $ret["result"];
	        $output["sErrMsg"] = $ret["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		if(is_array($ret["data_list"]))
		{
			foreach($ret["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["name"] = $item["name"];
				 $retItem["company_id"] = $item["company_id"];
	            $retItem["group_id"] = $item["group_id"];
				$output["stationinfo"][] = $retItem;
			}
		}
		
		$ret =  $merchantsResult_DB->getRoleInfo("");
		if ($ret["result"] != 0)
	    {
	        $output["retCode"] = $ret["result"];
	        $output["sErrMsg"] = $ret["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		if(is_array($ret["data_list"]))
		{
			foreach($ret["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["name"] = $item["name"];
				$output["roleinfo"][] = $retItem;
			}
		}
	    
	    $psize = 20;
	    $pshow = 10;
	    $result		= array();
	    $result		= FuncExt::pagination($ret["totalNum"], $psize, $page, $pshow);
		$output["recordcount"] = $result["recordcount"];
	    $output["pagecount"] = $result["pagecount"];
	    $output["pagesize"] = $result["pagesize"];
	    $output["absolutepage"] = $result["absolutepage"];
	    $output["previouspage"] = $result["previouspage"];
	    $output["nextpage"] = $result["nextpage"];
	    $output["startpage"] = $result["startpage"];
	    $output["endpage"] = $result["endpage"];
	    $output["pagequery"] = $pagequery;
	    $output["urlparam"] = $urlparam;
		
		//$paging	= FuncExt::pagination($loglist['total'], $limit, $page, 10);					//分页
		
		return $this->result_struct(
	        array(
	            'stateId'	=> -160,
	            'message'	=> 'get company info succeed',
	            'result'	=> $output
	        )
	    );
	}
	
	
	public function editUser($param)
	{
		TLOG_MSG("User::editUser: func begin");
		$merchantsResult_DB = new IMerchantsResult_DB($this->shandanDBFlg);
		$result = $merchantsResult_DB->editUser($param);
		$message= $result['result'] ? "edit user failure: ".$result['errorMsg']:"edit user succeed";
		//$this->log($this->Ary_Session['user'],$message);
		return $this->result_set((!$result['result'] ? -108 : 1807),$message);
	}
	
	public function addUser($param)
	{
		TLOG_MSG("User::addUser: func begin");
		$merchantsResult_DB = new IMerchantsResult_DB($this->shandanDBFlg);
		$result = $merchantsResult_DB->AddUser($param);
		$message= $result['result'] ? "add user failure: ".$result['errorMsg']:"add user succeed";
		//$this->log($this->Ary_Session['user'],$message);
		return $this->result_set((!$result['result'] ? -108 : 1807),$message);
	}
	
	public function getUserAllData($param){
		$var=explode(",",$param);
		TLOG_MSG("User::getUserAllData: func begin page=".$param." var0=".$var[0]." var1=".$var[1]);
		$urlparam = "";
	    $pagequery = array();
	    $output = array("data"=>array(),
	        "pagequery"=>array(),
	        "totalNum"=>0,
	        "retCode"=>0,
	        "sErrMsg"=>"");
		
		/*if (intval($page) <= 0)
	    {
	        $page = 1;
	    }*/
		
		$merchantsResult_DB = new IMerchantsResult_DB($this->shandanDBFlg);
		$ret =  $merchantsResult_DB->getCompanyDetail(1);
		if ($ret["result"] != 0)
	    {
	        $output["retCode"] = $ret["result"];
	        $output["sErrMsg"] = $ret["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		
		
		$id = "";
		if(is_array($ret["data_list"]))
		{
			foreach($ret["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["companyname"] = $item["companyname"];
	            $retItem["status"] = $item["status"];
				$retItem["created_date"] = $item["created_date"];
				$output["data"][] = $retItem;
			}
		}
		$output["totalNum"] = $ret["totalNum"];
		$return =  $merchantsResult_DB->getSpecialGroupName($var[0]);
		if ($return["result"] != 0)
	    {
	        $output["retCode"] = $return["result"];
	        $output["sErrMsg"] = $return["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		
		if(is_array($return["data_list"]))
		{
			foreach($return["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["name"] = $item["name"];
				$output["datainfo"][] = $retItem;
			}
		}
		
		$sqloption = "  where company_id='".$var[0]."' and group_id='".$var[1]."'";
		$resStation =  $merchantsResult_DB->getStationName($sqloption);
		if ($resStation["result"] != 0)
		{
			$output["retCode"] = $resStation["result"];
			$output["sErrMsg"] = $resStation["sErrMsg"];
			$test = "SearchResultCB(".json_encode($output).")";
			echo $test;
			return -1;
		}
		
		if(is_array($resStation["data_list"]))
		{
			foreach($resStation["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["name"] = $item["name"];
				$output["stainfo"][] = $retItem;
			}
		}
	    
		$sqloption = "";
		$resStation =  $merchantsResult_DB->getRoleInfo();
		if ($resStation["result"] != 0)
		{
			$output["retCode"] = $resStation["result"];
			$output["sErrMsg"] = $resStation["sErrMsg"];
			$test = "SearchResultCB(".json_encode($output).")";
			echo $test;
			return -1;
		}
		
		if(is_array($resStation["data_list"]))
		{
			foreach($resStation["data_list"] as $item)
			{
				
				$retItem = array();
	            
	            $retItem["id"] = $item["id"];
	            $retItem["name"] = $item["name"];
				$output["roleinfo"][] = $retItem;
			}
		}
		
	    $psize = 20;
	    $pshow = 10;
		
		return $this->result_struct(
	        array(
	            'stateId'	=> -160,
	            'message'	=> 'get company info succeed',
	            'result'	=> $output
	        )
	    );
		
		
	}
	
	//__________________  公有方法  ________________
	
	public function getUserList($param){
		$data = explode(",", $param);
		TLOG_MSG("User::getUserList: func param=$param");
		$urlparam = "";
	    $pagequery = array();
	    $output = array("data"=>array(),
	        "pagequery"=>array(),
	        "totalNum"=>0,
	        "retCode"=>0,
	        "sErrMsg"=>"");
		$page = $data[0];
		if (intval($page) <= 0)
	    {
	        $page = 1;
	    }
		
		$merchantsResult_DB = new IMerchantsResult_DB($this->shandanDBFlg);
		$ret =  $merchantsResult_DB->getUserList($param);
		if ($ret["result"] != 0)
	    {
	        $output["retCode"] = $ret["result"];
	        $output["sErrMsg"] = $ret["sErrMsg"];
	        $test = "SearchResultCB(".json_encode($output).")";
	        echo $test;
	        return -1;
	    }
		
		$datacnt=0;
		if(is_array($ret["data_list"]))
		{
			foreach($ret["data_list"] as $item)
			{
				$retItem = array();
	            $retItem["id"] = $item["id"];
				$retItem["name"] = $item["name"];
	            $retItem["username"] = $item["username"];
				$retItem["company_id"] = $item["company_id"];
				$retItem["group_id"] = $item["group_id"];
				$retItem["station_id"] = $item["station_id"];
				$retItem["roll_id"] = $item["roll_id"];
				$retItem["active"] = $item["active"];
				
				$retItem["mobile"] = $item["mobile"];
				$retItem["email"] = $item["email"];
				
				$retItem["companyname"] = "";
				$retItem["groupname"] = "";
				$retItem["stationname"] = "";
				
				$output["data"][] = $retItem;
				$datacnt++;
			}
		}
		
		$sqloption = "";
		$idscompany="";
		$idsgroup="";
		$idsstation="";
		$idsrole="";
		$cnt=0; 
		if(is_array($output["data"]))
		{
			foreach($output["data"] as $item)
			{
				if ($cnt == 0)
				{
					$idscompany="(";
					$idsgroup="(";
					$idsstation="(";
					$idsrole="(";
				}
					
				$cnt++;
				
				if ($datacnt == $cnt)
				{
					$idscompany.="$item[company_id])";
					if ($item['group_id'] > 0)
						$idsgroup.="$item[group_id])";
					else
						$idsgroup.=")";
					if ($item['station_id'] > 0)
						$idsstation.="$item[station_id])";
					else
						$idsstation.=")";
					$idsrole.="$item[roll_id])";
				}
				else
				{
					$idscompany.="$item[company_id],";
					if ($item['group_id'] > 0)
						$idsgroup.="$item[group_id],";
					if ($item['station_id'] > 0)
					$idsstation.="$item[station_id],";
					$idsrole.="$item[roll_id],";
				}
					
			}
		}
		
		if ($cnt > 0)
		{	
			$sqloption = "where id in$idscompany";
			$resCompany =  $merchantsResult_DB->getCompanyName($sqloption);
			if ($ret["result"] != 0)
			{
				$output["retCode"] = $ret["result"];
				$output["sErrMsg"] = $ret["sErrMsg"];
				$test = "SearchResultCB(".json_encode($output).")";
				echo $test;
				return -1;
			}
			
			$sqloption = "where id in$idsgroup";
			$resGroup =  $merchantsResult_DB->getGroupName($sqloption);
			if ($ret["result"] != 0)
			{
				$output["retCode"] = $ret["result"];
				$output["sErrMsg"] = $ret["sErrMsg"];
				$test = "SearchResultCB(".json_encode($output).")";
				echo $test;
				return -1;
			}
			
			$sqloption = "where id in$idsstation";
			$resStation =  $merchantsResult_DB->getStationName($sqloption);
			if ($ret["result"] != 0)
			{
				$output["retCode"] = $ret["result"];
				$output["sErrMsg"] = $ret["sErrMsg"];
				$test = "SearchResultCB(".json_encode($output).")";
				echo $test;
				return -1;
			}
			
			$sqloption = "where id in$idsrole";
			$resRole =  $merchantsResult_DB->getUserRoleName($sqloption);
			if ($ret["result"] != 0)
			{
				$output["retCode"] = $ret["result"];
				$output["sErrMsg"] = $ret["sErrMsg"];
				$test = "SearchResultCB(".json_encode($output).")";
				echo $test;
				return -1;
			}
			
			if(is_array($resCompany["data_list"]))
			{
				if(is_array($output["data"]))
				{
					foreach($resCompany["data_list"] as $key => $item)
					{
						foreach($output["data"] as $k =>$data)
						{
							if ($data["company_id"] == $item["id"])
							{
								$output["data"][$k]["companyname"] = $item["companyname"];
							}
						}
					}
					
				}	
			}
			
			if(is_array($resGroup["data_list"]))
			{
				if(is_array($output["data"]))
				{
					foreach($resGroup["data_list"] as $key => $item)
					{
						foreach($output["data"] as $k =>$data)
						{
							if ($data["group_id"] == $item["id"])
							{
								$output["data"][$k]["groupname"] = $item["name"];
							}
						}
					}
					
				}	
			}
			
			if(is_array($resStation["data_list"]))
			{
				if(is_array($output["data"]))
				{
					foreach($resStation["data_list"] as $key => $item)
					{
						foreach($output["data"] as $k =>$data)
						{
							if ($data["station_id"] == $item["id"])
							{
								$output["data"][$k]["stationname"] = $item["name"];
							}
						}
					}
					
				}	
			}
			
			if(is_array($resRole["data_list"]))
			{
				if(is_array($output["data"]))
				{
					foreach($resRole["data_list"] as $key => $item)
					{
						foreach($output["data"] as $k =>$data)
						{
							if ($data["roll_id"] == $item["id"])
							{
								$output["data"][$k]["roll"] = $item["name"];
							}
						}
					}
					
				}	
			}
		}
		
		$output["totalNum"] = $ret["totalNum"];
	    
	    $psize = 20;
	    $pshow = 10;
	    $result		= array();
	    $result		= FuncExt::pagination($ret["totalNum"], $psize, $page, $pshow);
		$output["recordcount"] = $result["recordcount"];
	    $output["pagecount"] = $result["pagecount"];
	    $output["pagesize"] = $result["pagesize"];
	    $output["absolutepage"] = $result["absolutepage"];
	    $output["previouspage"] = $result["previouspage"];
	    $output["nextpage"] = $result["nextpage"];
	    $output["startpage"] = $result["startpage"];
	    $output["endpage"] = $result["endpage"];
	    $output["pagequery"] = $pagequery;
	    $output["urlparam"] = $urlparam;
		
		return $this->result_struct(
	        array(
	            'stateId'	=> -160,
	            'message'	=> 'get Station info succeed',
	            'result'	=> $output
	        )
	    );
		
	}
	
	public function addStation($param)
	{
		TLOG_MSG("Station::addStation: macid=".$param['macid']." user=".$param['user']." ptype=".$param['ptype']." servip=".$param['servip']." servport=".$param['servport']." retry=".$param['retry']." timeout=".$param['timeout']." polltime=".$param['polltime']." connected=".$param['connected']." active=".$param['active']);
		$merchantsResult_DB = new IMerchantsResult_DB($this->shandanDBFlg);
		$result = $merchantsResult_DB->AddStationInfo($param);
		$message= $result['result'] ? "add device failure: ".$result['errorMsg']:"add device succeed";
		//$this->log($this->Ary_Session['user'],$message);
		return $this->result_set((!$result['result'] ? -108 : 1807),$message);
	}
	
	/*
	删除路由器设置
	number: 1900
	*/
	public function delRoute($param){
		return $this->setRoute($param,"del");
	}
}
?>