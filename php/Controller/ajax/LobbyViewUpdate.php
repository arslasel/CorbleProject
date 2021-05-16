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

        $dbLib = new DatabaseLibrary(new DatabaseConnection());
        $result = $dbLib->readLobbyDataFromDB($_GET['joincode']);

        if($result){
            $row = $result->fetch_assoc();
        
            $players = $dbLib->getPlayersOfLobby($row['indx']);
            $JSONplayers = array();
            foreach ($players as $player) {
                array_push($JSONplayers,$player->getName());
            }
            
            $result = new LobbyViewAjaxData();
            $result->state = $row["state"];
            $result->votetime = $row["votetime"];
            $result->starttime = $row["starttime"];
            $result->drawtime = $row["drawtime"];
            $result->maxplayer = $row["maxplayer"];
            $result->joincode = $row["joincode"];
            $result->players = array_values($JSONplayers);

            return $result;
        }

        return 0;
    }
}

$testclass = new LobbyViewAjaxUpdate();
try {
    echo json_encode($testclass->getData());
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}
