<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <link type="text/css" rel="stylesheet" href="css.css">
  </head>
  <body style="padding-top: 0;">
    <table height="100" cellSpacing="0" cellPadding="0" width="100%" border="0" align="center" style=" no-repeat left top;">
    <!--  <table height="100" cellSpacing="0" cellPadding="0" width="100%" border="0" align="center" style="background: #00a099 url(images/banner.jpg) no-repeat left top;"> -->
      <tr>
     <td title="GASOREX Cloud Platform" style="min-width:10%;display:table-cell;vertical-align:middle;height:80px;">
        <a><img src="images/axitech_logo.png"></a>
     </td>
     <td style="min-width:60%;display:table-cell;vertical-align:middle;height:80px;">
      <a style="text-align:center;">

        <font size="6" color="#075887"><b>&nbsp; GASOREX CLOUD PLATFORM</b></font>
          
      </a>


      </td>
     <td id="tabtop" style="min-width:20%;display:table-cell;vertical-align:middle;height:80px;"> 
          <div>
           <!-- <a href="#" onclick="(function(){if (parent.leftFrame && typeof(parent.leftFrame.gotoHome)=='function'){parent.leftFrame.gotoHome();}})();return false;" style="margin-right:12px;">
            <img style="margin: 0 5px 5px 0; border: 0;" src="images/home.png" title="首页" alt="首页"  class="btn2"></a>
            <a href="#" onclick="(function(){if (parent.leftFrame && typeof(parent.leftFrame.gotoLogout)=='function'){parent.leftFrame.gotoLogout()}})();return false;">
            <img style="margin-bottom: 5px; border: 0;" src="images/logout.png" title="退出" alt="退出" class="btn2"></a>   -->

            <input class="btn" id="btnsave" type="submit" value="HOME" name="btnsave" onclick="gotoHome();">
             <input class="btn" id="btnsave" type="submit" value="ADMINISTRATOR" name="btnsave" onclick="(function(){if (parent.leftFrame && typeof(parent.leftFrame.gotoLogout)=='function'){parent.leftFrame.gotoLogout()}})();return false;">
            <input class="btn" id="btnsave" type="submit" value="LOGOUT" name="btnsave" onclick="gotoLogout();">

          </div>
        	<div class="datetime">current time：<b id="datetime"><?=date("Y-m-d H:i:s")?></b></div>
          <br clear="all">
        </td> 
      </tr>
    </table>
     
    <script type="text/javascript" src="js/systemset.js"></script>
	<script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript">DateTime_StartCount(<?=time()?>)</script>	
  </body>
</html>