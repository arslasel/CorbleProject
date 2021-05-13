<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/LobbyModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/WordpoolModel.php");
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

        public function createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools,$username){
            return $this->lobbyModel->createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools,$username);
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