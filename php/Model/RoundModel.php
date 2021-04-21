<?php

    include_once('Database.php');

    class RoundModel{
        //Construktur noch zu implementieren

        private $sketches = array(); //getAllSketches() in Database.php
        
        public function savePicture($base64, $playerIndx){}

        public function saveRatingFromPlayer($ratingPlayerIndx, $sketchIndx){}

        public function getAllSketches($roundIndx){
            $this->sketches = CorbleDatabase::getAllSketches($roundIndx);
        }
    }
?>

