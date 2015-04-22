
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
<?php 

include 'includes/checklogin.php';
$isrunning = file_get_contents('/var/www/capture/usb/tlstatus', NULL, NULL, 0, 1);
if ($isrunning === "1") {echo ' <meta http-equiv="refresh" content="30" />';}
if ($isrunning === "2") {echo ' <meta http-equiv="refresh" content="10" />';}
?>
    
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
    
    echo '<h1>Timelapse</h1>';

    $varfilearray=  explode("\n",file_get_contents('/var/www/capture/usb/tlstatus'));
    
    $isrunning=$varfilearray[0];
    session_start();
    $_SESSION['rollname']=$varfilearray[1];
    $_SESSION['sleeptime']=$varfilearray[2];
//$isrunning = file_get_contents('/var/www/capture/usb/tlstatus', NULL, NULL, 0, 1);
//echo "irunning=".$isrunning;
//echo "<br>";


if ($isrunning === "1") 
    {   
        
        echo "Timelapse capture is currently running....</BR></BR>";
        echo '<table border="0" width="260px">';
        echo '<tr><td><p style="font-size:12px;">ROLLNAME: </p></td><td><p style="font-size:12px;">'.$_SESSION['rollname'].'</p></td></tr>';
        echo '<tr><td><p style="font-size:12px;">SLEEPTIME: </p></td><td><p style="font-size:12px;">'.$_SESSION['sleeptime'].'sec</p></td></tr>';
        echo '<tr><td><p style="font-size:12px;">DIR: </p></td><td><a href="/capture/usb/'.$_SESSION['rollname'].'/" style="font-size:12px;">/capture/usb/'.$_SESSION['rollname'].'</a></td></tr>';
        echo "</table></BR>";
        //$command1='ls -1 /var/www/capture/usb/'.$_SESSION['rollname'].'/'.$_SESSION['rollname'].'*.jpg | grep -c ""';
        $command1='ls -1 /var/www/capture/usb/'.$_SESSION['rollname'].' | grep -c ""';
        $return="";
        exec($command1,$return);
        echo 'Captured '.$return[0].' pictures so far</br></br>';
        echo '</BR><a href="timelapse-stop.php">STOP</a></br>';
   
        echo "<h1>Last captured image:</h1>";
        $return="";
        //$command="ls -t /var/www/capture/usb/".$_SESSION['rollname']."/ | grep jpg";
        $command="tail /var/www/capture/usb/".$_SESSION['rollname']."/".$_SESSION['rollname'].".log -n 1";
        exec($command,$return);
        $filename=end(explode("/",$return[0]));
        //echo 'return='.$return[0];
        //echo '$filename='.$filename;
        echo '<a href="/capture/usb/'.$_SESSION['rollname'].'/'.$filename.'">';
        //echo '<img src="/capture/usb/'.$_SESSION['rollname'].'/'.$filename.'" width="162" height="122" alt="Image not finished yet">';
        echo '<img src="/capture/usb/'.$_SESSION['rollname'].'/'.$filename.'" width="324" height="244" alt="Image not finished yet">';
        echo "</a></br></br>";
        
        
    }
    elseif ($isrunning === "2") 
    {
    
        echo "</BR>AVI Video conversation is currently running....</BR>";
        $return="";
        //$command="ls -t /var/www/capture/usb/".$_SESSION['rollname']."/ | grep jpg";
        $command="tail -c 90 /var/www/capture/usb/".$_SESSION['rollname']."-aviconv.log";
        exec($command,$return);
        //echo "returncode=".$return[0];
        preg_match('[\d?\d?\d\.\d[s]]', $return[0], $match);
        $aviposition=$match[0];

        preg_match('[\d?\d?\d?\d?\d?\d?\d?\d[f]]', $return[0], $match);
        $aviframes=$match[0];

        preg_match('[\d?\d?\d?\d?\d?\d?\d?\d[%]]', $return[0], $match);
        $avipercentage=$match[0];

        preg_match('[\d?\d?\d?\d?\d(?=min)]', $return[0], $match);
        $aviestminutes=$match[0];

        preg_match('[\d?\d?\d?\d?\d(?=mb)]', $return[0], $match);
        $aviestmegabyte=$match[0];
        
        if (($aviposition !==NULL) or ($aviframes !==NULL) or ($avipercentage !==NULL))

        {
            echo "</BR></BR>";
            //$filename=end(explode("/",$return[0]));
            echo '<table border="0" width="260px">';
            echo '<tr><td><p style="font-size:12px;">Position: </p></td><td><p style="font-size:12px;">'.$aviposition.'</p></td></tr>';
            echo '<tr><td><p style="font-size:12px;">Frames: </p></td><td><p style="font-size:12px;">'.$aviframes.'</p></td></tr>';
            echo '<tr><td><p style="font-size:12px;">Percent done: </p></td><td><p style="font-size:12px;">'.$avipercentage.'</p></td></tr>';
            echo '<tr><td><p style="font-size:12px;">Est.Size: </p></td><td><p style="font-size:12px;">'.$aviestmegabyte.' MB</p></td></tr>';
            echo '<tr><td><p style="font-size:12px;">Est.Time left: </p></td><td><p style="font-size:12px;">'.$aviestminutes.' min</p></td></tr>';
            echo "</table></BR>";
        }
        else
        {
            echo "</BR></BR>";
            echo "mencoder is currently initializing .... please be patient.";
        }   
        
        echo '<p>The converted .avi can be found here: <a href="/capture/usb/'.$_SESSION['rollname'].'.avi">/var/www/capture/usb/'.$_SESSION['rollname'].".avi</a></br>";
        echo 'RightClick and SaveAs to download it, when it\'s finished.</p>';
        //echo "avi='".$aviposition."'</br>"; 
        //echo "avi='".$aviframes."'</br>"; 
        //echo "avi='".$avipercentage."'</br>";
    }
    else
    {
        if (isset($_GET['error']))        
        {
            echo '<p style="color:red;">Error '.$_GET['error'].'</p>';
        }
        echo '<form action="timelapse-start.php" method="post" name="loginform">';
        echo '<table>';
        echo '<tr>';
        echo '<td>Roll-Name:</td>';
        echo '<td><input type="text" maxlength="100" size="20" name="rollname" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Time between pictures: </td>';
        echo '<td><input type="text" maxlength="100" size="5" name="sleeptime" /></td>';
        echo '</tr>';
        echo '</table>';
        echo '</BR>';
        echo '<input type="submit" VALUE=" Start Time Lapse " name="submitbutton"/>';
        echo '</form>';
        echo '</br>';
        echo '<h1>Converted video download</h1>';
        echo "<p>";
        $command="ls -1 /var/www/capture/usb/*-aviconv.log";
        $return="";
        exec($command,$return);
        foreach ($return as $line) 
            {
                //print "$line<br>";
                //echo "RETURN=".$line."<BR>";
                preg_match('[(.*?)(?=-aviconv.log)]', $line, $match);
                //echo "MATCH=".$match[0]."<BR>";
                $avifile= end(explode("/", $match[0])).".avi";
                echo '<a href="/capture/usb/'.$avifile.'" >/var/www/capture/usb/'.$avifile.'</a><BR>';
            }
        echo "</p>";
    }
    

    
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
 </BR>
 <h1>Converting the stills manually</h1>
 <p>If you are finished capturing the timlapse stills, you need to convert the single files into a video. </BR>
 This is usually done automatically within this webapp. But if something goes wrong, or you'd rather run this on a more powerful machine, use the following command line (from ssh or tty) to do this: </BR></p>
 
 
 <p style="font-family:Courier New, monospace;"> mencoder -nosound -ovc lavc -lavcopts vcodec=mpeg4:aspect=16/9:vbitrate=8000000 -vf scale=1920:1080 -o [output-file.avi] -mf type=jpeg:fps=24 mf://@[input-list.log]</p>
 <p>[output.avi] is the name of the video file being created</BR>
 [input-list.log] is the name of the list containing the file names of the single .jpg files</BR>
 </p>
 
</br>    
<p>(c) 2013 by <a href="http://www.supagusti.tk" target="_blank">Supagusti's Blog</a></p>
     </div>
</body>
</html>


    
