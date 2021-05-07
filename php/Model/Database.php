<?php
class CorbleDatabase
{
    private $servername = "corble.ch";
    private $username = "rigpdqdi_kaya";
    private $password = "Zhaw-1234!";
    private $db = "rigpdqdi_corbleCh";

    public function __construct(){
    }

    public function executeQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn->query($query);
        }
    }

    public function executeInsertQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->db
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


    private function createConnection(){
        // Create connection
        return new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->db
        );
    }

    public function checkIfUserExists($user){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_player WHERE name = '".$user."'";
        $conn = $this->createConnection();
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

    public function generateLobby($votetime,$rawtime,$starttimeUNIX,$maxplayer,$joincode,$playerINDX){
        $sql = "INSERT INTO tbl_lobby (votetime,drawtime,starttime,maxplayer,joincode,fk_player_indx_lobby,state) 
            VALUES (
            " . $votetime . ",
            " . $rawtime . ",
            " . $starttimeUNIX . ",
            " . $maxplayer . ",
            " . $joincode . ",
            " . $playerINDX . ",
            'WaitForPlayers')";

        $conn = $this->createConnection();
        
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

    public function checkIfJoinCodeExists($joincode){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_lobby WHERE joincode = '".$joincode."'";
        $conn = $this->createConnection();
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

    public function addWordCategoriesToLobby($worldpools,$lobbyIndx){
        $sql = "INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool)"; 
       
        $conn = $this->createConnection();
        
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

    public function getLobbyIndxByJoincode($joincode){
        $sql = "SELECT indx FROM tbl_lobby WHERE joincode=" . $joincode ;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        }else{
            return 0;
        }
    }
    
    public function getPlayersOfLobby($lobbyIndx){
        $players = array();
        $sql = "
            SELECT tbl_player.name, tbl_player.indx
            FROM tbl_lobby_player, tbl_player 
            WHERE tbl_player.indx = tbl_lobby_player.fk_player_indx_lobby_player 
            AND tbl_lobby_player.fk_lobby_indx_Lobby_player = ".$lobbyIndx."";
        
            $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $players[$row["indx"]] = new PlayerModel($row["name"],$row["indx"]);
            }
        }
        return $players;
    }

    public function getWordpoolsOfLobby($lobbyIndx){
        $wordpools = array();
        $sql = "
            SELECT tbl_wordpool.word as name, tbl_wordpool.indx
            FROM tbl_lobby_wordpool, tbl_wordpool 
            WHERE tbl_wordpool.indx = tbl_lobby_wordpool.fk_wordpool_indx_lobby_wordpool 
            AND tbl_lobby_wordpool.fk_lobby_indx_lobby_wordpool  = ".$lobbyIndx."";

        $result = $this->executeQuery($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $wordpools[$row["indx"]] = new WordpoolModel($row["name"],$row["indx"]);
            }
        }
        return $wordpools;
    }

    public function readLobbyDataFromDB($joincode){
        $sql = "SELECT * FROM tbl_lobby WHERE joincode = ".$joincode."";
        $conn = $this->createConnection();
        return $conn->query($sql);
    }

    public function addPlayerToLobby($playerIndx,$lobbyIndx,$partyLeaderString){
        $sql = "INSERT INTO tbl_lobby_player (fk_player_indx_lobby_player,fk_lobby_indx_Lobby_player,partyLeader) 
        VALUES (
            " . $playerIndx . ",
            " . $lobbyIndx . ",
            " . $partyLeaderString . ")";
       
        $conn = $this->createConnection();
        
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn->query($sql);
        }
        return 0;
    }

    public function getPlayerbyIndex($name){

        $sql = "SELECT indx FROM tbl_player WHERE name='" . $name . "'";
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        }else{
            return 0;
        }
    }

    public function getWordpools(){
        $sql = "SELECT * FROM  tbl_wordpool";
        $conn = $this->createConnection();
        return $conn->query($sql);
    }


    public function getPrimaryOptimalColorRatioForWord($word){
        $sql = "SELECT primaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public function getSecondaryOptimalColorRatioForWord($word){
        $sql = "SELECT secondaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public function getPrimaryColor($word){
        $sql = "SELECT primaryColor  AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public function getSecondaryColor($word){
        $sql = "SELECT secondaryColor  AS primaryColorRatio FROM tbl_word WHERE word = ".$word;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }else{
            return 0;
        }
    }

    public function setPointsForSketch($totalPoints, $sketchIndx){
        $sql = "UPDATE tbl_sketch SET computerscore = " .$totalPoints ."WHERE indx = " .$sketchIndx;
        $conn = $this->createConnection();
        if($conn->query($sql) === TRUE){
            return $conn->insert_id;
        }
    }

    public function getPlayerWithBestVotedSketch($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND votes = (" . $sql2 . ")";
        $sql4 = "SELECT name FROM tbl_player WHERE indx = " . $sql3;
        $conn = $this->createConnection();
        $result = $conn->query($sql4);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }
  
    public function getAllSketches($roundIndx, $playerindx){
        $sql = "SELECT path as path FROM tbl_sketch WHERE fk_round_indx = ".$roundIndx . " AND fk_player_indx_sketch <>  ".$playerindx;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
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

    public function getPlayerWithBestAlogrithmSketch($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_index  IN (". $sql1 . ")";
        $sql3 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";
        $sql4 = "SELECT name FROM tbl_player WHERE indx = " . $sql3;

        $conn = $this->createConnection();
        $result = $conn->query($sql4);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    public function getPlayerWithWorstVotedSketch($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";
        $sql4 = "SELECT name FROM tbl_player WHERE indx = " . $sql3;

        $conn = $this->createConnection();
        $result = $conn->query($sql4);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    public function getSketchBestVoted($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND votes = (" . $sql2 . ")";

        $conn = $this->createConnection();
        $result = $conn->query($sql3);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }
  
    public function saveRatingFromPlayer($sketchIndx){
        //Todo: This needs to made thread safe but on database level.

        $sql = "SELECT votes  AS votes FROM tbl_sketch WHERE indx = ".$sketchIndx;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $votes = $result->fetch_assoc();
            
            $votes = $votes + 1;

            $sql = "UPDATE tbl_sketch SET votes = " .$votes ."WHERE indx = " .$sketchIndx .";";
            $conn = $this->createConnection();
            if($conn->query($sql) === TRUE){
                return $conn->insert_id;
            }  
        }else{
            return 0;
        }
    }

    public function savePicture($path, $playerIndx){
        $sql = "INSERT INTO `tbl_sketch` (`path`, `computerscore`, `fk_player_indx_sketch`, `fk_word_indx_sketch`, `votes`, `fk_round_indx`) VALUES (".$path.", '0', ".$playerIndx.", '', '0', '')";

        $conn = $this->createConnection();
    
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


    /**
     * This method gets the round index of a specific sketch
     * @param: int $sketchIndx
     * @return: int array() $result->fetch_assoc()
     */
    public function getRoundIndexOfSketch($sketchIndx){
        $sql = "SELECT fk_round_indx_round_sketch FROM tbl_round_sketch WHERE fk_sketch_indx_round_sketch = " .$sketchIndx .";";
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }
        else{
            return 0;
        }
    }

    public function getSketchWorstAlgorithm($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql2 . ")";

        $conn = $this->createConnection();
        $result = $conn->query($sql3);
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
        $sql = "SELECT fk_word_indx_wordpool_word FROM tbl_wordpool_word WHERE fk_wordpool_indx_wordpool_word = " .$categoryId .";";
        $conn = $this->createConnection();
        $result = $conn->query($sql);
        if($result){
            return $result->fetch_assoc();
        }
        else{

            return 0;
        }
    }


    public function getSketchBestAlgorithm($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_index IN (". $sql1 . ")";
        $sql3 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql1 . ")";

        $conn = $this->createConnection();
        $result = $conn->query($sql3);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        };
    }

    public function getWinner($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT fk_player_index_sketch, SUM(votes) as total FROM tbl_sketch WHERE fk_round_index IN (" . $sql1 . ") GROUP BY fk_player_indx_sketch";
        $sql3 = "SELECT MAX(total) FROM " . $sql2 ;

        $sql4 = "SELECT fk_player_index_sketch FROM " . $sql2 . " WHERE total = " . $sql3;
        $sql5 = "SELECT name FROM tbl_player WHERE indx = " . $sql4;
        $conn = $this->createConnection();
        $result = $conn->query($sql5);
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
        $sql = "SELECT votes FROM tbl_sketch WHERE indx = " .$sketchIndx ." LIMIT 1 FOR UPDATE;"; //TODO: The readlock with FOR UPDATE currently doesn't work
        $conn = $this->createConnection();
        $result = $conn->query($sql);
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
    public function setVotes($sketchIndx){ //TODO: is duplicated with function saveRatingFromPlayer()
        $sql = "UPDATE tbl_sketch SET votes = " .$this->getVotes($sketchIndx)[0] + 1 ." WHERE indx = " .$sketchIndx .";";
        $conn = $this->createConnection();
        $conn->query($sql);
    }

    /**
     * Returns all scores of all pictures of a given player
     * @param $playerIndx String with index of player
     * @return array|int|null Returns a list or one value with all scores of aplayser
     */
    public function getScoreOfPlayer($playerIndx){
        $sql = "SELECT votes FROM tbl_sketch WHERE fk_player_indx_sketch = " .$playerIndx;
        $conn = $this->createConnection();
        $result = $conn->query($sql);
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