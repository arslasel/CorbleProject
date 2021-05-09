<?php
    include_once("../Model/LobbyModel.php");
    include_once("../Model/WordpoolModel.php");
    class LobbyController{
        private $lobbyModel;
        private $corbleDatabase;
        private $databaseConnection;
        
        public function __construct(){
            $this->databaseConnection = new DatabaseConnection();
            $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
            
            $this->lobbyModel = new LobbyModel($this->corbleDatabase,$this->databaseConnection);
        }
        
        public function login($username){
            return $this->lobbyModel->login($username);
        }

        public function getWordPools(){
            return WordpoolModel::getWordPools($this->corbleDatabase);
        }

        public function createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools){
            return $this->lobbyModel->createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools);
        }

        public function joinLobby($joincode){
            return $this->lobbyModel->joinLobby($joincode,$_SESSION["lobby_username"],false);
        }

        public function readLobbyDataFromDB(){
            $this->lobbyModel->readLobbyDataFromDB();
            return $this->lobbyModel;
        }
    }
    return;
?>