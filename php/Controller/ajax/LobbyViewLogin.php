<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

class LobbyViewLogin{

    public function login(){
        $lobbyController = new LobbyController();

        $returnOfHW = $lobbyController->login($_GET['username']);
        if ($returnOfHW == false) {
            echo "username taken";
        }else{    
            echo "success";
        }
    }

    
}

$instance = new LobbyViewLogin();
try {
    $instance->login();
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}
