<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/main.css" />
    <title>rpi-cam Raspberry Pi Camera Webserver</title>
    <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->


</head>
<div id="maintitle">
<div style="width:1010px;margin:0px auto;text-align:left;background-color:#bdbec6;border:1px solid #000000;">
 <div id="title">
  <img src="/images/raspberry-pi-icon.png" style="float:right;width:100px;height:89px;margin-left:3px;" alt="RPI Icon" />
  <h1 style="float:right;width:100px;height:29px;margin-right:-110px;margin-top: 85px;">
  <font color="red">rpi-cam</font>
  </h1>
  <h1>Raspberry Pi Camera Webserver</h1>
  </br></br>A simple LAMP based server with support for the Raspberry Pi Camera Module
 </div>
</div>
<!--
    <img src="/images/raspberry-pi-icon.png" width="100" height="89" alt="RPi Icon">
    <p style="margin-top: -20px;"> Raspberry Pi Camera Webserver</p>
-->    
<body>

<?php
    include 'includes/checklogin.php';
    $command="sudo reboot";
    exec($command,$return);

?>

</BR></BR></BR></BR></BR>
</br></br>
<h1>System is going down for reboot....</h1>    
<p>Please wait until the rpi-cam has finished rebooting!</p>

    <script language="JavaScript" type="text/javascript">  
    var count =61  
    var redirect="index.php"  
      
    function countDown(){  
     if (count <=0){  
      window.location = redirect;  
     }else{  
      count--;  
      document.getElementById("timer").innerHTML = "This page will redirect in "+count+" seconds."  
      setTimeout("countDown()", 1000)  
     }  
    }  
    </script>  
      
      
      
    <span id="timer">  
    <script>  
     countDown();  
    </script>  
    </span>  

</body>
</html>