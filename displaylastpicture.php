
<?php
include 'includes/checklogin.php';
echo "<h1>Last captured image:</h1>";
$command="ls -t /var/www/capture/usb/ | grep jpg";
exec($command,$return);
$filename=$return[0];

echo '<img src="/capture/usb/'.$filename.'" width="648" height="486" alt="RPi Icon">';
echo "</br>";
echo '<a href="/capture/usb/'.$filename.'"> Open '.$filename.'</a>';
echo "</br></br>";
echo '<a href="index.php">Back to main</a>';

?>
