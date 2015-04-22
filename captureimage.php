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
<script type="text/javascript">
    function submitform()
    {
        document.getElementById("loadingimage").style.display = "inline";
        document.forms["captureform"].submit();
        document.getElementById('width').disabled = true;
        document.getElementById('height').disabled = true;
        document.getElementById('quality').disabled = true;
        document.getElementById('raw').disabled = true;
        document.getElementById('timeout').disabled = true;
        document.getElementById('encoding').disabled = true;
        document.getElementById('sharpness').disabled = true;
        document.getElementById('contrast').disabled = true;
        document.getElementById('brightness').disabled = true;
        document.getElementById('saturation').disabled = true;
        document.getElementById('ISO').disabled = true;
        document.getElementById('vstab').disabled = true;
        document.getElementById('ev').disabled = true;
        document.getElementById('exposure').disabled = true;
        document.getElementById('awb').disabled = true;
        document.getElementById('imxfx').disabled = true;
        document.getElementById('colfx').disabled = true;
        document.getElementById('metering').disabled = true;
        document.getElementById('rotation').disabled = true;
        document.getElementById('hflip').disabled = true;
        document.getElementById('vflip').disabled = true;
        document.getElementById('submitbutton').disabled = true;
        document.getElementById('captureform').disabled = true; 
        
        
    }
     
