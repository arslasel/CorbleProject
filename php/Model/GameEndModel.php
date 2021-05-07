<?php

include_once('../Database.php');

class GameEndModel{
    private $lobbyIndex;
    public function __construct($lobbyIndex){
        $this->lobbyIndex = $lobbyIndex;
    }

    public function getPlayerWithBestVotedSketch(){
        DatabaseLibrary::getPlayerWithBestVotedSketch($this->lobbyIndex);
    }

    public function getPlayerWithBestAlogrithmSketch(){
        DatabaseLibrary::getPlayerWithBestAlogrithmSketch($this->lobbyIndex);
    }

    public function getPlayerWithWorstVotedSketch(){
        DatabaseLibrary::getPlayerWithWORSTAlogrithmSketch($this->lobbyIndex);
    }

    public function getSketchBestVoted(){
        DatabaseLibrary::getSketchBestVoted($this->lobbyIndex);
    }

    public function getSketchWorstAlgorithm(){
        DatabaseLibrary::getSketchWorstAlgorithm($this->lobbyIndex);
    }

    public function getSketchBestAlgorithm(){
        DatabaseLibrary::getSketchBestAlgorithm($this->lobbyIndex);
    }

    public function getWinner(){
        DatabaseLibrary::getWinner($this->lobbyIndex);
    }
}