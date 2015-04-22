
<?php
include 'includes/checklogin.php';

$command="raspistill --fullscreen --width 800 --height 600 -t 750 -o /var/www/capture/usb/preview.jpg";
exec($command);

header( 'Location: imagepreview.php' );              
exit();

?>
