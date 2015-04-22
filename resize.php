<?php
/*


<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript">

window.onload=function() 
{




<?php
include 'includes/checklogin.php';

if      (   
        isset($_GET['pic']) AND  
        class_exists("Imagick")  
        )
    {

    if (!extension_loaded('imagick')) echo 'imagick not installed';


    
    $picToResize=$_GET['pic'];
    //echo "create Preview from PICTUREGROUP:".$picToResize;
    //echo "</BR>";
    //echo "</BR>";
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
        echo '
            	alert("Preview erfolgreich erstellt");
                window.location = "listimages.php";
            ';
        }
    else 
        {
        echo '
                alert("Die Previews existieren schon !");
                window.location = "listimages.php";
            ';
        }
    
    }
    else
    {
        header( 'Location: listimages.php' );
    }


?>
        



}

</script>
</head>
 
*/?>



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
        header( 'Location: listimages.php?err=0' );
        }
    else 
        {
        
        //"Die Previews existieren schon !"
        header( 'Location: listimages.php?err=1' );
        }
    
    }
    else
    {
        header( 'Location: listimages.php?err=2' );
    }


?>