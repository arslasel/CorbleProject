<?php
    include('ImageProcessorModel.php');
    include('Database.php');

	class RatingModel{
        private $imageRessource;
        private $imageProcessingController;
        private $database;
        private const MAX_POINTS = 10;
        private $actualPoints;

        public function __construct(String $imageRessource){
            $this->imageRessource = $imageRessource;
            $this->imageProcessingController = new ImageProcessorModel($imageRessource);
            $this->database = new CorbleDatabase(); #Temp as longs as the between layer not exist
            $actualPoints = $this->MAX_POINTS;
        }

        /**
         * This function calculates the penalties for wrong color rates of a in the database defined color for a word
         * @input: Word $word
         * @input: int $sketchIndx
         * @Return: int penaltiePoints
         */
        function ratioColorsRate($word, $sketchIndx){
            list($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->imageProcessingController->pixelCount();
            $primaryOptimalColorRatio = $this->database->executeQuery("SELECT primaryColorRatio FROM tbl_word WHERE word = " .$word);
            $secondaryOptimalColorRatio = $this->database->executeQuery("SELECT secondaryColorRatio FROM tbl_word WHERE word = " .$word);
            
            $primaryColor = $this->database->executeQuery("SELECT primaryColor FROM tbl_word WHERE word = " .$word);
            $secondaryColor = $this->database->executeQuery("SELECT secondaryColor FROM tbl_word WHERE word = " .$word);
            
            list($actualPrimaryRatio, $actualSecondaryRatio) = $this->calculateRatio($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor, $secondaryColor);
            $penaltiePoints = $this->calculatePenaltiesRatio($primaryOptimalColorRatio, $secondaryOptimalColorRatio, $actualPrimaryRatio, $actualSecondaryRatio);

            return $penaltiePoints;
        }
        
        /**
         * This function sets the penalties for wrong applied colors in the picture
         * @Return: int penaltiesForForeignColors
         */
        function foreignColorsRate(){}
        
        /**
         * This function collects the penalties from the functions ratioColorsRate() and foreignColorsRate()
         * @input: Word $word
         * @input: int $sketchIndx 
         * @Return: int $totalPoints
         */
        function collectPenalties($word, $sketchIndx){
            $penaltiePoints = 0;
            $penaltiePoints = $this->actualPoints;
            $penaltiePoints += $this->ratioColorsRate($word, $sketchIndx);

            $totalPoints = $this->actualPoints - $penaltiePoints;

            return $totalPoints;
        }
        
        /**
         * This method is a helper methods. It helps to select the correct counter which is needed to bill the ratio
         * @input: int $blackCounter
         * @input: int $redCounter 
         * @input: int $greenCounter 
         * @input: int $blueCounter 
         * @input: int $yellowCounter 
         * @input: int $orangeCounter 
         * @input: int $colorToSelect
         * @Return: int $colorCounter
         */
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

        /**
         * This function calculate the actual ratio of the primary and the secondary colors
         * @input: int $blackCounter
         * @input: int $redCounter 
         * @input: int $greenCounter 
         * @input: int $blueCounter 
         * @input: int $yellowCounter 
         * @input: int $orangeCounter 
         * @input: int $primaryColor
         * @input: int $secondaryColor
         * @Return: list(double $actualPrimaryRatio, double $actualSecondaryRatio)
         */
        function calculateRatio($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor, $secondaryColor){
            $primaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor);
            $secondaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $secondaryColor);
            $totalCount = $primaryColorCounterNum + $secondaryColorCounterNum;
            
            $actualPrimaryRatio = $primaryColorCounterNum/$totalCount;
            $actualSecondaryRatio = $secondaryColorCounterNum/$totalCount;

            return list($actualPrimaryRatio, $actualSecondaryRatio);
        }

        /**
         * This function calculate the total penaltie points for the ratio
         * @input: double $primaryOptimalColorRatio
         * @input: double $secondaryOptimalColorRatio 
         * @input: double $actualPrimaryRatio 
         * @input: double $actualSecondaryRatio 
         * @Return: int $penaltiePoints
         */
        function calculatePenaltiesRatio($primaryOptimalColorRatio, $secondaryOptimalColorRatio, $actualPrimaryRatio, $actualSecondaryRatio){
            $penaltieRangeHarmless = 1;
            $penaltieRangeNotGood = 2;
            $penaltieRangeCatastrophic = 3;
            $penaltiePoints = 0;

            if($primaryOptimalColorRatio != NULL &&  $secondaryOptimalColorRatio != NULL && $actualPrimaryRatio != NULL && $actualSecondaryRatio != NULL){
                $differencePrimary = abs($primaryOptimalColorRatio - $actualPrimaryRatio);
                $differenceSecondary = abs($secondaryOptimalColorRatio - $actualSecondaryRatio);
                $penaltiePoints += $this->setPenaltiesRatioPoints($differencePrimary, $penaltiePoints);
                $penaltiePoints += $this->setPenaltiesRatioPoints($differenceSecondary, $penaltiePoints);
            }
            else{
                throw new Exception('One of the ratios is NULL!');
            }

            return $penaltiePoints;
        }

        /**
         * This function sets the effective penaltie points for the difference between optimal value and actual value of the color ratio
         * @input: double $difference 
         * @input: int $penaltiePoints
         * @Return: int $penaltiePoints
         */
        function setPenaltiesRatioPoints($difference, $penaltiePoints){
            if($difference <= 1){
                $penaltiePoints += 0.5;
            }
            else if($difference > 1 && $difference <= 2){
                $penaltiePoints += 2;
            }
            else if($difference > 2){
                $penaltiePoints += 3;
            }

            return $penaltiePoints;
        }

    }
?>