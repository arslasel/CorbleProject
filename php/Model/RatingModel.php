<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/ImageProcessorModel.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseLibrary.php");

    /**
     * This class is used to rate the picture which is drawn from the player
     */
	class RatingModel{
        private $corbleDatabase;
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
         * @param CorbleDatabase to run database querrys on
         * @param string $imageRessource
         * @param string $word
         */
        public function __construct(DatabaseLibrary $database, String $imageRessource, String $word){
            $this->corbleDatabase = $database;
            $this->imageProcessingController = new ImageProcessorModel($imageRessource);
            $this->actualPoints = self::MAX_POINTS;

            $this->primaryOptimalColorRatio = $this->corbleDatabase->getPrimaryOptimalColorRatioForWord($word);
            $this->secondaryOptimalColorRatio = $this->corbleDatabase->getSecondaryOptimalColorRatioForWord($word);
            $this->primaryColor = $this->corbleDatabase->getPrimaryColor($word);
            $this->secondaryColor = $this->corbleDatabase->getSecondaryColor($word);
        }

        /**
         * This function collects the penalties from the functions ratioColorsRate() and foreignColorsRate()
         * @param int $sketchIndex
         * @return int $totalPoints
         */
        public function collectPenalties($sketchIndex){
            $penaltyPoints = 0;
            list($blackCounter, $brownCounter, $greyCounter, $whiteCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->getPixelCountOfImage();
            $penaltyPoints += $this->ratioColorsRate($blackCounter,$redCounter,  $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter);
            $penaltyPoints += $this->foreignColorsRate($blackCounter,$redCounter,  $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter);
            $penaltyPoints = $this->validatepenaltyPoints($penaltyPoints);
            $totalPoints = $this->actualPoints - $penaltyPoints;
            $this->corbleDatabase->setComputerScoreForSketch($totalPoints, $sketchIndex);
        }

        /**
         * This function calculates the penalties for wrong color rates of a in the database defined color for a word
         * @param int $blackCounter Pixel counter for black color
         * @param int $redCounter Pixel counter for red color
         * @param int $greenCounter Pixel counter for green color
         * @param int $blueCounter Pixel counter or blue color
         * @param int $yellowCounter Pixel color for yellow color
         * @param int $orangeCounter Pixel counter for orange color
         * @return int penaltyPoints
         */
        public function ratioColorsRate($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter){
            list($actualPrimaryRatio, $actualSecondaryRatio) = $this->calculateRatio($blackCounter, $redCounter,  $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $this->primaryColor, $this->secondaryColor);
            $penaltyPoints = $this->calculatepenaltiesRatio($this->primaryOptimalColorRatio, $this->secondaryOptimalColorRatio, $actualPrimaryRatio, $actualSecondaryRatio);
            $penaltyPoints = $this->validatepenaltyPoints($penaltyPoints);
            return $penaltyPoints;
        }
        
        /**
         * This function sets the penalties for wrong applied colors in the picture         
         * @param int $blackCounter Pixel counter for black color
         * @param int $redCounter Pixel counter for red color
         * @param int $greenCounter Pixel counter for green color
         * @param int $blueCounter Pixel counter or blue color
         * @param int $yellowCounter Pixel color for yellow color
         * @param int $orangeCounter Pixel counter for orange color
         * @return int penaltiesForForeignColors
         */
        public function foreignColorsRate($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter){
            $penaltyPoints = 0;

            if(($blackCounter > RatingModel::NO_PIXEL && $this->primaryColor != "black") && ($blackCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "black")){
                $penaltyPoints += 1;
                ($blackCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }
            if(($redCounter > RatingModel::NO_PIXEL && $this->primaryColor != "red") && ($redCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "red")){
                $penaltyPoints += 1;
                ($redCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }
            if(($brownCounter > RatingModel::NO_PIXEL && $this->primaryColor != "brown") && ($brownCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "brown")){
                $penaltyPoints += 1;
                ($brownCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }
            if(($greyCounter > RatingModel::NO_PIXEL && $this->primaryColor != "grey") && ($greyCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "grey")){
                $penaltyPoints += 1;
                ($greyCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            } 
            if(($whiteCounter > RatingModel::NO_PIXEL && $this->primaryColor != "white") && ($whiteCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "white")){
                $penaltyPoints += 1;
                ($whiteCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }                             
            if(($greenCounter > RatingModel::NO_PIXEL && $this->primaryColor != "green") && ($greenCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "green")){
                $penaltyPoints += 1;
                ($greenCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }
            if(($blueCounter > RatingModel::NO_PIXEL && $this->primaryColor != "blue") && ($blueCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "blue")){
                $penaltyPoints += 1;
                ($blueCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }
            if(($yellowCounter > RatingModel::NO_PIXEL && $this->primaryColor != "yellow") && ($yellowCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "yellow")){
                $penaltyPoints += 1;
                ($yellowCounter >= 200) ? $penaltyPoints += 3 :$this->relax();
            }
            if(($orangeCounter > RatingModel::NO_PIXEL && $this->primaryColor != "orange") && ($orangeCounter > RatingModel::NO_PIXEL && $this->secondaryColor != "orange")){
                $penaltyPoints += 1;
                ($orangeCounter >= RatingModel::MAX_DIFFERENCE_BORDER) ? $penaltyPoints += 3 :$this->relax();
            }

            $penaltyPoints = $this->validatepenaltyPoints($penaltyPoints);

            return $penaltyPoints;
        }
        
        /**
         * This method is a helper methods. It helps to select the correct counter which is needed to bill the ratio
         * @param int $blackCounter Pixel counter for black color
         * @param int $redCounter Pixel counter for red color
         * @param int $greenCounter Pixel counter for green color
         * @param int $blueCounter Pixel counter or blue color
         * @param int $yellowCounter Pixel color for yellow color
         * @param int $orangeCounter Pixel counter for orange color
         * @param string $colorToSelect color to select for counting
         * @return int $colorCounter counter for 
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
         * @param int $blackCounter Pixel counter for black color
         * @param int $redCounter Pixel counter for red color
         * @param int $greenCounter Pixel counter for green color
         * @param int $blueCounter Pixel counter or blue color
         * @param int $yellowCounter Pixel color for yellow color
         * @param int $orangeCounter Pixel counter for orange color
         * @param string $primaryColor Primary color
         * @param string $secondaryColor Secundary color
         * @return list(float $actualPrimaryRatio, float $actualSecondaryRatio)
         */
        public function calculateRatio(int $blackCounter, int $redCounter, int $brownCounter, int $greyCounter, int $whiteCounter,
                int $greenCounter, int $blueCounter, int $yellowCounter, int $orangeCounter, string $primaryColor, string $secondaryColor){
            $primaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor);
            $secondaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $brownCounter, $greyCounter, $whiteCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $secondaryColor);
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
         * This function calculate the total penalty points for the ratio
         * @param float $primaryOptimalColorRatio Primary color ration as a float between 0 and 1 from database
         * @param float $secondaryOptimalColorRatio secundary color ratio as a float between 0 and 1 from database
         * @param float $actualPrimaryRatio Primary color ratio of sketch
         * @param float $actualSecondaryRatio Secundary color ratio of sketch
         * @return int $penaltyPoints resulting penalty points
         */
        public function calculatePenaltiesRatio(float $primaryOptimalColorRatio, float $secondaryOptimalColorRatio, float $actualPrimaryRatio, float $actualSecondaryRatio){
            $penaltyPoints = 0.0;
            if(!is_null($primaryOptimalColorRatio) && !is_null($secondaryOptimalColorRatio) && !is_null($actualPrimaryRatio) && !is_null($actualSecondaryRatio)) {
                $differencePrimary = (float)abs($primaryOptimalColorRatio - $actualPrimaryRatio);
                $differenceSecondary = (float)abs($secondaryOptimalColorRatio - $actualSecondaryRatio);
                $penaltyPoints = $this->setPenaltiesRatioPoints($differencePrimary, $penaltyPoints);
                $penaltyPoints = $this->setPenaltiesRatioPoints($differenceSecondary, $penaltyPoints);
            }
            else{
                throw new Exception('One of the ratios is NULL!');
            }

            return $penaltyPoints;
        }

        /**
         * This function sets the effective penalty points for the difference between optimal value and actual value of the color ratio
         * @param float $difference difference between image ration and sketch
         * @param int $penaltyPoints penalty points to be added to the picture
         * @return int $penaltyPoints resulting penalty points
         */
        public function setPenaltiesRatioPoints(float $difference, float $penaltyPoints){
            $penaltyRangeHarmless = 0.31;
            $penaltyRangeNotGood = 0.61;
            $penaltyRangeCatastrophic = 0.8;

            if($difference < 0.1){
                return $penaltyPoints;
            }
            else if($difference < $penaltyRangeHarmless){
                $penaltyPoints += 0.5;
            }
            else if($difference > $penaltyRangeHarmless && $difference < $penaltyRangeNotGood){
                $penaltyPoints += 2.0;
            }
            else{
                $penaltyPoints += 3.0;
            }

            return $penaltyPoints;
        }

        /**
         * This method validate that we haven't got more than the MAX_POINTS penatlie points because we
         * cannot achive less than 0 points in total
         * @param int $penaltyPoints Penalty points to be validated
         * @return int $penaltyPoints Penalty points after validation
         */
        public function validatePenaltyPoints(int $penaltyPoints){
            if($penaltyPoints <= self::MAX_POINTS){
                return $penaltyPoints;
            }
            else{
                return self::MAX_POINTS;
            }
        }

        /**
         * Setter for primaryOptimalColorRation
         * @param float Number with ratio of primary color
         */
        public function setPrimaryOptimalColorRatio($ratio){
            $this->primaryOptimalColorRatio = $ratio; 
        }

        /**
         * Setter for secundary OptimalColorRation
         * @param float Number with ratio of secundary color
         */
        public function setSecondaryOptimalColorRatio($ratio){
            $this->secondaryOptimalColorRatio = $ratio; 
        }

        /**
         * Setter for primary corlor
         * @param string Primary Color
         */
        public function setPrimaryColor($color){
            $this->primaryColor = $color;
        }

        /**
         * Setter for secundary corlor
         * @param string Secundary Color
         */
        public function setSecondaryColor($color){
            $this->secondaryColor = $color; 
        }

        //*********************************************************************
        // Private Methods
        //*********************************************************************
        private function getPixelCountOfImage(){
            return $this->imageProcessingController->pixelCount();
        }
        
    }
