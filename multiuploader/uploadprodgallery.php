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
       	 	 $product_image = nowDirectImage('myfile',$conf->absolute_path.$conf->gallery_dir,$conf->upload_size_allowed);
			 
			 $path_product_image = $conf->absolute_path.$conf->gallery_dir.$product_image;
			 $thumbnail_image =$conf->absolute_path.$conf->gallery_dir."_".$product_image;
			 //Resize image (options: exact, portrait, landscape, auto, crop)
			resizeImage($path_product_image,$conf->galleryThumbnailWidth, $conf->galleryThumbnailHeight, 'exact');
			 //Save image
			saveImage($thumbnail_image, 100);
			// large thumbnail
			//$thumbnail_image2 =$conf->absolute_path.$conf->gallery_dir."__".$product_image;
			
			 //Resize image (options: exact, portrait, landscape, auto, crop)
			//resizeImage($path_product_image,$conf->galleryWidth, $conf->galleryHeight, 'crop');
			 //Save image
			//saveImage($thumbnail_image2, 100);
			 //Resize image (options: exact, portrait, landscape, auto, crop)
			//createthumb($path_product_image,$thumbnail_image2,$conf->galImageWidth, $conf->galImageHeight);			    	 	 
    	}
    	else
    	{
            $fileCount = count($_FILES["myfile"]['name']);
    		for($i=0; $i < $fileCount; $i++)
    		{                
				$product_image = nowDirectImage('myfile',$conf->absolute_path.$conf->gallery_dir,$general->upload_size_allowed);
				$path_product_image = $conf->absolute_path.$conf->gallery_dir.$product_image;
				 $thumbnail_image =$conf->absolute_path.$conf->gallery_dir."_".$product_image;
			 	// Resize image (options: exact, portrait, landscape, auto, crop)
			 	resizeImage($path_product_image,$conf->galleryThumbnailWidth, $conf->galleryThumbnailHeight, 'exact');
				// Save image
				saveImage($thumbnail_image, 100);
				// large thumbnail
				//$thumbnail_image2 =$conf->absolute_path.$conf->gallery_dir."__".$product_image;
			 	//Resize image (options: exact, portrait, landscape, auto, crop)
				//resizeImage($path_product_image,$conf->galleryWidth, $conf->galleryHeight, 'crop');
				// Save image
				//saveImage($thumbnail_image2, 100);
				//createthumb($path_product_image,$thumbnail_image2,$conf->galImageWidth, $conf->galImageHeight);
    		}
    	}
    }
    echo $product_image;
 
}
?>