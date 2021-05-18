<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/RoundController.php");

class GameViewSubmitVote{

    public function submitVote(){
        $roundController = new RoundController();
        $roundController->sketchRateOfPlayer($_GET["sketchID"]);
    }
}

$instance = new GameViewSubmitVote();
try {
    $instance->submitVote();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
