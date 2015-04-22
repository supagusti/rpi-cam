<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/main.css" />
    <title>rpi-cam Raspberry Pi Camera Webserver</title>
    <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
    <script type="text/javascript" charset="utf-8">
            window.onload = function() {
                    document.location="captureandpreview.php";
            }
    </script>     
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
    $isrunning = file_get_contents('/var/www/capture/usb/tlstatus', NULL, NULL, 0, 1);
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
    
    echo '<h1>Image Capture</h1>';
    echo "<p>In Progress....</p></br>";
    echo '<img src="/images/convert_blue_512.gif" width="128" height="128" alt="progress">';
    echo "</BR>";
    echo "<p>Please be patient, this will take a view seconds!</p>";
//echo "irunning=".$isrunning;
//echo "<br>";


    
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
}

?>
 <!--
<form action="shellexec.php" method="post" name="loginform">
            <table>
                <tr>
                    <td>command:</td>
                    <td><input type="text" maxlength="100" size="100" name="command" /></td>
                </tr>

                <tr>
                    <td></td>
                    <td><p>eg. raspistill -t 10000 -tl 2000 -o /var/www/capture/usb/image%d.jpg</p></td>
                </tr>

            </table>
            </BR>
            <input type="submit" VALUE=" Submit " name="submitbutton"/> 
        </form>   
 -->
</br>    
<p>(c) 2013 by <a href="http://www.supagusti.tk" target="_blank">Supagusti's Blog</a></p>
     </div>
</body>
</html>


    
