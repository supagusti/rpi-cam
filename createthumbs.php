


<?php
include 'includes/checklogin.php';

if      (   
        isset($_GET['pic']) AND  
        class_exists("Imagick")  
        )
    {

    if (!extension_loaded('imagick')) echo 'imagick not installed';


    
    $picToResize=$_GET['pic'];

    if (file_exists('capture/usb/preview-'.$picToResize))
        {
            //DO NOTHING
            $previewExists=true;
  
        }
        else
        {
            
            $thumb = new Imagick('capture/usb/'.$picToResize);

            $thumb->resizeImage(162,122,Imagick::FILTER_POINT,1); //162x122
            $thumb->writeImage('capture/usb/preview-'.$picToResize);

            $thumb->destroy();
  
        }

    if (file_exists('capture/usb/fbi-'.$picToResize))
        {
            //DO NOTHING
            $fbiExists=true;
  
        }
        else
        {
            $thumb = new Imagick('capture/usb/'.$picToResize);

            $thumb->resizeImage(640,480,Imagick::FILTER_POINT,1); //640x480
            $thumb->writeImage('capture/usb/fbi-'.$picToResize);

            $thumb->destroy();            
        }

   
       
    if (!$fbiExists OR !$previewExists )
        {
        
        //"Preview erfolgreich erstellt"
        echo "Preview erfolgreich erstellt";
        }
    else 
        {
        
        //"Die Previews existieren schon !"
        echo "Die Previews existieren schon !";
        }
    
    }
    else
    {
        header( 'Location: listimages.php' );
    }


?>