<?php
/* 
$servername = "corble.ch";
$username = "rigpdqdi_kaya";
$password = "Zhaw-1234!";
$db = "rigpdqdi_corbleCh";

$conn = new mysqli($servername,$username,$password,$db);
$sql = "SELECT * FROM tbl_lobby WHERE joincode = ".$_POST['joincode']."";
$result  = $conn->query($sql);

if($result){
    $row = $result->fetch_assoc();

   // $players = array();
    $sql = "
        SELECT tbl_player.name, tbl_player.indx
        FROM tbl_lobby_player, tbl_player 
        WHERE tbl_player.indx = tbl_lobby_player.fk_player_indx_lobby_player 
        AND tbl_lobby_player.fk_lobby_indx_Lobby_player = ".$row['indx']."";

    $playerResult = $conn->query($sql);
    $players = '[';

    if($playerResult->num_rows > 0){
        while($playerRow = $playerResult->fetch_assoc()){
            $players .= $playerRow["name"] .",";
        }

        $players = substr($players, 0, -1);
    }
    $players .= ']';

    $state = $row["state"];
    $votetime = $row["votetime"];
    $starttime = $row["starttime"];
    $drawtime = $row["drawtime"];
    $maxplayer = $row["maxplayer"];
    $joincode = $row["joincode"];

    $return_arr = array(
        "state" => $state,
        "votetime" => $votetime,
        "starttime" => $starttime,
        "drawtime" => $drawtime,
        "maxplayer" => $maxplayer,
        "joincode" => $joincode,
        "players" => $players
    );

   echo json_encode($return_arr);
   
}
*/

include_once("../Model/DatabaseLibrary.php");
include_once("../Model/PlayerModel.php");

class LobbyViewAjaxData{
    public $state;
    public $votetime;
    public $starttime;
    public $drawtime;
    public $maxplayer;
    public $joincode;
    public $players;
}

class LobbyViewAjaxUpdate{

    public function getData(){

        ini_set('display_errors', 1); 
        error_reporting(E_ALL);

        $dbLib = new DatabaseLibrary(new DatabaseConnection());
        $result = $dbLib->readLobbyDataFromDB($_GET['joincode']);

        if($result){
            $row = $result->fetch_assoc();
        
            $players = $dbLib->getPlayersOfLobby($row['indx']);
            $JSONplayers = array();
            foreach ($players as $player) {
                array_push($JSONplayers,$player->getName());
            }
            
            $result = new LobbyViewAjaxData();
            $result->state = $row["state"];
            $result->votetime = $row["votetime"];
            $result->starttime = $row["starttime"];
            $result->drawtime = $row["drawtime"];
            $result->maxplayer = $row["maxplayer"];
            $result->joincode = $row["joincode"];
            $result->players = array_values($JSONplayers);

            return $result;
        }

        return 0;
    }
}

$testclass = new LobbyViewAjaxUpdate();
try {
    echo json_encode($testclass->getData());
}
catch (Exception $e) {
    echo json_encode($e->getMessage());
}

?>