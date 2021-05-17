<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/LobbyController.php");

/**
 * Class LobbyViewLoadwordPoolsData
 * 
 * Used as ajax data container
 */
class LobbyViewLoadwordPoolsData{
    public $index;
    public $name;
}

/**
 * Class LobbyViewLoadWordPools
 */
class LobbyViewLoadWordPools{

    /**
     * Function for Ajax to load WordPools
     */
    public function loadWordPools(){
        $lobbyController = new LobbyController();
        $wordPools = $lobbyController->getWordPools();
        $jsonArray = array();
        foreach ($wordPools as $wordpool) {
            $json = new LobbyViewLoadWordPoolsData();
            $json->index = $wordpool->getIndex();
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
