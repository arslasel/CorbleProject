<?php
    //Includes required for using the RoundController functionality
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/RatingModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/RoundModel.php");
    /**
     * The class RoundController will be used for doing the whole logic part of the game round
     */
    class RoundController{
        //Class variable initializations
        private $sketches = array(); //this should be an array of sketchesIds and imagedata
        private $sketchesIds = array();
        private $categoryId;
        private const MIN_WORD_ID = 1;
        private $ratingModel;
        private $roundIndx;
        private $corbleDatabase;
        private $roundModel;

        /**
         * This method is the constructor of the class RoundController
         * @param: String array() $sketches
         * @param: int $category
         */
        public function __construct(){
            $this->corbleDatabase = new DatabaseLibrary(new DatabaseConnection());
            $this->roundModel = new RoundModel($this->corbleDatabase);
            //$this->sketches = $sketches; //Here are sketch-id and picture information contained
            //$this->sketchesIds = array_column($this->sketches, 0);
            //$this->categoryId = $categoryId;
        }


        public function createRound(int $lobbyIndx, int $categoryId){
            $wordId = $this->selectRandomWord($categoryId);
            $this->corbleDatabase->createRound($lobbyIndx, $wordId);
        }

        /**
         * This method is used for rating a sketch with the computer algorithm
         */
        public function rateSketch(){
            foreach($this->sketches as $sketchId => $valueOfSketch) {
                $this->ratingModel = new RatingModel($this->corbleDatabase,$sketchId, $valueOfSketch);
                $this->ratingModel->collectPenalties($sketchId);
            }
        }

        /**
         * This method is used for selecting a random Word out of a category
         */
        public function selectRandomWord(){
            $wordIds = $this->corbleDatabase->getAllWordIdsOfCategory($this->categoryId);
            if($wordIds != 0){ // if wordIds == 0 then no word was found for category
                $numOfElements = count($wordIds);
                $randomNumInArray = rand($this->MIN_WORD_ID, $numOfElements);
                return $wordIds[$randomNumInArray];
            }
            else{
                throw new Exception('There are no words for this category!');
            }
        }

        /**
         * This method is used to perform the rating of a picture from a player
         * @param: int $sketchIndx
         */
        public function sketchRateOfPlayer($sketchIndx){
            $this->roundModel->saveRatingFromPlayer($sketchIndx);
        }

        /**
         * Returns array with key value pair of player and his score
         * @param $lobbyIndx Integer index of lobby
         */
        public function getLeaderBoard($lobbyIndx){
            $this->roundModel->getLeaderBoard($lobbyIndx);
        }

        /////////////////////////////////////////////////////////////////////
        /////////////// Helper Methods
        /////////////////////////////////////////////////////////////////////
        /**
         * This method get all sketches as a list.
         * @return: String array() $this->sketches
         */
        public function getSketchesOfRound(){
                return $this->sketches;
        }

        /**
         * This method refreshes the sketches which are contained in the round.
         */
        /*public function refreshListOfSketches(){
            $this->roundIndx = $this->corbleDatabase->getRoundIndexOfSketch($this->sketchesIds[0]);
            $this->sketches = $this->roundModel->getAllSketches($this->roundIndx);
        }*/
    }
?>
