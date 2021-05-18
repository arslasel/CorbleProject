<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php");

/**
 * Class GameViewEndLoadPictureWinnerVote
 * 
 */
class GameViewEndLoadPictureWinnerVote{
    private $gameEndController;

    /**
     * Constructor for class GameViewEndLoadPictureWinnerVote
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Load best voted picture from database 
     */
    public function LoadPicture(){ 
        $picture = $this->gameEndController->getSketchBestVoted();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPictureWinnerVote();
try {
    $instance->LoadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
