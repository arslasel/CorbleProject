<?php
    class LobbyModel{
        private $nameLobby;
        
        public function __construct(){
            
        }
        
        public function setName($nameLobby){
            $this->nameLobby = $nameLobby;
        }
        
        public function getName(){
            return $this->nameLobby .$this->nameLobby;
        }
    }
?>