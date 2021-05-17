<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

/**
 * Cass LobbyViewLogin
 */
class LobbyViewLogin{

    /**
     * Function for Ajax to logon user
     */
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
?>
