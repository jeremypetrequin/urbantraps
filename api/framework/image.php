<?php
/**
 *
 * @author Badger
 * @date 25 mai 2011
 * @project BMS
 * 
 * gerer, retailler, trouver les couleurs ... pour des images
 * 
 * somes functions from http://pilgrim.maleo.net/2007/10/fonctions-de-redimensionnement-d-images
 * & other
 * 
 */
class image {
    # Class variables
    private $image;
    private $width;
    private $height;
    private $imageResized;
    
    function __construct($fileName = '') {
        // *** Open up the file
        if($fileName == '') return;
        $this->image = $this->openImage($fileName);

        // *** Get width and height
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
    }
    
    public function img_resize( $filename, $newWidth, $newHeight ) {

        // R√©cup√©ration de la taille de l'image
        $imageSize = getimagesize($filename);
        $currentWidth   = $imageSize[0];
        $currentHeight  = $imageSize[1];
        $funcName         = str_replace('/', 'createfrom', $imageSize['mime']);

        // Cr√©ation de la miniature
        $srcImg = @$funcName($filename);
        if ( !$srcImg ) {
            $im = imagecreate(150, 30); /* Cr√©ation d'une image blanche */
            $bgc = imagecolorallocate($im, 255, 255, 255);
            $tc  = imagecolorallocate($im, 0, 0, 0);
            imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
            // Affichage d'un message d'erreur
            imagestring($im, 1, 5, 5, "Erreur de chargement de l'image ".basename($filename), $tc);
            return $im;
        }

        if ( !$dstImg = @imagecreatetruecolor($newWidth, $newHeight) ) {
            $dstImg = @imagecreate($newWidth, $newHeight);
        }   
        if ( !@imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $currentWidth, $currentHeight) ) {
            imagecopyresized($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $currentWidth, $currentHeight);
        }

