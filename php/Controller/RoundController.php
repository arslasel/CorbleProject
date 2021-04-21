<?php
    class RoundController{
        //Class variable initializations
        private $sketches = array();
        private $category;

        /**
         * This method is the constructor of the class RoundController
         */
        public function __construct($sketches, $category){
            $this->sketches = $sketches; //Here are sketch-id and picture information contained
            $this->category = $category;
        }

        public function rateSketch(){
        }

        public function selectRandomWord(){}

        public function sketchRateOfPlayer(){}
    }
?>