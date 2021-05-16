<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

class GameViewEndLoadPictureWorstAlgoVote{}
    private $gameEndController;

    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    public function LoadPicture(){
        $picture = $this->gameEndController->getSketchWorstAlgorithm();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPictureWorstAlgoVote();
try {
    $instance->LoadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}