<?php
   
	/**
	 * Class ImageProcessorModel
	 * 
	 * This class is used for counting the pixels on its specific color and is required for the grading algorithm 
	*/
    class ImageProcessorModel{
        private $imageRessource;
        
		/**
		 * This is the constuructor of the class ImageProcessorModel
		 * The imageRessource is required for count the specific pixels colors of the image
		 * @param string $imageRessource String Path to image
		*/
        public function __construct(String $imageRessource){
            $this->imageRessource = $imageRessource;
        }
        
		/**
		 * In the function pixelCount() will each pixels color be read out and with
         * every possible color code in our game compared. If the comparison is successfully
         * it will increment the counter of the specific color
		 * @return array The array of all counters from each in the game possible color
		*/
        public function pixelCount(){
			//Initalising all needed variables
            $im = imagecreatefrompng($this->imageRessource); //get stored image as an object
        	list($width, $height) = getimagesize($this->imageRessource); //get specific height and width of an image
        	$blackCounter = 0;
        	$greenCounter = 0;
        	$blueCounter = 0;
        	$redCounter = 0;
        	$yellowCounter = 0;
        	$orangeCounter = 0;
			$brownCounter = 0;
			$greyCounter = 0;
			$whiteCounter = 0;
        	
			//each pixel of the image will be selected, the color will be read out and the right counter will be incremented
        	for ($counterWidth=0; $counterWidth < $width; $counterWidth++) {
        		for ($counterHeight=0; $counterHeight < $height; $counterHeight++) {
        			$rgb = imagecolorat($im, $counterWidth, $counterHeight); //gets the color code of a specific pixel
        			$r = ($rgb >> 16) & 255; //split the color red off the rgb code and converts it to decimal (0 up to 255 is possible)
                    $g = ($rgb >> 8) & 255;
                    $b = $rgb & 255;
        			
					// Check if the color code wich was read out before and splittet fits with one 
					// valid of the game and increment the specific counter
        			if($r == 0 && $g == 0 && $b == 0){
        			    $blackCounter++;
        			}
        			else if($r == 255 && $g == 0 && $b == 0){
        			    $redCounter++;
                    }
        			else if($r == 0 && $g == 255 && $b == 0){
        			    $greenCounter++;
        		    }
        			else if($r == 0 && $g == 0 && $b == 255){
        			    $blueCounter++;
                    }
                    else if($r == 255 && $g == 255 && $b == 0){
                        $yellowCounter++;
        			}
					else if($r == 128 && $g == 128 && $b == 128){
                        $greyCounter++;
        			}
					else if($r == 165 && $g == 42 && $b == 42){
                        $brownCounter++;
        			}
					else if($r == 255 && $g == 255 && $b == 255){
        			    $whiteCounter++;
        			}
        			else if($r == 255 && $g == 165 && $b == 0){
        			    $orangeCounter++;
        			}
        		}
        	}
        	
        	return array($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter);
        }
    }
?>