<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseConnection.php");

class GameViewEndLoadWinner
{

    private $databaseConnection;
    private $corbleDatabase;

    public function __construct(){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
    }

    public function LoadWinner()
    { 
        $winnerName = $this->corbleDatabase->getWinner($_GET["username"]);//In der $_Get-Klammer muss noch spezifiziert werden
        echo $winnerName;
    }
}

$instance = new GameViewEndLoadWinner();
try {
    $instance->LoadWinner();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
