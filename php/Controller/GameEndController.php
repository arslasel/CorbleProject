<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/GameEndModel.php");

class GameEndController{
    private $lobbyIndex;
    private $databaseConnction;
    private $corbleDatabase;
    private $gameEndModel;

    public function __construct($joinCode){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
        $this->lobbyIndex = $this->corbleDatabase->getLobbyIndxByJoincode($joinCode);
        $this->gameEndModel = new GameEndModel($this->corbleDatabase, $this->lobbyIndex);
    }
    
    public function getPlayerWithBestVotedSketch($joinCode){
        $this->gameEndModel->getPlayerWithBestVotedSketch();
    }

    public function getPlayerWithBestAlogrithmSketch(){
        $this->gameEndModel->getPlayerWithBestAlogrithmSketch();
    }

    public function getPlayerWithWorstVotedSketch(){
        $this->gameEndModel->getPlayerWithWorstAlogrithmSketch();
    }

    public function getSketchBestVoted(){
        $this->gameEndModel->getSketchBestVoted();
    }

    public function getSketchWorstAlgorithm(){
        $this->gameEndModel->getSketchWorstAlgorithm();
    }

    public function getSketchBestAlgorithm(){
        $this->gameEndModel->getSketchBestAlgorithm();
    }

    public function getWinner(){
        $this->gameEndModel->getWinner();
    }
}