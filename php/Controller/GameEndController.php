<?php
include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/GameEndModel.php");

/**
 * Class GameEndController
 *
 * Methods and data for view and usecase GameEnd
 */
class GameEndController{
    private $lobbyIndex;
    private $databaseConnction;
    private $corbleDatabase;
    private $gameEndModel;

    /**
     * Create a new GameEnd controller with a given joincode
     * @param int JoinCode to create GameEndController
     */
    public function __construct($joinCode){
        $this->databaseConnection = new DatabaseConnection();
        $this->corbleDatabase = new DatabaseLibrary($this->databaseConnection);
        $this->lobbyIndex = $this->corbleDatabase->getLobbyIndexByJoinCode($joinCode);
        $this->gameEndModel = new GameEndModel($this->corbleDatabase, $this->lobbyIndex);
    }
    
    /**
     * Get the name of the player with
     * @return string Name of player
     */
    public function getPlayerWithBestVotedSketch(){
        return $this->gameEndModel->getPlayerWithBestVotedSketch();
    }

    /**
     * Returns name of player with best voted sketch by the algorithm
     * @return string Name of player
     */
    public function getPlayerWithBestAlogrithmSketch(){
        return $this->gameEndModel->getPlayerWithBestAlogrithmSketch();
    }

    /**
     * Returns name of player with the worst voted sketch by the algorithm
     * @return string Name of player
     */
    public function getPlayerWithWorstVotedSketch(){
        return $this->gameEndModel->getPlayerWithWorstAlogrithmSketch();
    }

    /**
     * Returns path to the best voted Sketch
     * @return string Path to the sketch
     */
    public function getSketchBestVoted(){
        return $this->gameEndModel->getSketchBestVoted();
    }

    /**
     * Returns path to the worst voted sketch by the algorithm
     * @return string Path to the sketch
     */
    public function getSketchWorstAlgorithm(){
        return $this->gameEndModel->getSketchWorstAlgorithm();
    }

    /**
     * Returns path to the best voted Sketch by the algorithm
     * @return string Path to the sketch
     */
    public function getSketchBestAlgorithm(){
        return $this->gameEndModel->getSketchBestAlgorithm();
    }

    /**
     * Name of player who is the winner of the game
     * @return string Name of player
     */
    public function getWinner(){
        return $this->gameEndModel->getWinner();
    }
}