<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/RoundController.php");

/**
 * Class GameViewVotePictureData
 */
class GameViewVotePictureData{
    public $dbIndex;
    public $path;
}

/**
 * Class GameViewVoteLoadPictures
 */
class GameViewVoteLoadPictures{
    private $roundController;
    /**
     * Constructor of class GameViewVoteLoadPictures
     */
    public function __construct(){
        $this->roundController = new RoundController();
    }

    /** 
    * Function to load a pictures to vote 
    */
    public function loadPicture(){ 
        $jsonarray = array();
        $pictureArray = $this->roundController->getAllSketchesToVote($_GET['start_roundID'], $_GET['username']);
        $pictureCount = 0;
        foreach ($pictureArray as $picture) {
            $jsonPicture = new GameViewVotePictureData();
            $jsonPicture->dbIndex = $pictureCount;
            $pictureCount = $pictureCount + 1;
            $jsonPicture->path = $picture[0];
            array_push($jsonarray,$jsonPicture);
        }
        echo json_encode($jsonarray);
    }
}

$instance = new GameViewVoteLoadPictures();
try {
    $instance->loadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
