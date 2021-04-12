<?php
    include('ImageProcessorModel.php');
    include('Database.php');
	class RatingModel{
        private $imageRessource;
        private $imageProcessingController;
        private $database;

        public function __construct(String $imageRessource){
            $this->imageRessource = $imageRessource;
            $this->imageProcessingController = new ImageProcessorModel($imageRessource);
            $this->database = new CorbleDatabase(); #Temp as longs as the between layer not exist
        }

        /**
         * This function calculates the penalties for wrong color rates of a in the database defined color for a word
         * @Return: int penaltiesForColorRate
         */
        function ratioColorsRate(){
            list($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->imageProcessingController->pixelCount();
        }
        
        /**
         * This function sets the penalties for wrong applied colors in the picture
         * @Return: int penaltiesForForeignColors
         */
        function foreignColorsRate(){}
        
        /**
         * This function collects the penalties from the functions ratioColorsRate() and foreignColorsRate()
         * @Return: int penaltieTotal
         */
        function collectPenalties(){}
    }
?>