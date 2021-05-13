<?php
//Includes required for using the RoundController functionality
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/GameEndModel.php');

class GameEndController{
    private $lobbyIndex;

    public function getPlayerWithBestVotedSketch(){
        GameEndModel::getPlayerWithBestVotedSketch($this->lobbyIndex);
    }

    public function getPlayerWithBestAlogrithmSketch(){
        GameEndModel::getPlayerWithBestAlogrithmSketch($this->lobbyIndex);
    }

    public function getPlayerWithWorstVotedSketch(){
        GameEndModel::getPlayerWithWORSTAlogrithmSketch($this->lobbyIndex);
    }

    public function getSketchBestVoted(){
        GameEndModel::getSketchBestVoted($this->lobbyIndex);
    }

    public function getSketchWorstAlgorithm(){
        GameEndModel::getSketchWorstAlgorithm($this->lobbyIndex);
    }

    public function getSketchBestAlgorithm(){
        GameEndModel::getSketchBestAlgorithm($this->lobbyIndex);
    }

    public function getWinner(){
        GameEndModel::getWinner($this->lobbyIndex);
    }
}