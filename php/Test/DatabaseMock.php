<?php

include_once("Database.php");

class DatabaseMock{
    private $lobbyIndex;
    private $playerIndex;
    private $gameIndex;
    private $roundIndex;
    private $wordpoolIndex;
    private $wordIndex;
    private $sketchIndex;

    /**
     * Create a mock for a whole game
     */
    public function createDatabaseMock(){
        $this->createWordpool();
        $this->createWord();
        $this->createWordpoolWord();
        $this->createPlayers();
        $this->createLobby();
        $this->createLobbyPlayer();
        $this->createLobbyWordpool();
        $this->createGame();
        $this->createRound();
        $this->createGameRound();
        $this->createRoundPlayer();
    }

    private function createWordpool(){
        $query = "INSERT INTO tbl_wordpool (word) Values ('Halunken')";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_wordpool WHERE word='Halunken'";
        $this->wordpoolIndex = CorbleDatabase::executeQuery($query);
    }

    private function createWord(){
        $query = "INSERT INTO tbl_word (primaryColor, secundaryColor, primaryColorRatio, secundaryColorRatio, word) 
            Values ('red', 'blue', 0.5, 0.5, 'Mackie Messer')";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_word WHERE name='Mackie Messer'";
        $this->wordIndex= CorbleDatabase::executeQuery($query);
    }

    private function createWordpoolWord(){
        $query = "INSERT INTO tbl_wordpool_word (fk_word_index_wordpool_word, fk_wordpool_indx_wordpool_word) 
            Values (". $this->wordIndex . ",". $this->wordpoolIndex .")";
        CorbleDatabase::executeInsertQuery($query);
    }

    private function createPlayers(){
        $query = "INSERT INTO tbl_player (name) Values ('Gino')";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_player WHERE name='Gino'";
        $this->playerIndex = CorbleDatabase::executeQuery($query);
    }

    private function createLobby(){
        $query = "INSERT INTO tbl_lobby (votetime, drawtime, maxplayer, fk_player_index_lobby, state, joincode, starttime) 
                Values (10, 10, 5, " . $this->playerIndex . ", 'Start', 1, 1617604745)";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_Lobby WHERE joincode = 1";
        $this->lobbyIndex= CorbleDatabase::executeQuery($query);
    }

    private function createLobbyPlayer(){
        $query = "INSERT INTO tbl_lobby_lobby (fk_lobby_index_Lobby_player, fk_player_index_lobby_player, partyLeader) 
            VALUES ($this->lobbyIndex, $this->playerIndex, 1)";
        CorbleDatabase::executeInsertQuery($query);
    }

    private function createLobbyWordpool(){
        $query = "INSERT INTO tbl_lobby_wordpool(fk_lobby_index_lobby_wordpool, fk_wordpool_indx_lobby_wordpool) 
            VALUES ($this->lobbyIndex, $this->wordpoolIndex)";
        CorbleDatabase::executeInsertQuery($query);
    }

    private function createGame(){
        $query = "INSERT INTO tbl_game (fk_lobby_indx_game) alues (" . $this->lobbyIndex . ")";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_game WHERE fk_lobby_indx_game = " . $this->lobbyIndex;
        $this->gameIndex = CorbleDatabase::executeQuery($query);
    }

    private function createRound(){
        $query = "INSERT INTO tbl_round (fk_word_indx_round) alues (" . $this->wordIndex . ")";
        CorbleDatabase::executeInsertQuery($query);

        $query = "SELECT indx FROM tbl_round WHERE fk_word_indx_round = " . $this->lobbyIndex;
        $this->roundIndex= CorbleDatabase::executeQuery($query);
    }

    private function createGameRound(){
        $query = "INSERT INTO tbl_game_round (fk_game_index_game_round, fk_round_indx_game_round) 
            Values (". $this->gameIndex . ",". $this->roundIndex .")";
        CorbleDatabase::executeInsertQuery($query);
    }
    private function createRoundPlayer(){
        $query = "INSERT INTO tbl_round_player (fk_round_indx_round_player, fk_player_indx_round_player) 
            Values (". $this->roundIndex . ",". $this->playerIndex .")";
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