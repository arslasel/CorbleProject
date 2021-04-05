<?php
    include_once("../Model/LobbyModel.php");
    include_once("../Model/WordpoolModel.php");
    class LobbyController{
        private $lobbyModel;
        
        public function __construct(){
            $this->lobbyModel = new LobbyModel();
        }
        
        public function login($username){
            return $this->lobbyModel->login($username);
        }

        public function getWordPools(){
            return WordpoolModel::getWordPools();
        }

        public function createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools){
            return $this->lobbyModel->createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools);
        }

        public function readLobbyDataFromDB(){
            $this->lobbyModel->readLobbyDataFromDB();
            return $this->lobbyModel;
        }
    }
    return;
?>