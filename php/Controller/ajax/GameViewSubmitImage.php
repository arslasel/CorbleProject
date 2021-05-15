<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/IOModel.php");

class GameViewSubmitImage
{

    public function submitImage()
    {
        $io = new IOModel();

        
        echo $io->savePicture(file_get_contents($_FILES['imageBase64']['tmp_name']),222,111,111);
    }
}

$instance = new GameViewSubmitImage();
try {
    $instance->submitImage();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
