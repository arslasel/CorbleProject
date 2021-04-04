<?php
    include("../Model/LobbyModel.php");
    class LobbyController{
        private $lobbyModel;
        
        public function __construct(){
            $this->lobbyModel = new LobbyModel();
        }
        
        public function login($username){
            return $this->lobbyModel->login($username);
        }

        public function getWordPools(){
            return $this->lobbyModel->getWordPools();
        }

        public function createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools){
            return $this->lobbyModel->createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools);
        }
    }
    return;
?>