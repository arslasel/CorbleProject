<?php

include_once("Database.php");

class DatabaseMock{
    private static $lobbyIndex;
    private static $playerIndex;
    private static $gameIndex;
    private static $roundIndex;
    private static $wordpoolIndex;
    private static $wordIndex;
    private static $sketchIndex;

    /**
     * Create a mock for a whole game
     */
    public static function createDatabaseMock(){
        self::createWordpool();
        self::createWord();
        self::createWordpoolWord();
        self::createPlayers();
        self::createLobby();
        self::createLobbyPlayer();
        self::createLobbyWordpool();
        self::createGame();
        self::createRound();
        self::createGameRound();
        self::createRoundPlayer();
    }

    private static function createWordpool(){
        $query = "INSERT INTO tbl_wordpool (word) Values ('Halunken')";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_wordpool WHERE word='Halunken'";
        self::$wordpoolIndex = CorbleDatabase::executeQuery($query);
    }

    private static function createWord(){
        $query = "INSERT INTO tbl_word (primaryColor, secundaryColor, primaryColorRatio, secundaryColorRatio, word) 
            Values ('red', 'blue', 0.5, 0.5, 'Mackie Messer')";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_word WHERE name='Mackie Messer'";
        self::$wordIndex= CorbleDatabase::executeQuery($query);
    }

    private static function createWordpoolWord(){
        $query = "INSERT INTO tbl_wordpool_word (fk_word_index_wordpool_word, fk_wordpool_indx_wordpool_word) 
            Values (". self::$wordIndex . ",". self::$wordpoolIndex .")";
        CorbleDatabase::executeInsertQuery($query);
    }

    private static function createPlayers(){
        $query = "INSERT INTO tbl_player (name) Values ('Gino')";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_player WHERE name='Gino'";
        self::$playerIndex = CorbleDatabase::executeQuery($query);
    }

    private static function createLobby(){
        $query = "INSERT INTO tbl_lobby (votetime, drawtime, maxplayer, fk_player_index_lobby, state, joincode, starttime) 
                Values (10, 10, 5, " . self::$playerIndex . ", 'Start', 1, 1617604745)";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_Lobby WHERE joincode = 1";
        self::$lobbyIndex= CorbleDatabase::executeQuery($query);
    }

    private static function createLobbyPlayer(){
        $query = "INSERT INTO tbl_lobby_lobby (fk_lobby_index_Lobby_player, fk_player_index_lobby_player, partyLeader) 
            VALUES (".self::$lobbyIndex.", ".self::$playerIndex.", 1)";
        CorbleDatabase::executeInsertQuery($query);
    }

    private static function createLobbyWordpool(){
        $query = "INSERT INTO tbl_lobby_wordpool(fk_lobby_index_lobby_wordpool, fk_wordpool_indx_lobby_wordpool) 
            VALUES (".self::$lobbyIndex.", ".self::$wordpoolIndex.")";
        CorbleDatabase::executeInsertQuery($query);
    }

    private static function createGame(){
        $query = "INSERT INTO tbl_game (fk_lobby_indx_game) alues (" . self::$lobbyIndex . ")";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_game WHERE fk_lobby_indx_game = " . self::$lobbyIndex;
        self::$gameIndex = CorbleDatabase::executeQuery($query);
    }

    private static function createRound(){
        $query = "INSERT INTO tbl_round (fk_word_indx_round) alues (" . self::$wordIndex . ")";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_round WHERE fk_word_indx_round = " . self::$lobbyIndex;
        self::$roundIndex= CorbleDatabase::executeQuery($query);
    }

    private static function createGameRound(){
        $query = "INSERT INTO tbl_game_round (fk_game_index_game_round, fk_round_indx_game_round) 
            Values (". self::$gameIndex . ",". self::$roundIndex .")";
        CorbleDatabase::executeInsertQuery($query);
    }
    private static function createRoundPlayer(){
        $query = "INSERT INTO tbl_round_player (fk_round_indx_round_player, fk_player_indx_round_player) 
            Values (". self::$roundIndex . ",". self::$playerIndex .")";
        CorbleDatabase::executeInsertQuery($query);
    }

    public function createImages(){
        $path = "Path-Here";
        $query = "INSERT INTO tbl_sketch (path, computerscore, fk_player_indx_sketch, fk_word_indx_sketch) 
                Values (" . $path . "2," . $this->playerIndex . ", " . $this->wordIndex . ")";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_sketch WHERE path =" . $path;
        $this->scetchIndex= CorbleDatabase::executeQuery($query);
    }

    public function createRoundSketch(){
        $query = "INSERT INTO tbl_round_sketch (fk_round_indx_round_sketch, fk_sketch_indx_round_sketch) 
            Values (". $this->roundIndex . ",". $this->sketchIndex .")";
        CorbleDatabase::executeInsertQuery($query);
    }
}