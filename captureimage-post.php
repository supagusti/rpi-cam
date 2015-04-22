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
//<input type="hidden" value="SENT" name="captureForm" /></td>
    if (
            (isset($_POST['captureForm'])) and
            ($_POST['captureForm']==="SENT")
            )
{
        //ECHO "SEND OK</BR>";
        ECHO "width=".$_POST['width']."</BR>";
        ECHO "height=".$_POST['height']."</BR>";
        ECHO "quality=".$_POST['quality']."</BR>";
        ECHO "raw=".$_POST['raw']."</BR>";
        ECHO "timeout=".$_POST['timeout']."</BR>";
        ECHO "encoding=".$_POST['encoding']."</BR>";
        ECHO "sharpness=".$_POST['sharpness']."</BR>";
        ECHO "contrast=".$_POST['contrast']."</BR>";
        ECHO "brightness=".$_POST['brightness']."</BR>";
        ECHO "saturation=".$_POST['saturation']."</BR>";
        ECHO "ISO=".$_POST['ISO']."</BR>";
        ECHO "vstab=".$_POST['vstab']."</BR>";
        ECHO "ev=".$_POST['ev']."</BR>";
        ECHO "exposure=".$_POST['exposure']."</BR>";
        ECHO "awb=".$_POST['awb']."</BR>";
        ECHO "imxfx=".$_POST['imxfx']."</BR>";
        ECHO "colfx=".$_POST['colfx']."</BR>";
        ECHO "metering=".$_POST['metering']."</BR>";
        ECHO "rotation=".$_POST['rotation']."</BR>";
        ECHO "hflip=".$_POST['hflip']."</BR>";
        ECHO "vflip=".$_POST['vflip']."</BR>";
        
        $exact_time = microtime(true);
        
        $filename="Rpi-".date("Ymd_His",$exact_time).".jpg";
        $raspistillcommand="raspistill -o /var/www/capture/usb/".$filename;
        
        if ( $_POST['width']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --width ".$_POST['width'];
        }
    
        if ( $_POST['height']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --height ".$_POST['height'];
        }

        if ( $_POST['quality']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --quality ".$_POST['quality'];
        }
        
        if ( $_POST['raw']==="YES") 
        {
                $raspistillcommand=$raspistillcommand." --raw";
        }
        
        if (  $_POST['timeout']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --timeout ".$_POST['timeout'];
        }        
    
        if (  $_POST['encoding']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --encoding ".$_POST['encoding'];
        }
        
        if (  $_POST['sharpness']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --sharpness ".$_POST['sharpness'];
        }
        
        if (  $_POST['contrast']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --contrast ".$_POST['contrast'];
        }
        
        if (  $_POST['brightness']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --brightness ".$_POST['brightness'];
        }
        
        if ( $_POST['saturation']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --saturation ".$_POST['saturation'];
        }
        
        if ( $_POST['ISO']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --ISO ".$_POST['ISO'];
        }
        
        if ( $_POST['vstab']==="YES") 
        {
                $raspistillcommand=$raspistillcommand." --vstab ";
        }
        
        if ( $_POST['ev']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --ev ".$_POST['ev'];
        }
        
        if ( $_POST['exposure']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --exposure ".$_POST['exposure'];
        }        
        
        if ( $_POST['awb']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --awb ".$_POST['awb'];
        }    
        
        if ( $_POST['imxfx']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --imxfx ".$_POST['imxfx'];
        }    
        
        if ( $_POST['colfx']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --colfx ".$_POST['colfx'];
        }    
        
        if ( $_POST['metering']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --metering ".$_POST['metering'];
        }    
        
        if ( $_POST['rotation']!=="") 
        {
                $raspistillcommand=$raspistillcommand." --rotation ".$_POST['rotation'];
        }    
        
        if ( $_POST['hflip']=="YES") 
        {
                $raspistillcommand=$raspistillcommand." --hflip ";
        }    

        if ( $_POST['vflip']==="YES") 
        {
                $raspistillcommand=$raspistillcommand." --vflip ";
        }            
        
        echo "</BR></BR></BR></BR></BR>".$raspistillcommand;
        exec($raspistillcommand);
        $resize='/var/www/cmd/wwwresize '.$filename;
        exec($resize);
        header( 'Location: index.php' );              
        exit();
}
    
    // ------ CONTENT UNTIL HERE ----------
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
     echo ' <a class="menu" href="reboot.php">Reboot RPi</a>';
     echo '</div>';
     echo '</div>';
     echo '<div id="content">';
     include "includes/manual.php";
}

?>

<p>(c) 2013 by <a href="http://www.supagusti.tk" target="_blank">Supagusti's Blog</a></p>
     </div>
</body>
</html>


