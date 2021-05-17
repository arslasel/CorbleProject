<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

class LobbyViewJoin{
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