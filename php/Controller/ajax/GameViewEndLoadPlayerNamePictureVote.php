<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

class GameViewEndLoadPlayerNamePictureVote{
    private $gameEndController;

    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    public function LoadPlayerName(){ 
        $playerName = $this->gameEndController->getPlayerWithBestVotedSketch();
        echo $playerName;
    }
}

$instance = new GameViewEndLoadPlayerNamePictureVote();
try {
    $instance->LoadPlayerName();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
