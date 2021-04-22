<?php
    include_once('../Database.php');
    include_once('../RatingModel.php');
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

        /**
         * This method is the constructor of the class RoundController
         * @param: String array() $sketches
         * @param: int $category
         */
        public function __construct($sketches, $categoryId){
            $this->sketches = $sketches; //Here are sketch-id and picture information contained
            $this->sketchesIds = array_column($this->sketches, 0);
            $this->categoryId = $categoryId;
        }

        /**
         * This method is used for rating a sketch with the computer algorithm
         */
        public function rateSketch(){
            foreach($this->sketches as $sketchId => $valueOfSketch) {
                $this->ratingModel = new RatingModel($sketchId, $valueOfSketch);
                $this->ratingModel->collectPenalties($sketchId);
            }
        }

        /**
         * This method is used for selecting a random Word out of a category
         */
        public function selectRandomWord(){
            $wordIds = CorbleDatabase::getAllWordIdsOfCategory($this->categoryId);
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
         */
        public function sketchRateOfPlayer(){

        }
    }
?>