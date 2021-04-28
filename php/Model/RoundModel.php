<?php

    include_once('Database.php');

    class RoundModel{
        
        public function savePicture($root,$base64, $lobbyIndx,$roundIndx,$playerIndx){
           $IoModel = new IOModel($root);
           $path = $IoModel->savePicture($base64,$lobbyIndx,$roundIndx,$playerIndx);
           if($path =! null){
                CorbleDatabase::savePicture($path, $playerIndx);
           }
        }

        public function saveRatingFromPlayer($sketchIndx){
            CorbleDatabase::saveRatingFromPlayer($sketchIndx);
        }

        public function getAllSketches($roundIndx){
            return CorbleDatabase::getAllSketches($roundIndx);
        }
    }
?>

