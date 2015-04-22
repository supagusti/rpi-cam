
<?php 


session_start();

include 'includes/account.php';

function my_crypto ($string)
    {
    $my_salt = sha1(md5($string));
    $string=hash('sha512',md5($string.$salt),false);
    return ($string);
    };

    

// Überprüfen, ob das Formular abgeschickt wurde und ob beide Angaben gemacht wurden.
if ( 
        (isset($_POST['username'], $_POST['password'])) AND 
        (strcmp(trim($_POST['username']),'') != 0 ) AND 
        (strcmp(trim($_POST['password']),'') != 0 ) AND 
        ($USERNAME === my_crypto(trim(strtolower($_POST[username])))) AND 
        ($PASSWORD === my_crypto(trim($_POST[password])))
    )   
        
    {
                
        echo "<br />";
        echo "<BR><h1>Login OK</h1><BR>";

        // Der Schlüssel 'loggedIn' erhält den Wert 'true'. So kann überprüft später werden, 
        // ob der User eingeloggt ist oder nicht.
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = trim($_POST['username']);
        
        // Set cookie
        $value=$USERNAME.'|*|'.$PASSWORD.'|*|'.trim($_POST['username']);
        
        if ($_POST['stayloggedin']==="stayloggedin") {setcookie("rpi-cam", $value, time()+1209600);}
                
        //echo "USERNAME=".$USERNAME;
        //echo "PASSWORD=".$PASSWORD;
        //echo "value=".$value;
        header( 'Location: index.php' );


        exit();     
    }




 else 
    {               echo "ERROR 1";
                    header( 'Location: login.php?error=1' );              
                    exit();

    }
?>