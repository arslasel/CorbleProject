<?php
include_once("Database.php");
include_once("PlayerModel.php");
include_once("WordpoolModel.php");
class LobbyModel
{
    private $corbleDatabase;

    private $UserName; //name of the current user

    private $indx;
    private $votetime;
    private $drawtime;
    private $starttime;
    private $maxplayer;
    private $joincode;
    private $state;
    private $wordpools = array();
    private $players = array();

    private $starttimeUNIX;

    public function __construct($corbleDatabase)
    {
        $this->corbleDatabase = $corbleDatabase;
    }

    public function login($UserName)
    {
        // check if a user with the same name exists
        if(DatabaseLibrary::checkIfUserExists($UserName)){
            return false;
        } else { // there is no user with the same name continue login
            $insertID = DatabaseConnection::executeInsertQuery(
                "INSERT INTO tbl_player (name)VALUES ('" . $UserName . "')"
            );
            if ($insertID != 0) {
                $_SESSION["lobby_username"] = $UserName;
                return true;
            }
            return false;
        }

    }

    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }

    public function getUserName()
    {
        return $this->UserName;
    }

    public function getState(){
        return $this->state;
    }

    public function getVoteTime(){
        return $this->votetime;
    }

    public function getStartTime(){
        return $this->starttime;
    }

    public function getDrawTime(){
        return $this->drawtime;
    }

    public function getMaxPlayers(){
        return $this->maxplayer;
    }

    public function getJoinCode(){
        return $this->joincode;
    }

    public function getPlayers(){
        return $this->players;
    }

    public function createLobby($votetime, $drawtime, $starttime, $maxplayer, $wordpools)
    {
        $this->votetime = $votetime;
        $this->drawtime = $drawtime;
        $this->starttime = $starttime;
        $this->maxplayer = $maxplayer;
        $this->wordpools = $wordpools;

        $this->generateLobbyDatabaseEntry();
        $this->joinLobby($this->joincode, $_SESSION["lobby_username"],true);
    }

    private function generateLobbyDatabaseEntry()
    {
        //generate Joincode and check if exists.
        do{
            $this->joincode = rand(100000, 999999);
        }while(DatabaseLibrary::checkIfJoinCodeExists($this->joincode));
        
        $date = new DateTime();
        $this->starttimeUNIX = $date->getTimestamp() + $this->starttime;

        $playerINDX = PlayerModel::getPlayerIndxByName($_SESSION["lobby_username"]);
        
        $insertID = DatabaseLibrary::generateLobby($this->votetime,$this->drawtime,$this->starttimeUNIX,$this->maxplayer,$this->joincode,$playerINDX);

        if ($insertID != 0) {
            $_SESSION["lobby_joincode"] = $this->joincode;
            $this->indx = $insertID;
        }
    }

    public function getLobbyIndxByJoincode($joincode)
    {
            DatabaseLibrary::addWordCategoriesToLobby($this->wordpools,$this->indx);
        }
    }

    public static function getLobbyIndxByJoincode($joincode)
    {
        return DatabaseLibrary::getLobbyIndxByJoincode($joincode);
    }

    public static function getPlayersOfLobby($lobbyINDX){
        return DatabaseLibrary::getPlayersOfLobby($lobbyINDX);
    }

    public static function getWordpoolsOfLobby($lobbyINDX){
        return DatabaseLibrary::getWordpoolsOfLobby($lobbyINDX);
    }

    public function readLobbyDataFromDB(){
        $queryResult = DatabaseLibrary::readLobbyDataFromDB($_SESSION["lobby_joincode"]);
>>>>>>> feature/AjaxLobby2

        if($queryResult->num_rows > 0){
            while($row = $queryResult->fetch_assoc()){
                $this->state = $row["state"];
                $this->votetime = $row["votetime"];
                $this->starttime = $row["starttime"];
                $this->drawtime = $row["drawtime"];
                $this->maxplayer = $row["maxplayer"];
                $this->joincode = $row["joincode"];
                $this->players = $this->getPlayersOfLobby($_SESSION["lobby_lobbyINDX"]);
                //$this->wordpools = LobbyModel::getWordpoolsOfLobby($_SESSION["lobby_lobbyINDX"]);
                
                break;
            }
        }
    }

    public function joinLobby($joincode, $username, $isPartyLeader)
    {
        $playerINDX = PlayerModel::getPlayerIndxByName($username);
        $lobbyINDX = $this->getLobbyIndxByJoincode($joincode);
        $partyLeaderString = "";
        if ($isPartyLeader == true) {
            $partyLeaderString = "TRUE";
        } else {
            $partyLeaderString = "FALSE";
        }

        if ($lobbyINDX != 0 && $playerINDX != 0) {
                $insertID = DatabaseLibrary::addPlayerToLobby($playerINDX,$lobbyINDX,$partyLeaderString);
            if ($insertID != 0) {
                $_SESSION["lobby_lobbyINDX"] = $lobbyINDX;
                $_SESSION["lobby_joincode"] = $joincode;
            }
        }
    }

}

return;
?>
<!-- >