<?php
include 'includes/checklogin.php';

    if(( isset($_POST['sleeptime'], $_POST['rollname'])
        AND
        strcmp(trim($_POST['sleeptime']),'') != 0
        AND
        strcmp(trim($_POST['rollname']),'') != 0 ) )
{
    session_start();
    $sleeptime=trim($_POST['sleeptime']);
    $rollname=trim($_POST['rollname']);
    $_SESSION['rollname']=$rollname;
    $_SESSION['sleeptime']=$sleeptime;
    
    
    if (file_exists('/var/www/capture/usb/'.$rollname.'/')) 
        {
            header( 'Location: timelapse.php?error=1');
            exit();
        }
        
    if (mkdir("/var/www/capture/usb/".$rollname."/", 0777)) 
        {
            // NOP ->echo "OK";
        }
    else
        {
            header( 'Location: timelapse.php?error=2');
            exit();
        }
    
    file_put_contents('/var/www/capture/usb/tlstatus', "1\n".$rollname."\n".$sleeptime."\n");
    
    $command="/var/www/cmd/wwwtimelapse ".$rollname." ".$sleeptime;
    echo $command;
    echo "<br>";
    //shell_exec($command); 
    //shell_exec($command . ' 2>&1 > /var/www/capture/usb/out.log'); 
    exec($command . " > /var/www/capture/usb/".$rollname."/".$rollname.".log &");  
    //print_r($return)

    header( 'Location: timelapse.php' );              
    exit();
}
else 
{
    
    ECHO "ROLL=".$_POST['rollname']."</BR>";
    ECHO "sleeptime=".$_POST['sleeptime']."</BR>";
    //header( 'Location: timelapse.php' );              
    //exit();
}
?>
