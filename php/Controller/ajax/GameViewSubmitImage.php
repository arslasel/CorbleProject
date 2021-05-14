<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/IOModel.php");

class GameViewSubmitImage
{

    public function submitImage()
    {
        $io = new IOModel();

        /*

        THIS CODE WORKS

        foreach ($_POST as $key => $value) {
            echo "--------";
            echo $key;
            echo "--";
            echo $value;
            echo "--------";
        }

        echo "FILENAME" . $_FILES['imageBase64']['name'];

        $filename = $_FILES['imageBase64']['name'];

        $location = "upload/" . $filename;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);

        if (move_uploaded_file($_FILES['imageBase64']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/php/Controller/ajax/upload")) {
            $response = $location;
        }

        echo "respose" . $response ;
        */

        echo $io->savePicture(file_get_contents($_FILES['imageBase64']['tmp_name']),222,111,111);
    }
}

$instance = new GameViewSubmitImage();
try {
    $instance->submitImage();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
