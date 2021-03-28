<?php
    include("../Model/LobbyModel.php");
    class LobbyController{
        private $lobbyModel;
        
        public function __construct(){
            $this->lobbyModel = new LobbyModel();
        }
        
        public function helloWorld($name){
            $this->lobbyModel->setName($name);
            return $this->lobbyModel->getName();
        }
    }
?>