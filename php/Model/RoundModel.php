<?php

    include_once('DatabaseLibrary.php');
    include_once('PlayerModel.php');

    class RoundModel{

        /**
         * Save picture from player on database
         * @param $root String with root directory
         * @param $base64 String with base64 coded picture to be saved as png
         * @param $lobbyIndx String with database lobby index
         * @param $roundIndx String with database round index
         * @param $playerIndx String with database player index
         */
        public static function savePicture($root,$base64, $lobbyIndx,$roundIndx,$playerIndx){
           $IoModel = new IOModel($root);
           $path = $IoModel->savePicture($base64,$lobbyIndx,$roundIndx,$playerIndx);
           if($path =! null){
                DatabaseLibrary::savePicture($path, $playerIndx);
           }
        }

        /**
         * Adds a vote to a sketch (+1)
         *
         * @param $sketchIndx String with database index of scetch
         */
        public static function saveRatingFromPlayer($sketchIndx){
            DatabaseLibrary::saveRatingFromPlayer($sketchIndx);
        }

        /**
         * Get all sketches as an array but not the one of the player (no possiblity to vote for the own sketch)
         * @param $roundIndx String with database index of the round
         * @param $playerIndx String with database index of the player
         * @return array|int Path to all sketches (but not the players one)
         */
        public static function getAllSketches($roundIndx, $playerIndx){
            return DatabaseLibrary::getAllSketches($roundIndx, $playerIndx);
        }

        /**
         * Get key-value array to display the leaderboard with name and score for each player
         * @param $lobbyIndx String with index of lobby
         */
        public static function getLeaderBoard($lobbyIndx){
            $players = array(DatabaseLibrary::getPlayersOfLobby($lobbyIndx));
            $leaderboard = array();
            foreach ($players as $player){
                $playerScore = 0;
                $result = DatabaseLibrary::getScoreOfPlayer($player::getIndx());
                foreach($result as $res){
                    $playerScore = $playerScore + $res;
                }
                $leaderboard[$player::getName()] = $playerScore;
            }
            return arsort($leaderboard);
        }

    }
?>

