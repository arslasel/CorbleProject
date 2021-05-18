<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/PlayerModel.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/WordpoolModel.php");
/**
 * Class LobbyModel 
 */
class LobbyModel
{
    private $corbleDatabase;
    private $databaseConnection;

    private $UserName;

    private $lobbyIndex;
    private $votetime;
    private $drawtime;
    private $starttime;
    private $maxplayer;
    private $joincode;
    private $state;
    private $wordpools = array();
    private $players = array();

    private $starttimeUNIX;

    /**
     * LobbyModel constructor.
     * @param CorbleDatabase Object Database Libary
     * @param DatabaseConnection Object Database Connection
     */
    public function __construct($corbleDatabase,$databaseConnection){
        $this->databaseConnection = $databaseConnection;
        $this->corbleDatabase = $corbleDatabase;
    }

    /**
     * Log in a new username
     * @param string String username to be logged in to the database
     * @return bool Returns true if the user is successfully logged in.
     */
    public function login($userName){
        if ($this->corbleDatabase->checkIfUserExists($userName)) {
            return false;
        } else {
            $result = $this->corbleDatabase->insertUser($userName);
            if ($result != 0) {
                $_SESSION["lobby_username"] = $userName;
                return true;
            }
            return false;
        }
    }

    /**
     * Reads parameters of lobby from database taken single by getter
     * @param int JoinCode to write to database
     * @param int lobbyIndex to of current lobby
     */
    public function readLobbyDataFromDB($joinCode, $lobbyIndex){
        $queryResult = $this->corbleDatabase->readLobbyDataFromDB($joinCode);

        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
                $this->state = $row["state"];
                $this->votetime = $row["votetime"];
                $this->starttime = $row["starttime"];
                $this->drawtime = $row["drawtime"];
                $this->maxplayer = $row["maxplayer"];
                $this->joincode = $row["joincode"];
                $this->players = $this->getPlayersOfLobby($lobbyIndex);

                break;
            }
        }
    }

    /**
     * Join an existing lobby with a player and add information of the player is the party leader
     * @param int $joincode String Join-code of lobby
     * @param bool $isPartyLeader boolean Is the player the party leader
     * @param string String Username of player to be entered into the corble database
     */
    public function joinLobby($joincode, $username, $isPartyLeader){
        $playerIndex = PlayerModel::getPlayerIndexByName($this->corbleDatabase, $username);
        $lobbyIndex = $this->getLobbyIndexByJoincode($joincode);
        $partyLeaderString = "";
        if ($isPartyLeader == true) {
            $partyLeaderString = "TRUE";
        } else {
            $partyLeaderString = "FALSE";
        }

        if ($lobbyIndex != 0 && $playerIndex != 0) {
             return $this->corbleDatabase->addPlayerToLobby($playerIndex, $lobbyIndex, $partyLeaderString);
        }
        return 0;
    }
    
     /**
     * Method to save a new lobby into the corble database
     * @param int Time to vote for a sketch
     * @param int Time to draw a sketch
     * @param int Start time of lobby
     * @param int Maximum amount of players
     * @param array Choosen wordpools for lobby
     */
    public function createLobby($votetime, $drawtime, $starttime, $maxplayer, $wordpools, $username){
        $this->votetime = $votetime;
        $this->drawtime = $drawtime;
        $this->starttime = $starttime;
        $this->maxplayer = $maxplayer;
        $this->wordpools = $wordpools;
        $this->UserName = $username;

        $this->generateLobbyDatabaseEntry();
        $this->joinLobby($this->joincode, $username, true);

        return $this->joincode;
    }

    /**
     * Add the chosen wordpools to the database
     */
    public function addWordCategoriesToLobby(){
        $this->corbleDatabase->addWordCategoriesToLobby($this->wordpools, $this->lobbyIndex);
    }

    /**
     * Get the lobby index by a given joincode
     * @param int String Joincode of lobby
     * @return mixed Returns the database index of the lobby
     */
    public function getLobbyIndexByJoincode($joincode){
        return $this->corbleDatabase->getLobbyIndexByJoincode($joincode);
    }

    /**
     * Get the players of the current lobby
     * @param int String Database index of current lobby
     * @return mixed Returns an array with all players of current lobby
     */
    public function getPlayersOfLobby($lobbyIndex){
        return $this->corbleDatabase->getPlayersOfLobby($lobbyIndex);
    }

    /**
     * Returns all chosen Wordools of the current lobby
     * @param int index of lobby
     * @return mixed returns database output with 
     */
    public function getWordpoolsOfLobby($lobbyIndex){
        return $this->corbleDatabase->getWordpoolsOfLobby($lobbyIndex);
    }

    /**
     * Get Wordpool Indexes of given lobby
     * @param int Index of lobby
     * @return mixed array with indexs of Wordpool for given lobby
     */
    public function getWordpoolIdsOfLobby($lobbyIndex){
        return $this->corbleDatabase->getWordpoolIdsOfLobby($lobbyIndex);
    }

    /**
    * Get Wordpool Indexes of given lobby
    * @param int Index of lobby
    * @return mixed array with indexs of Wordpool for given lobby
    */
    public function getRoundIndexFromLobby($lobbyIndex){
    return $this->corbleDatabase->getRoundIndexFromLobby($lobbyIndex);
    }

    //*************************************************************************
    // Getters
    //*************************************************************************

    /**
     * Set username of current user
     * @param string String with name of current user
     */
    public function setUserName($UserName){
        $this->UserName = $UserName;
    }

    /**
     * Getter for username
     * @return string Returns username of current user
     */
    public function getUserName(){
        return $this->UserName;
    }

    /**
     * Getter for state of lobby
     * @return string State of current lobby
     */
    public function getState(){
        return $this->state;
    }

    /**
     * Getter for time to vote for a sketch
     * @return int Time to vote for a sketch
     */
    public function getVoteTime(){
        return $this->votetime;
    }

    /**
     * Getter for start time of lobby
     * @return int Start time of lobby
     */
    public function getStartTime(){
        return $this->starttime;
    }

    /**
     * Getter for time to draw a sketch
     * @return int Time to draw a sketch
     */
    public function getDrawTime(){
        return $this->drawtime;
    }

    /**
     * Return maximum amount of player in the lobby
     * @return int Maximum amount of players
     */
    public function getMaxPlayers(){
        return $this->maxplayer;
    }

    /**
     * Getter for Join code of lobby
     * @return int Returns join code of lobby
     */
    public function getJoinCode(){
        return $this->joincode;
    }

    /**
     * Getter for array with current players
     * @return array Name of current players
     */
    public function getPlayers(){
        return $this->players;
    }
    
    //*************************************************************************
    // Private Methods
    //*************************************************************************
    private function generateLobbyDatabaseEntry(){
        do {
            $this->joincode = rand(100000, 999999);
        } while ($this->corbleDatabase->checkIfJoinCodeExists($this->joincode));

        $date = new DateTime();
        $this->starttimeUNIX = $date->getTimestamp() + $this->starttime;

        $playerIndex = PlayerModel::getPlayerIndexByName($this->corbleDatabase, $this->UserName);
        $insertID = $this->corbleDatabase->generateLobby($this->votetime, $this->drawtime, $this->starttimeUNIX, $this->maxplayer, $this->joincode, $playerIndex);

        if ($insertID != 0) {
            $this->lobbyIndex = $insertID;
        }
        $this->addWordCategoriesToLobby();
    }
}

return;
