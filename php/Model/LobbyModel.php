<?php
include_once("Database.php");
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
    private $wordpools = array();

    private $starttimeUNIX;

    public function __construct()
    {
    }

    public function login($UserName)
    {
        // check if a user with the same name exists
        $foundSameUser = false;
        $queryResult = CorbleDatabase::executeQuery("SELECT * FROM  tbl_player");
        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
                if ($row["name"] == $UserName) {
                    $foundSameUser = true;
                    break;
                }
            }
        }

        if ($foundSameUser) {
            return false;
        } else { // there is no user with the same name continue login
            $insertID = CorbleDatabase::executeInsertQuery(
                "INSERT INTO tbl_player (name)VALUES ('" . $UserName . "')"
            );
            if($insertID != 0){
                $_SESSION["lobby_username"] = $UserName;
                return true;
            }
            return false;
        }
    }

    public function getWordPools()
    {
        $res = CorbleDatabase::executeQuery("SELECT * FROM  tbl_wordpool");
        $wordpools = array();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $wordpools[$row["indx"]] = new WordpoolModel($row["indx"], $row["word"]);
            }
        }
        return $wordpools;
    }

    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }

    public function getUserName()
    {
        return $this->UserName;
    }

    public function createLobby($votetime, $drawtime, $starttime, $maxplayer, $wordpools)
    {
        $this->votetime = $votetime;
        $this->drawtime = $drawtime;
        $this->starttime = $starttime;
        $this->maxplayer = $maxplayer;
        $this->wordpools = $wordpools;

        $this->generateLobbyDatabaseEntry();
        $this->joinLobby($this->joincode, $this->UserName);
    }

    private function generateLobbyDatabaseEntry()
    {
        $this->joincode = rand(100000, 999999);
        $date = new DateTime();
        $this->starttimeUNIX = $date->getTimestamp() + $this->starttime;

        $insertID = CorbleDatabase::executeInsertQuery("
            INSERT INTO tbl_lobby (votetime,drawtime,starttime,maxplayer,joincode,state) 
            VALUES (
                " . $this->votetime . ",
                " . $this->drawtime . ",
                " . $this->starttimeUNIX . ",
                " . $this->maxplayer . ",
                " . $this->joincode . ",
                'WaitForPlayers')");

        if ($insertID != 0) {
            $_SESSION["lobby_joincode"] = $this->joincode;
            $this->indx = $insertID;
            foreach ($this->wordpools as $wordpool) {
                CorbleDatabase::executeInsertQuery("
                INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool) 
                VALUES (
                    " . $this->indx . ",
                    " . $wordpool->getIndx() . ")");
            }
        }
    }

    private function joinLobby($joincode, $username)
    {

        $selectPlayerResult = CorbleDatabase::executeQuery("SELECT indx FROM tbl_player WHERE name='" . $username . "'");
        $selectLobbyResult = CorbleDatabase::executeQuery("SELECT indx FROM tbl_lobby WHERE joincode=" . $joincode . "");

        if ($selectLobbyResult->num_rows > 0 && $selectPlayerResult->num_rows > 0) {
            $insertID = CorbleDatabase::executeInsertQuery("
            INSERT INTO tbl_lobby_player (fk_lobby_indx_Lobby_player,fk_player_indx_lobby_player) 
            VALUES (
                " . $selectPlayerResult->fetch_assoc()["indx"] . ",
                " . $selectLobbyResult->fetch_assoc()["indx"] . ")");
            if ($insertID != 0) {
                $_SESSION["lobby_lobbyINDX"] = $$selectLobbyResult->fetch_assoc()["indx"];
            }
        }
    }
}

return;
?>
<!-- >