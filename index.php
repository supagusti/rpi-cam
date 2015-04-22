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
     
<?php    

include 'includes/checklogin.php';

//USB Stick gemountet ?

//$command="ls /var/www/capture/usb/exist";
$command="mount | grep /dev/sda";
$return=shell_exec($command);

// LINKER NAVIGATOR
  echo '<div id="left">';
  echo '<div class="menucontainer">';
  echo ' <p class="menutitle">Main Menu</p>';
  echo ' <a class="menu" href="index.php">Home</a>';
  echo '</div>';
  echo '<div class="menucontainer">';
  echo ' <p class="menutitle">USB Stick</p>';


//if (trim($return)==='/var/www/capture/usb/exist')
if (trim($return)!='')
{   
    $usbstick="MOUNT OK";
    //Check ob USB Stich auch vom WWW beschreibbar?
    include "includes/checkusb.php";
    
    //$isrunning = file_get_contents('/var/www/capture/usb/tlstatus', NULL, NULL, 0, 1);
    
    $varfilearray=  explode("\n",file_get_contents('/var/www/capture/usb/tlstatus'));
    
    $isrunning=$varfilearray[0];
    session_start();
    $_SESSION['rollname']=$varfilearray[1];
    $_SESSION['sleeptime']=$varfilearray[2];
    
    if ($isrunning === "1") {echo ' <a class="menu" href="#">'.$usbstick.'</a>';} else {echo ' <a class="menu" href="umount.php">'.$usbstick.'</a>';}
    echo '<p style="text-align:center;">/var/www/capture/usb</p>';
    // load USB Stick free Space
    include 'includes/displayusb.php';
    
    if ($isrunning === "1") {echo ' <a class="menu" href="#">Unmount not possible</a>';} else {echo ' <a class="menu" href="umount.php">Unmount</a>';}
    
    echo '</div>';
    echo '<div class="menucontainer">';
    echo ' <p class="menutitle">Operation</p>';
    if ($isrunning === "1") 
        { 
            //NOP
        } 
        else 
        {
            echo ' <a class="menu" href="quickcapture.php">Quick Image capture</a>';
            echo ' <a class="menu" href="imagepreview.php">Preview Image</a>';
            echo ' <a class="menu" href="captureimage.php">Capture Image</a>';
            echo ' <a class="menu" href="listimages.php">List Images</a>';
        
        }
    
    echo ' <a class="menu" href="timelapse.php">Timelapse</a>';
    
    
    if ($isrunning === "1") {$status="Timelapse running";} elseif ($isrunning ==="2"){$status="AVI converting";} else {$status="Timelapse stopped";}
    echo '<p style="text-align:center;">'.$status.'</p>';
    echo ' <a class="menu" href="apconfig.php">Configure AP</a>';
    echo ' <a class="menu" href="reboot.php">Reboot RPi</a>';
    echo ' <a class="menu" href="logout.php">Logout "'.$_SESSION['username'].'"</a>';
    echo '</div>';
    
    echo '</div>';
    
    
    // ------ CONTENT GOES HERE ----------
    echo '<div id="content">';
    include "includes/manual.php";
    
    
    echo "<h1>Last captured image:</h1>";
/*    
    $command="ls -t /var/www/capture/usb/ | grep jpg";
    $return="";
    exec($command,$return);
    $filename=$return[0];
    
    echo '<a href="/capture/usb/'.$filename.'">';
    echo '<img src="/capture/usb/'.$filename.'" width="162" height="122" alt="RPi Icon">';
    echo "</a></br></br>";
*/    
    $command="ls -t /var/www/capture/usb/Rpi*.jpg";
    $return="";
    exec($command,$return);
    $filenamearray=  explode("/", $return[0]);
    $filename=end($filenamearray);
    echo '<a href="/capture/usb/'.$filename.'">';
    echo '<img src="/capture/usb/preview-'.$filename.'" width="162" height="122" alt="RPi Icon">';
    echo "</a></br></br>";
}
 else 
{
     $usbstick="NOT MOUNTED";
     echo ' <a class="menu" href="mount.php">'.$usbstick.'</a>';
     echo ' <p style="text-align:center;">/var/www/capture/usb</p>';
     echo ' <a class="menu" href="mount.php">Mount</a>';
     echo '</div>';
     
     echo '<div class="menucontainer">';
     echo ' <p class="menutitle">Operation</p>';
     echo ' <a class="menu" href="apconfig.php">Configure AP</a>';
     echo ' <a class="menu" href="reboot.php">Reboot RPi</a>';
     echo ' <a class="menu" href="logout.php">Logout "'.$_SESSION['username'].'"</a>';
     echo '</div>';
     echo '</div>';
     echo '<div id="content">';
     include "includes/manual.php";
}

?>
 <h1>Send a command to your rpi-cam:</h1>
<form action="index.php" method="post" name="loginform">
            <table>
                <tr>
                    <td>command:</td>
                    <td><input type="text" maxlength="300" size="100" name="command" /></td>
                </tr>

                <tr>
                    <td></td>
                    <td><p>eg. raspistill -t 10000 -tl 2000 -o /var/www/capture/usb/image%d.jpg</p></td>
                </tr>

            </table>
            </BR>
            <input type="submit" VALUE=" Submit " name="submitbutton"/> 
        </form>   



<?php 
if (isset($_POST['command']))
{
    $command=trim($_POST['command']);
    $return="";
    $line="";
    exec($command,$return);
    echo "<h1>Command Output:</h1>";
    echo '<p style="font-family: monospace;">';
    echo '"'.$command.'"</br>';
    //print_r ($return);
    echo "<hr></hr>";
    echo '<p style="font-family: monospace;"';
    foreach ($return as $line) 
        {
            print "$line<br>";
        }
    echo '<p>';
    echo "<hr></hr>";
}

?>
<p>(c) 2013 by <a href="http://www.supagusti.tk" target="_blank">Supagusti's Blog</a></p>
     </div>
</body>
</html>

