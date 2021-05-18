<?php

include_once($_SERVER['DOCUMENT_ROOT']."/php/Model/DatabaseLibrary.php");

/**
 * Class GameEndModel
 *
 * Methods for GameEnd view and usecase of corble application
 */
class GameEndModel{
    private $lobbyIndex;
    private $corbleDatabase;

    /**
     * Constructor of GameEndModel with a given database and lobbyindex
     */
    public function __construct($corbleDatabase, $lobbyIndex){
        $this->lobbyIndex = $lobbyIndex;
        $this->corbleDatabase = $corbleDatabase;
    }

    /**
     * Returns the name of the player with the best voted sketch
     * @return string Name of player with the best vote sketch
     */
    public function getPlayerWithBestVotedSketch(){
        return $this->corbleDatabase->getPlayerWithBestVotedSketch($this->lobbyIndex);
    }

    /**
     * Returns the name of the player with the best voted sketch by the algorithm
     * @return string Name of player
     */
    public function getPlayerWithBestAlogrithmSketch(){
        return $this->corbleDatabase->getPlayerWithBestAlogrithmSketch($this->lobbyIndex);
    }

    /**
     * Return name of player with worst aloritm name 
     * @return string with name of player 
     */
    public function getPlayerWithWorstAlogrithmSketch(){
        return $this->corbleDatabase->getPlayerWithWorstAlogrithmSketch($this->lobbyIndex);
    }

    /**
     * Returns the path to the best voted sketch
     * @return string Path to the sketch that is the best voted sketch
     */
    public function getSketchBestVoted(){
        return $this->corbleDatabase->getSketchBestVoted($this->lobbyIndex);
    }

    /**
     * Returns the path to the worst voted sketch by the alrogritm
     * @return string Path to the sketch
     */
    public function getSketchWorstAlgorithm(){
        return $this->corbleDatabase->getSketchWorstAlgorithm($this->lobbyIndex);
    }

    /**
     * Returns the path to the sketch that is the best voted by the algorithm
     * @return string Path to the sketch
     */
    public function getSketchBestAlgorithm(){
        return $this->corbleDatabase->getSketchBestAlgorithm($this->lobbyIndex);
    }

    /**
     * Returns the winner of the current lobby
     * @return string Name of the payer
     */
    public function getWinner(){
        return $this->corbleDatabase->getWinner($this->lobbyIndex);
    }
}