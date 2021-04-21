<?php
class CorbleDatabase
{
    private static $servername = "corble.ch";
    private static $username = "rigpdqdi_kaya";
    private static $password = "Zhaw-1234!";
    private static $db = "rigpdqdi_corbleCh";

    public function __construct(){
    }

    public static function executeQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            CorbleDatabase::$servername,
            CorbleDatabase::$username,
            CorbleDatabase::$password,
            CorbleDatabase::$db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn->query($query);
        }
    }

    public static function executeInsertQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            CorbleDatabase::$servername,
            CorbleDatabase::$username,
            CorbleDatabase::$password,
            CorbleDatabase::$db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if($conn->query($query) === TRUE){
                return $conn->insert_id;
            }
            echo $query;
            echo("Error description: " . $conn->error);
            return 0;
        }
    }


    private static function createConnection(){
        // Create connection
        return new mysqli(
            CorbleDatabase::$servername,
            CorbleDatabase::$username,
            CorbleDatabase::$password,
            CorbleDatabase::$db
        );
    }

    public static function checkIfUserExists($user){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_player WHERE name = '".$user."'";
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            $row = $result->fetch_assoc();
            if($row['matches']==0){
                return false;
            }else{
                return true;
            }
        }
    }

    public static function generateLobby($votetime,$rawtime,$starttimeUNIX,$maxplayer,$joincode,$playerINDX){
        $sql = "INSERT INTO tbl_lobby (votetime,drawtime,starttime,maxplayer,joincode,fk_player_indx_lobby,state) 
            VALUES (
            " . $votetime . ",
            " . $rawtime . ",
            " . $starttimeUNIX . ",
            " . $maxplayer . ",
            " . $joincode . ",
            " . $playerINDX . ",
            'WaitForPlayers')";

        $conn = self::createConnection();
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if($conn->query($sql) === TRUE){
                return $conn->insert_id;
            }
            echo $sql;
            echo("Error description: " . $conn->error);
            return 0;
        }
    }

    public static function checkIfJoinCodeExists($joincode){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_lobby WHERE joincode = '".$joincode."'";
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            $row = $result->fetch_assoc();
            if($row['matches']==0){
                return false;
            }else{
                return true;
            }
        }
    } 

    public static function addWordCategoriesToLobby($worldpools,$lobbyIndx){
        $sql = "INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool)"; 
       
        $conn = self::createConnection();
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            foreach ($worldpools as $wordpool) {
                $sql = "INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool) 
                    VALUES (
                    " . $lobbyIndx . ",
                    " .  $wordpool. ")";

                $conn->query($sql);
            }
            return 0;
        }
    }

    public static function getLobbyIndxByJoincode($joincode){
        $sql = "SELECT indx FROM tbl_lobby WHERE joincode=" . $joincode ;
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        }else{
            return 0;
        }
    }
    
    public static function getPlayersOfLobby($lobbyIndx){
        $players = array();
        $sql = "
            SELECT tbl_player.name, tbl_player.indx
            FROM tbl_lobby_player, tbl_player 
            WHERE tbl_player.indx = tbl_lobby_player.fk_player_indx_lobby_player 
            AND tbl_lobby_player.fk_lobby_indx_Lobby_player = ".$lobbyIndx."";
        
            $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $players[$row["indx"]] = new PlayerModel($row["name"],$row["indx"]);
            }
        }
        return $players;
    }

    public static function getWordpoolsOfLobby($lobbyIndx){
        $wordpools = array();
        $sql = "
            SELECT tbl_wordpool.word as name, tbl_wordpool.indx
            FROM tbl_lobby_wordpool, tbl_wordpool 
            WHERE tbl_wordpool.indx = tbl_lobby_wordpool.fk_wordpool_indx_lobby_wordpool 
            AND tbl_lobby_wordpool.fk_lobby_indx_lobby_wordpool  = ".$lobbyIndx."";

        $result = CorbleDatabase::executeQuery($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $wordpools[$row["indx"]] = new WordpoolModel($row["name"],$row["indx"]);
            }
        }
        return $wordpools;
    }

    public static function readLobbyDataFromDB($joincode){
        $sql = "SELECT * FROM tbl_lobby WHERE joincode = ".$joincode."";
        $conn = self::createConnection();
        return $conn->query($sql);
    }

    public static function addPlayerToLobby($playerIndx,$lobbyIndx,$partyLeaderString){
        $sql = "INSERT INTO tbl_lobby_player (fk_player_indx_lobby_player,fk_lobby_indx_Lobby_player,partyLeader) 
        VALUES (
            " . $playerIndx . ",
            " . $lobbyIndx . ",
            " . $partyLeaderString . ")";
       
        $conn = self::createConnection();
        
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn->query($sql);
        }
        return 0;
    }

    public static function getPlayerbyIndex($name){

        $sql = "SELECT indx FROM tbl_player WHERE name='" . $name . "'";
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        }else{
            return 0;
        }
    }

    public static function getWordpools(){
        $sql = "SELECT * FROM  tbl_wordpool";
        $conn = self::createConnection();
        return $conn->query($sql);
    }


    public static function getPrimaryOptimalColorRatioForWord($word){
        $sql = "SELECT primaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public static function getSecondaryOptimalColorRatioForWord($word){
        $sql = "SELECT secondaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public static function getPrimaryColor($word){
        $sql = "SELECT primaryColor  AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public static function getSecondaryColor($word){
        $sql = "SELECT secondaryColor  AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public static function setPointsForSketch($totalPoints,$sketchIndx){
        $sql = "UPDATE tbl_sketch SET computerscore = " .$totalPoints ."WHERE indx = " .$sketchIndx .";";
        $conn = self::createConnection();
        if($conn->query($sql) === TRUE){
            return $conn->insert_id;
        }
    }

    public static function getAllSketches($roundIndx){
        //ToDo: To Implement
    }

}

return;
?>
<!-- >