<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/RoundController.php");

/**
 * Class GameViewSubmitImage
 */
class GameViewSubmitImage{

    /** 
     * Function to submit an image to the database
     */
    public function submitImage(){
        $roundController = new RoundController();
        $sketchID = $roundController->saveSketch($_FILES['imageBase64']['tmp_name'], $_POST['lobby_joincode'], $_POST['lobby_username'], $_POST["start_roundID"]);
        $roundController->rateSketch($sketchID, $_POST["start_roundID"]);
    }
}

$instance = new GameViewSubmitImage();
try {
    $instance->submitImage();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
