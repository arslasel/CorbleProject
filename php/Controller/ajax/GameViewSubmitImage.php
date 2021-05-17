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
        $roundController->saveSketch($_FILES['imageBase64']['tmp_name'], $_GET['joincode'], $_GET['username']);
    }
}

$instance = new GameViewSubmitImage();
try {
    $instance->submitImage();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
