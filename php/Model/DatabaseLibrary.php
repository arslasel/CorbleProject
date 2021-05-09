<?php

include_once 'DatabaseConnection.php';

/**
 * Class CorbleDatabase
 *
 * Library of methods with sql statements for the corble database using the Database Conneciton class
 *
 */
class DatabaseLibrary{

    /**
     * DatabaseLibrary default constructor
     */
    public function __construct(){
    }

    /**
     * Returns true if a user given by the name exists on the database
     * @param $user string Username
     * @return bool True iff the user exists on the database
     */
    public static function checkIfUserExists($user){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_player WHERE name = '".$user."'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            $row = $result->fetch_assoc();
            if($row['matches']==0){
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     * Insert a new entry to the table tbl_lobby with all parameters
     * @param $votetime int Time to vote for the best drawn picture
     * @param $rawtime int Time to draw a picture
     * @param $starttimeUNIX int Time where the game started
     * @param $maxplayer int Maximum amount of players
     * @param $joincode string String to join the lobby
     * @param $playerINDX string Strin with index of the player who is lobby-leader
     * @return lobby id
     */
    public function generateLobby($votetime,$rawtime,$starttimeUNIX,$maxplayer,$joincode,$playerINDX){
        $sql = "INSERT INTO tbl_lobby (votetime,drawtime,starttime,maxplayer,joincode,fk_player_indx_lobby,state) 
            VALUES ('" . $votetime . "','" . $rawtime . "',''" . $starttimeUNIX . "','" . $maxplayer . "','"
            . $joincode . "','" . $playerINDX . "', WaitForPlayers')";
        
        return DatabaseConnection::executeInsertQuery($sql);
    }

    /**
     * Checks if a joincode exists
     * @param $joincode string Joincode to be checked on the database
     * @return bool True iff the join-code exists
     */
    public function checkIfJoinCodeExists($joincode){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_lobby WHERE joincode = '".$joincode."'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            $row = $result->fetch_assoc();
            if($row['matches']==0){
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     * Adds an array of wordpools to the lobby
     * @param $worldpools array List of wordpools
     * @param $lobbyIndx string Database index of worpool
     * @return int Error-Code
     */
    public function addWordCategoriesToLobby($worldpools,$lobbyIndx){
        $sql = "INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool)";
        $conn = DatabaseConnection::createConnection($sql);

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

    /**
     * Gets lobby index by Join-code - if not existing returns 0
     * @param $joincode String Joincode searhed in table tbl_lobby
     * @return int|mixed Lobby-index if a lobby with join-code exists else 0
     */
    public function getLobbyIndxByJoincode($joincode){
        $sql = "SELECT indx FROM tbl_lobby WHERE joincode= '". $joincode ."'";
        $result = DatabaseConnection::executeQuery($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        }else{
            return 0;
        }
    }

    /**
     * Gets all players of a lobby by a given lobby index
     * @param $lobbyIndx string Lobby index
     * @return array List with all players (can be empty array)
     */
    public function getPlayersOfLobby($lobbyIndx){
        $players = array();
        $sql = "
            SELECT tbl_player.name, tbl_player.indx
            FROM tbl_lobby_player, tbl_player 
            WHERE tbl_player.indx = tbl_lobby_player.fk_player_indx_lobby_player 
            AND tbl_lobby_player.fk_lobby_indx_Lobby_player = '" .$lobbyIndx. "'";

        $result = DatabaseConnection::executeQuery($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $players[$row["indx"]] = new PlayerModel($row["name"],$row["indx"]);
            }
        }
        return $players;
    }

    /**
     * Get Wordpools of lobby
     * @param $lobbyIndx string Index of lobby
     * @return array Array with all wordpools
     */
    public function getWordpoolsOfLobby($lobbyIndx){
        $wordpools = array();
        $sql = "
            SELECT tbl_wordpool.word as name, tbl_wordpool.indx
            FROM tbl_lobby_wordpool, tbl_wordpool 
            WHERE tbl_wordpool.indx = tbl_lobby_wordpool.fk_wordpool_indx_lobby_wordpool 
            AND tbl_lobby_wordpool.fk_lobby_indx_lobby_wordpool  = '". $lobbyIndx ."'";

        $result = DatabaseConnection::executeQuery($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $wordpools[$row["indx"]] = new WordpoolModel($row["name"],$row["indx"]);
            }
        }
        return $wordpools;
    }

    /**
     * Returns lobby information of a given join-code
     * @param $joincode string JoinCode
     * @return mixed Table
     */
    public function readLobbyDataFromDB($joincode){
        $sql = "SELECT * FROM tbl_lobby WHERE joincode = ''" .$joincode ."'";
        return DatabaseConnection::executeQuery($sql);
    }

    /**
     * Adds a player to an existing lobby
     * @param $playerIndx string Index of player
     * @param $lobbyIndx string Index of lobby
     * @param $partyLeaderString string index of player that is party-leader
     * @return int returns 0 on success else dies
     */
    public function addPlayerToLobby($playerIndx,$lobbyIndx,$partyLeaderString){
        $sql = "INSERT INTO tbl_lobby_player (fk_player_indx_lobby_player,fk_lobby_indx_Lobby_player,partyLeader) 
        VALUES ('" . $playerIndx . "','". $lobbyIndx . "','" . $partyLeaderString . "')";
       
        return DatabaseConnection::executeInsertQuery($sql);
    }

    /**
     * Returns player index by his name
     * @param $name string with name of player
     * @return int|mixed string with index if player is in database else 0
     */
    public function getPlayerByIndex($name){
        $sql = "SELECT indx FROM tbl_player WHERE name='" . $name . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        }else{
            return 0;
        }
    }

    /**
     * Returns an array of Wordpool instances
     * @return resultset $result
     */
    public function getWordpools(){
        $sql = "SELECT * FROM  tbl_wordpool";
        $result = DatabaseConnection::executeQuery($sql);
        return $result;
    }

    /**
     * Return primary optimal color ratio for word given with name
     * @param $word string Wordname
     * @return int color ratio if word is found else 0
     */
    public static function getPrimaryOptimalColorRatioForWord($word){
        $sql = "SELECT primaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = '" . $word . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    /**
     * Return secundary optimal color ration for word
     * @param $word string Wordname
     * @return int Color ration if not found equals 0
     */
    public function getSecondaryOptimalColorRatioForWord($word){
        $sql = "SELECT secondaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = '" . $word . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    /**
     * Return primary color of a given word
     * @param $word string Word name
     * @return int rgb number of color if not found = 0
     */
    public static function getPrimaryColor($word){
        $sql = "SELECT primaryColor  AS primaryColorRatio FROM tbl_word WHERE word = '" . $word . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    /**
     * Return secundary color of a given word
     * @param $word string Word name
     * @return int rgb number of color if not found = 0
     */
    public function getSecondaryColor($word){
        $sql = "SELECT secondaryColor  AS primaryColorRatio FROM tbl_word WHERE word = '" . $word . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    /**
     * Sets the computerscore for a sketch with a given index
     * @param $totalPoints int Computer score
     * @param $sketchIndx string Index of sketch
     * @return mixed Returns 0 for success else dies
     */
    public static function setComputerScoreForSketch($totalPoints, $sketchIndx){
        $sql = "UPDATE tbl_sketch SET computerscore = '" . $totalPoints ."' WHERE indx = '" . $sketchIndx . "'";
        return DatabaseConnection::executeInsertQuery($sql);
    }

    /**
     * Returns player name of best voted sketch
     * @param $lobbyIndex string Index of lobby
     * @return mixed Returns player name or 0 if not found
     */
    public static function getPlayerWithBestVotedSketch($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND votes = (" . $sql2 . ")";
        $sql4 = "SELECT name FROM tbl_player WHERE indx = " . $sql3;
        $result = DatabaseConnection::executeQuery($sql4);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Reuturns all skatches but not the one of the given player
     * @param $roundIndx string Database index of round
     * @param $playerindx string Player index
     * @return array|int Array with paths. if nothing found result is 0
     */
    public static function getAllSketches($roundIndx, $playerindx){
        $sql = "SELECT path as path FROM tbl_sketch WHERE fk_round_indx = '" . $roundIndx . "' AND fk_player_indx_sketch <> '" . $playerindx . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            $results = array();
            while($row = $result->fetch_row()){
                $results[] = $row;
            }
            return $results;
        }else{
            return 0;
        }
    }

    /**
     * Returns name of player with best computer-alscorithm scored sketch
     * @param $lobbyIndex string Lobby index
     * @return mixed name of player if a player is found and 0 if nothing is found
     */
    public function getPlayerWithBestAlogrithmSketch($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_index  IN (". $sql1 . ")";
        $sql3 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";
        $sql4 = "SELECT name FROM tbl_player WHERE indx = " . $sql3;
        $result = DatabaseConnection::executeQuery($sql4);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Reutrns player name of worst voted sketch by the computer
     * @param $lobbyIndex string Index of lobby
     * @return mixed Name of player if nothing found 0
     */
    public function getPlayerWithWorstVotedSketch($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";
        $sql4 = "SELECT name FROM tbl_player WHERE indx = " . $sql3;

        $result = DatabaseConnection::executeQuery($sql4);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Returns path of best voted sketch
     * @param $lobbyIndex string Lobby index
     * @return int String with path of best voted sketch if nothing found 0
     */
    public function getSketchBestVoted($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND votes = (" . $sql2 . ")";

        $result = DatabaseConnection::executeQuery($sql3);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Saves a enew sketch into the database with a given path and player index
     * @param $path string path of player
     * @param $playerIndx string player index
     * @return int|string returns 0 for success
     */
    public static function savePicture($path, $playerIndx){
        $sql = "INSERT INTO tbl_sketch (path, computerscore, fk_player_indx_sketch, fk_word_indx_sketch, votes, fk_round_indx) VALUES ('"
            . $path . "', '0', '" . $playerIndx . "', '', '0', '')";
        return DatabaseConnection::executeInsertQuery($sql);
    }


    /**
     * This method gets the round index of a specific sketch
     * @param: int $sketchIndx
     * @return: int array() $result->fetch_assoc()
     */
    public static function getRoundIndexOfSketch($sketchIndx){
        $sql = "SELECT fk_round_indx_round_sketch FROM tbl_round_sketch WHERE fk_sketch_indx_round_sketch = " .$sketchIndx .";";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }
        else{
            return 0;
        }
    }

    /**
     * Returns path of sketch with worst rating from algorithm
     * @param $lobbyIndex string with index of lobby
     * @return int Returns path to sketch or 0 if none found
     */
    public function getSketchWorstAlgorithm($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";

        $result = DatabaseConnection::executeQuery($sql3);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }
  
    /**
     * This method gives back all wordIds of a category
     * @param: int $categoryId
     * @return: int array() $result->fetch_assoc()
     */
    public function getAllWordIdsOfCategory($categoryId){
        $sql = "SELECT fk_word_indx_wordpool_word FROM tbl_wordpool_word WHERE fk_wordpool_indx_wordpool_word = '" .$categoryId . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }
        else{
            return 0;
        }
    }

    /**
     * Returns best sketch rated by the algorithm
     * @param $lobbyIndex string Index of lobby
     * @return int Path of sketch if found else 0
     */
    public function getSketchBestAlgorithm($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";

        $result = DatabaseConnection::executeQuery($sql3);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Returns winner of a lobby by the sum of the total amount of votes
     * @param $lobbyIndex string Index of lobby
     * @return int Name of winner else 0
     */
    public function getWinner($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = '" . $lobbyIndex . "'";
        $sql2 = "SELECT fk_player_index_sketch, SUM(votes) as total FROM tbl_sketch WHERE fk_round_index IN (" . $sql1 . ") GROUP BY fk_player_indx_sketch";
        $sql3 = "SELECT MAX(total) FROM " . $sql2 ;

        $sql4 = "SELECT fk_player_index_sketch FROM " . $sql2 . " WHERE total = " . $sql3;
        $sql5 = "SELECT name FROM tbl_player WHERE indx = " . $sql4;

        $result = DatabaseConnection::executeQuery($sql5);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

   /**
     * This method gets the votes for a specific sketch index.
     * @param: int $sketchIndx
     * @return: int array() result->fetch_assoc()
     */
    public function getVotes($sketchIndx){
        $sql = "SELECT votes FROM tbl_sketch WHERE indx = '" . $sketchIndx . "' LIMIT 1 FOR UPDATE";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }
        else{
            return 0;
        }
    }

    /**
     * This method sets the vote for a specific sketch index.
     * @param: int $sketchIndx
     */
    public function setVotes($votes, $sketchIndx){
        $sql = "UPDATE tbl_sketch SET votes = '" . $votes . "' WHERE indx = '" . $sketchIndx . "'";
        DatabaseConnection::executeQuery($sql);
    }

    /**
     * Returns all scores of all pictures of a given player
     * @param $playerIndx String with index of player
     * @return array|int|null Returns a list or one value with all scores of aplayser
     */
    public function getScoreOfPlayer($playerIndx){
        $sql = "SELECT votes FROM tbl_sketch WHERE fk_player_indx_sketch = '" . $playerIndx . "'";
        $result = DatabaseConnection::executeQuery($sql);
        if($result){
            return $result->fetch_assoc();
        }
        else {
            return 0;
        }
    }
}

return;
?>
<!-- >