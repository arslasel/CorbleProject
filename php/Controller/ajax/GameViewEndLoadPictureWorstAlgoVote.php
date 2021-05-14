<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseConnection.php");

class GameViewEndLoadPictureWorstAlgoVote
{

    private $databaseConnection;
    private $corbleDatabase;

    public function __construct(){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
    }

    public function LoadPicture()
    { 
        $picture = $this->corbleDatabase->getSketchWorstAlgorithm($_GET["username"]);//In der $_Get-Klammer muss noch spezifiziert werden
        echo $picture;
    }
}

$instance = new GameViewEndLoadPictureWorstAlgoVote();
try {
    $instance->LoadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}