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
    }
?>