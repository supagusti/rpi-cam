<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/main.css" />
    <title>rpi-cam Raspberry Pi Camera Webserver</title>
    <!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
     <script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
     <script src="script/lightbox.js"></script>

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


    function deleteImage(thisImage,linkurl)
    {
        var xmlHttpObject = new XMLHttpRequest();
        
         //Image auf den Spinner ändern
         thisImage.src="images/convert_blue_512.gif";

        
        // Anfrage vorbereiten, ruft createthumbs auf
        xmlHttpObject.open('GET', linkurl);
        // Handler hinterlegen
        xmlHttpObject.onreadystatechange = handleStateChange;
        // Anfrage abschicken
        xmlHttpObject.send(null);

         
         
        // Funktion, die bei Statusänderungen reagiert (ist eine Unterfunktion innerhalb der aufgerufenen Funktion)
        function handleStateChange()
            {
                // Derzeitigen Status zurückgeben
                //alert("xmlHttpObject.readyState = " + xmlHttpObject.readyState + (xmlHttpObject.readyState >= 3 ? " HTTP-Status = " + xmlHttpObject.status : ''));
                if (xmlHttpObject.readyState===4 ) {
                    //Retourmeldung ausgeben
                    alert (xmlHttpObject.responseText);
                    //Image auf den Spinner ändern
                    thisImage.src="images/delete-icon.png.png";
                    //Page reload
                    window.location.reload();
                }

            }
         
    }





    function createPreview(thisImage,linkurl)
    {
        var xmlHttpObject = new XMLHttpRequest();
        
         //Image auf den Spinner ändern
         thisImage.src="images/convert_blue_512.gif";

        
        // Anfrage vorbereiten, ruft createthumbs auf
        xmlHttpObject.open('GET', linkurl);
        // Handler hinterlegen
        xmlHttpObject.onreadystatechange = handleStateChange;
        // Anfrage abschicken
        xmlHttpObject.send(null);

         
         
        // Funktion, die bei Statusänderungen reagiert (ist eine Unterfunktion innerhalb der aufgerufenen Funktion)
        function handleStateChange()
            {
                // Derzeitigen Status zurückgeben
                //alert("xmlHttpObject.readyState = " + xmlHttpObject.readyState + (xmlHttpObject.readyState >= 3 ? " HTTP-Status = " + xmlHttpObject.status : ''));
                if (xmlHttpObject.readyState===4 ) {
                    //Retourmeldung ausgeben
                    alert (xmlHttpObject.responseText);
                    //Image auf den Spinner ändern
                    thisImage.src="images/preview_create.png";
                    //Page reload
                    window.location.reload();
                }

            }
         
    }
    
</script>        
<?php    
include 'includes/checklogin.php';
include "includes/checkusb.php";

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
    echo "<h1>List captured images:</h1></BR>";
    //$command="ls /var/www/capture/usb/ | grep jpg";
    $command="ls /var/www/capture/usb/Rpi*";
    exec($command,$return);
    $count=0;
    //echo "<p>".$command."<p>";
    //print_r ($return);

    //echo "<p>-------------------------------------------</p>";
    echo "<table>";
    foreach ($return as $line) {
        $count=$count+1;
        $lineOut=  end(explode("/", $line));
        $filesizeMB=  number_format(filesize("/var/www/capture/usb/".$lineOut) / 1024 /1024,2);
        $fileDate=date ("F d Y H:i:s.", filemtime("/var/www/capture/usb/".$lineOut));
        echo '
            
            <tr>
                <td>('.$count.'.)</td>
             ';
        if (file_exists('capture/usb/preview-'.$lineOut)) 
                {
                    echo '<td><a href="/capture/usb/'.$lineOut.'" class="lightbox_trigger" ><img src="/capture/usb/preview-'.$lineOut.'" alt="PIC" /></BR>'.$lineOut.'</a></td>';
                }
            else
                {
                    echo '<td><a href="/capture/usb/'.$lineOut.'" class="lightbox_trigger" ><img src="/images/nopreview.png" width="122" height="122" alt="PIC" /></BR>'.$lineOut.'</a></td>';
                }
        if (file_exists('capture/usb/fbi-'.$lineOut))
                {
                    //echo '<td><p style="text-align:center; font-size:9px;">fbi-Preview</BR> OK</p></td>';
                    echo '<td><img src="/images/preview_ok.png" width="80" height="80" alt="preview_ok" /></td>';
                }
            else
                {
                    //echo '<td><p style="text-align:center; font-size:9px;">fbi-Preview</BR> missing</p></td>';
                    echo '<td><img src="/images/preview_fail.png" width="80" height="80" alt="preview_fail" /></td>';
                }                
//<td><a href="#"><img src="/images/preview.png" width="80" height="80" alt="create preview" onclick="changeicon(this,\'resize.php?pic='.$lineOut.'\');"/></a></td>    
//<td><a href="resize.php?pic='.$lineOut.'" ><img src="/images/preview.png" width="80" height="80" alt="create preview" /></a></td>                
                
//<td><img src="/images/convert_blue_512" style="width:16px;height:16px;display: none;" alt="Loading..." id="loadingimage" /></td>                    
//<td><a href="deleteimage.php?pic='.$lineOut.'" ><img src="/images/delete-icon.png" width="64" height="64" alt="delete PIC" /></a></td>
        echo '
                <td>'.$filesizeMB.' MByte</BR>'.$fileDate.'</td>
                
                <td><img src="/images/delete-icon.png" width="64" height="64" alt="delete Image" onclick="deleteImage(this,\'deleteimage.php?pic='.$lineOut.'\');"/></td> 
                <td><img src="/images/preview_create.png" width="80" height="80" alt="create preview" onclick="createPreview(this,\'createthumbs.php?pic='.$lineOut.'\');"/></td>    
                
           </tr>
           
            ';
    }
    echo "</table>";
    echo "</br></br>";
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


  

