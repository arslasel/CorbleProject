<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/RoundModel.php");

class GameViewSubmitImage
{

    public function submitImage()
    {
        $io = new RoundModel(new DatabaseLibrary(new DatabaseConnection));

        
        echo $io->savePicture(
            file_get_contents($_FILES['imageBase64']['tmp_name']),
            197,//lobby
            1,//round
            213,//user
            2);//round
    }
}

$instance = new GameViewSubmitImage();
try {
    $instance->submitImage();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