</script>
    
    
    
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
    echo '
        
    <h1>Capture Image</h1>
    
    <form action="captureimage-post.php" method="post" id="captureform" name="captureform">
    <p>Image parameter commands</p>
            <table style="font-size:10pt;">
                <tr>
                    <td>width:</td>
                    <td><input type="text" maxlength="300" size="10" id="width" name="width" /></td>
                    <td>Set image width <size></td>
                </tr>
                <tr>
                    <td>height:</td>
                    <td><input type="text" maxlength="300" size="10" id="height" name="height" /></td>
                    <td>Set image height <size></td>
                </tr>
                <tr>
                    <td>quality:</td>
                    <td><input type="text" maxlength="300" size="10" id="quality" name="quality" /></td>
                    <td>Set jpeg quality <0 to 100></td>
                </tr>
                <tr>
                    <td>raw:</td>
                    <td><input type="checkbox" maxlength="300" size="10" id="raw" name="raw" value="YES"/></td>
                    <td>Add raw bayer data to jpeg metadata</td>
                </tr>
                <tr>
                    <td>timeout:</td>
                    <td><input type="text" maxlength="300" size="10" id="timeout"  name="timeout" /></td>
                    <td>Time (in ms) before takes picture and shuts down (if not specified, set to 5s)</td>
                </tr>                
                <tr>
                    <td>encoding:</td>
                    <td>
                    <select id="encoding" name="encoding">
                	<optgroup label="encoding">
                            <option value ="jpg">jpg</option>
                            <option value ="bmp">bmp</option>
                            <option value ="gif">gif</option>
                            <option value ="png">png</option>
        		</optgroup>
                </td>   
                    <td>Encoding to use for output file (jpg, bmp, gif, png)</td>
                </tr>                
                <tr>
                    <td>sharpness:</td>
                    <td><input type="text" maxlength="300" size="10" id="sharpness" name="sharpness" /></td>
                    <td>Set image sharpness (-100 to 100)</td>
                </tr>
                <tr>
                    <td>contrast:</td>
                    <td><input type="text" maxlength="300" size="10" id="contrast" name="contrast" /></td>
                    <td>Set image contrast (-100 to 100)</td>
                </tr>
                <tr>
                    <td>brightness:</td>
                    <td><input type="text" maxlength="300" size="10" id="brightness" name="brightness" /></td>
                    <td>Set image brightness (0 to 100)</td>
                </tr>                
                <tr>
                    <td>saturation:</td>
                    <td><input type="text" maxlength="300" size="10" id="saturation" name="saturation" /></td>
                    <td>Set image saturation (-100 to 100)</td>
                </tr>                   
                <tr>
                    <td>ISO:</td>
                    <td><input type="text" maxlength="300" size="10" id="ISO" name="ISO" /></td>
                    <td>Set capture ISO</td>
                </tr>   
                <tr>
                    <td>vstab:</td>
                    <td><input type="checkbox" maxlength="300" size="10" id="vstab" name="vstab" value="YES"/></td>
                    <td>Turn on video stablisation</td>
                </tr>   
                <tr>
                    <td>ev:</td>
                    <td><input type="text" maxlength="300" size="10" id="ev" name="ev" /></td>
                    <td>Set EV compensation</td>
                </tr>   
                <tr>
                    <td>exposure:</td>
                    <td>
                    <select id="exposure" name="exposure">
                	<optgroup label="exposure">
                            <option value ="off">off</option>
                            <option value ="auto">auto</option>
                            <option value ="night">night</option>
                            <option value ="nightpreview">nightpreview</option>
                            <option value ="backlight">backlight</option>
                            <option value ="spotlight">spotlight</option>
                            <option value ="sports">sports</option>
                            <option value ="snow">snow</option>
                            <option value ="beach">beach</option>
                            <option value ="verylong">verylong</option>
                            <option value ="fixedfps">fixedfps</option>
                            <option value ="antishake">antishake</option>
                            <option value ="fireworks">fireworks</option>
                            
        		</optgroup>
                    </td>
                    <td>Set exposure mode</td>
                </tr>                

                <tr>
                    <td>awb:</td>
                    <td>
                    <select id="awb" name="awb">
                	<optgroup label="awb">
                            <option value ="off">off</option>
                            <option value ="auto">auto</option>
                            <option value ="sun">sun</option>
                            <option value ="cloud">cloud</option>
                            <option value ="shade">shade</option>
                            <option value ="tungsten">tungsten</option>
                            <option value ="fluorescent">fluorescent</option>
                            <option value ="incandescent">incandescent</option>
                            <option value ="flash">flash</option>
                            <option value ="horizon">horizon</option>
        		</optgroup>
                    </td>
                    <td>Set AWB mode</td>
                </tr>   
                <tr>
                    <td>imxfx:</td>
                    <td>
                    <select id="imxfx" name="imxfx">
                	<optgroup label="imxfx">
                            <option value ="none">none</option>
                            <option value ="negative">negative</option>
                            <option value ="solarise">solarise</option>
                            <option value ="sketch">sketch</option>
                            <option value ="denoise">denoise</option>
                            <option value ="emboss">emboss</option>
                            <option value ="oilpaint">oilpaint</option>
                            <option value ="hatch">hatch</option>
                            <option value ="gpen">gpen</option>
                            <option value ="pastel">pastel</option>
                            <option value ="watercolour">watercolour</option>
                            <option value ="film">film</option>
                            <option value ="blur">blur</option>
                            <option value ="saturation">saturation</option>
                            <option value ="colourswap">colourswap</option>
                            <option value ="washedout">washedout</option>
                            <option value ="posterise">posterise</option>
                            <option value ="colourpoint">colourpoint</option>
                            <option value ="colourbalance">colourbalance</option>
                            <option value ="cartoon">cartoon</option>
                            
        		</optgroup>
                    </td>
                    <td>Set image effect (see Notes)</td>
                </tr>                   
                <tr>                
                    <td>colfx:</td>
                    <td><input type="text" maxlength="300" size="10" id="colfx" name="colfx" /></td>
                    <td>Set colour effect (U:V)</td>
                </tr>   
                <tr>
                    <td>metering:</td>
                    <td>
                    <select id="metering" name="metering">
                	<optgroup label="metering">
                            <option value ="average">average</option>
                            <option value ="spot">spot</option>
                            <option value ="backlit">backlit</option>
                            <option value ="matrix">matrix</option>
        		</optgroup>
                    </td>
                    <td>Set image effect (see Notes)</td>
                </tr>  
                <tr>                
                    <td>rotation:</td>
                    <td><input type="text" maxlength="300" size="10" id="rotation" name="rotation" /></td>
                    <td>Set image rotation (0-359)</td>
                </tr>                   
                <tr>                
                    <td>hflip:</td>
                    <td><input type="checkbox" maxlength="300" size="10" id="hflip" name="hflip" value="YES"/></td>
                    <td>Set horizontal flip</td>
                </tr>                   
                <tr>                
                    <td>vflip:</td>
                    <td><input type="checkbox" maxlength="300" size="10" id="vflip" name="vflip" value="YES"/></td>
                    <td>Set vertical flip</td>
                </tr>                                   
            </table>
            
            </BR>
            <input type="hidden" value="SENT" name="captureForm" /></td>
<!--            <input type="submit" VALUE=" Submit " name="submitbutton"/>  -->
        </form>   

<input type="button" value=" Submit " id="submitbutton" onclick="submitform()" />
<img src="/images/convert_blue_512" style="width:16px;height:16px;display: none;" alt="Loading..." id="loadingimage" />

        ';
    
    
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

