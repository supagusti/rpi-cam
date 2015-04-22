
<?php
include 'includes/checklogin.php';

$exact_time = microtime(true);
$capturetime=500;
$filename="Rpi-".date("Ymd_His",$exact_time).".jpg";
$command="raspistill --fullscreen -t ".$capturetime." -o /var/www/capture/usb/".$filename;
exec($command);
$resize='/var/www/cmd/wwwresize '.$filename;
//Wenn Preview Erstellung im Hintergrund passieren soll....
//exec($resize . " > /dev/zero &");  

//Wartet bis Preview fertig ist...
exec($resize,$return);
/*
    echo "<p>".$command."<p>";
    echo "<p>-------------------------------------------</p>";
    foreach ($return as $line) {
    print "$line<br>";
    }
*/
header( 'Location: index.php' );              
exit();

?>
