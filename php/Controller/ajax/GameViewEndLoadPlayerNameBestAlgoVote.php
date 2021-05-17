<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

/**
 * Class GameViewEndLoadPlayerNameBestAlgoVote 
 */
class GameViewEndLoadPlayerNameBestAlgoVote{
    private $gameEndController;
    
    /**
     * Constructor for class GameViewEndLoadPlayerNameBestAlgoVote
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Functio to load winner of lobby
     */
    public function loadWinner(){ 
        $winnerName = $this->gameEndController->getPlayerWithBestAlogrithmSketch();
        echo $winnerName;
    }
}

$instance = new GameViewEndLoadPlayerNameBestAlgoVote();
try {
    $instance->loadWinner();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
