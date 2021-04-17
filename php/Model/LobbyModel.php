<?php
include_once("Database.php");
include_once("PlayerModel.php");
include_once("WordpoolModel.php");
class LobbyModel
{
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

    public function __construct()
    {
    }

    public function login($UserName)
    {
        // check if a user with the same name exists
        if(CorbleDatabase::checkIfUserExists($UserName)){
            return false;
        } else { // there is no user with the same name continue login
            $insertID = CorbleDatabase::executeInsertQuery(
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
        }while(CorbleDatabase::checkIfJoinCodeExists($this->joincode));
        
        $date = new DateTime();
        $this->starttimeUNIX = $date->getTimestamp() + $this->starttime;

        $playerINDX = PlayerModel::getPlayerIndxByName($_SESSION["lobby_username"]);
/*
        $insertID = CorbleDatabase::executeInsertQuery("
            INSERT INTO tbl_lobby (votetime,drawtime,starttime,maxplayer,joincode,fk_player_indx_lobby,state) 
            VALUES (
                " . $this->votetime . ",
                " . $this->drawtime . ",
                " . $this->starttimeUNIX . ",
                " . $this->maxplayer . ",
                " . $this->joincode . ",
                " . $playerINDX . ",
                'WaitForPlayers')");
*/
        
        $insertID = CorbleDatabase::generateLobby($this->votetime,$this->drawtime,$this->starttimeUNIX,$this->maxplayer,$this->joincode,$playerINDX);

        if ($insertID != 0) {
            $_SESSION["lobby_joincode"] = $this->joincode;
            $this->indx = $insertID;           
            /*foreach ($this->wordpools as $wordpool) {
                
                CorbleDatabase::executeInsertQuery("
                INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool) 
                VALUES (
                    " . $this->indx . ",
                    " .  $wordpool. ")");
                
            }
            */
            CorbleDatabase::addWordCategoriesToLobby($this->wordpools,$this->indx);
        }
    }

    public static function getLobbyIndxByJoincode($joincode)
    {
        /*$selectLobbyResult = CorbleDatabase::executeQuery("SELECT indx FROM tbl_lobby WHERE joincode=" . $joincode . "");

        if ($selectLobbyResult->num_rows > 0) {
            return $selectLobbyResult->fetch_assoc()["indx"];
        } else {
            return 0;
        }*/

        return CorbleDatabase::getLobbyIndxByJoincode($joincode);
    }

    public static function getPlayersOfLobby($lobbyINDX){
        /*$players = array();
        $query = "
            SELECT tbl_player.name, tbl_player.indx
            FROM tbl_lobby_player, tbl_player 
            WHERE tbl_player.indx = tbl_lobby_player.fk_player_indx_lobby_player 
            AND tbl_lobby_player.fk_lobby_indx_Lobby_player = ".$lobbyINDX."";
        $queryResult = CorbleDatabase::executeQuery($query);
        if($queryResult->num_rows > 0){
            while($row = $queryResult->fetch_assoc()){
                $players[$row["indx"]] = new PlayerModel($row["name"],$row["indx"]);
            }
        }
        return $players;
        */
        return CorbleDatabase::getPlayersOfLobby($lobbyINDX);
    }

    public static function getWordpoolsOfLobby($lobbyINDX){
        /*$wordpools = array();
        $query = "
            SELECT tbl_wordpool.word as name, tbl_wordpool.indx
            FROM tbl_lobby_wordpool, tbl_wordpool 
            WHERE tbl_wordpool.indx = tbl_lobby_wordpool.fk_wordpool_indx_lobby_wordpool 
            AND tbl_lobby_wordpool.fk_lobby_indx_lobby_wordpool  = ".$lobbyINDX."";

        $queryResult = CorbleDatabase::executeQuery($query);
        if($queryResult->num_rows > 0){
            while($row = $queryResult->fetch_assoc()){
                $wordpools[$row["indx"]] = new WordpoolModel($row["name"],$row["indx"]);
            }
        }*/
        return CorbleDatabase::getWordpoolsOfLobby($lobbyINDX);
    }

    public function readLobbyDataFromDB(){
        $query = "SELECT * FROM tbl_lobby WHERE joincode = ".$_SESSION["lobby_joincode"]."";
        $queryResult = CorbleDatabase::executeQuery($query);

        if($queryResult->num_rows > 0){
            while($row = $queryResult->fetch_assoc()){
                $this->state = $row["state"];
                $this->votetime = $row["votetime"];
                $this->starttime = $row["starttime"];
                $this->drawtime = $row["drawtime"];
                $this->maxplayer = $row["maxplayer"];
                $this->joincode = $row["joincode"];
                $this->players = LobbyModel::getPlayersOfLobby($_SESSION["lobby_lobbyINDX"]);
                $this->wordpools = LobbyModel::getWordpoolsOfLobby($_SESSION["lobby_lobbyINDX"]);
                
                break;
            }
        }
    }

    public function joinLobby($joincode, $username, $isPartyLeader)
    {
        $playerINDX = PlayerModel::getPlayerIndxByName($username);
        $lobbyINDX = LobbyModel::getLobbyIndxByJoincode($joincode);
        $partyLeaderString = "";
        if ($isPartyLeader == true) {
            $partyLeaderString = "TRUE";
        } else {
            $partyLeaderString = "FALSE";
        }

        if ($lobbyINDX != 0 && $playerINDX != 0) {

            $insertID = CorbleDatabase::executeInsertQuery("
            INSERT INTO tbl_lobby_player (fk_player_indx_lobby_player,fk_lobby_indx_Lobby_player,partyLeader) 
            VALUES (
                " . $playerINDX . ",
                " . $lobbyINDX . ",
                " . $partyLeaderString . ")");
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