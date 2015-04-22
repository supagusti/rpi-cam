<?php
include 'includes/checklogin.php';

if (isset($_GET['pic']))
    {
    $picToDelete=$_GET['pic'];
    //echo "delete PICTUREGROUP:".$picToDelete;
    //echo "</BR>";
    //echo "</BR>";
    if (file_exists('capture/usb/preview-'.$picToDelete))
        {
            //echo "delete PIC: preview-".$picToDelete;
            //echo "</BR>";
            $prevDelete=unlink('capture/usb/preview-'.$picToDelete);
        }
        else
        {
            $prevDelete=true;
        }

    if (file_exists('capture/usb/fbi-'.$picToDelete))
        {
            //echo "delete PIC: fbi-".$picToDelete;
            //echo "</BR>";
            $fbiDelete=unlink('capture/usb/fbi-'.$picToDelete);
        }
        else
        {
            $fbiDelete=true;
        }

    if (file_exists('capture/usb/'.$picToDelete))
        {
            //echo "delete PIC: ".$picToDelete;
            //echo "</BR>";
            $picDelete=unlink('capture/usb/'.$picToDelete);
        }        
    if ($prevDelete AND $fbiDelete AND $picDelete)
        {
        echo 'Eintrag gelöscht';
        }
    else 
        {
        echo 'Ein Fehler ist beim Löschen aufgetreten';
        }
    //header( 'Location: listimages.php' );
    }
    else
    {
        header( 'Location: listimages.php' );
    }


?>
