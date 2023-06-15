<?php

   # ========================================================================#
   #
   #  Author:    Jarrod Oberto
   #  Version:	 1.0
   #  Date:      17-Jan-10
   #  Purpose:   Resizes and saves image
   #  Requires : Requires PHP5, GD library.
   #  Usage Example:
   #                     include("classes/resize_class.php");
   #                     $resizeObj = new resize('images/cars/large/input.jpg');
   #                     $resizeObj -> resizeImage(150, 100, 0);
   #                     $resizeObj -> saveImage('images/cars/large/output.jpg', 100);
   #
   #
   # ========================================================================#


		
			// *** Class variables
			 $image;
		     $width;
		     $height;
			 $imageResized;

			function Init($fileName)
			{
				// *** Open up the file
				$GLOBALS['image'] = openImage($fileName);

			    // *** Get width and height
			    $GLOBALS['width']  = imagesx($GLOBALS['image']);
			    $GLOBALS['height'] = imagesy($GLOBALS['image']);
			}

			## --------------------------------------------------------

			 function openImage($file)
			{
				// *** Get extension
				$extension = strtolower(strrchr($file, '.'));

				switch($extension)
				{
					case '.jpg':
					case '.jpeg':
						$img = @imagecreatefromjpeg($file);
						break;
					case '.gif':
						$img = @imagecreatefromgif($file);
						break;
					case '.png':
						$img = @imagecreatefrompng($file);
						break;
					default:
						$img = false;
						break;
				}
				return $img;
			}

			## --------------------------------------------------------

			 function resizeImage($fileName,$newWidth, $newHeight, $option="auto")
			{
				Init($fileName);
				// *** Get optimal width and height - based on $option
				$optionArray = getDimensions($newWidth, $newHeight, $option);

				$optimalWidth  = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];


				// *** Resample - create image canvas of x, y size
				$GLOBALS['imageResized'] = imagecreatetruecolor($optimalWidth, $optimalHeight);
				imagecopyresampled($GLOBALS['imageResized'], $GLOBALS['image'], 0, 0, 0, 0, $optimalWidth, $optimalHeight, $GLOBALS['width'], $GLOBALS['height']);


				// *** if option is 'crop', then crop too
				if ($option == 'crop') {
					crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
				}
			}

			## --------------------------------------------------------
			
			 function getDimensions($newWidth, $newHeight, $option)
			{

			   switch ($option)
				{
					case 'exact':
						$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
						break;
					case 'portrait':
						$optimalWidth = getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
						break;
					case 'landscape':
						$optimalWidth = $newWidth;
						$optimalHeight= getSizeByFixedWidth($newWidth);
						break;
					case 'auto':
						$optionArray = getSizeByAuto($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
					case 'crop':
						$optionArray = getOptimalCrop($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
				}
				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			 function getSizeByFixedHeight($newHeight)
			{
				$ratio = $GLOBALS['width'] / $GLOBALS['height'];
				$newWidth = $newHeight * $ratio;
				return $newWidth;
			}

			 function getSizeByFixedWidth($newWidth)
			{
				$ratio = $GLOBALS['height'] / $GLOBALS['width'];
				$newHeight = $newWidth * $ratio;
				return $newHeight;
			}

			 function getSizeByAuto($newWidth, $newHeight)
			{
				if ($GLOBALS['height'] < $GLOBALS['width'])
				// *** Image to be resized is wider (landscape)
				{
					$optimalWidth = $newWidth;
					$optimalHeight= getSizeByFixedWidth($newWidth);
				}
				elseif ($GLOBALS['height'] > $GLOBALS['width'])
				// *** Image to be resized is taller (portrait)
				{
					$optimalWidth = getSizeByFixedHeight($newHeight);
					$optimalHeight= $newHeight;
				}
				else
				// *** Image to be resizerd is a square
				{
					if ($newHeight < $newWidth) {
						$optimalWidth = $newWidth;
						$optimalHeight= getSizeByFixedWidth($newWidth);
					} else if ($newHeight > $newWidth) {
						$optimalWidth = getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
					} else {
						// *** Sqaure being resized to a square
						$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
					}
				}

				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			 function getOptimalCrop($newWidth, $newHeight)
			{

				$heightRatio = $GLOBALS['height'] / $newHeight;
				$widthRatio  = $GLOBALS['width'] /  $newWidth;

				if ($heightRatio < $widthRatio) {
					$optimalRatio = $heightRatio;
				} else {
					$optimalRatio = $widthRatio;
				}

				$optimalHeight = $GLOBALS['height'] / $optimalRatio;
				$optimalWidth  = $GLOBALS['width']  / $optimalRatio;

				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			 function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
			{
				// *** Find center - this will be used for the crop
				$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
				$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

				$crop = $GLOBALS['imageResized'];
				//imagedestroy($this->imageResized);

				// *** Now crop from center to exact requested size
				$GLOBALS['imageResized'] = imagecreatetruecolor($newWidth , $newHeight);
				imagecopyresampled($GLOBALS['imageResized'], $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
			}

			## --------------------------------------------------------

			 function saveImage($savePath, $imageQuality="100")
			{
				// *** Get extension
        		$extension = strrchr($savePath, '.');
       			$extension = strtolower($extension);

				switch($extension)
				{
					case '.jpg':
					case '.jpeg':
						if (imagetypes() & IMG_JPG) {
							imagejpeg($GLOBALS['imageResized'], $savePath, $imageQuality);
						}
						break;

					case '.gif':
						if (imagetypes() & IMG_GIF) {
							imagegif($GLOBALS['imageResized'], $savePath);
						}
						break;

					case '.png':
						// *** Scale quality from 0-100 to 0-9
						$scaleQuality = round(($imageQuality/100) * 9);

						// *** Invert quality setting as 0 is best, not 9
						$invertScaleQuality = 9 - $scaleQuality;

						if (imagetypes() & IMG_PNG) {
							 imagepng($GLOBALS['imageResized'], $savePath, $invertScaleQuality);
						}
						break;

					// ... etc

					default:
						// *** No extension - No save.
						break;
				}

				imagedestroy($GLOBALS['imageResized']);
			}


			## --------------------------------------------------------

		
?>
