<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/php/Model/DatabaseConnection.php");

/**
 * Class DatabaseLibrary
 *
 * Library of methods with sql statements for the Corble database using the DatabaseConeciton class
 */
class DatabaseLibrary{

    private $databaseConnection;

    /**
     * DatabaseLibrary default constructor
     */
    public function __construct($databaseConnection){
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * Returns true if a user given by the name exists on the database
     * @param string $username string Name of user
     * @return bool True iff the user exists on the database
     */
    public function checkIfUserExists($username){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) as matches FROM tbl_player WHERE name = ?");
        $stmt->bind_param("s", $username);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            $row = $result->fetch_assoc();
            if ($row['matches'] == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Insert a new entry to the table tbl_lobby with all parameters
     * @param int $voteTime int Time to vote for the best drawn picture
     * @param int $rawTime int Time to draw a picture
     * @param int $startTimeUnix int Time where the game started
     * @param int $maxplayer int Maximum amount of players
     * @param int $joinCode Code join the lobby
     * @param int $playerIndex Index of the player who is lobby-leader
     * @return lobby id
     */
    public function generateLobby($voteTime, $rawTime, $startTimeUnix, $maxplayer, $joinCode, $playerIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("INSERT INTO tbl_lobby (votetime, drawtime, starttime, maxplayer, joincode, fk_player_indx_lobby, state) 
            VALUES (?,?,?,?,?,?,'WaitForPlayers')");        
            
        $stmt->bind_param("iiiiii", $voteTime, $rawTime, $startTimeUnix, $maxplayer, $joinCode,  $playerIndex);
        
        return $this->databaseConnection->executeInsertQuery($conn, $stmt);
    }

    /**
     * Checks if a joinCode exists
     * @param int $joinCode joinCode to be checked on the database
     * @return bool True iff the join-code exists
     */
    public function checkIfjoinCodeExists($joinCode){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) as matches FROM  tbl_lobby WHERE joincode = ?");
        $stmt->bind_param("i", $joinCode); 

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            $row = $result->fetch_assoc();
            if ($row['matches'] == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Adds an array of wordpools to the lobby
     * @param array $worldpools array List of wordpools
     * @param int $lobbyIndex Database index of worpool
     * @return int Error-Code
     */
    public function addWordCategoriesToLobby($worldpools, $lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool)");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            foreach ($worldpools as $wordpool) {
                $stmt = $conn->prepare("INSERT INTO tbl_lobby_wordpool (fk_lobby_indx_lobby_wordpool,fk_wordpool_indx_lobby_wordpool) 
                    VALUES (?,?)");
                $stmt->bind_param("ii", $lobbyIndex, $wordpool ); 
                $stmt->execute();
            }
            return 0;
        }
    }

    /**
     * Gets lobby index by Join-code - if not existing returns 0
     * @param int $joinCode joinCode searhed in table tbl_lobby
     * @return int|mixed Lobby-index if a lobby with join-code exists else 0
     */
    public function getLobbyIndexByjoinCode($joinCode){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT indx FROM tbl_lobby WHERE joincode = ?");
        $stmt->bind_param("i", $joinCode); 

        $result = $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        } else {
            return 0;
        }
    }

    /**
     * Gets all players of a lobby by a given lobby index
     * @param int $lobbyIndx Lobby index
     * @return array List with all players (can be empty array)
     */
    public function getPlayersOfLobby($lobbyIndex){
        $players = array();

        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT tbl_player.name, tbl_player.indx
            FROM tbl_lobby_player, tbl_player 
            WHERE tbl_player.indx = tbl_lobby_player.fk_player_indx_lobby_player 
            AND tbl_lobby_player.fk_lobby_indx_Lobby_player = ?");

        $stmt->bind_param("i", $lobbyIndex); 

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $players[$row["indx"]] = new PlayerModel($row["name"],$row["indx"]);
            }
        }
        return $players;
    }

    /**
     * Get Wordpools of lobby
     * @param int $lobbyIndex Index of lobby
     * @return array Array with all wordpools
     */
    public function getWordpoolsOfLobby($lobbyIndex){
        $wordpools = array();

        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT tbl_wordpool.word as name, tbl_wordpool.indx
            FROM tbl_lobby_wordpool, tbl_wordpool 
            WHERE tbl_wordpool.indx = tbl_lobby_wordpool.fk_wordpool_indx_lobby_wordpool 
            AND tbl_lobby_wordpool.fk_lobby_indx_lobby_wordpool  = ?");
        $stmt->bind_param("i", $lobbyIndex); 

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $wordpools[$row["indx"]] = new WordpoolModel($row["name"],$row["indx"]);
            }
        }
        return $wordpools;
    }

    /**
     * Returns lobby information of a given join-code
     * @param int $joinCode joinCode
     * @return mixed Table with data from database 
     */
    public function readLobbyDataFromDB($joinCode){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT * FROM tbl_lobby WHERE joincode = ?");
        $stmt->bind_param("i", $joinCode); 

        return $this->databaseConnection->executeQuery($conn, $stmt);
    }

    /**
     * Adds a player to an existing lobby
     * @param int $playerIndex Index of player
     * @param ind $lobbyIndex Index of lobby
     * @param string $partyLeaderString string index of player that is party-leader
     * @return int returns 0 on success else dies
     */
    public function addPlayerToLobby($playerIndex, $lobbyIndex, $partyLeaderString){
        $conn = $this->databaseConnection->createConnection();

        $partyLeaderStringDB = "";
        if ($partyLeaderString == "TRUE") {
            $partyLeaderStringDB = "1";
        } else {
            $partyLeaderStringDB = "0";
        }

        $stmt = $conn->prepare("INSERT INTO tbl_lobby_player (fk_player_indx_lobby_player,fk_lobby_indx_Lobby_player,partyLeader) VALUES (?,?,?)");
        $stmt->bind_param("iis", $playerIndex,  $lobbyIndex, $partyLeaderStringDB);   

        return $this->databaseConnection->executeInsertQuery($conn, $stmt);
    }

    /**
     * Returns player index by his name
     * @param string $name string with name of player
     * @return int|mixed string with index if player is in database else 0
     */
    public function getPlayerByIndex($name){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT indx FROM tbl_player WHERE name= ?");
        $stmt->bind_param("s", $name);        

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        } else {
            return 0;
        }
    }

    /**
     * Returns an array of Wordpool instances
     * @return array with wordpool instance 
     */
    public function getWordpools(){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT * FROM  tbl_wordpool");

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        return $result;
    }

    /**
     * Return primary optimal color ratio for word given with name
     * @param string $word string Wordname
     * @return int color ratio if word is found else 0
     */
    public function getPrimaryOptimalColorRatioForWord($word){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT primaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = ?");
        $stmt->bind_param("s", $word);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Return secundary optimal color ration for word
     * @param string $word string Wordname
     * @return int Color ration if not found equals 0
     */
    public function getSecondaryOptimalColorRatioForWord($word){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT secondaryColorRatio AS primaryColorRatio FROM tbl_word WHERE word = ?");
        $stmt->bind_param("s", $word);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Return primary color of a given word
     * @param string $word string Word name
     * @return int rgb number of color if not found = 0
     */
    public function getPrimaryColor($word){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT primaryColor  AS primaryColorRatio FROM tbl_word WHERE word = ?");
        $stmt->bind_param("s", $word);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Return secundary color of a given word
     * @param string $word string Word name
     * @return int rgb number of color if not found = 0
     */
    public function getSecondaryColor($word){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT secondaryColor  AS primaryColorRatio FROM tbl_word WHERE word = ?");
        $stmt->bind_param("s", $word);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Sets the computerscore for a sketch with a given index
     * @param int $totalPoints int Computer score
     * @param int $sketchIndex string Index of sketch
     * @return mixed Returns 0 for success else dies
     */
    public function setComputerScoreForSketch($totalPoints, $sketchIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("UPDATE tbl_sketch SET computerscore = ? WHERE indx = ?");
        $stmt->bind_param("ii", $totalPoints, $sketchIndex);

        return $this->databaseConnection->executeInsertQuery($conn, $stmt);
    }

    /**
     * Returns player name of best voted sketch
     * @param int $lobbyIndex string Index of lobby
     * @return mixed Returns player name or 0 if not found
     */
    public function getPlayerWithBestVotedSketch($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT name FROM tbl_player WHERE indx = (
            SELECT fk_player_indx_sketch FROM tbl_sketch WHERE fk_round_indx IN (
                SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?) AND votes = (
                    SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_indx IN (
                        SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?)))");
        $stmt->bind_param("ii", $lobbyIndex, $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["name"];
        } else {
            return 0;
        }
    }

    /**
     * Reuturns all skatches but not the one of the given player
     * @param int $roundIndex Database index of round
     * @param int $playerIndex Player index
     * @return array|int Array with paths. if nothing found result is 0
     */
    public function getAllSketches($roundIndex, $playerIndex){
        $conn = $this->databaseConnection->createConnection();
        echo " R" . $roundIndex . " " . $playerIndex;
        $stmt = $conn->prepare("SELECT path as path FROM tbl_sketch WHERE fk_round_indx = ? AND fk_player_indx_sketch <> ?");
        $stmt->bind_param("ii", $roundIndex, $playerIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            $results = array();
            while ($row = $result->fetch_row()) {
                array_push($results, $row);
            }
            return $results;
        } else {
            return 0;
        }
    }

    /**
     * Returns name of player with best computer-alscorithm scored sketch
     * @param int $lobbyIndex Lobby index
     * @return mixed name of player if a player is found and 0 if nothing is found
     */
    public function getPlayerWithBestAlogrithmSketch($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT name FROM tbl_player WHERE indx = (
            SELECT fk_player_indx_sketch FROM tbl_sketch WHERE fk_round_indx IN (
                SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?) AND computerscore = (
                    SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_indx IN (
                        SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?)))");

        $stmt->bind_param("ii", $lobbyIndex, $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["name"];
        } else {
            return 0;
        }
    }

    /**
     * Reutrns player name of worst voted sketch by the computer
     * @param int $lobbyIndex string Index of lobby
     * @return mixed Name of player if nothing found 0
     */
    public function getPlayerWithWorstVotedSketch($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT name FROM tbl_player WHERE indx = (
            SELECT fk_player_indx_sketch FROM tbl_sketch WHERE fk_round_indx IN (
                SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?) AND computerscore = (
                    SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_indx IN (
                        SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?)))");
                        
        $stmt->bind_param("ii", $lobbyIndex, $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["name"];
        } else {
            return 0;
        }
    }

    /**
     * Returns path of best voted sketch
     * @param int $lobbyIndex Lobby index
     * @return int String with path of best voted sketch if nothing found 0
     */
    public function getSketchBestVoted($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT path FROM tbl_sketch WHERE fk_round_indx IN (
            SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?) AND votes = (
                SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_indx IN (
                    SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?))");

        $stmt->bind_param("ii", $lobbyIndex, $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["path"];
        } else {
            return 0;
        }
    }

    /**
     * Saves a enew sketch into the database with a given path and player index
     * @param string $path string path of player
     * @param int $playerIndex player index
     * @return int|string returns 0 for success
     */
    public function savePicture($path, $playerIndex, $wordIndex, $roundIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("INSERT INTO tbl_sketch (
            path, computerscore, fk_player_indx_sketch, fk_word_indx_sketch, votes, fk_round_indx) VALUES (?, '0', ?, ?, '0', ?)");

        $stmt->bind_param("siii", $path, $playerIndex, $wordIndex, $roundIndex);

        return $this->databaseConnection->executeInsertQuery($conn, $stmt);
    }

    /**
     * This method gets the round index of a specific sketch
     * @param int $sketchIndex Index of sketch
     * @return int Round index of sketch
     */
    public function getRoundIndexOfSketch($sketchIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT fk_round_indx_round_sketch FROM tbl_round_sketch WHERE fk_sketch_indx_round_sketch = ?");

        $stmt->bind_param("i", $sketchIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * This method gets the round index of a specific sketch
     * @param int $sketchIndex Index of sketch
     * @return string word name of round
     */
    public function getWordIndxOfRound($roundIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT fk_word_indx_round FROM tbl_round WHERE indx = ?)");

        $stmt->bind_param("i", $roundIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

        /**
     * This method gets the round index of a specific sketch
     * @param int $sketchIndex Index of sketch
     * @return string word name of round
     */
    public function getWordNameOfRound($roundIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT word FROM tbl_word WHERE indx = (SELECT fk_word_indx_round FROM tbl_round WHERE indx = ?)");

        $stmt->bind_param("i", $roundIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    public function insertSketchInRound($sketchID, $roundID){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("INSERT INTO tbl_round_sketch (fk_sketch_indx_round_sketch, fk_round_indx_round_sketch) VALUES (?,?)");
        $stmt->bind_param("ii", $sketchID,$roundID);

        return $this->databaseConnection->executeInsertQuery($conn, $stmt);
    }


    /**
     * Returns path of sketch with worst rating from algorithm
     * @param int $lobbyIndex string with index of lobby
     * @return int Returns path to sketch or 0 if none found
     */
    public function getSketchWorstAlgorithm($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT path FROM tbl_sketch WHERE fk_round_indx IN ((
            SELECT indx FROM tbl_round WHERE fk_lobby_indx =  ?)) AND computerscore = (
                SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_indx IN (
                    SELECT indx FROM tbl_round WHERE fk_lobby_indx =  ?))");

        $stmt->bind_param("ii", $lobbyIndex, $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["path"];
        } else {
            return 0;
        }
    }

    /**
     * This method gives back all wordIds of a category
     * @param int $categoryId Category of words (wordpool)
     * @return array with wordpool indexes
     */
    public function getAllWordIdsOfCategory($categoryId){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT fk_word_indx_wordpool_word FROM tbl_wordpool_word WHERE fk_wordpool_indx_wordpool_word = ?");
        $stmt->bind_param("s", $categoryId);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        $wordIndexes = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $wordIndexes[] = $row['fk_word_indx_wordpool_word'];
            }
            return $wordIndexes;
        } else {
            return $wordIndexes;
        }
    }

    /**
     * Returns best sketch rated by the algorithm
     * @param int $lobbyIndex Index of lobby
     * @return int Path of sketch if found else 0
     */
    public function getSketchBestAlgorithm($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT path FROM tbl_sketch WHERE fk_round_indx IN ((
                SELECT indx FROM tbl_round WHERE fk_lobby_indx =  ?)) AND computerscore = (
                    SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_indx IN (
                        SELECT indx FROM tbl_round WHERE fk_lobby_indx =  ?))");

        $stmt->bind_param("ii", $lobbyIndex,  $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["path"];
        } else {
            return 0;
        }
    }

    /**
     * Returns winner of a lobby by the sum of the total amount of votes
     * @param int $lobbyIndex Index of lobby
     * @return int Name of winner else 0
     */
    public function getWinner($lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT name FROM tbl_player WHERE indx = (
            SELECT fk_player_indx_sketch FROM (
                SELECT fk_player_indx_sketch, SUM(votes) as total FROM tbl_sketch WHERE fk_round_indx IN (
                    SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?) GROUP BY fk_player_indx_sketch) as maximum WHERE total = (
                        SELECT MAX(total) FROM (SELECT fk_player_indx_sketch, SUM(votes) as total FROM tbl_sketch WHERE fk_round_indx IN (
                            SELECT indx FROM tbl_round WHERE fk_lobby_indx = ?) GROUP BY fk_player_indx_sketch) as playersum))");

        $stmt->bind_param("ii", $lobbyIndex,  $lobbyIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc()["name"];
        } else {
            return 0;
        }
    }

    /**
     * This method gets the votes for a specific sketch index.
     * @param int $sketchIndex Index of sketch to get votes from 
     * @return int votes of sketch
     */
    public function getVotes($sketchIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT votes FROM tbl_sketch WHERE indx = ? LIMIT 1 FOR UPDATE");
        $stmt->bind_param("i", $sketchIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Insert a user to the database if it not existis
     * @param string $useraname to be inserted
     * @return boolean if insert was sucessfull
     */
    public function insertUser($userName){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("INSERT INTO tbl_player (name) VALUES (?)");
        $stmt->bind_param("s", $userName);

        return $this->databaseConnection->executeInsertQuery($conn, $stmt);
    }

    /**
     * Return index of user by given username 
     * @param string Username 
     * @return int index of user 
     */
    public function getUserIndexbyUserName($userName){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT indx FROM tbl_player WHERE name = ?");
        $stmt->bind_param("s", $userName);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['indx'];
        } else {
            return 0;
        }
    }

    /**
     * This method sets the vote for a specific sketch index.
     * @param int $votes Votes to be set for sktech
     * @param int $sketchIndex Index of sketch where to votes should be set 
     */
    public function setVotes($votes, $sketchIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("UPDATE tbl_sketch SET votes = ? WHERE indx = ?");
        $stmt->bind_param("ii", $votes, $sketchIndex);
        $this->databaseConnection->executeQuery($conn, $stmt);
    }

    /**
     * Returns all scores of all pictures of a given player
     * @param $playerIndex String with index of player
     * @return array|int|null Returns a list or one value with all scores of aplayser
     */
    public function getScoreOfPlayer($playerIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT votes FROM tbl_sketch WHERE fk_player_indx_sketch = ?");
        $stmt->bind_param("i", $playerIndex);

        $result =  $this->databaseConnection->executeQuery($conn, $stmt);
        if($result){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * This function returns de drawtime for a round
     * @param int $joinCode joinCode of lobby
     * @return int $drawtime int returns time to draw 
     */
    public function getDrawTime(int $joinCode){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT voteTime FROM tbl_lobby WHERE joincode = ?");
        $stmt->bind_param("i", $joinCode);
        $result = $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }
    
    /**
     * This function returns de drawtime for a round
     * @param int $joinCode joinCode of lobby
     * @return int $drawtime int returns time to draw 
     */
    public function getSketchByIndex(int $sketchIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT path as path FROM tbl_sketch WHERE indx = ?");
        $stmt->bind_param("i", $sketchIndex);

        $result = $this->databaseConnection->executeQuery($conn, $stmt);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    /**
     * Get Wordpool id's of Wordpools 
     * @param int $lobbyIndex Index of lobby to get the active wordpools
     * @return array of wordpools-index 
     */
    public function getWordpoolIdsOfLobby(int $lobbyIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("SELECT fk_wordpool_indx_lobby_wordpool FROM tbl_lobby_wordpool WHERE fk_lobby_indx_lobby_wordpool = ?");
        $stmt->bind_param("i", $lobbyIndex);

        $result = $this->databaseConnection->executeQuery($conn,$stmt);
        $wordpools = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $wordpools[] = $row['fk_wordpool_indx_lobby_wordpool'];
            }
            return $wordpools;
        } else {
            return 0;
        }
    }

    /**
     * Create new round with a given lobbyIndex and WordIndex
     * @param int $lobbyIndex Index of lobby 
     * @param int $wordIndex Word that was chosen in the round
     * @return int Index of created round
     */
    public function createRound(int $lobbyIndex, int $wordIndex){
        $conn = $this->databaseConnection->createConnection();
        $stmt = $conn->prepare("INSERT INTO tbl_round(fk_lobby_indx, fk_word_indx_round) VALUES (?,?)");
        $stmt->bind_param("ii", $lobbyIndex,$wordIndex);

        return $this->databaseConnection->executeInsertQuery($conn,$stmt);
    }
}

return;
