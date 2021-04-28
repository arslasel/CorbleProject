<?php

include_once('../Database.php');

class GameEndModel{
    private $lobbyIndex;
    public function __construct($lobbyIndex){
        $this->lobbyIndex = $lobbyIndex;
    }

    public function getPlayerWithBestVotedSketch(){
        CorbleDatabase::getPlayerWithBestVotedSketch($this->lobbyIndex);
    }

    public function getPlayerWithBestAlogrithmSketch(){
        CorbleDatabase::getPlayerWithBestAlogrithmSketch($this->lobbyIndex);
    }

    public function getPlayerWithWorstVotedSketch(){
        CorbleDatabase::getPlayerWithWORSTAlogrithmSketch($this->lobbyIndex);
    }

    public function getSketchBestVoted(){
        CorbleDatabase::getSketchBestVoted($this->lobbyIndex);
    }

    public function getSketchWorstAlgorithm(){
        CorbleDatabase::getSketchWorstAlgorithm($this->lobbyIndex);
    }

    public function getSketchBestAlgorithm(){
        CorbleDatabase::getSketchBestAlgorithm($this->lobbyIndex);
    }

    public function getWinner(){
        CorbleDatabase::getWinner($this->lobbyIndex);
    }
}