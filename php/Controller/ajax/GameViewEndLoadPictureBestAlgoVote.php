<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

/**
 * Class GameViewEndLoadPictureBestAlgoVote
 */
class GameViewEndLoadPictureBestAlgoVote{
    private $gameEndController;

    /**
     * Constructor of GameViewEndLoadPictureBestAlgoVote
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Load best picture rated by the algorithm
     */
    public function loadPicture(){
        $picture = $this->gameEndController->getSketchBestAlgorithm();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPictureBestAlgoVote();
try {
    $instance->loadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
