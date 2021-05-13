<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

class LobbyViewCreateLobby{

    public function createLobby(){
        $lobbyController = new LobbyController();

        $wordpools = array();
        foreach ($_GET['wordpools'] as $wordpool) {
            array_push($wordpools,$wordpool);
        }

        $joincode = $lobbyController->createLobby(
            $_GET['drawtime'],
            $_GET['votetime'],
            $_GET['starttime'], 
            $_GET['maxplayer'], 
            $wordpools,
            $_GET['username']);
        
        return $joincode;
    }

    
}

$instance = new LobbyViewCreateLobby();
try {
    echo json_encode($instance->createLobby());
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}

?>