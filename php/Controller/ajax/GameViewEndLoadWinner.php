<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

class GameViewEndLoadWinner{
    private $gameEndController;

    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    public function LoadWinner()
    {
        $winnerName = $this->gameEndController->getWinner();
        echo $winnerName;
    }
}

$instance = new GameViewEndLoadWinner();
try {
    $instance->LoadWinner();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
