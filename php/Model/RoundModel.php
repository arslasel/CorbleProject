<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/PlayerModel.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/IOModel.php");


/**
 * Class RoundModel 
 * 
 * Functions for the round 
 */
class RoundModel
{
    private $corbleDatabase;

    /**
     * RoundModel constructor.
     * @param CorbleDatabase Object Database connection
     */
    public function __construct($corbleDatabase){
        $this->corbleDatabase = $corbleDatabase;
    }

    /**
     * Save picture from player on database
     * @param string String with base64 coded picture to be saved as png
     * @param int Database lobby index
     * @param int Database round index
     * @param int Database player index
     */
    public function savePicture($base64, $lobbyIndex, $roundIndex, $playerIndex){
        $IoModel = new IOModel();
        $path = $IoModel->savePicture($base64, $lobbyIndex, $roundIndex, $playerIndex);
        if (!is_null($path)) {
            $sketchID = $this->corbleDatabase->savePicture($path, $playerIndex, 
                    $this->corbleDatabase->getWordIndexOfRound($roundIndex), $roundIndex);
            $this->corbleDatabase->insertSketchInRound($sketchID, $roundIndex);
            return $sketchID;
        }
    }

    /**
     * Adds a vote to a sketch (+1)
     * @param int Database index of scetch
     * TODO: Make this method thread-save
     */
    public function saveRatingFromPlayer($sketchIndex){
        $this->corbleDatabase->setVotes($this->corbleDatabase->getVotes($sketchIndex) + 1, $sketchIndex);
    }

    /**
     * Get all sketches as an array but not the one of the player (no possiblity to vote for the own sketch)
     * @param int Database index of the round
     * @param int Database index of the player
     * @return array|int Path to all sketches (but not the players one)
     */
    public function getAllSketches($roundIndex, $playerIndex){
        return $this->corbleDatabase->getAllSketches($roundIndex, $playerIndex);
    }

    /**
     * Returns the draw time for a lobby by the joincode
     * @param int Joincode of lobby
     * @return int time to draw a sketch
     */
    public function getDrawTime($joinCode){
        return $this->corbleDatabase->getDrawTime($joinCode);
    }

    /**
     * Returns the draw time for a lobby by the joincode
     * @param int Joincode of lobby
     * @return int time to draw a sketch
     */
    public function getVoteTime($joinCode){
        return $this->corbleDatabase->getVoteTime($joinCode);
    }

    /**
     * Get key-value array to display the leaderboard with name and score for each player
     * @param int Integer with index of lobby
     * @return array Key-Value table with player and score
     */
    public function getLeaderBoard($lobbyIndex){
        $players = array($this->corbleDatabase->getPlayersOfLobby($lobbyIndex));
        $leaderboard = array();
        foreach ($players as $player) {
            $playerScore = 0;
            $result = $this->corbleDatabase->getScoreOfPlayer($player::getIndex());
            foreach ($result as $res) {
                $playerScore = $playerScore + $res;
            }
            $leaderboard[$player::getName()] = $playerScore;
        }
        return arsort($leaderboard);
    }

    /**
     * Returns wordname of current round
     * @param int $roundIndex Index of current round
     * @return string name of word
     */
    public function getWordNameDatabase($roundIndex){
        return $this->corbleDatabase->getWordNameOfRound($roundIndex);
    }
}
