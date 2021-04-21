<?php
class WordpoolModel
{

    private $indx;
    private $name;


    public function __construct($indx, $name)
    {
        $this->indx = $indx;
        $this->name = $name;
    }

    public function getIndx()
    {
        return $this->indx;
    }
    public function getName()
    {
        return $this->name;
    }

    public static function getWordPools()
    {
        //$res = CorbleDatabase::executeQuery("SELECT * FROM  tbl_wordpool");
        $res = CorbleDatabase::getWordpools();
        $wordpools = array();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $wordpools[$row["indx"]] = new WordpoolModel($row["indx"], $row["name"]);
            }
        }
        return $wordpools;
    }
}

return;
?>
<!-- >