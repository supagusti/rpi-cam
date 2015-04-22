<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/main.css" />
    <title>rpi-cam Raspberry Pi Camera Webserver</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
     
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
    </BR></BR>
    <p>(c) 2013 by <a href="http://www.supagusti.tk" target="_blank">Supagusti's Blog</a></p>
    </BR></BR></BR></BR></BR></BR></BR>
    <h1 style="margin-left:30%;">Login</h1>
    <p style="margin-left:30%;">Please enter your credentials to proceed.</p>
    </BR>
    
    <form action="login-validate.php" method="post" name="loginform">
        <table style="margin-left:30%;">
            <tr><td>Username:</td>
            <td><input type="text" maxlength="40"  name="username" /></td></tr>
            <tr><td>Password:</td>
            <td><input type="password" maxlength="40"  name="password" />
             <tr><td><p style="font-size: 10px;">Stay logged in</td>
            <td><input type="checkbox" maxlength="40"  value="stayloggedin" name="stayloggedin" />   
            <tr><td></td>
            <td><input type="submit" VALUE=" Login " name="submitbutton"/></td></tr>
        </table>
        
    </form>
    </BR></BR>
<?php

if ($_GET['error']==="1")
{
    echo '<p style="text-align:center; color:red;">Error - User and/or password does not match!</p>';
}

?>

</body>
</html>