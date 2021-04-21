<?php 

class PlayerModel{
    private $name;
    private $indx;

    public function __construct($name,$indx)
    {
        $this->name = $name;
        $this->indx = $indx;
    }


    public static function getPlayerIndxByName($name){
       /* $query = "SELECT indx FROM tbl_player WHERE name='" . $name . "'";
        $selectPlayerResult = CorbleDatabase::executeQuery($query);

        if ($selectPlayerResult->num_rows > 0) {
            return $selectPlayerResult->fetch_assoc()["indx"];
        } else {
            return 0;
        }*/
        return CorbleDatabase::getPlayerbyIndex($name);
    }

    public function getName(){
        return $this->name;
    }

    public function getIndx(){
        return $this->indx;
    }
}


return;
?> 
<!-- >