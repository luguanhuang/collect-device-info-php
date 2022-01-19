<?php
require_once dirname(__FILE__).'/cfg/database_config.php';
require_once dirname(__FILE__).'/database_module.php';

class IMerchantsResult_DB 
{
	 var $DB;
   function __construct()
   {
   		 $num  = func_num_args();  
   		 if (0 == $num)
   		 {
   		 		//TLOG_MSG("IMerchantsResult_DB::__construct: [num]=".$num." [MODE]=".$MODE); 
   		 		$this->DB = new DataBase();
   		 }
   		 else if (1 == $num)
   		 {
   		 		//TLOG_MSG("IMerchantsResult_DB::__construct: param is more than zero [num]=".$num." [MODE]=".MODE); 
   		 		TLOG_MSG("IMerchantsResult_DB::__construct: param is more than zero [DATABASE_NAME]=".DATABASE_NAME.
   		 		" [DATABASE_IP]=".DATABASE_IP." [DATABASE_USER]=".DATABASE_USER.
   		 		" [DATABASE_PASSWORD]=".DATABASE_PASSWORD." [DATABASE_CHARSET]=".DATABASE_CHARSET);
   		 		$this->DB = new DataBase(DATABASE_NAME, DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_CHARSET);
   		 }
   }
    
  
	function getCompanyDetail($page)
   {
	   TLOG_MSG("IMerchantsResult_DB::getCompanyDetail: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
       $actualCntSql = "select count(*) as count from dtm_company";
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getUserDetail: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
       $totalSql = "select id, companyname, status,created_date from dtm_company ";
       
       $totalSql = $totalSql." limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getCompanyDetail: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getCompanyDetail: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getCompanyDetail: func end");
       return $returnArray;
   }
   
