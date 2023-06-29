<?php include "../dbcon-ajax.php";
//If directory doesnot exists create it.

if(isset($_FILES["myfile"]))
{
	$ret = array();

	$error =$_FILES["myfile"]["error"];
   {
    
    	if(!is_array($_FILES["myfile"]['name'])) //single file
    	{            
       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];
       	 	 $product_image = nowDirectImage('myfile',$conf->absolute_path.$conf->product_dir,$conf->upload_size_allowed);
			 
			 $path_product_image = $conf->absolute_path.$conf->product_dir.$product_image;
			 $thumbnil_image =$conf->absolute_path.$conf->product_dir."_".$product_image;
			// Resize image (options: exact, portrait, landscape, auto, crop)
			resizeImage($path_product_image,$conf->ConceptThumbWidth, $conf->ConceptThumbHeight, 'crop');
			// Save image
			saveImage($thumbnil_image, 100);	       	 	 
    	}
    	else
    	{
            $fileCount = count($_FILES["myfile"]['name']);
    		for($i=0; $i < $fileCount; $i++)
    		{                
				$product_image = nowDirectImage('myfile',$conf->absolute_path.$conf->product_dir,$general->upload_size_allowed);
				$path_product_image = $conf->absolute_path.$conf->product_dir.$product_image;
				 $thumbnil_image =$conf->absolute_path.$conf->product_dir."_".$product_image;
			 	// Resize image (options: exact, portrait, landscape, auto, crop)
			 	resizeImage($path_product_image,$conf->ConceptThumbWidth, $conf->ConceptThumbHeight, 'crop');
				// Save image
				saveImage($thumbnil_image, 100);
    		}
    	}
    }
    echo $product_image;
 
}
?>