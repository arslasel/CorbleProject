<?php

use function PHPUnit\Framework\isNull;

include_once('ImageProcessorModel.php');
    include_once('DatabaseLibrary.php');

    /**
     * This class is used to rate the picture which is drawn from the player
     */
	class RatingModel{
        private $corbleDatabase;
        private $imageRessource;
        private $imageProcessingController;
        public const MAX_POINTS = 10;
        public const MAX_DIFFERENCE_BORDER = 200;
        public const NO_PIXEL = 0;
        private $actualPoints;
        private $primaryOptimalColorRatio;
        private $secondaryOptimalColorRatio;
        private $primaryColor;
        private $secondaryColor;

        private function relax() {
            ;
        }

        /**
         * This method is the constructor of the class RatingModel
         * @param: String $imageRessource
         * @param: String $word
         */
        public function __construct($corbleDatabase,String $imageRessource, String $word){
            $this->corbleDatabase = $corbleDatabase;
            
            $this->imageRessource = $imageRessource;
            $this->imageProcessingController = new ImageProcessorModel($imageRessource);
            $actualPoints = self::MAX_POINTS;

            $this->primaryOptimalColorRatio = $this->corbleDatabase->getPrimaryOptimalColorRatioForWord($word);
            $this->secondaryOptimalColorRatio = $this->corbleDatabase->getSecondaryOptimalColorRatioForWord($word);
            $this->primaryColor = $this->corbleDatabase->getPrimaryColor($word);
            $this->secondaryColor = $this->corbleDatabase->getSecondaryColor($word);
        }

        /**
         * This function calculates the penalties for wrong color rates of a in the database defined color for a word
         * @return: int penaltiePoints
         */
        public function ratioColorsRate($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter){
            list($actualPrimaryRatio, $actualSecondaryRatio) = $this->calculateRatio($blackCounter, $redCounter,  $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $this->primaryColor, $this->secondaryColor);
            $penaltiePoints = $this->calculatePenaltiesRatio($this->primaryOptimalColorRatio, $this->secondaryOptimalColorRatio, $actualPrimaryRatio, $actualSecondaryRatio);
            $penaltiePoints = $this->validatePenaltiePoints($penaltiePoints);
            return $penaltiePoints;
        }
        
        /**
         * This function sets the penalties for wrong applied colors in the picture
         * @return: int penaltiesForForeignColors
         */
        public function foreignColorsRate($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter){
            $penaltiePoints = 0;

            if(($blackCounter > RatingModel::NO_PIXEL && $this->primaryColor != "black") && ($blackCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "black")){
                $penaltiePoints += 1;
                ($blackCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }
            if(($redCounter > RatingModel::NO_PIXEL && $this->primaryColor != "red") && ($redCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "red")){
                $penaltiePoints += 1;
                ($redCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }
            if(($brownCounter > RatingModel::NO_PIXEL && $this->primaryColor != "brown") && ($brownCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "brown")){
                $penaltiePoints += 1;
                ($brownCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }
            if(($greyCounter > RatingModel::NO_PIXEL && $this->primaryColor != "grey") && ($greyCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "grey")){
                $penaltiePoints += 1;
                ($greyCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            } 
            if(($whiteCounter > RatingModel::NO_PIXEL && $this->primaryColor != "white") && ($whiteCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "white")){
                $penaltiePoints += 1;
                ($whiteCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }                             
            if(($greenCounter > RatingModel::NO_PIXEL && $this->primaryColor != "green") && ($greenCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "green")){
                $penaltiePoints += 1;
                ($greenCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }
            if(($blueCounter > RatingModel::NO_PIXEL && $this->primaryColor != "blue") && ($blueCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "blue")){
                $penaltiePoints += 1;
                ($blueCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }
            if(($yellowCounter > RatingModel::NO_PIXEL && $this->primaryColor != "yellow") && ($yellowCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "yellow")){
                $penaltiePoints += 1;
                ($yellowCounter >= 200) ? $penaltiePoints += 3 :$this->relax();
            }
            if(($orangeCounter > RatingModel::NO_PIXEL && $this->primaryColor != "orange") && ($orangeCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "orange")){
                $penaltiePoints += 1;
                ($orangeCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltiePoints += 3 :$this->relax();
            }

            $penaltiePoints = $this->validatePenaltiePoints($penaltiePoints);
            
            return $penaltiePoints;
        }

        private function getPixelCountOfImage(){
            return $this->imageProcessingController->pixelCount();
        }
        
        /**
         * This function collects the penalties from the functions ratioColorsRate() and foreignColorsRate()
         * @param: int $sketchIndx
         */
        public function collectPenalties($sketchIndx){
            $penaltiePoints = 0;
            $penaltiePoints = $this->actualPoints;
            list($blackCounter, $brownCounter, $greyCounter, $whiteCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->getPixelCountOfImage();
            $penaltiePoints += $this->ratioColorsRate($blackCounter,$redCounter,  $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter);
            $penaltiePoints += $this->foreignColorsRate($blackCounter,$redCounter,  $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter);
            $penaltiePoints = $this->validatePenaltiePoints($penaltiePoints);
            $totalPoints = $this->actualPoints - $penaltiePoints;
            $this->corbleDatabase->setComputerScoreForSketch($totalPoints, $sketchIndx);
        }
        
        /**
         * This method is a helper methods. It helps to select the correct counter which is needed to bill the ratio
         * @param: int $blackCounter
         * @param: int $redCounter 
         * @param: int $greenCounter 
         * @param: int $blueCounter 
         * @param: int $yellowCounter 
         * @param: int $orangeCounter 
         * @param: string $colorToSelect
         * @return: int $colorCounter
         */
        public function setupColorCounter(int $blackCounter, int $redCounter, int $brownCounter, int $greyCounter, int $whiteCounter, int $greenCounter, int $blueCounter, int $yellowCounter, int $orangeCounter, string $colorToSelect){
            $colorCounter = 0;
            switch ($colorToSelect){
                case "black":
                    $colorCounter = $blackCounter;
                    break;
                case "red":
                    $colorCounter = $redCounter;
                    break;
                case "brown":
                    $colorCounter = $brownCounter;
                    break;
                case "grey":
                    $colorCounter = $greyCounter;
                    break;
                case "white":
                    $colorCounter = $whiteCounter;
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
                default:
                    $colorCounter = 0;
                    break;
            }
            return $colorCounter;
        }

        /**
         * This function calculate the actual ratio of the primary and the secondary colors
         * @param: int $blackCounter
         * @param: int $redCounter 
         * @param: int $greenCounter 
         * @param: int $blueCounter 
         * @param: int $yellowCounter 
         * @param: int $orangeCounter 
         * @param: string $primaryColor
         * @param: string $secondaryColor
         * @return: list(float $actualPrimaryRatio, float $actualSecondaryRatio)
         */
        public function calculateRatio(
                int $blackCounter, 
                int $redCounter, 
                int $brownCounter,
                int $greyCounter,
                int $whiteCounter,
                int $greenCounter, 
                int $blueCounter, 
                int $yellowCounter, 
                int $orangeCounter, 
                string $primaryColor, 
                string $secondaryColor){
            $primaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor);
            $secondaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $secondaryColor);
            //throw new Exception("primaryColorCounterNum: " .$primaryColorCounterNum ."   and secondaryColorCounterNum: " .$secondaryColorCounterNum);
            $totalCount = $primaryColorCounterNum + $secondaryColorCounterNum;
            
            if($totalCount > 0){
                $actualPrimaryRatio = (float)($primaryColorCounterNum/$totalCount);
                $actualSecondaryRatio = (float)($secondaryColorCounterNum/$totalCount);
            }else {
                $actualPrimaryRatio = 0;
                $actualSecondaryRatio = 0;
            }
            
            return array($actualPrimaryRatio, $actualSecondaryRatio);
        }

        /**
         * This function calculate the total penaltie points for the ratio
         * @param: float $primaryOptimalColorRatio
         * @param: float $secondaryOptimalColorRatio 
         * @param: float $actualPrimaryRatio 
         * @param: float $actualSecondaryRatio 
         * @return: int $penaltiePoints
         */
        public function calculatePenaltiesRatio(float $primaryOptimalColorRatio, float $secondaryOptimalColorRatio, float $actualPrimaryRatio, float $actualSecondaryRatio){
            $penaltiePoints = 0.0;
            if(isNull($primaryOptimalColorRatio) && isNull($secondaryOptimalColorRatio) && isNull($actualPrimaryRatio) && isNull($actualSecondaryRatio)) {
                $differencePrimary = (float)abs($primaryOptimalColorRatio - $actualPrimaryRatio);
                $differenceSecondary = (float)abs($secondaryOptimalColorRatio - $actualSecondaryRatio);
                $penaltiePoints = $this->setPenaltiesRatioPoints($differencePrimary, $penaltiePoints);
                $penaltiePoints = $this->setPenaltiesRatioPoints($differenceSecondary, $penaltiePoints);
            }
            else{
                throw new Exception('One of the ratios is NULL!');
            }

            return $penaltiePoints;
        }

        /**
         * This function sets the effective penaltie points for the difference between optimal value and actual value of the color ratio
         * @param: float $difference 
         * @param: int $penaltiePoints
         * @return: int $penaltiePoints
         */
        public function setPenaltiesRatioPoints(float $difference, float $penaltiePoints){
            $penaltieRangeHarmless = 0.31;
            $penaltieRangeNotGood = 0.61;
            $penaltieRangeCatastrophic = 0.8;

            if($difference < 0.1){
                return $penaltiePoints;
            }
            else if($difference < $penaltieRangeHarmless){
                $penaltiePoints += 0.5;
            }
            else if($difference > $penaltieRangeHarmless && $difference < $penaltieRangeNotGood){
                $penaltiePoints += 2.0;
            }
            else{
                $penaltiePoints += 3.0;
            }

            return $penaltiePoints;
        }

        /**
         * This method validate that we haven't got more than the MAX_POINTS penatlie points because we
         * cannot achive less than 0 points in total
         * @param: int $penaltiePoints
         * @return: int $penaltiePoints
         */
        public function validatePenaltiePoints(int $penaltiePoints){
            if($penaltiePoints <= self::MAX_POINTS){
                return $penaltiePoints;
            }
            else{
                return self::MAX_POINTS;
            }
        }

        //Setters and Getters
        public function setPrimaryOptimalColorRatio($ratio){ $this->primaryOptimalColorRatio = $ratio; }
        public function setSecondaryOptimalColorRatio($ratio){ $this->secondaryOptimalColorRatio = $ratio; }
        public function setPrimaryColor($color){ $this->primaryColor = $color; }
        public function setSecondaryColor($color){ $this->secondaryColor = $color; }
    }
