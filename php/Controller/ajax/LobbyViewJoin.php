<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

/**
 * Class LobbyViewJoin
 */
class LobbyViewJoin{
    /**
     * Function to join a lobby 
     */
    public function join(){
        $lobbyController = new LobbyController();
        $lobbyController->joinLobby($_GET['joincode'],$_GET['username']);
    }
}

$instance = new LobbyViewJoin();
try {
    $instance->join();
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}
?>