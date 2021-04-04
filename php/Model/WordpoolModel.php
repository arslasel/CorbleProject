<?php
class WordpoolModel{

    private $indx;
    private $name;


    public function __construct($indx,$name)
    {
        $this->indx = $indx;
        $this->name = $name;
    }

    public function getIndx(){
        return $this->indx;
    }
    public function getName(){
        return $this->name;
    }
}

return;
?>
<!-- >