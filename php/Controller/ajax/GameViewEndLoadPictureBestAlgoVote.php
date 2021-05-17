<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

class GameViewEndLoadPictureBestAlgoVote{
    private $gameEndController;

    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    public function LoadPicture(){
        $picture = $this->gameEndController->getSketchBestAlgorithm();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPictureBestAlgoVote();
try {
    $instance->LoadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
