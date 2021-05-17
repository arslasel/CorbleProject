<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Controller/RoundController.php");

    /**
     * Class GameViewInitGame
     */
    class GameViewInitGame{

        /**
         * Get Draw time for ajax
         */
        public function getDrawTime(){
            $roundController = new RoundController();
            return $roundController->getDrawTime($_GET["joincode"]);
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
