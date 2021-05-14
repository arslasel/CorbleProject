<?php

include_once('../DatabaseLibrary.php');

class GameEndModel{
    private $lobbyIndex;
    private $corbleDatabase;
    public function __construct($corbleDatabase,$lobbyIndex){
        $this->lobbyIndex = $lobbyIndex;
        $this->corbleDatabase = $corbleDatabase;
    }

    public function getPlayerWithBestVotedSketch(){
        $this->corbleDatabase->getPlayerWithBestVotedSketch($this->lobbyIndex);
    }

    public function getPlayerWithBestAlogrithmSketch(){
        $this->corbleDatabase->getPlayerWithBestAlogrithmSketch($this->lobbyIndex);
    }

    public function getPlayerWithWorstAlogrithmSketch(){
        $this->corbleDatabase->getPlayerWithWorstAlgorithmSketch($this->lobbyIndex);
    }

    public function getSketchBestVoted(){
        $this->corbleDatabase->getSketchBestVoted($this->lobbyIndex);
    }

    public function getSketchWorstAlgorithm(){
        $this->corbleDatabase->getSketchWorstAlgorithm($this->lobbyIndex);
    }

    public function getSketchBestAlgorithm(){
        $this->corbleDatabase->getSketchBestAlgorithm($this->lobbyIndex);
    }

    public function getWinner(){
        $this->corbleDatabase->getWinner($this->lobbyIndex);
    }
}