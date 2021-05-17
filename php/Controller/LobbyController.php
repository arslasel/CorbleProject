<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/LobbyModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/WordpoolModel.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/php/Controller/RoundController.php");

    class LobbyController{

        private $lobbyModel;
        private $corbleDatabase;
        private $databaseConnection;

        /**
         * LobbyController constructor
         */
        public function __construct(){
            $this->databaseConnection = new DatabaseConnection();
            $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
            
            $this->lobbyModel = new LobbyModel($this->corbleDatabase,$this->databaseConnection);
        }

        /**
         * Login a new user to the database
         * @param string userName of current user to be added
         */
        public function login($userName){
            return $this->lobbyModel->login($userName);
        }

        /**
         * Get all wordpools available on the corble database
         * @return array Array with wordpools of lobby
         */
        public function getWordPools(){
            return WordpoolModel::getWordPools($this->corbleDatabase);
        }

        /**
         * Create a new lobby with given parameters
         * @param int $voteTime Time to vote for a sketch
         * @param int $drawTime Time to draw a sketch
         * @param int $startTime Time to start the game
         * @param int $maxPlayer Maximum amount of players
         * @param $wordpools array Choosen wordpool categories
         */
        public function createLobby($voteTime, $drawTime, $startTime, $maxPlayer, $wordpools, $userName){
            $joinCode = $this->lobbyModel->createLobby($voteTime, $drawTime, $startTime, $maxPlayer, $wordpools, $userName);
            $lobbyIndex = $this->lobbyModel->getLobbyIndexByjoinCode($joinCode);
            $wordPoolsOfLobby = $this->lobbyModel->getWordpoolIdsofLobby($lobbyIndex);

            $rand = rand(0,count($wordPoolsOfLobby)-1);
            $round1 = new RoundController();
            $roundId = $round1->createRound($this->lobbyModel->getLobbyIndexByjoinCode($joinCode),$wordpools[$rand]);
            return array($joinCode, $roundId);
        }

        /**
         * Join a lobby to with a joind code and a username 
         * @param int Joincode to to access a lobby
         * @param string Username to join
         * @return 
         */
        public function joinLobby($joinCode, $userName){
            return $this->lobbyModel->joinLobby($joinCode,$userName,false);
        }

        /**
         * Get State of lobby
         * @param int $joinCode Join Code to get the state from 
         * @return string state of lobby
         */
        public function getState($joinCode){
            $this->lobbyModel->readLobbyDataFromDB($joinCode, $this->corbleDatabase->getLobbyIndexByjoinCode($joinCode));
            return $this->lobbyModel->getState();
        }

        /**
         * Get vote time of lobby
         * @param int $joinCode Join Code to get the state from 
         * @return int Vote time of lobby
         */
        public function getVoteTime($joinCode){
            $this->lobbyModel->readLobbyDataFromDB($joinCode, $this->corbleDatabase->getLobbyIndexByjoinCode($joinCode));
            return $this->lobbyModel->getVoteTime();
        } 

        /**
         * Get start time of lobby
         * @param int $joinCode Join Code to get the state from 
         * @return int start time of lobby
         */
        public function getStartTime($joinCode){
            $this->lobbyModel->readLobbyDataFromDB($joinCode, $this->corbleDatabase->getLobbyIndexByjoinCode($joinCode));
            return $this->lobbyModel->getStartTime();
        }     
        
        /**
         * Get draw time of lobby
         * @param int $joinCode Join Code to get the state from 
         * @return int draw time of lobby
         */        
        public function getDrawTime($joinCode){
            $this->lobbyModel->readLobbyDataFromDB($joinCode, $this->corbleDatabase->getLobbyIndexByjoinCode($joinCode));
            return $this->lobbyModel->getDrawTime();
        }             

        /**
         * Return maximum amount of players
         * @param int $joinCode Join Code to get the state from 
         * @return int maximum amount of players
         */
        public function getMaxPlayers($joinCode){
            $this->lobbyModel->readLobbyDataFromDB($joinCode, $this->corbleDatabase->getLobbyIndexByjoinCode($joinCode));
            return $this->lobbyModel->getMaxPlayers();
        }             

         /**
         * Get players of lobby
         * @param int $joinCode Join Code to get the state from 
         * @return array with players of a given lobby
         */
        public function getPlayersOfLobby($joinCode){
            return $this->lobbyModel->getPlayersOfLobby($this->corbleDatabase->getLobbyIndexByjoinCode($joinCode));
        }

    }
    return;
?>