        return $dstImg;

    } // end of 'img_resize()'

    public function img_resize_x ( $filename, $maxWidth ) {

        // R√©cup√©ration de la taille de l'image
        $imageSize = getimagesize($filename);
        $newWidth = $currentWidth = $imageSize[0];
        $newHeight = $currentHeight = $imageSize[1];

        if ( $currentWidth > $maxWidth ) {
            $ratio      = $currentWidth / $currentHeight;
            $newWidth   = $maxWidth;
            $newHeight  = round($newWidth / $ratio);
        }

        return $this->img_resize($filename, $newWidth, $newHeight);

    } // end of 'img_resize_x()'
    

    public function img_resize_y($filename, $maxHeight) {

        // R√©cup√©ration de la taille de l'image
        $imageSize = getimagesize($filename);
        $newWidth = $currentWidth = $imageSize[0];
        $newHeight = $currentHeight = $imageSize[1];

        if ( $currentHeight > $maxHeight ) {
            $ratio      = $currentWidth / $currentHeight;
            $newHeight  = $maxHeight;
            $newWidth   = round($newHeight * $ratio);
        }

        return $this->img_resize($filename, $newWidth, $newHeight);

    } // end of 'img_resize_y()'

    public function img_resize_auto( $filename, $maxSize ) {

        // R√©cup√©ration de la taille de l'image
        $imageSize  = getimagesize($filename);
        $width      = $imageSize[0];
        $height     = $imageSize[1];

        if ( $width >= $height && $width > $maxSize ) {
            return $this->img_resize_x($filename, $maxSize);
        } elseif ( $height > $width && $height > $maxSize ) {
            return $this->img_resize_y($filename, $maxSize);
        } else {
            return imagecreatefromjpeg($filename);
        }

    } // end of 'img_resize_auto()'
    
     
    /**
     * Retourne une image rogn√©e
     */
    public function img_rogne_resize($filename, $width, $height, $image = FALSE){
        // r√©cup√©ration de la taille de l'image d'origine
        list($width_orig, $height_orig) = getimagesize($filename);
        $height_orig2=$height_orig/($width_orig/$width);

        $image_p = imagecreatetruecolor($width, $height);
        if(!$image) {
            $image = imagecreatefromjpeg($filename);
        }

        imagecopyresized($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);

        return $image_p;
    }
    
    public function getPictureColors($imageFile, $numColors = 20, $granularity = 5) {
        
	   $granularity = max(1, abs((int)$granularity));
	   $colors = array();
	   $size = @getimagesize($imageFile);
	   if($size === false)
	   {
	      // Impossible d'obtenir la taille de l'image
	      return false;
	   }//a changer selon si on est en png ou jpg
	   $img = @imagecreatefromjpeg($imageFile);
	   if (!$img)
	   {
	     // echo  "Impossible d'ouvrir l'image PNG";
	      return false;
	   }
	   for ($x = 0; $x < $size[0]; $x += $granularity)
	   {
	      for ($y = 0; $y < $size[1]; $y += $granularity)
	      {
	         $thisColor = imagecolorat($img, $x, $y);
	         $rgb = imagecolorsforindex($img, $thisColor);
	         $red = round(round(($rgb['red'] / 0x33)) * 0x33);
	         $green = round(round(($rgb['green'] / 0x33)) * 0x33);
	         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);
	         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue);
	         if(array_key_exists($thisRGB, $colors))
	         {
	            $colors[$thisRGB]++;
	         }
	         else
	         {
	            $colors[$thisRGB] = 1;
	         }
	      }
	   }
	   arsort($colors);
           
	   return array_slice(array_keys($colors), 0, $numColors);
	}
        
        /**
    * @param file $file image file
    * @return file $img
    */
    private function openImage($file)
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

    /**
    * @param integer $newWidth
    * @param integer $newHeight
    * @param string $option optional
    * @see getDimensions
    */
    public function resizeImage($newWidth, $newHeight, $option="auto")
    {
        // *** Get optimal width and height - based on $option
        

        $optionArray = $this->getDimensions($newWidth, $newHeight, $option);

        $optimalWidth  = $optionArray['optimalWidth'];
        $optimalHeight = $optionArray['optimalHeight'];


        // *** Resample - create image canvas of x, y size
        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        $white = imagecolorallocate($this->imageResized, 255, 255, 255);
        imagefill($this->imageResized, 0, 0, $white);				
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


        // *** if option is 'crop', then crop too
        if ($option == 'crop') {
            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }
    }

    public function hardCrop($xfrom, $yfrom, $width, $height, $img) {
        $docroot = Framework::load()->config->DOC_ROOT;
        $src = $this->openImage($docroot.$img);
        $dest = imagecreatetruecolor($width, $height);
        list($owidth, $oheight, $type, $attr) = getimagesize($docroot.$img);
        
        
        imagecopy($dest, $src, 0, 0, $xfrom, $yfrom, $owidth, $oheight);
        $this->imageResized = $dest;
        $cachePath = self::getCachePath($img,$width, $height,'hardcrop');
        $this->saveImage($docroot.$cachePath, 1);
        
        return $cachePath;
    }
    /**
    * @param integer $newWidth
    * @param integer $newHeight
    * @param string $option
    * @see getSizeByFixedHeight
    * @see getSizeByFixedWidth
    * @see getSizeByAuto
    * @see getOptimalCrop
    * @return row
    */
    private function getDimensions($newWidth, $newHeight, $option)
    {

       switch ($option)
        {
            case 'exact':
                $optimalWidth = $newWidth;
                $optimalHeight= $newHeight;
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
                break;
            case 'landscape':
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'hardcrop':
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
                break;
        }
        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    /**
    * @param integer $newHeight
    * @return integer $newWidth
    */
    private function getSizeByFixedHeight($newHeight)
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    /**
    * @param integer $newWidth
    * @return integer $newHeight
    */
    private function getSizeByFixedWidth($newWidth)
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }

    /**
    * @param integer $newWidth
    * @param integer $newHeight
    * @return row
    */
    private function getSizeByAuto($newWidth, $newHeight)
    {
        if ($this->height < $this->width)
        // *** Image to be resized is wider (landscape)
        {
            $optimalWidth = $newWidth;
            $optimalHeight= $this->getSizeByFixedWidth($newWidth);
        }
        elseif ($this->height > $this->width)
        // *** Image to be resized is taller (portrait)
        {
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight= $newHeight;
        }
        else
        // *** Image to be resizerd is a square
        {
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
            } else {
                // *** Sqaure being resized to a square
                $optimalWidth = $newWidth;
                $optimalHeight= $newHeight;
            }
        }

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    /**
    * @param integer $newWidth
    * @param integer $newHeight
    * @return row
    */
    private function getOptimalCrop($newWidth, $newHeight)
    {

        $heightRatio = $this->height / $newHeight;
        $widthRatio  = $this->width /  $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth  = $this->width  / $optimalRatio;

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    /**
    * @param integer $optimalWidth
    * @param integer $optimalHeight
    * @param integer $newWidth
    * @param integer $newHeight
    */
    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
    {
        // *** Find center - this will be used for the crop
        $cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
        $cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

        $crop = $this->imageResized;
        //imagedestroy($this->imageResized);

        // *** Now crop from center to exact requested size
        $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
        imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
    }

    /**
    * @param string $savePath optional
    * @param integer|string $imageQuality optional
    */
    public function saveImage($savePath=null, $imageQuality="100")
    {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);
        
        
        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;

            case '.png':
                // *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality/100) * 9);

                // *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality;

                if (imagetypes() & IMG_PNG) {
                     imagepng($this->imageResized, $savePath, $invertScaleQuality);
                }
                break;

            // ... etc

            default:
                // *** No extension - No save.
                break;
        }

        imagedestroy($this->imageResized);
    }

    /**
    * @param file $image
    * @param integer $newWidth
    * @param integer $newHeight
    * @param string $option optional
    * @return string path
    */
    public function resize($image,$newWidth, $newHeight, $option="auto"){
        $docroot = Framework::load()->config->DOC_ROOT;
        
        if(file_exists($docroot.$image) && !empty($image) ){
            $cachePath = self::getCachePath($image,$newWidth, $newHeight,$option);
            if(file_exists($docroot.$cachePath)){
                return $cachePath;
            } else {
                if($option == 'hardcrop') return $this->hardCrop (0, 0, $newWidth, $newHeight, $image);
                $resizeObj = new image($docroot.$image);
                $resizeObj -> resizeImage($newWidth, $newHeight, $option);
                $resizeObj -> saveImage($docroot.$cachePath,90);
                return $cachePath;
            }
        }
    }
    
    /**
    * @param string $tocache
    * @param integer $newWidth
    * @param integer $newHeight
    * @param string $option optional
    * @return string $tocache
    */
    public function getCachePath($tocache,$newWidth, $newHeight,$option){
        $cachepath = Framework::load()->config->CACHE_PATH;
        $tocache = $cachepath.'/'.$newWidth.'__'.$newHeight.'__'.$option.'__'.str_replace('/','~',$tocache);
        return $tocache;
    }

}

?>
