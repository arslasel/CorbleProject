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


    public function getPlayerIndxByName($name){
        return $this->corbleDatabase->getPlayerbyIndex($name);
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