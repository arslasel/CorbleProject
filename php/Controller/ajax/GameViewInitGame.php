<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
    class GameViewInitGame{
        public function getDrawTime(){
            $dbCon = new DatabaseConnection(); 
            $dblib = new DatabaseLibrary($dbCon);
            $joinCode = $_GET["joincode"];
            return $dblib->getDrawTime($joinCode);
        }        
    }
    $instance = new GameViewInitGame();
    try {
        echo json_encode($instance->getDrawTime(), JSON_NUMERIC_CHECK);
    }
    catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
?>
