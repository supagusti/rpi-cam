<?php
include 'includes/checklogin.php';


/* 
$varfilearray=  explode("\n",file_get_contents('/var/www/capture/usb/tlstatus'));
    
    $isrunning=$varfilearray[0];
    session_start();
    $_SESSION['rollname']=$varfilearray[1];
    $_SESSION['sleeptime']=$varfilearray[2];

    
   
if ($isrunning === "1")     
{
file_put_contents('/var/www/capture/usb/tlstatus', "2\n".$_SESSION['rollname']."\n".$_SESSION['sleeptime']."\n");

//mencoder -nosound -ovc lavc -lavcopts vcodec=mpeg4:aspect=16/9:vbitrate=8000000 -vf scale=1920:1080 -o /var/www/capture/usb/street-cloudy.avi -mf type=jpeg:fps=24 mf://@/var/www/capture/usb/street-cloudy/street-cloudy.log > /var/www/capture/usb/street-cloudy-aviconv.log
$return="";
//$command="mencoder -nosound -ovc lavc -lavcopts vcodec=mpeg4:aspect=16/9:vbitrate=8000000 -vf scale=1920:1080 -o /var/www/capture/usb/".$_SESSION['rollname'].".avi -mf type=jpeg:fps=24 mf://@/var/www/capture/usb/".$_SESSION['rollname']."/".$_SESSION['rollname'].".log > /var/www/capture/usb/".$_SESSION['rollname']."-aviconv.log &";
$command="/var/www/cmd/wwwmencoder ".$_SESSION['rollname']." > /var/www/capture/usb/".$_SESSION['rollname']."-aviconv.log &";
exec($command,$return);
}

*/



file_put_contents('/var/www/capture/usb/tlstatus', "0");
     session_start();
    $_SESSION['rollname']="";
    $_SESSION['sleeptime']="";
  
echo "Timelapse session stopped...<br>";
echo "Please unmount the USB stick and convert the stills manually!<br>";
             
exit();

?>
