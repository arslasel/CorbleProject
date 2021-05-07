<?php

    include_once('Database.php');
    include_once('PlayerModel.php');

    class RoundModel{
        private $corbleDatabase;
        public function __construct($corbleDatabase){
            $this->corbleDatabase = $corbleDatabase;
        }

        /**
         * Save picture from player on database
         * @param $root String with root directory
         * @param $base64 String with base64 coded picture to be saved as png
         * @param $lobbyIndx String with database lobby index
         * @param $roundIndx String with database round index
         * @param $playerIndx String with database player index
         */
        public function savePicture($root,$base64, $lobbyIndx,$roundIndx,$playerIndx){
           $IoModel = new IOModel($root);
           $path = $IoModel->savePicture($base64,$lobbyIndx,$roundIndx,$playerIndx);
           if($path =! null){
            $this->corbleDatabase->savePicture($path, $playerIndx);
           }
        }

        /**
         * Adds a vote to a sketch (+1)
         *
         * @param $sketchIndx String with database index of scetch
         */
        public function saveRatingFromPlayer($sketchIndx){
            $this->corbleDatabase->saveRatingFromPlayer($sketchIndx);
        }

        /**
         * Get all sketches as an array but not the one of the player (no possiblity to vote for the own sketch)
         * @param $roundIndx String with database index of the round
         * @param $playerIndx String with database index of the player
         * @return array|int Path to all sketches (but not the players one)
         */
        public function getAllSketches($roundIndx, $playerIndx){
            return $this->corbleDatabase->getAllSketches($roundIndx, $playerIndx);
        }

        /**
         * Get key-value array to display the leaderboard with name and score for each player
         * @param $lobbyIndx String with index of lobby
         */
        public function getLeaderBoard($lobbyIndx){
            $players = array($this->corbleDatabase->getPlayersOfLobby($lobbyIndx));
            $leaderboard = array();
            foreach ($players as $player){
                $playerScore = 0;
                $result = $this->corbleDatabase->getScoreOfPlayer($player::getIndx());
                foreach($result as $res){
                    $playerScore = $playerScore + $res;
                }
                $leaderboard[$player::getName()] = $playerScore;
            }
            return arsort($leaderboard);
        }

    }
?>

