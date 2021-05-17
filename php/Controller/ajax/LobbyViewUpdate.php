<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

/**
 * Class LobbyViewAjaxData
 * 
 * Used as ajax data container
 */
class LobbyViewAjaxData{
    public $state;
    public $voteTime;
    public $startTime;
    public $drawTime;
    public $maxPlayer;
    public $joinCode;
    public $players;
}

/**
 * Class LobbyViewAjaxUpdate
 */
class LobbyViewAjaxUpdate{

    /**
     * Ajax Update functio to get data from Model
     * @return LobbyViewAjaxData object with data
     */
    public function getData(){

        ini_set('display_errors', 1); 
        error_reporting(E_ALL);

        $lobbycontroller = new LobbyController();

        $players = $lobbycontroller->getPlayersOfLobby($_GET['joincode']);
        $JSONplayers = array();
        foreach ($players as $player) {
            array_push($JSONplayers,$player->getName());
        }
           
        $result = new LobbyViewAjaxData();
        $result->state = $lobbycontroller->getState($_GET['joinCode']);
        $result->voteTime =$lobbycontroller->getVoteTime($_GET['joinCode']);
        $result->startTime =$lobbycontroller->getStartTime($_GET['joinCode']);
        $result->drawTime =$lobbycontroller->getDrawTime($_GET['joinCode']);
        $result->maxPlayer = $lobbycontroller->getMaxPlayers($_GET['joinCode']);
        $result->joinCode = $_GET['joinCode'];
        $result->players = array_values($JSONplayers);

        return $result;
    }
}

$testclass = new LobbyViewAjaxUpdate();
try {
    echo json_encode($testclass->getData());
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}
