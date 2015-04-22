 <?php
include 'account.php';

// ein bestimmtes Cookie ausgeben
$cookieArray=explode("|*|", $_COOKIE["rpi-cam"]);

/*
echo 'cookie'.$_COOKIE["rpi-cam"];
echo "<BR>";
echo $cookieArray[0] ."</BR>";
echo $cookieArray[1] ."</BR>";
echo $cookieArray[2] ."</BR>";
echo "U=".$USERNAME ."</BR>";
echo "P=".$PASSWORD ."</BR>";
*/
 
    if(!isset($_SESSION))
    {
    session_start();
    }  

    if( !$_SESSION['loggedIn'] ) {
        
        if (
        ($cookieArray[0] === $USERNAME) AND
        ($cookieArray[1] === $PASSWORD)
            )
        
        {   $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $cookieArray[2];
            /*echo "login from cookie -> Ok";*/
            header( 'Location: index.php' );
        }
        
        else
        {
        header( 'Location: login.php' );
        exit();
        }
    }



?> 