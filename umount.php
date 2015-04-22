<?php
include 'includes/checklogin.php';

$command="/var/www/cmd/wwwumount";
exec($command,$return);
/*
echo "<p>".$command."<p>";
//print_r ($return);
        
echo "<p>-------------------------------------------</p>";

foreach ($return as $line) {
print "$line<br>";
}

echo "</br></br>";
echo '<a href="index.php">Back to main</a>';
*/

header( 'Location: index.php' );              
exit();
?>