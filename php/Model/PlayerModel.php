<?php 

class PlayerModel{
    private $name;
    private $indx;
    private $corbleDatabase;

    public function __construct($corbleDatabase,$name,$indx)
    {
        $this->corbleDatabase = $corbleDatabase;
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
        return DatabaseLibrary::getPlayerByIndex($name);
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