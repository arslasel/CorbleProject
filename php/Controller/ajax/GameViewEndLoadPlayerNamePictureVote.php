<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseConnection.php");

class GameViewEndLoadPlayerNamePictureVote
{

    private $databaseConnection;
    private $corbleDatabase;

    public function __construct(){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
    }

    public function LoadPlayerName()
    { 
        $playerName = $this->corbleDatabase->getPlayerWithBestVotedSketch(197);
        echo $playerName;
    }
}

$instance = new GameViewEndLoadPlayerNamePictureVote();
try {
    $instance->LoadPlayerName();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
