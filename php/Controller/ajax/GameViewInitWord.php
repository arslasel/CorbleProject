<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Controller/RoundController.php");

    /**
     * Class GameViewInitWord
     */
    class GameViewInitWord{

        /**
         * Get Draw time for ajax
         */
        public function getWordToDraw(){
            $roundController = new RoundController();
            return $roundController->getWordNameController($_GET["roundIndex"]);
        }        
    }

    $instance = new GameViewInitWord();
    try {
        echo $instance->getWordToDraw();
    }
    catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
?>
