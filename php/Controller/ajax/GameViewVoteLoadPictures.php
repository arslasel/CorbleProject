<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseConnection.php");

class GameViewVotePictureData{
    public $dbIndex;
    public $path;
}


class GameViewVoteLoadPictures
{
    private $databaseConnection;
    private $corbleDatabase;

    public function __construct(){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
    }

    public function LoadPicture()
    { 
        $jsonarray = array();
        $pictureArray = $this->corbleDatabase->getAllSketches(1,158);//insert real id here
        foreach ($pictureArray as $picture) {
            $jsonPicture = new GameViewVotePictureData();
            $jsonPicture->dbIndex = $picture[1];
            $jsonPicture->path = $picture[0];
            array_push($jsonarray,$jsonPicture);
        }
        echo json_encode($jsonarray);
    }
}

$instance = new GameViewVoteLoadPictures();
try {
    $instance->LoadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
