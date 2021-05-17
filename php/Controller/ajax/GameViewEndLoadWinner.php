<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

/**
 * Class GameViewEndLoadWinner
 */
class GameViewEndLoadWinner{
    private $gameEndController;

    /**
     * Constructor of class GameViewEndLoadWinner 
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Function to load name of winner of the game
     */
    public function loadWinner(){
        $winnerName = $this->gameEndController->getWinner();
        echo $winnerName;
    }
}

$instance = new GameViewEndLoadWinner();
try {
    $instance->loadWinner();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
