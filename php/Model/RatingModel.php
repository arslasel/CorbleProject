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
        function ratioColorsRate($word, $sketchIndx){
            list($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->imageProcessingController->pixelCount();
            $primaryColorCounter = 0;
            $secondaryColorCounter = 0;
            $primaryOptimalColorRatio = $this->database->executeQuery("SELECT primaryColorRatio FROM tbl_word WHERE word = " .$word);
            $secondaryOptimalColorRatio = $this->database->executeQuery("SELECT secondaryColorRatio FROM tbl_word WHERE word = " .$word);
            $primaryColor = $this->database->executeQuery("SELECT primaryColor FROM tbl_word WHERE word = " .$word);
            $secondaryColor = $this->database->executeQuery("SELECT secondaryColor FROM tbl_word WHERE word = " .$word);
            $primaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor);
            $secondaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $secondaryColor);
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

        function setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $colorToSelect){
            $colorCounter = 0;
            switch ($colorToSelect){
                case "black":
                    $colorCounter = $blackCounter;
                    break;
                case "red":
                    $colorCounter = $redCounter;
                    break;
                case "green":
                    $colorCounter = $greenCounter;
                    break;
                case "blue":
                    $colorCounter = $blueCounter;
                    break;
                case "yellow":
                    $colorCounter = $yellowCounter;
                    break;
                case "orange":
                    $colorCounter = $orangeCounter;
                    break;
            }
            return $colorCounter;
        }

    }
?>