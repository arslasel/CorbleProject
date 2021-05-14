<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseConnection.php");

class GameViewEndLoadPlayerNameBestAlgoVote
{

    private $databaseConnection;
    private $corbleDatabase;

    public function __construct(){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
    }

    public function LoadWinner()
    { 
        $winnerName = $this->corbleDatabase->getPlayerWithBestAlogrithmSketch($_GET["username"]);//In der $_Get-Klammer muss no spezifiziert werden
        echo $winnerName;
    }
}

$instance = new GameViewEndLoadPlayerNameBestAlgoVote();
try {
    $instance->LoadWinner();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}