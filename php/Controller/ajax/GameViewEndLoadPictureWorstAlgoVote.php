<?php

include_once($_SERVER['DOCUMENT_ROOT'] ."/php/Controller/GameEndController.php.php");

/**
 * Class GameViewEndLoadPictureWorstAlgoVote
 */
class GameViewEndLoadPictureWorstAlgoVote{
    private $gameEndController;

    /**
     * Constructor for class GameViewEndLoadPictureWorstAlgoVote
     */
    public function __construct(){
        $this->gameEndController = new GameEndController($_GET['joincode']);
    }

    /**
     * Load sketch with worst algorithm score
     */
    public function loadPicture(){
        $picture = $this->gameEndController->getSketchWorstAlgorithm();
        echo $picture;
    }
}

$instance = new GameViewEndLoadPictureWorstAlgoVote();
try {
    $instance->loadPicture();
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}
