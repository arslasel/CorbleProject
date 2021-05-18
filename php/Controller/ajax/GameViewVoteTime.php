<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Controller/RoundController.php");

    /**
     * Class GameViewInitGame
     */
    class GameViewInitGame{

        /**
         * Get Draw time for ajax
         */
        public function getVoteTime(){
            $roundController = new RoundController();
            return $roundController->getVoteTime($_GET["joincode"]);
        }        
    }

    $instance = new GameViewInitGame();
    try {
        echo json_encode($instance->getVoteTime(), JSON_NUMERIC_CHECK);
    }
    catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
?>
