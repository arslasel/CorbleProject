<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/PlayerModel.php");

class LobbyViewAjaxData{
    public $state;
    public $votetime;
    public $starttime;
    public $drawtime;
    public $maxplayer;
    public $joincode;
    public $players;
}

class LobbyViewAjaxUpdate{

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
        $result->state = $lobbycontroller->getState($_GET['joincode']);
        $result->votetime =$lobbycontroller->getVoteTime($_GET['joincode']);
        $result->starttime =$lobbycontroller->getStartTime($_GET['joincode']);
        $result->drawtime =$lobbycontroller->getDrawTime($_GET['joincode']);
        $result->maxplayer = $lobbycontroller->getMaxPlayers($_GET['joincode']);
        $result->joincode =$lobbycontroller->getJoinCode($_GET['joincode']);
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

?>