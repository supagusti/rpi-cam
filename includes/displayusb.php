<?php
include 'includes/checklogin.php';

        //ermitteln des freien Speicherplatzes
        $command2='df -h /dev/sda';
        $freeSpace="";
        exec($command2,$freeSpace);
                
        //Zerteilen des Strings
        $SizeArray=  explode(" ", $freeSpace[1]);
        
        //ausfiltern der Null-Werte
        $SizeArrayFilterd=array_values(array_filter($SizeArray));
        
        echo '<table border="0" width="170px">';
        echo '<tr><td><p style="font-size:10px;">USB-Stick: </p></td><td><p style="font-size:10px;">'.$SizeArrayFilterd[0].'</p></td></tr>';
        echo '<tr><td><p style="font-size:10px;">Total Space: </p></td><td><p style="font-size:10px;">'.$SizeArrayFilterd[1].'</p></td></tr>';
        echo '<tr><td><p style="font-size:10px;">Used Space: </p></td><td><p style="font-size:10px;">'.$SizeArrayFilterd[2].'</p></td></tr>';
        echo '<tr><td><p style="font-size:10px;">Available Space: </p></td><td><p style="font-size:10px;">'.$SizeArrayFilterd[3].'</p></td></tr>';
        echo '<tr><td><p style="font-size:10px;">Percentage Used: </p></td><td><p style="font-size:10px;">'.$SizeArrayFilterd[4].'</p></td></tr>';
        echo "</table></br>";
        
?>
