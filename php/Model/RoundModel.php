<?php

    include_once('Database.php');

    class RoundModel{
        
        public static function savePicture($root,$base64, $lobbyIndx,$roundIndx,$playerIndx){
           $IoModel = new IOModel($root);
           $path = $IoModel->savePicture($base64,$lobbyIndx,$roundIndx,$playerIndx);
           if($path =! null){
                CorbleDatabase::savePicture($path, $playerIndx);
           }
        }

        public static function saveRatingFromPlayer($sketchIndx){
            CorbleDatabase::saveRatingFromPlayer($sketchIndx);
        }

        public static function getAllSketches($roundIndx){
            return CorbleDatabase::getAllSketches($roundIndx);
        }

        public static function getRoundIndexOfSketch($sketchId){}

        public static function getAllWordIdsOfCategory($categoryId){
            return [];
        }
    }
?>

