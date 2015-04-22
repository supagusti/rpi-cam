 <?php

     session_start();
     $_SESSION['loggedIn'] = false;
     setcookie("rpi-cam", "", time()+10);
     header( 'Location: login.php' );
     exit(); 

?> 