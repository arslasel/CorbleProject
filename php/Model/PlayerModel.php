<?php 

class PlayerModel{
    public static function getPlayerIndxByName($name){
        $selectPlayerResult = CorbleDatabase::executeQuery("SELECT indx FROM tbl_player WHERE name='" . $name . "'");

        if ($selectPlayerResult->num_rows > 0) {
            return $selectPlayerResult->fetch_assoc()["indx"];
        } else {
            return 0;
        }
    }
}


return;
?> 
<!-- >