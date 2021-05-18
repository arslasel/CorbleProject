<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php");

/**
 * Class GameViewEndLoadPlayerNameWorstAlgoVote
 */
class GameViewEndLoadPlayerNameWorstAlgoVote{
    private $gameEndController;

    /**
     * Constructor of class GameViewEndLoadPlayerNameWorstAlgoVote
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Function to load name of palyer with worst voted sketch
     */
    public function loadName(){ 
        $picture = $this->gameEndController->getPlayerWithWorstVotedSketch();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPlayerNameWorstAlgoVote();
try {
    $instance->loadName();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
