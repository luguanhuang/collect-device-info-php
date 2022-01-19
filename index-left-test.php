<?php
require("services/AtherFrameWork.php");
require("mdb/MenuData.php");
TLOG_INIT(TLOG_LEVEL_M, 10, 1024000, "./logs", "indexleft",0);
TLOG_MSG("indexleft: func begin");
global $Obj_Frame;
global $Ary_ResultCompany;
global $Ary_ResultGroup;
global $Ary_ResultStation;
global $Ary_ResultDevice;
$Obj_Frame = new AtherFrameWork();
//$Ary_Result= $Obj_Frame->user_getlogin(true);
$Ary_ResultCompany= $Obj_Frame->load_page("Company::getCompanyList",@FuncExt::getnumber('page'),false);
$Ary_ResultGroup= $Obj_Frame->load_page("Group::getGroupList",@FuncExt::getnumber('page'),false);
$Ary_ResultStation= $Obj_Frame->load_page("Station::getStationInfoList",@FuncExt::getnumber('page'),false);
$Ary_ResultDevice= $Obj_Frame->load_page("Station::getDeviceList",@FuncExt::getnumber('page'),false);

//$Ary_Params = $Ary_Result['result']['pagequery'];
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link type="text/css" rel="stylesheet" href="css.css" />
<base target="mainFrame" />
</head>
<body style="background: #B2ABA9;text-align: left;margin-left: 15px;">
<div>
<form id="frm" name="frm" action="submit.php" onsubmit="" submitwin="ajax" method="post">
<ul id="myUL">
  <?php
    if (is_array($Ary_ResultCompany['result']['data'])){
      foreach($Ary_ResultCompany['result']['data'] as $kCompany=>$rowCompany){
  ?>
    <div><li>
      <span class="caret"><?=$rowCompany['companyname']?></span>
      <ul class="nested">
        <?php
        if (is_array($Ary_ResultGroup['result']['data'])){
          foreach($Ary_ResultGroup['result']['data'] as $kGroup=>$rowGroup){
          if ($rowGroup['company_id'] != $rowCompany['id'])
            continue;
        ?>
         <div> <li>
            <span class="caret"><?=$rowGroup['name']?></span>
            <ul class="nested">
               <?php
                if (is_array($Ary_ResultStation['result']['data'])){
                  foreach($Ary_ResultStation['result']['data'] as $kStation=>$rowStation){
                    
                  if ($rowStation['company_id'] != $rowGroup['company_id']
                    || $rowStation['group_id'] != $rowGroup['id'])
                    continue;
                ?>
               <div> <li>
                  <span class="caret"><?=$rowStation['name']?></span>
                  <ul class="nested">
                    <?php
                      if (is_array($Ary_ResultDevice['result']['data'])){
                      foreach($Ary_ResultDevice['result']['data'] as $kDevice=>$rowDevice){

                      if ($rowDevice['company_id'] != $rowStation['company_id']
                      || $rowDevice['group_id'] != $rowStation['id']
                      || $rowDevice['station_id'] != $rowStation['id'])
                      continue;
                    ?>
                    <li>
                      <a  href="livedata.php?id=<?=$rowDevice['id']?>&devname=<?=$rowDevice['devname']?>" onclick="return Tag_Show()" ><?=$rowDevice['devname']?></a>
                    </li>
                    <?php }
                    }
                    ?>
                    
                  </ul>
               <li> </div> 
              <?php }
              }
              ?>
            </ul>
        </li>  </div>
        <?php }
        }
        ?>
        
      </ul>
  </li> </div>
  <?php }
  }
  ?>
</ul>  

<input name="php_interface" type="hidden" id="php_interface" value="Router::setRoute" />
<input name="php_parameter" type="hidden" id="php_parameter" value="[['id'],'actstep']" />
<input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />

</form> 
</div>
<form id="frm2" name="frm2" action="livedata.php" onsubmit="" submitwin="tab_self" method="get">  

  <input name="devname"     id="devname"    type="hidden" value="" />
    <input name="php_parameter" type="hidden" id="php_parameter" value="['devname']" />
    <input name="php_returnmode" type="hidden" id="php_returnmode" value="normal" />
</form>

<script type="text/javascript" src="js/route.js"></script>
<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>

</body>
</html>
