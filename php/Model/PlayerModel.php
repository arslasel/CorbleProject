<?php 

class PlayerModel{
    public static function getPlayerIndxByName($name){
        $query = "SELECT indx FROM tbl_player WHERE name='" . $name . "'";
        $selectPlayerResult = CorbleDatabase::executeQuery($query);

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