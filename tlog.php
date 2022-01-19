<?php
//�ݲ�����
//require_once "/usr/local/boss/ad/php/common/bosscgi.php";

define ("TLOG_LEVEL_D", 0); //���Լ���
define ("TLOG_LEVEL_M", 1); //MSG����
define ("TLOG_LEVEL_E", 2); //���󼶱�

class CTLog
{
    public $dwLogLevl;  //��־����
    public $dwMaxFiles; //����ļ���
    public $dwMaxSize;  //ÿ���ļ������size
    public $sLogPath;   //��־Ŀ¼
    public $sFileName;  //��־�ļ���
    public $dwConFlag;  //�Ƿ����̨չʾ
    ////
    //��̬����
    private static   $instance;
    function __construct(){}
    
    public function InitParam()
    {
        $this->dwLogLevl  = 0;
        $this->dwMaxFiles = 0;
        $this->dwMaxSize  = 0;
        $this->sLogPath   = "";
        $this->sFileName  = "";
        $this->dwConFlag  = 0;
    }
    
    public static function GetInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    //�����ļ��������ļ���С����־Ŀ¼����־�ļ�
    public function Init($level, $maxfiles, $maxsize, $logpath, $filename, $conflag)
    {
        $this->dwLogLevl  = $level;
        $this->dwMaxFiles = $maxfiles;
        $this->dwMaxSize  = $maxsize;
        if ($logpath[strlen($logpath)-1] != '/')
        {
            $this->sLogPath   = $logpath . "/";
        }
        else
        {
            $this->sLogPath   = $logpath;
        }
        $this->sFileName  = $filename;
        $this->dwConFlag = $conflag;
        //���Ŀ¼�Ƿ���ڣ��������򴴽�һ��
        if (!file_exists($this->sLogPath))
        {
            mkdir($this->sLogPath, 0777, true);
        }
        return 0;
    }
    public function GetTime()
    {
        $ustime = explode ( " ", microtime () );
        return "[" . date('Y-m-d H:i:s', time()) .".". ($ustime[0] * 1000) . "]";
    }
    
    public function __echo($var)
    {
        if ($this->dwConFlag == 1)
        {
            echo "<pre>" . $var;
        }
        return 0;
    }
    
    public function Msg($var, $file, $line)
    {
    		
        //$this->__echo($var);
        
        if ($this->dwLogLevl >= TLOG_LEVEL_M)
        {
            $this->__log($this->GetTime() . "[" . $file . ":" . $line . "] MSG: " . $var . "\n");
        }
        return 0;
    }
    public function Debug($var, $file, $line)
    {
        $this->__echo($var);
        
        if ($this->dwLogLevl >= TLOG_LEVEL_D)
        {
            $this->__log($this->GetTime() . "[" . $file . ":" . $line . "] DEBUG: " . $var . "\n");
        }
        return 0;
    }
    public function Err($var, $file, $line)
    {
        $this->__echo($var);
        
        if ($this->dwLogLevl >= TLOG_LEVEL_D)
        {
            $this->__log($this->GetTime() . "[" . $file . ":" . $line . "] ERR: " . $var . "\n");
        }
        return 0;
    }
    //д�ļ�
    public function __log($var)
    {
        //�建����Ϣ
        clearstatcache();
        //���ж��ļ���С�Ƿ�ﵽ���ֵ
        $sFName = $this->sLogPath . $this->sFileName . ".log";
        //����ļ�����
        if (file_exists($sFName))
        {
            //�ļ��ﵽ���ֵʱ
            if (filesize($sFName) >= $this->dwMaxSize)
            {
                //����������־�ļ�
                $dwIndex = 0;
                for (; $dwIndex < $this->dwMaxFiles; $dwIndex++)
                {
					
                    if (!file_exists($this->sLogPath . $this->sFileName . "_" . $dwIndex . ".log"))
                    {
                        break;
                    }
                }
                //����ﵽ���ֵ����ɾ�����ϵ���־�ļ�
                if ($dwIndex == $this->dwMaxFiles -1)
                {
                    if (file_exists($this->sLogPath . $this->sFileName . "_" . $dwIndex . ".log"))
                    {
                        unlink($this->sLogPath . $this->sFileName . "_" . $dwIndex . ".log");
                    }
                }
                //�ƶ��ļ�
                for (; $dwIndex > 0; $dwIndex--)
                {
                    $old = $this->sLogPath . $this->sFileName . "_" . ($dwIndex-1) . ".log";
                    $new = $this->sLogPath . $this->sFileName . "_" . $dwIndex . ".log";
                    rename($old, $new);
                }
                //�ƶ����ļ�
                $sNFile = $this->sLogPath . $this->sFileName . "_0.log";
                rename($sFName, $sNFile);
            }
        }
        //�½��ļ���д��־
        
        
        $fp = fopen($sFName, "ab");
        if($fp === false) // added by ryansu 2013-06-28: ������ļ�ʧ�ܣ������½�Ŀ¼��
        {
            if(mkdir(dirname($sFName), 0755, true) === true)
            {
                $fp = fopen($sFName, "a+b");
            }
        }
        
        fwrite($fp, $var, strlen($var));
        fclose($fp);
        return 0;
    }
    
    public function TWRITE_MSG($var)
    {
        //echo $var;
        //echo("data=".$var);
        $ret = debug_backtrace();
        $this->Msg($var, basename($ret[0]["file"]), $ret[0]["line"]);
    }
}

function TLOG_INIT($level=TLOG_LEVEL_M, $maxfiles=10, $maxsize=10240000, 
                   $logpath="./", $filename="noname", $cflag = NULL)
{
    /*
    $CF = $cflag;
    if ($CF == NULL)
    {
        if (BOSSCGI::GetInstance()->debug == 1)
        {
            $CF = 1;
        }
    }
    */
    //�ݲ��ṩ
    $CF = 0;
    CTLog::GetInstance()->Init($level, $maxfiles, $maxsize, $logpath, $filename, $CF);
}
//function TLOG_MSG($var)
function TLOG_MSG($var)
{
    //echo $var;
    
    $ret = debug_backtrace();
	CTLog::GetInstance()->Msg($var, basename($ret[0]["file"]), $ret[0]["line"]);
}

function TLOG_ERR($var)
{
    //echo $var;
    $ret = debug_backtrace();
	CTLog::GetInstance()->Err($var, basename($ret[0]["file"]), $ret[0]["line"]);
}
function TLOG_DEBUG($var)
{
    //echo $var;
    $ret = debug_backtrace();
	CTLog::GetInstance()->Debug($var, basename($ret[0]["file"]), $ret[0]["line"]);
}

/*
���Դ���
TLOG_INIT();
for ($i=0; $i < 100; $i++)
{
    TLOG_MSG("test");
    TLOG_ERR("h");
    TLOG_DEBUG("444");
}
*/
?>
