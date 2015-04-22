<?php 
/*
 * FOR SAFETY REASON IT'S BETTER TO DELETE THIS FILE AFTER 
 * CREATING AN ACCOUNT OR PROHIBIT ANY USER FROM ACCESSING IT
 * 
 */

include 'checklogin.php';
?>

<h1 >Create Account</h1>
<p>Please enter your desired credentials to proceed.</p>
</BR>
    
<form action="createaccount.php" method="post" name="loginform">
    <table>
        <tr><td>New username:</td>
        <td><input type="text" maxlength="40"  name="username" /></td></tr>
        <tr><td>New password:</td>
        <td><input type="password" maxlength="40"  name="password" />
        <tr><td></td>
        <td><input type="submit" VALUE=" Submit " name="submitbutton"/></td></tr>
    </table>

</form>
</BR>
<?php
function my_crypto ($string)
    {
    $my_salt = sha1(md5($string));
    $string=hash('sha512',md5($string.$salt),false);
    return ($string);
    };

// Überprüfen, ob das Formular abgeschickt wurde und ob beide Angaben gemacht wurden.
if( isset($_POST['username'], $_POST['password'])
    AND
    strcmp(trim($_POST['username']),'') != 0 
    AND
    strcmp(trim($_POST['password']),'') != 0 
    
    )        
    {
            $inpusername = my_crypto(trim(strtolower($_POST[username])));
            $inppassword = my_crypto(trim($_POST[password]));
            echo '<p style="font-family: monospace;">';
            ECHO '$USERNAME="'.$inpusername.'"; <BR>';
            ECHO '$PASSWORD="'.$inppassword.'"; <BR>'; 
            echo '</p>';
            echo "Copy the above 2 lines and copy it into the file /includes/account.php to change/add another user for rpi-cam.";
    }
?>
</BR></BR>
<a href="index.php">Back to main</a>
</BR></BR>
    <p>(c) 2013 by <a href="http://www.supagusti.tk" target="_blank">Supagusti's Blog</a></p>