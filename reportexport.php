<?php
//15分钟超时
set_time_limit(15*60);
require("services/AtherFrameWork.php");
global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "downdata",0);

require("services/LogService.php");
$Obj_Frame = new AtherFrameWork();

$retItem = array();
$retItem[0] = 'B';
$retItem[1] = 'C';
$retItem[2] = 'D';
$retItem[3] = 'E';
$retItem[4] = 'F';
$retItem[5] = 'G';
$retItem[6] = 'H';
$retItem[7] = 'I';
$retItem[8] = 'J';
$retItem[9] = 'K';
$retItem[10] = 'L';
$retItem[11] = 'M';
$retItem[12] = 'N';
$retItem[13] = 'O';
$retItem[14] = 'P';
$retItem[15] = 'Q';
$retItem[16] = 'R';
$retItem[17] = 'S';
$retItem[18] = 'T';
$retItem[19] = 'U';
$retItem[20] = 'V';
$retItem[21] = 'W';
$retItem[22] = 'X';
$retItem[23] = 'Y';
$retItem[24] = 'Z';
$retItem[25] = 'AA';
$retItem[26] = 'AB';
$retItem[27] = 'AC';
$retItem[28] = 'AD';
$retItem[29] = 'AE';
$retItem[30] = 'AF';
$retItem[31] = 'AG';
$retItem[32] = 'AH';
$retItem[33] = 'AI';


if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'exportlist') {

if(isset($_REQUEST['devname']) && trim($_REQUEST['devname'])!="")
{

  $devname = $_REQUEST['devname'];
 
}

if(isset($_REQUEST['date_from']) && trim($_REQUEST['date_from'])!="")
{


  $datefrom = $_REQUEST['date_from'];
}
  
if(isset($_REQUEST['date_to']) && trim($_REQUEST['date_to'])!="")
{

  
  $dateto = $_REQUEST['date_to'];
  
}

if(isset($_REQUEST['report_type']) && trim($_REQUEST['report_type'])!="")
{

  $reptype = $_REQUEST['report_type'];
  
}
if(isset($_REQUEST['file_type']) && trim($_REQUEST['file_type'])!="")
{

  $ftype = $_REQUEST['file_type'];
 
} 
}
/*
print_r($datefrom);
print_r($dateto);
print_r($reptype);
print_r($ftype);
print_r($devname);*/



$Ary_Result= $Obj_Frame->load_page("Channel::Download",$devname,false);

//echo $_SERVER["QUERY_STRING"];
//TLOG_MSG("downdata: data=".$Ary_Result['result']['tab']);
//$text = $Ary_Result['result']['tab'];

//$vendor=explode(",","3.000000,2.003906,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,-0.000031,-8209.874023,2.004179,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,");
//$vendor=explode(",",$text);

//echo $Ary_Result['result'][0];    
//echo $_SERVER["QUERY_STRING"];

//php_spreadsheet_export.php

include '/home/axitech/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

//$sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(__DIR__ . '/reporttemp/testreport.xlsx');
//$sheet->setActiveSheetIndex(0);

//$activeSheet = $sheet->getActiveSheet();
//$activeSheet->setCellValueExplicit('B4', number_format(126852.36, 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
//$activeSheet->setCellValueExplicit('B5', number_format(33525555.2, 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);


//if(isset($_POST["export"]))
//{

 // $file = new Spreadsheet();

  //$active_sheet = $file->getActiveSheet();
$sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(__DIR__ . $_REQUEST['templatelocation']);
$sheet->setActiveSheetIndex(0);

$activesheet = $sheet->getActiveSheet();
$count =7;

TLOG_MSG("downdata: func begin： type=".$_REQUEST['report_type']);
if($Ary_Result['result'] != "" && !empty($Ary_Result['result']) && $Ary_Result['message'] != "" && !empty($Ary_Result['message']))
{
	$tmp=explode("|",$Ary_Result['result']);
	$tmpSeprator=explode("|",$Ary_Result['message']);

//TLOG_MSG("downdata: func begin： tmp[0]=".$tmp[0]." location=".$Ary_Result['message']);
	$curtime = "";
	foreach($tmp as $j=>$info)
	{
		$vendor=explode(",",$tmp[$j]);
		$data=explode(",",$tmpSeprator[$j]);
		
		
		foreach($vendor as $k=>$item)
		{
			if ($k == 0)
				$activesheet->setCellValue("A".$count, $vendor[0]);
			else
				$activesheet->setCellValueExplicit($data[$k] . $count, number_format($vendor[$k], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
		}
		
		$count++;
	}
	
}


	
	$todt = new DateTime($_REQUEST['date_to']);
	
	$todate = $todt->format('Y-m-d');
	
	$activesheet->setCellValue("U1", $todate);
	//$activesheet->setCellValue("A7", $todt);
	$activesheet->setCellValue("H2", $_REQUEST['devicedesc']);
  

  //$count = 2;

 /* foreach($result as $row)
  {
    $active_sheet->setCellValue('A' . $count, $row["first_name"]);
    $active_sheet->setCellValue('B' . $count, $row["last_name"]);
    $active_sheet->setCellValue('C' . $count, $row["created_at"]);
    $active_sheet->setCellValue('D' . $count, $row["updated_at"]);

    $count = $count + 1;
  }*/
  //$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
 // $spreadsheet = $reader->load("test.xlsx");
 // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $_POST["file_type"]);
   $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
 // $file_name = time() . '.' . strtolower($_POST["file_type"]);
    $file_name = time() . '.' . strtolower($ftype);
  //$writer->save(__DIR__ . '/reporttemp/output.xlsx');

  $writer->save($file_name);

  header('Content-Type: application/x-www-form-urlencoded');

  header('Content-Transfer-Encoding: Binary');

  header("Content-disposition: attachment; filename=\"".$file_name."\"");

  readfile($file_name);

  unlink($file_name);

  exit;



?>
<!DOCTYPE html>
<html>
   <head>
     <title>Export Data From Mysql to Excel using PHPSpreadsheet</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
   </head>
   <body>
     <div class="container">
      <br />
      <h3 align="center">Export Data From Mysql to Excel using PHPSpreadsheet</h3>
      <br />
        <div class="panel panel-default">
          <div class="panel-heading">
            <form method="post">
              <div class="row">
                <div class="col-md-6">User Data</div>
                <div class="col-md-4">
                  <select name="file_type" class="form-control input-sm">
                    <option value="Xlsx">Xlsx</option>
                    <option value="Xls">Xls</option>
                    <option value="Csv">Csv</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="export" class="btn btn-primary btn-sm" value="Export" />
                </div>
              </div>
            </form>
          </div>
          <div class="panel-body">
          <div class="table-responsive">
           <table class="table table-striped table-bordered">
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                </tr>
         

              </table>
          </div>
          </div>
        </div>
     </div>
      <br />
      <br />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </body>
</html>



