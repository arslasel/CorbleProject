<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

class LobbyViewLoadWordPoolsData{
    public $index;
    public $name;
}

class LobbyViewLoadWordPools{

    public function loadWordPools(){
        $lobbyController = new LobbyController();
        $wordpools = $lobbyController->getWordPools();
        $jsonArray = array();
        foreach ($wordpools as $wordpool) {
            $json = new LobbyViewLoadWordPoolsData();
            $json->index = $wordpool->getIndx();
            $json->name = $wordpool->getName();
            array_push($jsonArray,$json);
        }   
        echo json_encode($jsonArray);
    }

    
}

$instance = new LobbyViewLoadWordPools();
try {
    $instance->loadWordPools();
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}
