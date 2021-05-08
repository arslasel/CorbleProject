<?php
    include('ImageProcessorModel.php');
    include('DatabaseLibrary.php');

    /**
     * This class is used to rate the picture which is drawn from the player
     */
	class RatingModel{
        private $imageRessource;
        private $imageProcessingController;
        private const MAX_POINTS = 10;
        private const MAX_DIFFERENCE_BORDER = 200;
        private const NO_PIXEL = 0;
        private $actualPoints;
        private $primaryOptimalColorRatio;
        private $secondaryOptimalColorRatio;
        private $primaryColor;
        private $secondaryColor;

        /**
         * This method is the constructor of the class RatingModel
         * @param: String $imageRessource
         * @param: String $word
         */
        public function __construct(String $imageRessource, String $word){
            $this->imageRessource = $imageRessource;
            $this->imageProcessingController = new ImageProcessorModel($imageRessource);
            $actualPoints = $this->MAX_POINTS;

            $this->primaryOptimalColorRatio = DatabaseLibrary::getPrimaryOptimalColorRatioForWord($word);
            $this->secondaryOptimalColorRatio = DatabaseLibrary::getSecondaryOptimalColorRatioForWord($word);
            $this->primaryColor = DatabaseLibrary::getPrimaryColor($word);
            $this->secondaryColor = DatabaseLibrary::getSecondaryColor($word);
        }

        /**
         * This function calculates the penalties for wrong color rates of a in the database defined color for a word
         * @return: int penaltiePoints
         */
        function ratioColorsRate(){
            list($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->imageProcessingController->pixelCount();
            list($actualPrimaryRatio, $actualSecondaryRatio) = $this->calculateRatio($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $this->primaryColor["primaryColor"], $this->secondaryColor["secondaryColor"]);
            $penaltiePoints = $this->calculatePenaltiesRatio($this->primaryOptimalColorRatio["primaryOptimalColorRatio"], $this->secondaryOptimalColorRatio["secondaryOptimalColorRatio"], $actualPrimaryRatio, $actualSecondaryRatio);
            $penaltiePoints = $this->validatePenaltiePoints($penaltiePoints);
            return $penaltiePoints;
        }
        
        /**
         * This function sets the penalties for wrong applied colors in the picture
         * @return: int penaltiesForForeignColors
         */
        function foreignColorsRate(){
            $penaltiePoints = 0;
            list($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter) = $this->imageProcessingController->pixelCount();
            if(($blackCounter >= $this->NO_PIXEL && $this->primaryColor["primaryColor"] != "black") && ($blackCounter >= $this->NO_PIXEL && $this->secondaryColor["secondaryColor"] != "black")){
                $penaltiePoints += 1;
                ($blackCounter >= $this->MAX_DIFFERENCE_BORDER) ?: $penaltiePoints += 3;
            }
            else if(($redCounter >= $this->NO_PIXEL && $this->primaryColor["primaryColor"] != "red") && ($redCounter >= $this->NO_PIXEL && $this->secondaryColor["secondaryColor"] != "red")){
                $penaltiePoints += 1;
                ($redCounter >= $this->MAX_DIFFERENCE_BORDER) ?: $penaltiePoints += 3;
            }
            else if(($greenCounter >= $this->NO_PIXEL && $this->primaryColor["primaryColor"] != "green") && ($greenCounter >= $this->NO_PIXEL && $this->secondaryColor["secondaryColor"] != "green")){
                $penaltiePoints += 1;
                ($greenCounter >= $this->MAX_DIFFERENCE_BORDER) ?: $penaltiePoints += 3;
            }
            else if(($blueCounter >= $this->NO_PIXEL && $this->primaryColor["primaryColor"] != "blue") && ($blueCounter >= $this->NO_PIXEL && $this->secondaryColor["secondaryColor"] != "blue")){
                $penaltiePoints += 1;
                ($blueCounter >= $this->MAX_DIFFERENCE_BORDER) ?: $penaltiePoints += 3;
            }
            else if(($yellowCounter >= $this->NO_PIXEL && $this->primaryColor["primaryColor"] != "yellow") && ($yellowCounter >= $this->NO_PIXEL && $this->secondaryColor["secondaryColor"] != "yellow")){
                $penaltiePoints += 1;
                ($yellowCounter >= 200) ?: $penaltiePoints += 3;
            }
            else if(($orangeCounter >= $this->NO_PIXEL && $this->primaryColor["primaryColor"] != "orange") && ($orangeCounter >= $this->NO_PIXEL && $this->secondaryColor["secondaryColor"] != "orange")){
                $penaltiePoints += 1;
                ($orangeCounter >= $this->MAX_DIFFERENCE_BORDER) ?: $penaltiePoints += 3;
            }

            $penaltiePoints = $this->validatePenaltiePoints($penaltiePoints);
            
            return $penaltiePoints;
        }
        
        /**
         * This function collects the penalties from the functions ratioColorsRate() and foreignColorsRate()
         * @param: int $sketchIndx 
         * @return: int $totalPoints
         */
        function collectPenalties($sketchIndx){
            $penaltiePoints = 0;
            $penaltiePoints = $this->actualPoints;
            $penaltiePoints += $this->ratioColorsRate();
            $penaltiePoints += $this->foreignColorsRate();
            $penaltiePoints = $this->validatePenaltiePoints($penaltiePoints);
            $totalPoints = $this->actualPoints - $penaltiePoints;
            DatabaseLibrary::setComputerScoreForSketch($totalPoints, $sketchIndx);
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
        function setupColorCounter(int $blackCounter, int $redCounter, int $greenCounter, int $blueCounter, int $yellowCounter, int $orangeCounter, string $colorToSelect){
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
        function calculateRatio(int $blackCounter, int $redCounter, int $greenCounter, int $blueCounter, int $yellowCounter, int $orangeCounter, string $primaryColor, string $secondaryColor){
            $primaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $primaryColor);
            $secondaryColorCounterNum = $this->setupColorCounter($blackCounter, $redCounter, $greenCounter, $blueCounter, $yellowCounter, $orangeCounter, $secondaryColor);
            $totalCount = $primaryColorCounterNum + $secondaryColorCounterNum;
            
            $actualPrimaryRatio = (float)($primaryColorCounterNum/$totalCount);
            $actualSecondaryRatio = (float)($secondaryColorCounterNum/$totalCount);

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
        function calculatePenaltiesRatio(float $primaryOptimalColorRatio, float $secondaryOptimalColorRatio, float $actualPrimaryRatio, float $actualSecondaryRatio){
            $penaltiePoints = 0;

            if($primaryOptimalColorRatio["primaryOptimalColorRatio"] != NULL &&  $secondaryOptimalColorRatio["secondaryOptimalColorRatio"] != NULL && $actualPrimaryRatio != NULL && $actualSecondaryRatio != NULL){
                $differencePrimary = abs($primaryOptimalColorRatio["primaryOptimalColorRatio"] - $actualPrimaryRatio);
                $differenceSecondary = abs($secondaryOptimalColorRatio["secondaryOptimalColorRatio"] - $actualSecondaryRatio);
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
         * @param: float $difference 
         * @param: int $penaltiePoints
         * @return: int $penaltiePoints
         */
        function setPenaltiesRatioPoints(float $difference, int $penaltiePoints){
            $penaltieRangeHarmless = 1;
            $penaltieRangeNotGood = 2;
            $penaltieRangeCatastrophic = 3;

            if($difference <= $penaltieRangeHarmless){
                $penaltiePoints += 0.5;
            }
            else if($difference > 1 && $difference <= $penaltieRangeNotGood){
                $penaltiePoints += 2;
            }
            else if($difference > $penaltieRangeCatastrophic){
                $penaltiePoints += 3;
            }

            return $penaltiePoints;
        }

        /**
         * This method validate that we haven't got more than the MAX_POINTS penatlie points because we
         * cannot achive less than 0 points in total
         * @param: int $penaltiePoints
         * @return: int $penaltiePoints
         */
        function validatePenaltiePoints(int $penaltiePoints){
            if($penaltiePoints <= $this->MAX_POINTS){
                return $penaltiePoints;
            }
            else{
                return $this->MAX_POINTS;
            }
        }

    }
?>