   function getActiveDeviceList()
   {
	   TLOG_MSG("IMerchantsResult_DB::getActiveDeviceList: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $totalSql = "select id, devname from auth where active='1'";
       
       TLOG_MSG("IMerchantsResult_DB::getActiveDeviceList: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getActiveDeviceList: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getDeviceList: func end");
       return $returnArray;
   }
	
	function getDeviceInfo($devname)
   {
	   TLOG_MSG("IMerchantsResult_DB::getDeviceInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $totalSql = "select id, devname,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv from auth where devname='$devname'";
       
       TLOG_MSG("IMerchantsResult_DB::getDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getDeviceInfo: func end");
       return $returnArray;
   }
	
	
	function getChannelData($devname)
   {
	   TLOG_MSG("IMerchantsResult_DB::getChannelData: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
      
       
       $totalSql = "select ch, dtype, slaveid,funcode,startreg,countreg,chdesc from $devname ";
       
       
       TLOG_MSG("IMerchantsResult_DB::getChannelData: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getChannelData: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getChannelData: func end");
       return $returnArray;
   }
	
	function getChannelid($devname)
   {

	   TLOG_MSG("IMerchantsResult_DB::getChannelid: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $totalSql = "select ch, dtype, slaveid,funcode,startreg,countreg from $devname where reporttype=1 ";
       
       
       TLOG_MSG("IMerchantsResult_DB::getChannelid: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getChannelid: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getChannelid: func end");
       return $returnArray;
   }
   
    function getTagAllData($devname, $channel, $option)
   {
	  // TLOG_MSG("IMerchantsResult_DB::getTagAllData: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
	   $name = $devname."_$channel";
       $totalSql = "$option   order by time desc limit 1";
       
       
      // TLOG_MSG("IMerchantsResult_DB::getTagAllData: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getTagAllData: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getTagAllData: func end");
       return $returnArray;
   }
   
   function getTagId($devname, $channel)
   {
	   TLOG_MSG("IMerchantsResult_DB::getTagId: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
	   $name = $devname."_tag";
       $totalSql = "select id,chid,tagid,excellocation from $name where chid=$channel and reportenable='1'";
       
       
       TLOG_MSG("IMerchantsResult_DB::getTagId: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getTagId: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getTagId: func end");
       return $returnArray;
   }
	
	function getChannelTabData($devname,$option)
   {
	   TLOG_MSG("IMerchantsResult_DB::getChannelTabData: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
      
       $tabname = $devname."_tag";
       $totalSql = "select id, chid, tagid,tagname,tagdesc,writeenable,coiltype,mainpagelocation from $tabname  $option";
       
       TLOG_MSG("IMerchantsResult_DB::getChannelTabData: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getChannelTabData: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getChannelTabData: func end");
       return $returnArray;
   }
   
	
	function getChannelLimitData($devname, $channelid, $tagid)
   {
	   //TLOG_MSG("IMerchantsResult_DB::getChannelLimitData: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
      
       //$tabname = $devname."_"."$channelid";
	   $tabname = $devname."_livedata_"."$channelid";
	   $field = "data_".$tagid;
       $totalSql = "select id, time, $field from $tabname  order by time desc limit 1";
       
       TLOG_MSG("IMerchantsResult_DB::getChannelLimitData: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getChannelLimitData: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       //TLOG_MSG("IMerchantsResult_DB::getChannelLimitData: func end");
       return $returnArray;
   }
	
	
	
	function getPtype($option)
   {
	   TLOG_MSG("IMerchantsResult_DB::getPtype: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $totalSql = "select id, name from dtm_ptype $option";
       
       TLOG_MSG("IMerchantsResult_DB::getPtype: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getPtype: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getPtype: func end");
       return $returnArray;
   }
	
	function getRoleInfo()
   {
	   TLOG_MSG("IMerchantsResult_DB::getRoleInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $totalSql = "select id, name from dtm_rolls";
       
       TLOG_MSG("IMerchantsResult_DB::getRoleInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getRoleInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getRoleInfo: func end");
       return $returnArray;
   }
	
	function getDtype($sql)
   {
	   TLOG_MSG("IMerchantsResult_DB::getDtype: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $totalSql = "select id, name from dtm_dtype $sql";
       
       TLOG_MSG("IMerchantsResult_DB::getDtype: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getDtype: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getDtype: func end");
       return $returnArray;
   }
	
	function getChannelInfo($page, $devname)
   {
	   TLOG_MSG("IMerchantsResult_DB::getChannelInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
       $totalSql = "select ch, dtype, slaveid,funcode,startreg,countreg,active,company_id,group_id,station_id,history,chdesc,reporttype,Alarmchannel from $devname ";
       
       $totalSql = $totalSql." limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getChannelInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getChannelInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getChannelInfo: func end");
       return $returnArray;
   }
	
	function getGroupDetail1($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::getGroupDetail: func begin param=$param");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        $data = explode(",", $param);
		$page = $data[0];
		if (intval($page) <= 0)
	    {
	        $page = 1;
	    }
		
		$actualCntSql = "";
		if ($data[1] == "1")
		{
				$actualCntSql = "select count(*) as count from dtm_group ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
				$actualCntSql = "select count(*) as count from dtm_group where company_id=$data[2] ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3"  || $data[1] == "6")
		{
				$actualCntSql = "select count(*) as count from dtm_group where company_id=$data[2] and id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "4"  || $data[1] == "7")
		{
				$actualCntSql = "select count(*) as count from dtm_group where company_id=$data[2] and id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
		
       //$actualCntSql = "select count(*) as count from dtm_group";
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
	   if ($data[1] == "1")
		{
				$totalSql = "select id, name, company_id,status from dtm_group ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
				$totalSql = "select id, name, company_id,status from dtm_group  where company_id=$data[2] ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3" || $data[1] == "6")
		{
				$totalSql = "select id, name, company_id,status from dtm_group  where company_id=$data[2]  and id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "4" || $data[1] == "7")
		{
				$totalSql = "select id, name, company_id,status from dtm_group  where company_id=$data[2]  and id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$actualCntSql);
		}
		
       //$totalSql = $totalSql." limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getGroupDetail: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: func end");
       return $returnArray;
   }
	
	function getGroupDetail($page)
   {
	   TLOG_MSG("IMerchantsResult_DB::getGroupDetail: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
				
       $actualCntSql = "select count(*) as count from dtm_group";
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
	   $totalSql = "select id, name, company_id,status from dtm_group ";
       $totalSql = $totalSql." limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getGroupDetail: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: func end");
       return $returnArray;
   }
	
	function getCompanyName($sqloption)
   {
	   TLOG_MSG("IMerchantsResult_DB::getCompanyName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, companyname from dtm_company $sqloption";
       
       TLOG_MSG("IMerchantsResult_DB::getCompanyName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getCompanyName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getGroupDetail: func end11111111");
       return $returnArray;
   }
	
	function getGroupName($sqloption)
   {
	   TLOG_MSG("IMerchantsResult_DB::getGroupName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, name from dtm_group $sqloption";
       
       TLOG_MSG("IMerchantsResult_DB::getGroupName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getGroupName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getGroupName: func end11111111");
       return $returnArray;
   }
	
	function getSpecialGroupName($id)
   {
	   TLOG_MSG("IMerchantsResult_DB::getSpecialGroupName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, name from dtm_group where company_id=".$id;
       
       TLOG_MSG("IMerchantsResult_DB::getSpecialGroupName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getSpecialGroupName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getSpecialGroupName: func end11111111");
       return $returnArray;
   }
	
	function getSpecialStationName($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::getSpecialStationName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, name from dtm_station where company_id=".$param['companyname']." and group_id=".$param['groupname'];
       
       TLOG_MSG("IMerchantsResult_DB::getSpecialStationName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getSpecialStationName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getSpecialStationName: func end11111111");
       return $returnArray;
   }
	
	function getSpecialDevName($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::getSpecialDevName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, devname from auth where company_id=$param[companyname] and group_id=$param[groupname] and station_id=$param[stationname]";
       
       TLOG_MSG("IMerchantsResult_DB::getSpecialDevName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getSpecialDevName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getSpecialDevName: func end11111111");
       return $returnArray;
   }
	
	function getDevName($data)
   {
	   TLOG_MSG("IMerchantsResult_DB::getDevName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, devname from auth where company_id=$data[0] and group_id=$data[1] and station_id=$data[2]";
       
       TLOG_MSG("IMerchantsResult_DB::getDevName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getDevName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getDevName: func end");
       return $returnArray;
   }
	
	function getAllDevName()
   {
	   TLOG_MSG("IMerchantsResult_DB::getAllDevName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, devname,company_id,group_id,station_id from auth";
       
       TLOG_MSG("IMerchantsResult_DB::getAllDevName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getAllDevName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getAllDevName: func end");
       return $returnArray;
   }
	
	function getStationName($sqloption)
   {
	   TLOG_MSG("IMerchantsResult_DB::getStationName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, name,company_id,group_id from dtm_station $sqloption";
       
       TLOG_MSG("IMerchantsResult_DB::getStationName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getStationName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getStationName: func end");
       return $returnArray;
   }
	
	function getUserRoleName($sqloption)
   {
	   TLOG_MSG("IMerchantsResult_DB::getUserRoleName: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
        
       $totalSql = "select id, name from dtm_rolls $sqloption";
       
       TLOG_MSG("IMerchantsResult_DB::getUserRoleName: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getUserRoleName: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
	   
       TLOG_MSG("IMerchantsResult_DB::getUserRoleName: func end");
       return $returnArray;
   }
	
	function getStationList($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::getStationList: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
		$data = explode(",", $param);
		$page = $data[0];
		if (intval($page) <= 0)
	    {
	        $page = 1;
	    }
		
		$actualCntSql = "";
		if ($data[1] == "1")
		{
				$actualCntSql = "select count(*) as count from dtm_station ";
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
				$actualCntSql = "select count(*) as count from dtm_station where company_id=$data[2] ";
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3" || $data[1] == "6")
		{
				$actualCntSql = "select count(*) as count from dtm_station where company_id=$data[2] and group_id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "4" || $data[1] == "7")
		{
				$actualCntSql = "select count(*) as count from dtm_station where company_id=$data[2] and group_id=$data[3] and id=$data[4]";
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
		
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getStationList: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
	   if ($data[1] == "1")
		{
				$totalSql = "select id, name, company_id, group_id, status from dtm_station  ";
				
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
				$totalSql = "select id, name, company_id, group_id, status from dtm_station  where company_id=$data[2]  ";
			
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3" || $data[1] == "6")
		{
				$totalSql = "select id, name, company_id, group_id, status from dtm_station where company_id=$data[2] and group_id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "4" || $data[1] == "7")
		{
				$totalSql = "select id, name, company_id, group_id, status from dtm_station where company_id=$data[2] and group_id=$data[3] and id=$data[4]";
				TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$actualCntSql);
		}
		
       $totalSql = $totalSql." limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getStationList: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getStationList: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getStationList: func end");
       return $returnArray;
   }
	
	function getDeviceList($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::getDeviceList: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
		$data = explode(",", $param);
		$page = $data[0];
		if (intval($page) <= 0)
	    {
	        $page = 1;
	    }
		
		$actualCntSql = "";
		if ($data[1] == "1")
		{
				$actualCntSql = "select count(*) as count from auth ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
				$actualCntSql = "select count(*) as count from auth where company_id=$data[2] ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3" || $data[1] == "6")
		{
				$actualCntSql = "select count(*) as count from auth where company_id=$data[2] and group_id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "4" || $data[1] == "7")
		{
				$actualCntSql = "select count(*) as count from auth where company_id=$data[2] and group_id=$data[3] and station_id= $data[4]";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
		
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getDeviceList: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
	   if ($data[1] == "1")
		{
				$totalSql = "select id, macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,active,socktype,devicedesc,templatelocation,connected,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv from auth ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
				$totalSql = "select id, macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,active,socktype,devicedesc,templatelocation,connected,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv from auth where company_id=$data[2] ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3" || $data[1] == "6")
		{
				$totalSql = "select id, macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,active,socktype,devicedesc,templatelocation,connected,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv from auth  where company_id=$data[2] and group_id=$data[3] ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "4" || $data[1] == "7")
		{
				$totalSql = "select id, macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,active,socktype,devicedesc,templatelocation,connected,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv from auth where company_id=$data[2] and group_id=$data[3] and station_id= $data[4] ";
				TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$actualCntSql);
		}
	   
       $totalSql = $totalSql." limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getDeviceList: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getDeviceList: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getDeviceList: func end");
       return $returnArray;
   }
   
   function getConnList()
   {
	   TLOG_MSG("IMerchantsResult_DB::getConnList: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
      
		$totalSql = "select id, macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,active,socktype,devicedesc,templatelocation,connected from auth ";
	   
       TLOG_MSG("IMerchantsResult_DB::getConnList: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getConnList: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getConnList: func end");
       return $returnArray;
   }
   
   
   function getUserInfo()
   {
	   TLOG_MSG("IMerchantsResult_DB::getUserInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
       
       $totalSql = "select id, name, username,password,email,suburb,country,address,postcode,phone,mobile,company_id,group_id,station_id,fax,roll_id,active from dtm_user ";
       
       TLOG_MSG("IMerchantsResult_DB::getUserInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getUserInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getUserInfo: func end");
       return $returnArray; 
   }
	
	function getUserList($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::getUserList: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        $data = explode(",", $param);
		$page = $data[0];
		if (intval($page) <= 0)
	    {
	        $page = 1;
	    }
		$actualCntSql = "";
	   TLOG_MSG("IMerchantsResult_DB::getUserList: param=".$param);
		if ($data[1] == "1")
		{
				$actualCntSql = "select count(*) as count from dtm_user ";
				TLOG_MSG("IMerchantsResult_DB::getUserList: [sql]=".$actualCntSql);
		}
       else if ($data[1] == "2" || $data[1] == "5")
		{
			$actualCntSql = "select count(*) as count from dtm_user where roll_id in(2,3,4,5,6,7) and company_id=$data[2] ";
				TLOG_MSG("IMerchantsResult_DB::getUserList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "3" || $data[1] == "6")
		{
			$actualCntSql = "select count(*) as count from dtm_user where roll_id in(3,4,6,7) and company_id=$data[2] and group_id=$data[3]";
				TLOG_MSG("IMerchantsResult_DB::getUserList: [sql]=".$actualCntSql);
		}
		else if ($data[1] == "4" || $data[1] == "7")
		{
			$actualCntSql = "select count(*) as count from dtm_user where roll_id in(4,7) and company_id=$data[2] and group_id=$data[3] and station_id=$data[4]";
				TLOG_MSG("IMerchantsResult_DB::getUserList: [sql]=".$actualCntSql);
		}
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getUserList: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
	   
	   if ($data[1] == "1")
		{
			$totalSql = "select id, name, username,password,writepassword,email,suburb,country,address,postcode,phone,mobile,company_id,group_id,station_id,fax,roll_id,active from dtm_user  ";
			$totalSql = $totalSql." limit $numFrom, $pageSize";
		}
		else if ($data[1] == "2" || $data[1] == "5")
		{
			$totalSql = "select id, name, username,password,writepassword,email,suburb,country,address,postcode,phone,mobile,company_id,group_id,station_id,fax,roll_id,active from dtm_user where roll_id in(2,3,4,5,6,7) and company_id=$data[2] ";
			$totalSql = $totalSql." limit $numFrom, $pageSize";
		}
       else if ($data[1] == "3" || $data[1] == "6")
		{
			$totalSql = "select id, name, username,password,writepassword,email,suburb,country,address,postcode,phone,mobile,company_id,group_id,station_id,fax,roll_id,active from dtm_user where roll_id in(3,4,6,7) and company_id=$data[2] and group_id=$data[3] ";
			$totalSql = $totalSql." limit $numFrom, $pageSize";
		}
		 else if ($data[1] == "4" || $data[1] == "7")
		{
			$totalSql = "select id, name, username,password,writepassword,email,suburb,country,address,postcode,phone,mobile,company_id,group_id,station_id,fax,roll_id,active from dtm_user where roll_id in(4,7) and company_id=$data[2] and group_id=$data[3] and station_id=$data[4] ";
			$totalSql = $totalSql." limit $numFrom, $pageSize";
		}
	
       TLOG_MSG("IMerchantsResult_DB::getUserList: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getUserList: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getUserList: func end");
       return $returnArray;
   }
	
	
	function getStationDetail()
   {
       TLOG_MSG("IMerchantsResult_DB::getStationDetail: func begin");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
       $totalSql = "select id, macid, user,ptype,servip,servport,retry,timeout,polltime,connected,active from auth";
        
       TLOG_MSG("IMerchantsResult_DB::getStationDetail: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getStationDetail: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
       
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getStationDetail: func end");
       return $returnArray;
   }
	
	function AddStationInfo($param)
   {
       TLOG_MSG("IMerchantsResult_DB::AddStationInfo: func begin");
	   TLOG_MSG("Group::AddStationInfo: companyname=".$param['companyname']." active=".$param['active']." groupname=".$param['groupname']." stationname=".$param['stationname']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   if (empty($param['active']))
		$totalSql = "insert into dtm_station(name, company_id,group_id,status,is_deleted,created_date,updated_date) values('$param[stationname]',$param[companyname],$param[groupname], '0','1','$time','$time')";
		else
			$totalSql = "insert into dtm_station(name, company_id,group_id,status,is_deleted,created_date,updated_date) values('$param[stationname]',$param[companyname],$param[groupname], '1','1','$time','$time')";
        
       TLOG_MSG("IMerchantsResult_DB::AddStationInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddStationInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
       
       TLOG_MSG("IMerchantsResult_DB::AddStationInfo: func end");
       return $ret;
   }
	
	function AddDeviceInfo($param)
   {
       TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: func begin");
	   TLOG_MSG("Group::addGroup: companyname=".$param['companyname']." active=".$param['active']." groupname=".$param['groupname']." stationname=".$param['stationname']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   if (empty($param['active']))
		$totalSql = "insert into auth(macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,connected,active,socktype,threaded,devicedesc,templatelocation,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv) values('$param[macid]','$param[devicename]','$param[ptype]','$param[servip]','$param[servport]','$param[retry]','$param[timeout]','$param[polltime]','$param[companyname]','$param[groupname]','$param[stationname]', '0','0','1','0','$param[devicedesc]','$param[templatelocation]','$param[pic1filelocation]','$param[pic2filelocation]','$param[pic3filelocation]','$param[pic4filelocation]','$param[mainpagediv]')";
		else
			$totalSql = "insert into auth(macid, devname,ptype,servip,servport,retry,timeout,polltime,company_id,group_id,station_id,connected,active,socktype,threaded,devicedesc,templatelocation,pic1filelocation,pic2filelocation,pic3filelocation,pic4filelocation,mainpagediv) values('$param[macid]','$param[devicename]','$param[ptype]','$param[servip]','$param[servport]','$param[retry]','$param[timeout]','$param[polltime]','$param[companyname]','$param[groupname]','$param[stationname]', '0','1','$param[socktype]','0','$param[devicedesc]','$param[templatelocation]','$param[pic1filelocation]','$param[pic2filelocation]','$param[pic3filelocation]','$param[pic4filelocation]','$param[mainpagediv]')";

	TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }

		$totalSql = "CREATE TABLE IF NOT EXISTS `$param[devicename]`  ( 
 `ch` int(0) NOT NULL AUTO_INCREMENT,
  `dtype` int(0) NOT NULL,
  `slaveid` int(0) NOT NULL,
  `funcode` int(0) NOT NULL,
  `startreg` int(0) NOT NULL,
  `countreg` int(0) NOT NULL,
  `reporttype` int(0) NOT NULL,
  `querystr` varchar(1024) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `resstr` varchar(1024) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `company_id` int(0) NOT NULL,
  `group_id` int(0) NOT NULL,
  `active` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `station_id` int(0) NOT NULL,
  `history` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `chdesc` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`ch`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;";
       TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
	   $totalSql = "CREATE TABLE IF NOT EXISTS `$param[devicename]_write`  (
  `id` double NOT NULL AUTO_INCREMENT,
  `channel` int(0) NOT NULL,
  `dtype` int(0) NOT NULL,
  `slaveid` int(0) NOT NULL,
  `funcode` int(0) NOT NULL,
  `reg` int(0) NOT NULL,
  `value` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `mbwrite` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;";
       TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
	   $totalSql = "CREATE TABLE IF NOT EXISTS `$param[devicename]_tag`
 (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `chid` int(0) NOT NULL,
  `tagid` int(0) NOT NULL,
  `tagname` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `tagdesc` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `webshow` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
   `coiltype` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `reportenable` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `writeenable` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `excellocation` varchar(10) NULL DEFAULT NULL,
  `mainpageenable` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `mainpagelocation` varchar(16) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;";
       TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
	   $totalSql = "CREATE TABLE IF NOT EXISTS `$param[devicename]_alaconf`  (
  `id` double NOT NULL AUTO_INCREMENT,
  `chid` double NOT NULL,
  `tagid` double NOT NULL,
  `alatext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alaofftext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;";
       TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
       TLOG_MSG("IMerchantsResult_DB::AddDeviceInfo: func end");
	   
       return $ret;
   }
	
	function editUser($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::editUser:  active=".$param['active']." passwd=".$param['passwd']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   
	   $active='0';
	   
	   $write = "";
	   if (trim($param['passwd'])!="")
	   {
		   $passwd = md5($param['passwd']);
		   
		   $write = ",password='$passwd',";
	   }
	   
	 
	   if (trim($param['writepassword'])!="")
	   {
		   $writepassword = md5($param['writepassword']);
		    if ($write == "")
				$write .= ",writepassword='$writepassword',";
			else
				$write .= "writepassword='$writepassword',";
	   }
	   
	   if ($write == "")
			$write = ",";
	   if ($param['active']!=null)
			$active='1';
	   
		$totalSql = "update dtm_user set name='$param[name]', username='$param[username]', email='$param[email]', mobile='$param[mobile]' $write roll_id='$param[rolename]',company_id='$param[companyname]',group_id='$param[groupname]',station_id=$param[stationname],active='$active' where id=".$param['id'];
		

	TLOG_MSG("IMerchantsResult_DB::editUser: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'update');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::editUser: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
       TLOG_MSG("IMerchantsResult_DB::editUser: func end");
       return $ret;
   }
	
	function AddUser($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::AddUser:  active=".$param['active']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $active='0';
	   $passwd = md5($param['password']);
	   $writepassword = md5($param['writepassword']);
	   if (!empty($param['active']))
		$active='1';
		$partsql="insert into dtm_user(name, username,password,email,suburb,state,country,address,postcode,phone,mobile,company_id,group_id,station_id,fax,roll_id,active,is_deleted,created_date,updated_date,writepassword)";
		$totalSql = "$partsql values('$param[name]','$param[username]','$passwd','$param[email]','','',0,'','','','$param[mobilenumber]',$param[companyname],$param[groupname],$param[stationname], '', $param[rolename],'$active','0','$time','$time','$writepassword')";

		TLOG_MSG("IMerchantsResult_DB::AddUser: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddUser: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	  
       TLOG_MSG("IMerchantsResult_DB::AddUser: func end");
       return $ret;
   }
	
	function AddChannel($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::AddChannel:  active=".$param['active']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $active='0';
	   $history='0';
	   $Alarmchannel='0';
	   if (!empty($param['active']))
		$active='1';
	   if (!empty($param['history']))
		$history='1';
	   
	   if (!empty($param['Alarmchannel']))
		$Alarmchannel='1';
		$totalSql = "insert into $param[devname](dtype, slaveid,funcode,startreg,countreg,querystr,resstr,active,company_id,group_id,station_id,history,chdesc,reporttype, Alarmchannel) values('$param[dtype]','$param[slaveid]','$param[funcode]','$param[startreg]','$param[countreg]','$param[querystr]','$param[resstr]','$active',$param[companyname],$param[groupname],$param[stationname],'$history','$param[chdesc]','$param[reporttype]','$Alarmchannel')";
		

	TLOG_MSG("IMerchantsResult_DB::AddChannel: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
	   $i=0;
	   $str="";
	   for($i=0; $i<$param[countreg];$i++)
	   {
		   $idx = $i + 1;
		   $field ="data_".$idx;
		   $str.="`$field` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,";
	   }

		$chid = $ret[insert_id];
		$totalSql = "CREATE TABLE IF NOT EXISTS `$param[devname]_$chid`  ( 
  `id` double NOT NULL AUTO_INCREMENT,
  `time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `channel` int(0) NULL DEFAULT NULL,
  $str
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";
       TLOG_MSG("IMerchantsResult_DB::AddChannel: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
	   
		$totalSql = "CREATE TABLE IF NOT EXISTS `$param[devname]_livedata_$chid`  ( 
  `id` double NOT NULL AUTO_INCREMENT,
  `time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `channel` int(0) NULL DEFAULT NULL,
  $str
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";
       TLOG_MSG("IMerchantsResult_DB::AddChannel: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
	   $totalSql = "insert into $param[devname]_livedata_$chid(time) values('$time')";
			TLOG_MSG("IMerchantsResult_DB::AddChannel: [sql]=".$totalSql);
		   $ret = $this->DB->execute_v2($totalSql, 'INSERT');
		   if ($ret["result"] != 0)
		   {
			   TLOG_ERR("IMerchantsResult_DB::AddChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
			   
		   }
	   
	   for($i=1; $i<=$param[countreg];$i++)
	   {
			$totalSql = "insert into $param[devname]_tag(chid, tagid) values($chid,$i)";
			TLOG_MSG("IMerchantsResult_DB::AddChannel: [sql]=".$totalSql);
		   $ret = $this->DB->execute_v2($totalSql, 'INSERT');
		   if ($ret["result"] != 0)
		   {
			   TLOG_ERR("IMerchantsResult_DB::AddChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
			   
		   }
	   }
	   
	   $totalSql = "update auth set threaded='0' where devname='$param[devname]'";
	   TLOG_MSG("IMerchantsResult_DB::AddChannel: [sql]=".$totalSql);
	   $ret = $this->DB->execute_v2($totalSql, 'update');
	   if ($ret["result"] != 0)
	   {
		   TLOG_ERR("IMerchantsResult_DB::AddChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
		   
	   }
       TLOG_MSG("IMerchantsResult_DB::AddChannel: func end");
       return $ret;
   }
	
	function EditChannel($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::EditChannel:  active=".$param['active']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   
	   $active='0';
	   $history='0';
	    $Alarmchannel='0';
	   if ($param['active']!=null)
			$active='1';
	   if ($param['history']!=null)
		$history='1';
	     if ($param['Alarmchannel']!=null)
		$Alarmchannel='1';
	   
		$totalSql = "update $param[devicename] set dtype='$param[dtype]', slaveid='$param[slaveid]',funcode='$param[funcode]',startreg='$param[startreg]',countreg='$param[countreg]',company_id=$param[companyname],group_id=$param[groupname],station_id=$param[stationname], active='$active', history='$history', chdesc='$param[chdesc]' , reporttype='$param[reporttype]' , Alarmchannel='$Alarmchannel' where ch=".$param['id'];
		

	TLOG_MSG("IMerchantsResult_DB::EditChannel: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'update');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::EditChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
       TLOG_MSG("IMerchantsResult_DB::EditChannel: func end");
       return $ret;
   }
	
	function AddWriteData($device,$channel,$dtype,$slaveid,$funcode,$reg,$value)
   {
	   TLOG_MSG("IMerchantsResult_DB::AddWriteData: func begin");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $name = $device."_write";
	   $totalSql = "insert into $name(channel, dtype,slaveid,funcode,reg,value,mbwrite) values($channel,$dtype,$slaveid,$funcode,$reg,'$value','0')";

	TLOG_MSG("IMerchantsResult_DB::AddWriteData: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'insert');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddWriteData: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
	   
       TLOG_MSG("IMerchantsResult_DB::AddWriteData: func end");
       return $ret;
   }
	
	
	function EditTag($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::EditTag:  active=");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
	   
	   for ($i=1; $i<=$param[countreg];$i++)
		{
			$channelid = "channelid_$i";
			$tagid = "tagid_$i";
			$tagname = "tagname_$i";
			$tagdesc = "tagdesc_$i";
			$webshow = "webshow_$i";
			$coiltype = "coiltype_$i";
			$writeenable = "writeenable_$i";
			$excellocation = "excellocation_$i";
			$reportenable = "reportenable_$i";
			$mainpageenable = "mainpageenable_$i";
			$mainpagelocation = "mainpagelocation_$i";
			$excellocationinfo = $param[$excellocation];
			$mainpagelocationinfo = $param[$mainpagelocation];
			//if (!empty($param[$excellocation]))
				//;
				
			$webshowflg='0';
		   $coiltypeflg='0';
		   $writeenableflg='0';
		    $reportenableflg='0';
			$mainpageenableflg = '0';
		   if (!empty($param[$webshow]))
			   $webshowflg='1';
		   
		   if (!empty($param[$coiltype]))
			   $coiltypeflg='1';
		   
		   if (!empty($param[$writeenable]))
			   $writeenableflg='1';
			
			 if (!empty($param[$reportenable]))
			   $reportenableflg='1';
			
			 if (!empty($param[$mainpageenable]))
			   $mainpageenableflg='1';
			
			$totalSql = "update $param[devname]_tag set tagname='$param[$tagname]',tagdesc='$param[$tagdesc]',webshow='$webshowflg',coiltype='$coiltypeflg',writeenable='$writeenableflg',reportenable='$reportenableflg',excellocation='$excellocationinfo' ,mainpageenable='$mainpageenableflg',mainpagelocation='$mainpagelocationinfo' where chid=$param[$channelid] and tagid=$param[$tagid]";
			
			TLOG_MSG("tagid=$tagid channelid=$param[$channelid] tagid=$param[$tagid] tagname=$param[$tagname] tagdesc=$param[$tagdesc] webshow=$param[$webshow] coiltype=$param[$coiltype] writeenable=$param[$writeenable] ");
			TLOG_MSG("IMerchantsResult_DB::EditTag: [sql]=".$totalSql);
		   $ret = $this->DB->execute_v2($totalSql, 'update');
		   if ($ret["result"] != 0)
		   {
			   TLOG_ERR("IMerchantsResult_DB::EditChannel: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
			   
		   }
		}

		TLOG_MSG("IMerchantsResult_DB::EditTag: func end");
		return $ret;
   }
	
	function AddTag($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::AddTag:  active=");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
	   
	   $actualCntSql = "select count(*) as count from $param[devicename]_tag where id=$param[id] and tagid=$param[tagid]";
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::AddTag: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" != $returnArray["totalNum"])
       {
			return $returnArray;
       }
	   
	   TLOG_MSG("Channel::AddTag: id=$param[id] devicename=$param[devicename] tagid=$param[tagid] tagname=$param[tagname] tagdesc=$param[tagdesc] webshow=$param[webshow]");
	   
	   $webshow='0';
	   $coiltype='0';
	   $writeenable='0';
	   if (!empty($param['webshow']))
		   $webshow='1';
	   
	   if (!empty($param['coiltype']))
		   $coiltype='1';
	   
	   if (!empty($param['writeenable']))
		   $writeenable='1';
	   
      
		$totalSql = "insert into $param[devicename]_tag(chid, tagid,tagname,tagdesc,webshow,coiltype,writeenable) values($param[id],$param[tagid],'$param[tagname]','$param[tagdesc]','$webshow','$coiltype','$writeenable')";
		
			$ret = $this->DB->execute_v2($totalSql, 'insert');

		TLOG_MSG("IMerchantsResult_DB::AddTag: [sql]=".$totalSql);

		if ($ret["result"] != 0)
		{
		   TLOG_ERR("IMerchantsResult_DB::AddTag: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
		   
		}

		TLOG_MSG("IMerchantsResult_DB::EditTag: func end");
		return $ret;
   }
	
	function getTagInfo($devname,$id)
   {
       TLOG_MSG("IMerchantsResult_DB::getTagInfo: func begin");
	   $name = $devname."_tag";
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
       $totalSql = "select chid, tagid, tagname,tagdesc,webshow,coiltype,writeenable,reportenable,excellocation,mainpageenable,mainpagelocation from $name where chid=$id";
        
       TLOG_MSG("IMerchantsResult_DB::getTagInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getTagInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
       
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getTagInfo: func end");
       return $returnArray;
   }
	
	function getAlarmInfo($devname,$id)
   {
       TLOG_MSG("IMerchantsResult_DB::getAlarmInfo: func begin");
	   $name = $devname."_alaconf";
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
       $totalSql = "select chid, tagid, tagname, tagdesc, alarmenable,alarmontext,alarmofftext,minvalue,maxvalue from $name where chid=$id";
        
       TLOG_MSG("IMerchantsResult_DB::getAlarmInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getAlarmInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
       
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getAlarmInfo: func end");
       return $returnArray;
   }
	
	function editDeviceInfo($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::editDeviceInfo: companyname=".$param['companyname']." active=".$param['active']." groupname=".$param['groupname']." stationname=".$param['stationname']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $totalSql = "";
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   //$totalSql = "update auth set macid='$param[macid]'";//, devname='$param['devicename']',ptype='$param['ptype']',servip='$param['servip']',servport='$param['servport']',retry='$param['retry']',timeout='$param['timeout']',polltime='$param['polltime']',company_id='$param['companyname']',group_id='$param['groupname']',station_id='$param['stationname']',connected='$param['connected']', active='0',socktype='.$param['socktype']." where id=$param['id']";
		if ($param['active']==null)
			$totalSql = "update auth set macid='$param[macid]', devname='$param[devicename]',ptype='$param[ptype]',servip='$param[servip]',servport='$param[servport]',retry='$param[retry]',timeout='$param[timeout]',polltime='$param[polltime]',company_id='$param[companyname]',group_id='$param[groupname]',station_id='$param[stationname]',connected='0', active='0',socktype='$param[socktype]',devicedesc='$param[devicedesc]',templatelocation='$param[templatelocation]',pic1filelocation='$param[pic1filelocation]',pic2filelocation='$param[pic2filelocation]',pic3filelocation='$param[pic3filelocation]',pic4filelocation='$param[pic4filelocation]',mainpagediv='$param[mainpagediv]' where id=".$param['id'];
		else
			$totalSql = "update auth set macid='$param[macid]', devname='$param[devicename]',ptype='$param[ptype]',servip='$param[servip]',servport='$param[servport]',retry='$param[retry]',timeout='$param[timeout]',polltime='$param[polltime]',company_id='$param[companyname]',group_id='$param[groupname]',station_id='$param[stationname]',connected='0', active='1',socktype='$param[socktype]',devicedesc='$param[devicedesc]',templatelocation='$param[templatelocation]',pic1filelocation='$param[pic1filelocation]',pic2filelocation='$param[pic2filelocation]',pic3filelocation='$param[pic3filelocation]',pic4filelocation='$param[pic4filelocation]',mainpagediv='$param[mainpagediv]' where id=".$param['id'];
        
        
       TLOG_MSG("IMerchantsResult_DB::editDeviceInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'update');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::editDeviceInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           
       }
       
       TLOG_MSG("IMerchantsResult_DB::editDeviceInfo: func end");
       return $ret;
   }
	
	function DelCompany($param)
   {
       TLOG_MSG("IMerchantsResult_DB::DelCompany: func begin");
       $returnArray = array("result"=>0,
           "sErrMsg"=>"");
	   
		$totalSql = "delete from dtm_company where id=$param[id]";
       TLOG_MSG("IMerchantsResult_DB::DelCompany: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::DelCompany: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
       }
       
       TLOG_MSG("IMerchantsResult_DB::DelCompany: func end");
       return $ret;
   }
   
	function AddCompany($param)
   {
       TLOG_MSG("IMerchantsResult_DB::AddCompany: func begin");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $totalSql = "";
	   if (empty($param['active']))
			$totalSql = "insert into dtm_company(companyname, status,is_deleted,created_date,updated_date) values('$param[companyname]','0','1','{$time}','{$time}')";
		else
			$totalSql = "insert into dtm_company(companyname, status,is_deleted,created_date,updated_date) values('$param[companyname]','1','1','{$time}','{$time}')";
        
       TLOG_MSG("IMerchantsResult_DB::AddCompany: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddCompany: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
       }
       
       TLOG_MSG("IMerchantsResult_DB::AddCompany: func end");
       return $ret;
   }
   
   function AddGroup($param)
   {
       TLOG_MSG("IMerchantsResult_DB::AddGroup: func begin");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $totalSql = "";
	   if (empty($param['active']))
			$totalSql = "insert into dtm_group(name,company_id, status,is_deleted,created_date,updated_date) values('$param[groupname]','$param[companyname]','0','1','{$time}','{$time}')";
		else
			$totalSql = "insert into dtm_group(name,company_id, status,is_deleted,created_date,updated_date) values('$param[groupname]','$param[companyname]','1','1','{$time}','{$time}')";
        
       TLOG_MSG("IMerchantsResult_DB::AddGroup: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'INSERT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::AddGroup: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
       }
       
       TLOG_MSG("IMerchantsResult_DB::AddGroup: func end");
       return $ret;
   }
   
    function EditGroup($param)
   {
       TLOG_MSG("IMerchantsResult_DB::EditGroup: func begin");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $totalSql = "";
	   
	    $totalSql = "";
	   if ($param['active']==null)
			$totalSql = "update dtm_group set company_id='".$param['companyname']."', status='0', name='$param[groupname]' where id=".$param['id'];
		else
			$totalSql = "update dtm_group set company_id='".$param['companyname']."', status='1', name='$param[groupname]' where id=".$param['id'];
        
       TLOG_MSG("IMerchantsResult_DB::EditGroup: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'update');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::EditGroup: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
       }
       
       TLOG_MSG("IMerchantsResult_DB::EditGroup: func end");
       return $ret;
   }
   
   function EditStation($param)
   {
	   TLOG_MSG("IMerchantsResult_DB::EditStation: companyname=".$param['companyname']." active=".$param['active']." groupname=".$param['groupname']." stationname=".$param['stationname']." id=".$param['id']);
       
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	   $totalSql = "";
	   
	    
	   if ($param['active']==null)
			$totalSql = "update dtm_station set company_id=".$param['companyname'].", status='0', group_id=$param[groupname] , name='$param[stationname]' where id=".$param['id'];
		else
			$totalSql = "update dtm_station set company_id=".$param['companyname'].", status='1', group_id=$param[groupname], name='$param[stationname]' where id=".$param['id'];
        
       TLOG_MSG("IMerchantsResult_DB::EditStation: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'update');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::EditStation: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
       }
       
       TLOG_MSG("IMerchantsResult_DB::EditStation: func end");
       return $ret;
   }
   
   function SetCompany($param)
   {
       //TLOG_MSG("IMerchantsResult_DB::SetCompany: func begin");
	   TLOG_MSG("SetCompany: companyname=".$param['companyname']." active=".$param['active']." id=".$param['id']);
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
	   $time=date("Y-m-d H-i-s", time());//默认就是time()，可以省略
	  
		
	   $totalSql = "";
	   if ($param['active']==null)
			$totalSql = "update dtm_company set companyname='".$param['companyname']."', status='0' where id=".$param['id'];
		else
			$totalSql = "update dtm_company set companyname='".$param['companyname']."', status='1' where id=".$param['id'];
        
       TLOG_MSG("IMerchantsResult_DB::SetCompany: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'update');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::SetCompany: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
       }
       
       TLOG_MSG("IMerchantsResult_DB::SetCompany: func end");
       return $ret;
   }
	
   function getRunEnvDetail($nodeid)
   {
       TLOG_MSG("IMerchantsResult_DB::getRunEnvDetail: func begin");
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "sErrMsg"=>"");
       $totalSql = "select NODEID, HEARTMSG from CB_NODESTATUS where NODEID='".$nodeid."'";
        
       TLOG_MSG("IMerchantsResult_DB::getRunEnvDetail: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getRunEnvDetail: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
       
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getRunEnvDetail: func end");
       return $returnArray;
   }
   
   function getRunEnvInfo($page, $sqloption)
   {
       TLOG_MSG("IMerchantsResult_DB::getRunEnvInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
       
       $actualCntSql = "select count(*) as count from CB_NODESTATUS as a,TN_NODE as b where a.NODEID=b.NODEID and  (b.TYPE=25 or b.TYPE=26) ".$sqloption;
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::SearchAuditShowDealInfo: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
       
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
       $totalSql = "select a.NODEID,a.SECSTAT, a.AGENTTIME, a.HEARTMSG from CB_NODESTATUS as a,TN_NODE as b where a.NODEID=b.NODEID and  (b.TYPE=25 or b.TYPE=26) ".$sqloption;
       $totalSql = $totalSql." order by AGENTTIME limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getRunEnvInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getRunEnvInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
        
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getRunEnvInfo: func end");
       return $returnArray;
   }
   
   function getUserOpInfo($page, $sqloption)
   {
       TLOG_MSG("IMerchantsResult_DB::getUserOpInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
        
       $actualCntSql = "select count(*) as count from hostagent_operinfo ".$sqloption;
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getUserOpInfo: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
        
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
       
       $totalSql = "select nodeid, hostip,username,datetime,clientip,catalog,command from hostagent_operinfo ".$sqloption;
       
       $totalSql = $totalSql." order by datetime desc limit $numFrom, $pageSize";
       
       TLOG_MSG("IMerchantsResult_DB::getUserOpInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getUserOpInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
   
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getUserOpInfo: func end");
       return $returnArray;
   }
   
   function getDbOpInfo($page, $sqloption)
   {
       TLOG_MSG("IMerchantsResult_DB::getDbOpInfo: func begin");
       $htmlRes = array();
       $returnArray = array("result"=>0,
           "data_list"=>array(),
           "totalNum"=>0,
           "sErrMsg"=>"");
   
       $actualCntSql = "select count(*) as count from db_operinfo ".$sqloption;
       $returnArray["totalNum"] = $this->queryCount($actualCntSql);
       TLOG_MSG("IMerchantsResult_DB::getDbOpInfo: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]);
       if ("0" == $returnArray["totalNum"])
       {
           return $returnArray;
       }
   
       $pageSize = 20;
       $numFrom = $pageSize * ($page - 1);
        
       $totalSql = "select nodeid, srcip,srcport,destip,destport,datetime,command from db_operinfo ".$sqloption;
        
       $totalSql = $totalSql." order by datetime desc limit $numFrom, $pageSize";
        
       TLOG_MSG("IMerchantsResult_DB::getDbOpInfo: [sql]=".$totalSql);
       $ret = $this->DB->execute_v2($totalSql, 'SELECT');
       if ($ret["result"] != 0)
       {
           TLOG_ERR("IMerchantsResult_DB::getDbOpInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);
           $returnArray["result"] = $ret["result"];
           $returnArray["sErrMsg"] = $ret["errorMsg"];
           return $returnArray;
       }
        
       $returnArray["data_list"] = $ret["data_list"];
       TLOG_MSG("IMerchantsResult_DB::getDbOpInfo: func end");
       return $returnArray;
   }
   
   /*function getCommInfo($dealId, $tradeId, $sellerUin, $buyerUin)
   {
   		TLOG_MSG("IMerchantsResult_DB::getCommInfo: func begin"); 
   		//$tbIndex = ($sellerUin) % 1000;
   		$tbIndex = $sellerUin - intval($sellerUin / 1000) * 1000;
   		$tbIndex = sprintf("%03d", $tbIndex);
   		
   		TLOG_MSG("IMerchantsResult_DB::getCommInfo: [sellerUin]=".$sellerUin." [index]=".$tbIndex); 
   		$totalSql = "select deal_id, FCommodityId, fdsr1, fdsr2, fdsr3, buyer_explain, buyer_evaltime, buyer_evallevel, commodity_title, commodity_logo from t_evaluation_ref_seller_".$tbIndex." where FDealId=".$dealId." and ftradeid=".$tradeId." and seller_uin=".$sellerUin \
   		." and buyer_uin=".$buyerUin;
   		
   		mysql_query("set names latin1");
   		
   		$totalSql = "select trade_id, deal_id, CommodityId, fdsr1, fdsr2, fdsr3, buyer_explain, buyer_evaltime, buyer_evallevel, commodity_title, commodity_logo from t_evaluation_ref_seller_".$tbIndex." where FDealId=".$tradeId;
   		TLOG_MSG("IMerchantsResult_DB::getCommInfo: [sql]=".$totalSql); 
   		
   		$ret = $this->DB->execute_v2($totalSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::getCommInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
	     
	     $returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::getCommInfo: func end");  
	     return $returnArray;
   }*/
    
   /*function getSellerReply($sellerUin, $dealId)
   {
   		TLOG_MSG("IMerchantsResult_DB::getSellerReply: func begin"); 
   		$tbIndex = $sellerUin - intval($sellerUin / 128) * 128;
   		$tbIndex = sprintf("%03d", $tbIndex);
   		TLOG_MSG("IMerchantsResult_DB::getCommInfo: [sellerUin]=".$sellerUin." [index]=".$tbIndex); 
   		$totalSql = "select FUin, FContent, FROM_UNIXTIME(FLastUpdateTime) as FLastUpdateTime from t_evalreply_".$tbIndex." where FDealId=".$dealId." and FUin=".$sellerUin;
   		TLOG_MSG("IMerchantsResult_DB::getSellerReply: [sql]=".$totalSql); 
   		
   		$ret = $this->DB->execute_v2($totalSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::getCommInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
   		
   		$returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::getSellerReply: func end");  
	     return $returnArray;
   }
    
   function getShaidanImage($sellerUin, $sid, $picNum)
   {
   		TLOG_MSG("IMerchantsResult_DB::getShaidanImage: func begin"); 
   		$tbIndex = $sellerUin - intval($sellerUin / 100) * 100;
   		$tbIndex = sprintf("%02d", $tbIndex);
   		TLOG_MSG("IMerchantsResult_DB::getShaidanImage: [sellerUin]=".$sellerUin." [index]=".$tbIndex); 
   		
   		
   		$totalSql = "select url2 , url from shaidan_photo_".$tbIndex." where sid=".$sid." and sort<".$picNum." order by sort";
   		TLOG_MSG("IMerchantsResult_DB::getShaidanImage: [sql]=".$totalSql); 
   		
   		$ret = $this->DB->execute_v2($totalSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::getShaidanImage: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
   		
   		$returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::getShaidanImage: func end");  
	     return $returnArray;
   }*/
    
   /*function updateShenheStatus($queryInfoArray)
   {
   		TLOG_MSG("IMerchantsResult_DB::updateShenheStatus: func begin");
   		$returnArray = array("result"=>0, 
                            "sErrMsg"=>"");
   		  
   		$totalSql = "update shaidan_shenhe set commit_state=".$queryInfoArray["shenheRes"].", reason='".$queryInfoArray["rejectDesc"]."'" \
   		." where sid=".$queryInfoArray["sid"];
   		          
   		  if ('4' == $queryInfoArray["shenheRes"])
   		 	{
   		 		$totalSql = "update shaidan_shenhe set commit_state=".$queryInfoArray["shenheRes"].", reason='".$queryInfoArray["rejectDesc"]."'"
   					.", lasttime='".$queryInfoArray["curTime"]."' where sid=".$queryInfoArray["sid"];		
   					
   					$totalSql = "update shaidan_shenhe set commit_state=".$queryInfoArray["shenheRes"].", reason='".$queryInfoArray["rejectDesc"]."'"
   					.", lasttime='".$queryInfoArray["curTime"]."', ftrade_id='".$queryInfoArray["realSubdealid"]."', faudit_person='".$queryInfoArray["userName"]."' where id=".$queryInfoArray["notRealSid"];		
   		 	}
   		 	else if ('5' == $queryInfoArray["shenheRes"])
   		 	{
   		 			$totalSql = "update shaidan_shenhe set commit_state=".$queryInfoArray["shenheRes"].", reason='".$queryInfoArray["rejectDesc"]."'"
   					.", lasttime='".$queryInfoArray["curTime"]."', ftrade_id='".$queryInfoArray["realSubdealid"]."', faudit_person='".$queryInfoArray["userName"]."', isSndTip=0 where id=".$queryInfoArray["notRealSid"];		
   		 	}
   			
   		TLOG_MSG("IMerchantsResult_DB::updateShenheStatus: [sql]=".$totalSql); 
   		$ret = $this->DB->execute_v2($totalSql, 'update');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::updateShenheStatus: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
   		
   		return $returnArray;
   } */
   
   /*function updateShaidanInfo($queryInfoArray)
   {
   		TLOG_MSG("IMerchantsResult_DB::updateShaidanInfo: func begin");
   		
   		$tbIndex = $queryInfoArray["sellerUin"] - intval($queryInfoArray["sellerUin"] / 100) * 100;
   		$tbIndex = sprintf("%02d", $tbIndex);
   		
   		$returnArray = array("result"=>0, 
                            "sErrMsg"=>"");
                            
   		$totalSql = "update shaidan_".$tbIndex." set state=".$queryInfoArray["shenheRes"].", lasttime=".$queryInfoArray["curTime"]." where id=".$queryInfoArray["sid"];
   		TLOG_MSG("IMerchantsResult_DB::updateShaidanInfo: [sql]=".$totalSql); 
   		
   		$ret = $this->DB->execute_v2($totalSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::getCommInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
                            
   		$totalSql = "update shaidan_shenhe set commit_state=".$queryInfoArray["shenheRes"].", reason='".$queryInfoArray["rejectDesc"]."'" \
   		." where sid=".$queryInfoArray["sid"];
   		
   			$totalSql = "update shaidan_shenhe set commit_state=".$queryInfoArray["shenheRes"].", reason='".$queryInfoArray["rejectDesc"]."'"
   		.", lasttime='".$queryInfoArray["curTime"]."' where sid=".$queryInfoArray["sid"];
   		
   		TLOG_MSG("IMerchantsResult_DB::updateShenheStatus: [sql]=".$totalSql); 
   		$ret = $this->DB->execute_v2($totalSql, 'update');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::updateShenheStatus: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
   		
   		//return $returnArray;
   } */
   
   /*function BatchUpdateAuditNotPassStatus($arrSid, $aReason, $aTradeId, $curTime, $person)
   	{
   		TLOG_MSG("IMerchantsResult_DB::BatchUpdateAuditNotPassStatus: func begin");
   		$returnArray = array("result"=>0, 
                            "sErrMsg"=>"");
   		  
   		for ($i=0; $i<count($arrSid); $i++)
   		{
	   			$totalSql = "update shaidan_shenhe set commit_state=5, reason='".$aReason[$i]."'"
	   			.", lasttime='".$curTime."', ftrade_id='".$aTradeId[$i]."', faudit_person='".$person."', isSndTip=0 where id=".$arrSid[$i];		
   				//$sql = "update shaidan_shenhe set commit_state=5, lasttime='".$curTime."'"." where sid in".$arrSid;
		   		TLOG_MSG("IMerchantsResult_DB::BatchUpdateAuditNotPassStatus: [sql]=".$totalSql); 
		   		$ret = $this->DB->execute_v2($totalSql, 'update');
		    	 if ($ret["result"] != 0)
			     {
			     		 TLOG_ERR("IMerchantsResult_DB::BatchUpdateAuditNotPassStatus: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
			         $returnArray["result"] = $ret["result"];
			         $returnArray["sErrMsg"] = $ret["errorMsg"];
			         //return $returnArray;  
			     }
   		}
   		  
   		return $returnArray;
   		
   		$sql = "update shaidan_shenhe set commit_state=4, lasttime='".$curTime."'"." where sid in".$arrSid;
   		TLOG_MSG("IMerchantsResult_DB::BatchUpdateAuditNotPassStatus: [sql]=".$sql); 
   		$ret = $this->DB->execute_v2($sql, 'update');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::BatchUpdateAuditNotPassStatus: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
   		
   		return $returnArray;
   	} */
   
   /* function BatchUpdateAuditStatus($arrSid, $curTime, $person)
   	{
   		TLOG_MSG("IMerchantsResult_DB::BatchUpdateAuditStatus: func begin");
   		$returnArray = array("result"=>0, 
                            "sErrMsg"=>"");
   		  
   		//$sql = "update shaidan_shenhe set commit_state=4, lasttime='".$curTime."'"." where sid in".$arrSid;
   		$sql = "update shaidan_shenhe set commit_state=4, lasttime='".$curTime."', faudit_person='".$person."' where sid in".$arrSid;
   		TLOG_MSG("IMerchantsResult_DB::BatchUpdateAuditStatus: [sql]=".$sql); 
   		$ret = $this->DB->execute_v2($sql, 'update');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::BatchUpdateAuditStatus: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
   		
   		return $returnArray;
   	} */
   
   /*function GetCommSql($commId, $flg)
   {
   		if (0 == $flg)
   		{
   				if ("" != $commId)
		   		{
		   				$sql = " where commid=CONV(SUBSTR('".$commId."', 17, 16), 16, 10)";
		   				TLOG_MSG("IMerchantsResult_DB::GetCommSql: [sql]=".$sql);
		   				return $sql;
		   		}
   		}
   		else if (1 == $flg)
   		{
   				if ("" != $commId)
		   		{
		   				$sql = " and commid=CONV(SUBSTR('".$commId."', 17, 16), 16, 10)";
		   				TLOG_MSG("IMerchantsResult_DB::GetCommSql: [sql]=".$sql);
		   				return $sql;
		   		}	
   		}
   }*/
   
   /*function searchShaidanInfo($queryInfoArray)
    {
    	TLOG_MSG("IMerchantsResult_DB::searchShaidanInfo: func begin");  
    	//$totalSql = "select sid, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin from shaidan_shenhe";
    	$totalSql = "";
    	$bHaveSql = 0;
    	
    	$actualSql = "select id, sid, photonum, commit_state, lasttime, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin, reason, faudit_person from shaidan_shenhe ";
    	$actualCntSql = "select count(*) as count from shaidan_shenhe ";
    	
    	$totalSql = $totalSql.$this->GetSql("fdealid", $queryInfoArray["deal_id"], "");
    	//$totalSql = $totalSql.$this->GetSql("commid", $queryInfoArray["seller_comm_id"], "");
    	$totalSql = $totalSql.$this->GetSql("buyeruin", $queryInfoArray["buyer_qq"], "");
    	$totalSql = $totalSql.$this->GetSql("selleruin", $queryInfoArray["seller_qq"], "");
    	$totalSql = $totalSql.$this->GetSql("evaltime", $queryInfoArray["buyer_evalu_begin_time"], ">=");
    	$totalSql = $totalSql.$this->GetSql("evaltime", $queryInfoArray["buyer_evalu_end_time"], "<=");
    	$totalSql = $totalSql.$this->GetSql("createtime", $queryInfoArray["buyer_showdeal_begin_time"], ">=");
    	$totalSql = $totalSql.$this->GetSql("createtime", $queryInfoArray["buyer_showdeal_end_time"], "<=");
    	
    	if ("0" != $queryInfoArray["evaluationState"])
    	{
    		$totalSql = $totalSql.$this->GetSql("evallevel", $queryInfoArray["evaluationState"], "");
    	}
    	
    	if ("0" != $queryInfoArray["check_result"])
    	{
    		if (10 == $queryInfoArray["check_result"])
    		{
    				$totalSql = $totalSql.$this->GetSql("commit_state", "(4, 5)", "in");
    		}
    		else
    		{
    				$totalSql = $totalSql.$this->GetSql("commit_state", $queryInfoArray["check_result"], "");
    		}
    	}
    	
    	if (false == strpos($totalSql, "where"))
    	{
    			$totalSql = $totalSql.$this->GetCommSql($queryInfoArray["seller_comm_id"], 0);
    	}
    	else
    	{
    			$totalSql = $totalSql.$this->GetCommSql($queryInfoArray["seller_comm_id"], 1);	
    	}
    	
    	$actualSql = $actualSql.$totalSql;
    	$actualCntSql = $actualCntSql.$totalSql;
    	
    	$returnArray = array("result"=>0, 
                            "data_list"=>array(),
                            "totalNum"=>0,
                            "sErrMsg"=>"");
    	
    	$returnArray["totalNum"] = $this->queryCount($actualCntSql);
    	TLOG_MSG("IMerchantsResult_DB::searchShaidanInfo: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]); 
    	if ("0" == $returnArray["totalNum"])
    	{
    			return $returnArray;
    	}
    	
    	
    	$page = $queryInfoArray["page"];
    	$pageSize = $queryInfoArray["pageSize"];
    	$numFrom = $pageSize * ($page - 1);
    	
    	$actualSql = $actualSql." order by createtime limit $numFrom, $pageSize";
    	
    	TLOG_MSG("IMerchantsResult_DB::searchShaidanInfo: [numFrom]=".$numFrom." [pageSize]=".$pageSize); 
    	TLOG_MSG("IMerchantsResult_DB::searchShaidanInfo: [comm sql]=".$actualSql); 
    	
    	$ret = $this->DB->execute_v2($actualSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::searchShaidanInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
	     
	     $returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::searchShaidanInfo: func end");  
	     return $returnArray;
    }
    
     function searchUpDealInfo()
    {
    	TLOG_MSG("IMerchantsResult_DB::searchUpDealInfo: func begin");  
    	//$totalSql = "select sid, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin from shaidan_shenhe";
    	$totalSql = "";
    	$bHaveSql = 0;
    	
    	$actualSql = "select id, sid, photonum, commit_state, lasttime, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin, reason from shaidan_shenhe ";
    	TLOG_MSG("IMerchantsResult_DB::searchUpDealInfo: [actualSql]=".$actualSql); 
    	
    	$ret = $this->DB->execute_v2($actualSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::searchUpDealInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
	     
	     $returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::searchUpDealInfo: func end");  
	     return $returnArray;
    }
    
    function UpShowdealTradeInfo($id, $tradeId)
    {
    	TLOG_MSG("IMerchantsResult_DB::UpShowdealTradeInfo: func begin");  
    	//$totalSql = "select sid, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin from shaidan_shenhe";
    	$returnArray = array("result"=>0, 
                            "sErrMsg"=>"");
    	
    	$totalSql = "";
    	$bHaveSql = 0;
    	
    	$actualSql = "update shaidan_shenhe  set ftrade_id='".$tradeId."' where id=".$id;
    	TLOG_MSG("IMerchantsResult_DB::UpShowdealTradeInfo: [actualSql]=".$actualSql); 
    	
    	$ret = $this->DB->execute_v2($actualSql, 'update');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::UpShowdealTradeInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
	     
	     TLOG_MSG("IMerchantsResult_DB::UpShowdealTradeInfo: func end");  
	     return $returnArray;
    }
    
    function GetSameDealInfo($arrDealId)
    {
    		TLOG_MSG("IMerchantsResult_DB::GetSameDealInfo: func begin"); 
    		$returnArray = array("result"=>0, 
                            "data_list"=>array(),
                            "totalNum"=>0,
                            "sErrMsg"=>"");
    		
				$actualSql = "select fdealid, subdealid from shaidan_shenhe where subdealid in$arrDealId and commit_state=3";    
				TLOG_MSG("IMerchantsResult_DB::GetSameDealInfo: [sql]=".$actualSql); 
				$ret = $this->DB->execute_v2($actualSql, 'SELECT');
	    	 if ($ret["result"] != 0)
		     {
		     		 TLOG_ERR("IMerchantsResult_DB::GetSameDealInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
		         $returnArray["result"] = $ret["result"];
		         $returnArray["sErrMsg"] = $ret["errorMsg"];
		         return $returnArray;  
		     }
	     
	     $returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::GetSameDealInfo: func end");  
	     return $returnArray;
    }
    
   
     /*function SearchAuditShowDealInfo($queryInfoArray)
    {
    	TLOG_MSG("IMerchantsResult_DB::SearchAuditShowDealInfo: func begin");  
    	//$totalSql = "select sid, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin from shaidan_shenhe";
    	$totalSql = "";
    	$bHaveSql = 0;
    	
    	$actualSql = "select id, sid, photonum, commit_state, lasttime, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin, reason, faudit_person from shaidan_shenhe ";
    	$actualCntSql = "select count(*) as count from shaidan_shenhe ";
    	
    	$totalSql = $totalSql.$this->GetSql("fdealid", $queryInfoArray["deal_id"], "");
    	//$totalSql = $totalSql.$this->GetSql("commid", $queryInfoArray["seller_comm_id"], "");
    	$totalSql = $totalSql.$this->GetSql("buyeruin", $queryInfoArray["buyer_qq"], "");
    	$totalSql = $totalSql.$this->GetSql("selleruin", $queryInfoArray["seller_qq"], "");
    	$totalSql = $totalSql.$this->GetSql("evaltime", $queryInfoArray["buyer_evalu_begin_time"], ">=");
    	$totalSql = $totalSql.$this->GetSql("evaltime", $queryInfoArray["buyer_evalu_end_time"], "<=");
    	$totalSql = $totalSql.$this->GetSql("createtime", $queryInfoArray["buyer_showdeal_begin_time"], ">=");
    	$totalSql = $totalSql.$this->GetSql("createtime", $queryInfoArray["buyer_showdeal_end_time"], "<=");
    	
    	if ("0" != $queryInfoArray["evaluationState"])
    	{
    		$totalSql = $totalSql.$this->GetSql("evallevel", $queryInfoArray["evaluationState"], "");
    	}
    	
    	if ("0" != $queryInfoArray["check_result"])
    	{
    		if (10 == $queryInfoArray["check_result"])
    		{
    				$totalSql = $totalSql.$this->GetSql("commit_state", "(4, 5)", "in");
    		}
    		else
    		{
    				$totalSql = $totalSql.$this->GetSql("commit_state", $queryInfoArray["check_result"], "");
    		}
    	}
    	
    	if (false == strpos($totalSql, "where"))
    	{
    			$totalSql = $totalSql.$this->GetCommSql($queryInfoArray["seller_comm_id"], 0);
    	}
    	else
    	{
    			$totalSql = $totalSql.$this->GetCommSql($queryInfoArray["seller_comm_id"], 1);	
    	}
    	
    	$actualSql = $actualSql.$totalSql;
    	$actualCntSql = $actualCntSql.$totalSql;
    	
    	$returnArray = array("result"=>0, 
                            "data_list"=>array(),
                            "totalNum"=>0,
                            "sErrMsg"=>"");
    	
    	$returnArray["totalNum"] = $this->queryCount($actualCntSql);
    	TLOG_MSG("IMerchantsResult_DB::SearchAuditShowDealInfo: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]); 
    	if ("0" == $returnArray["totalNum"])
    	{
    			return $returnArray;
    	}
    	
    	
    	$page = $queryInfoArray["page"];
    	$pageSize = $queryInfoArray["pageSize"];
    	$numFrom = $pageSize * ($page - 1);
    	
    	$actualSql = $actualSql." order by createtime desc limit $numFrom, $pageSize";
    	
    	TLOG_MSG("IMerchantsResult_DB::SearchAuditShowDealInfo: [numFrom]=".$numFrom." [pageSize]=".$pageSize); 
    	TLOG_MSG("IMerchantsResult_DB::SearchAuditShowDealInfo: [comm sql]=".$actualSql); 
    	
    	$ret = $this->DB->execute_v2($actualSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::SearchAuditShowDealInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
	     
	     $returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::SearchAuditShowDealInfo: func end");  
	     return $returnArray;
    }
    
     function SearchForAuditShowDealInfo($queryInfoArray)
    {
    	TLOG_MSG("IMerchantsResult_DB::SearchForAuditShowDealInfo: func begin");  
    	//$totalSql = "select sid, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin from shaidan_shenhe";
    	$totalSql = "";
    	$bHaveSql = 0;
    	
    	$actualSql = "select id, sid, photonum, commit_state, lasttime, createtime, evallevel, fdealid, subdealid, buyeruin, selleruin, reason from shaidan_shenhe ";
    	$actualCntSql = "select count(*) as count from shaidan_shenhe ";
    	
    	$totalSql = $totalSql.$this->GetSql("fdealid", $queryInfoArray["deal_id"], "");
    	//$totalSql = $totalSql.$this->GetSql("commid", $queryInfoArray["seller_comm_id"], "");
    	$totalSql = $totalSql.$this->GetSql("buyeruin", $queryInfoArray["buyer_qq"], "");
    	$totalSql = $totalSql.$this->GetSql("selleruin", $queryInfoArray["seller_qq"], "");
    	$totalSql = $totalSql.$this->GetSql("evaltime", $queryInfoArray["buyer_evalu_begin_time"], ">=");
    	$totalSql = $totalSql.$this->GetSql("evaltime", $queryInfoArray["buyer_evalu_end_time"], "<=");
    	$totalSql = $totalSql.$this->GetSql("createtime", $queryInfoArray["buyer_showdeal_begin_time"], ">=");
    	$totalSql = $totalSql.$this->GetSql("createtime", $queryInfoArray["buyer_showdeal_end_time"], "<=");
    	
    	if ("0" != $queryInfoArray["evaluationState"])
    	{
    		$totalSql = $totalSql.$this->GetSql("evallevel", $queryInfoArray["evaluationState"], "");
    	}
    	
    	if ("0" != $queryInfoArray["check_result"])
    	{
    		if (10 == $queryInfoArray["check_result"])
    		{
    				$totalSql = $totalSql.$this->GetSql("commit_state", "(4, 5)", "in");
    		}
    		else
    		{
    				$totalSql = $totalSql.$this->GetSql("commit_state", $queryInfoArray["check_result"], "");
    		}
    	}
    	
    	if (false == strpos($totalSql, "where"))
    	{
    			$totalSql = $totalSql.$this->GetCommSql($queryInfoArray["seller_comm_id"], 0);
    	}
    	else
    	{
    			$totalSql = $totalSql.$this->GetCommSql($queryInfoArray["seller_comm_id"], 1);	
    	}
    	
    	$actualSql = $actualSql.$totalSql;
    	$actualCntSql = $actualCntSql.$totalSql;
    	
    	$returnArray = array("result"=>0, 
                            "data_list"=>array(),
                            "totalNum"=>0,
                            "sErrMsg"=>"");
    	
    	$returnArray["totalNum"] = $this->queryCount($actualCntSql);
    	TLOG_MSG("IMerchantsResult_DB::SearchForAuditShowDealInfo: [actual cnt sql]=".$actualCntSql." [num]=".$returnArray["totalNum"]); 
    	if ("0" == $returnArray["totalNum"])
    	{
    			return $returnArray;
    	}
    	
    	
    	$page = $queryInfoArray["page"];
    	$pageSize = $queryInfoArray["pageSize"];
    	//$numFrom = $pageSize * ($page - 1);
    	$numFrom = $queryInfoArray["dataFrom"];
    	
    	$actualSql = $actualSql." order by createtime desc limit $numFrom, $pageSize";
    	
    	TLOG_MSG("IMerchantsResult_DB::SearchForAuditShowDealInfo: [numFrom]=".$numFrom." [pageSize]=".$pageSize); 
    	TLOG_MSG("IMerchantsResult_DB::SearchForAuditShowDealInfo: [comm sql]=".$actualSql); 
    	
    	$ret = $this->DB->execute_v2($actualSql, 'SELECT');
    	 if ($ret["result"] != 0)
	     {
	     		 TLOG_ERR("IMerchantsResult_DB::SearchForAuditShowDealInfo: Call DB->execute_v2 error [error msg]=".$ret["errorMsg"]);  
	         $returnArray["result"] = $ret["result"];
	         $returnArray["sErrMsg"] = $ret["errorMsg"];
	         return $returnArray;  
	     }
	     
	     $returnArray["data_list"] = $ret["data_list"];
	     TLOG_MSG("IMerchantsResult_DB::SearchForAuditShowDealInfo: func end");  
	     return $returnArray;
    }*/
    
    function queryCount($sqlCount)
    {
        $retCount = $this->DB->execute_v2 ( $sqlCount, 'SELECT');
        if ($retCount["result"] == 0)
            return $retCount["data_list"][0]["count"];
        return 0;
    }
  
  	
    
    function close()
    {
    		$this->DB->close();
    }
}

?>
