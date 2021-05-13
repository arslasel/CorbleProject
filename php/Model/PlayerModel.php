<?php

class PlayerModel
{
    private $name;
    private $indx;
    
    public function __construct($name, $indx)
    {
        $this->name = $name;
        $this->indx = $indx;
    }


    public static function getPlayerIndxByName($corbleDatabase,$name)
    {
        return $corbleDatabase->getPlayerByIndex($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIndx()
    {
        return $this->indx;
    }
}


return;
?>
<!-- >