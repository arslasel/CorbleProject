<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

class GameViewEndLoadPlayerNameWorstAlgoVote{
    private $gameEndController;

    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    public function LoadName()
    { 
        $picture = $this->gameEndController->getPlayerWithWorstVotedSketch();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPlayerNameWorstAlgoVote();
try {
    $instance->LoadName();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}