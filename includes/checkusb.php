<?php
include 'includes/checklogin.php';

if (file_put_contents('/var/www/capture/usb/usbstatus', "0"))
{
    
}
else
{
    echo "NOK";
    $command="/var/www/cmd/wwwumount";
    exec($command,$return);
    $command="/var/www/cmd/wwwmount";
    exec($command,$return);
    header( 'Location: index.php' );              
    exit();
}

?>
