<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php");

/**
 * Class GameViewEndLoadPlayerNamePictureVote
 */
class GameViewEndLoadPlayerNamePictureVote{
    private $gameEndController;

    /**
     * Constructor of class GameViewEndLoadPlayerNamePictureVote
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Function to load player with best voted sketch
     */
    public function loadPlayerName(){ 
        $playerName = $this->gameEndController->getPlayerWithBestVotedSketch();
        echo $playerName;
    }
}

$instance = new GameViewEndLoadPlayerNamePictureVote();
try {
    $instance->loadPlayerName();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
