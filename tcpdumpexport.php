<?php
//15分钟超时
set_time_limit(15*60);
require("services/AtherFrameWork.php");
global $Obj_Frame;
global $Ary_Result;
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "downdata",0);
TLOG_MSG("downdata: func begin： data=".$_SERVER["QUERY_STRING"]);
require("services/LogService.php");
$Obj_Frame = new AtherFrameWork();

//$Ary_Result= $Obj_Frame->load_page("Channel::Download","",false);
//TLOG_MSG("downdata: data=".$Ary_Result['result']['tab']);
//$text = $Ary_Result['result']['tab'];
  //  print($text);
//$vendor=explode(",",$text);
$vendor=explode(",","3.000000,2.003906,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,-0.000031,-8209.874023,2.004179,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,0.000000,");

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


if(isset($_POST["export"]))
{

 // $file = new Spreadsheet();

  //$active_sheet = $file->getActiveSheet();
$sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(__DIR__ . '/reporttemp/testreport.xlsx');
$sheet->setActiveSheetIndex(0);

$activesheet = $sheet->getActiveSheet();
$count =7;


  $activesheet->setCellValueExplicit('B' . $count, number_format($vendor[0], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('C' . $count, number_format($vendor[1], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('D' . $count, number_format($vendor[2], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('E' . $count, number_format($vendor[3], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('F' . $count, number_format($vendor[4], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('G' . $count, number_format($vendor[5], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('H' . $count, number_format($vendor[6], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('I' . $count, number_format($vendor[7], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('J' . $count, number_format($vendor[8], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('K' . $count, number_format($vendor[9], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('L' . $count, number_format($vendor[10], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('M' . $count, number_format($vendor[11], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('N' . $count, number_format($vendor[12], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('O' . $count, number_format($vendor[13], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('P' . $count, number_format($vendor[14], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('Q' . $count, number_format($vendor[15], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
  $activesheet->setCellValueExplicit('R' . $count, number_format($vendor[16], 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

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
  $file_name = time() . '.' . strtolower($_POST["file_type"]);
 
  //$writer->save(__DIR__ . '/reporttemp/output.xlsx');

  $writer->save($file_name);

  header('Content-Type: application/x-www-form-urlencoded');

  header('Content-Transfer-Encoding: Binary');

  header("Content-disposition: attachment; filename=\"".$file_name."\"");

  readfile($file_name);

  unlink($file_name);

  exit;

}

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



