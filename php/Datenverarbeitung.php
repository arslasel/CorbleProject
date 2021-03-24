<?php
    class Datenverarbeitung{
        private $imageRessource;
        
        public function __construct(String $imageRessource){
            $this->$imageRessource = $imageRessource;
        }
        
        public function pixelCount(){
            $im = imagecreatefrompng($imageRessource);

        	list($width, $height) = getimagesize($imageRessource);
        	
        	
        	for ($counterWidth=0; $counterWidth < $width; $counterWidth++) {
        		for ($counterHeight=0; $counterHeight < $height; $counterHeight++) {
        			$rgb = imagecolorat($im, $counterWidth, $counterHeight);
        			$r = ($rgb >> 16) & 0xFF;
        			$g = ($rgb >> 8) & 0xFF;
        			$b = $rgb & 0xFF;
        			
        			#var_dump($r, $g, $b);
        		}
        	} 
        	return(300000);
        }
    }
?>