<?php


class RoundController{
    private $roundModel;
    private $RatingModel;

    public function __construct(){
        $this->roundModel = new RoundModel();
        $this->RatingModel = new RatingModel();
    }

}