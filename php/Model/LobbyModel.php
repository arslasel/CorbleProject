<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseLibrary.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/PlayerModel.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/WordpoolModel.php");
class LobbyModel
{
    private $corbleDatabase;
    private $databaseConnection;

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

    public function __construct($corbleDatabase, $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
        $this->corbleDatabase = $corbleDatabase;
    }

    public function login($UserName){
        // check if a user with the same name exists
        if ($this->corbleDatabase->checkIfUserExists($UserName)) {
            return false;
        } else { // there is no user with the same name continue login
            $result = $this->corbleDatabase->insertUser($UserName);
            if ($result != 0) {
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

    public function getState()
    {
        return $this->state;
    }

    public function getVoteTime()
    {
        return $this->votetime;
    }

    public function getStartTime()
    {
        return $this->starttime;
    }

    public function getDrawTime()
    {
        return $this->drawtime;
    }

    public function getMaxPlayers()
    {
        return $this->maxplayer;
    }

    public function getJoinCode()
    {
        return $this->joincode;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function createLobby($votetime, $drawtime, $starttime, $maxplayer, $wordpools, $username)
    {
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

    private function generateLobbyDatabaseEntry()
    {
        //generate Joincode and check if exists.
        do {
            $this->joincode = rand(100000, 999999);
        } while ($this->corbleDatabase->checkIfJoinCodeExists($this->joincode));

        $date = new DateTime();
        $this->starttimeUNIX = $date->getTimestamp() + $this->starttime;

        $playerINDX = PlayerModel::getPlayerIndxByName($this->corbleDatabase, $this->UserName);
        $insertID = $this->corbleDatabase->generateLobby($this->votetime, $this->drawtime, $this->starttimeUNIX, $this->maxplayer, $this->joincode, $playerINDX);

        if ($insertID != 0) {
            $this->indx = $insertID;
        }
        $this->addWordCategoriesToLobby();
    }

    public function addWordCategoriesToLobby()
    {
        $this->corbleDatabase->addWordCategoriesToLobby($this->wordpools, $this->indx);
    }

    public function getLobbyIndxByJoincode($joincode)
    {
        return $this->corbleDatabase->getLobbyIndxByJoincode($joincode);
    }

    public function getPlayersOfLobby($lobbyINDX)
    {
        return $this->corbleDatabase->getPlayersOfLobby($lobbyINDX);
    }

    public function getWordpoolsOfLobby($lobbyINDX)
    {
        return $this->corbleDatabase->getWordpoolsOfLobby($lobbyINDX);
    }

    public function getWordpoolIdsofLobby($lobbyINDX)
    {
        return $this->corbleDatabase->getWordpoolIdsofLobby($lobbyINDX);
    }

    public function readLobbyDataFromDB()
    {
        $queryResult = $this->corbleDatabase->readLobbyDataFromDB($_SESSION["lobby_joincode"]);

        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
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
        $playerINDX = PlayerModel::getPlayerIndxByName($this->corbleDatabase, $username);
        $lobbyINDX = $this->getLobbyIndxByJoincode($joincode);
        $partyLeaderString = "";
        if ($isPartyLeader == true) {
            $partyLeaderString = "TRUE";
        } else {
            $partyLeaderString = "FALSE";
        }

        if ($lobbyINDX != 0 && $playerINDX != 0) {
            $insertID = $this->corbleDatabase->addPlayerToLobby($playerINDX, $lobbyINDX, $partyLeaderString);
            if ($insertID != 0) {
                $_SESSION["lobby_lobbyINDX"] = $lobbyINDX;
                $_SESSION["lobby_joincode"] = $joincode;
            }
        }
    }
}

return;
