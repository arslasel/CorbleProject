<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

class LobbyViewCreateLobbyJSONData{
    public $joincode;
    public $roundID;
}

/**
 * Class LobbyViewCreateLobby
 */
class LobbyViewCreateLobby{

    /**
    * Function to create a new lobby
    * @return int joincode of lobby
    */
    public function createLobby(){
        $lobbyController = new LobbyController();

        $wordpools = array();
        foreach ($_GET['wordpools'] as $wordpool) {
            array_push($wordpools,$wordpool);
        }

        list($joincode,$roundID) = $lobbyController->createLobby(
            $_GET['drawtime'],
            $_GET['votetime'],
            $_GET['starttime'], 
            $_GET['maxplayer'], 
            $wordpools,
            $_GET['username']);

        $json = new LobbyViewCreateLobbyJSONData();
        $json->joincode = $joincode;
        $json->roundID = $roundID;
        
        return $json;
    }
}

$instance = new LobbyViewCreateLobby();
try {
    echo json_encode($instance->createLobby());
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}

