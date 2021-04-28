<?php

include_once('../Database.php');

class GameEndModel{


    public function getPlayerWithBestVotedSketch($roundIndex){
         $sql1 = "SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_index = " . $roundIndex;
         $sql2 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND votes = (" . $sql1 . ")";
         $sql3 = "SELECT name FROM tbl_player WHERE indx = " . $sql2;

        // Call sql3;
        $resultOfQuery = "Hans";
       return $resultOfQuery;
    }

    public function getPlayerWithBestAlogrithmSketch($roundIndex){
        $sql1 = "SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_index = " .  $roundIndex;
        $sql2 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql1 . ")";
        $sql3 = "SELECT name FROM tbl_player WHERE indx = " . $sql2;

        // Call sql3;
        $resultOfQuery = "Peter";
        return $resultOfQuery;
    }

    public function getPlayerWithWorstVotedSketch($roundIndex){
        $sql1 = "SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_index = " .  $roundIndex;
        $sql2 = "SELECT fk_player_index_sketch FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql1 . ")";
        $sql3 = "SELECT name FROM tbl_player WHERE indx = " . $sql2;

        // Call of sql3
        $resultOfQuery = "Hans";
        return $resultOfQuery;
    }

    public function getSketchBestVoted($roundIndex){
        $sql1 = "SELECT MAX(votes) FROM tbl_sketch WHERE fk_round_index = " .  $roundIndex;
        $sql2 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND votes = (" . $sql1 . ")";

        // Call sql2;
        $resultOfQuery = "";
        return $resultOfQuery;
    }

    public function getSketchWorstAlgorithm($roundIndex){
        $sql1 = "SELECT MAX(computerscore) FROM tbl_sketch WHERE fk_round_index = " . $this->roundIndex;
        $sql2 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql1 . ")";

        // Call sql2;
        $resultOfQuery = "";
        return $resultOfQuery;
    }

    public function getSketchBestAlgorithm($roundIndex){
        $sql1 = "SELECT MIN(computerscore) FROM tbl_sketch WHERE fk_round_index = " . $roundIndex;
        $sql2 = "SELECT path FROM tbl_sketch WHERE fk_round_index = roundIndex AND computerscore = (" . $sql1 . ")";

        // Call of sql3
        $resultOfQuery = "Hans";
        return $resultOfQuery;
    }

    public function getWinner($lobbyIndex){
        $sql1 = "SELECT index FROM tbl_round WHERE fk_lobby_index = " . $lobbyIndex;
        $sql2 = "SELECT fk_player_index_sketch, SUM(votes) as total FROM tbl_sketch WHERE fk_round_index IN (" . $sql1 . ") GROUP BY fk_player_indx_sketch";
        $sql3 = "SELECT MAX(total) FROM " . sql2 ;

        $skl4 = "SELECT fk_player_index_sketch FROM " . sql2 . " WHERE total = " . sql3;
        $sql5 = "SELECT name FROM tbl_player WHERE indx = " . sql4;

        // Call of sl5
        $resultOfQuery = "Hans";
        return $resultOfQuery;
    }
}