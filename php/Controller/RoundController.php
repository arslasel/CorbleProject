<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/RatingModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/RoundModel.php");

    /**
     * The class RoundController will be used for doing the whole logic part of the game round
     */
    class RoundController{
        private $sketches = array();
        private $ratingModel;
        private $roundIndex;
        private $corbleDatabase;
        private $roundModel;

        /**
         * This method is the constructor of the class RoundController
         */
        public function __construct(){
            $this->corbleDatabase = new DatabaseLibrary(new DatabaseConnection());
            $this->roundModel = new RoundModel($this->corbleDatabase);
        }

        /**
         * Create new round with given lobby-index and word cataroy
         * @param int $lobbyIndex Index of lobby
         * @param int $categoryId Category id 
         * @return int Database index of created round
         */
        public function createRound(int $lobbyIndex, int $categoryId){
            $wordId = $this->selectRandomWord($categoryId);
            return $this->corbleDatabase->createRound($lobbyIndex, $wordId);
        }

        /**
         * This method is used for rating a sketch with the computer algorithm
         */
        public function rateSketch($sketchIndex, $roundIndex){
            echo " sketchID " . $sketchIndex;
            echo " roundId " . $roundIndex;
            echo " Sketch " . $this->corbleDatabase->getSketchByIndex($sketchIndex);
            echo " Word" . $this->corbleDatabase->getWordNameOfRound($roundIndex);
            $this->ratingModel = new RatingModel($this->corbleDatabase->getSketchByIndex($sketchIndex), 
                 $this->corbleDatabase->getWordNameOfRound($roundIndex));

            $this->ratingModel->collectPenalties($sketchIndex);
        }

        /**
         * Saves a picture to the database
         * @param string file with sketch to be saved
         * @param int $joinCode Joincode to save the sketch to
         * @param string $userName String with name of user
         */
        public function saveSketch($file, $joinCode, $userName, $roundIndex){
            return $this->roundModel->savePicture(
                file_get_contents($file), $this->corbleDatabase->getLobbyIndexByJoinCode($joinCode), 
                $roundIndex, $this->corbleDatabase->getPlayerByIndex($userName));
        }


        /**
         * Returns all sketches of a player by a given joincode and username
         * @param int joincode of player 
         * @param string username of player
         * @return array with all sketches to vote
         */
        public function getAllSketchesToVote($roundIndex, $userName){
            $userIndex = $this->corbleDatabase->getUserIndexbyUserName($userName);
            return $this->roundModel->getAllSketches($roundIndex, $userIndex);
        }

        /**
         * This method is used for selecting a random Word out of a category
         * @param int $categoryId Database id to get all word from 
         */
        public function selectRandomWord($categoryId){
            $wordIds = $this->corbleDatabase->getAllWordIdsOfCategory($categoryId);
            if(sizeof($wordIds) != 0){ // if wordIds == 0 then no word was found for category
                $numOfElements = sizeof($wordIds);
                $randomNumInArray = rand(0, $numOfElements-1);
                return $wordIds[$randomNumInArray];
            }
            else{
                throw new Exception('There are no words for this category!');
            }
        }

        /**
         * This method is used to perform the rating of a picture from a player
         * @param int $sketchIndex Database index of sketch 
         */
        public function sketchRateOfPlayer($sketchIndex){
            $this->roundModel->saveRatingFromPlayer($sketchIndex);
        }

        /**
         * Returns array with key value pair of player and his score
         * @param int $lobbyIndex Integer index of lobby
         */
        public function getLeaderBoard($lobbyIndex){
            $this->roundModel->getLeaderBoard($lobbyIndex);
        }

        /**
         * This method get all sketches as a list.
         * @return: array Array with strings
         */
        public function getSketchesOfRound(){
            return $this->sketches;
        }

        /**
         * Method returns draw time of lobby
         * @param int $joinCode integer with joincode of lobby 
         */
        public function getDrawTime($joinCode){
            return $this->roundModel->getDrawTime($joinCode);
        }

        /**
         * Method that returns the wordname
         * @param int $roundIndex Index of round
         * @param string name of word 
         */
        public function getWordName($roundIndex){
            return $this->roundModel->getWordName($roundIndex);
        }
    }
?>
