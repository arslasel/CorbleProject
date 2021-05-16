<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseConnection.php");

class GameViewEndLoadPlayerNameWorstAlgoVote
{

    private $databaseConnection;
    private $corbleDatabase;

    public function __construct(){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
    }

    public function LoadName()
    { 
        $picture = $this->corbleDatabase->getPlayerWithWorstVotedSketch(197);
        echo $picture;
    }
}

$instance = new GameViewEndLoadPlayerNameWorstAlgoVote();
try {
    $instance->LoadName();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}