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

include_once("../Model/Database.php");
include_once("../Model/PlayerModel.php");

class LobbyViewAjaxUpdate{

    public function getData($joincode){
        $dbLib = new DatabaseLibrary();
        $result = $dbLib->readLobbyDataFromDB($joincode);
       
        if($result){
            $row = $result->fetch_assoc();
        
            $players = $dbLib->getPlayersOfLobby($row['indx']);
        
            

            $playerArray = '[';

            foreach($players as $player) { 
                $playerArray .= $player->getName() .",";
            }

            //If array has value delete last ','
            if(sizeof($players) > 0){
                $playerArray = substr($playerArray, 0, -1);
            }
            
            $playerArray .= ']';

            //build JSON
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
                "players" => $playerArray
            );

            return $return_arr;
        }

        return 0;
    }
}

$testclass = new LobbyViewAjaxUpdate();
echo $testclass->getData($_POST['joincode']);
?>