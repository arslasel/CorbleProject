<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/LobbyModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/WordpoolModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/RoundController.php");

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
            $joincode = $this->lobbyModel->createLobby($votetime,$drawtime,$starttime,$maxplayer,$wordpools,$username);
            $lobbyIndex = $this->lobbyModel->getLobbyIndxByJoincode($joincode);
            $wordPoolsOfLobby = $this->lobbyModel->getWordpoolIdsofLobby($lobbyIndex);

            $rand = rand(0,count($wordPoolsOfLobby)-1);
            $round1 = new RoundController();
            $round1->createRound($this->lobbyModel->getLobbyIndxByJoincode($joincode),3);//$wordpools[$rand]
            return $joincode;
        }

        public function joinLobby($joincode,$username){
            return $this->lobbyModel->joinLobby($joincode,$username,false);
        }

        public function readLobbyDataFromDB(){
            $this->lobbyModel->readLobbyDataFromDB();
            return $this->lobbyModel;
        }
    }
    return;
?>