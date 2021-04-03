<?php
    class LobbyModel{
        private $UserName;//name of the current user
        
        public function __construct(){
            
        }
        
        public function login($UserName){
            return false;
        }

        public function setUserName($UserName){
            $this->UserName = $UserName;
        }
        
        public function getUserName(){
            return $this->UserName;
        }
    }
?>