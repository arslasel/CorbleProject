<?php

/**
 * Class WordpoolModel
 *
 */
class WordpoolModel
{
    private $index;
    private $name;

    /**
     * WordpoolModel constructor.
     * @param int database index of wordpool
     * @param string Name of wordpool
     */
    public function __construct($index, $name){
        $this->index = $index;
        $this->name = $name;
    }

    /**
     * Getter for the database index of the Wordpool
     * @return integer database index
     */
    public function getIndex(){
        return $this->index;
    }

    /**
     * Returns name of Wordpool
     * @return string name of wordpool
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Creates a list of Wordpools
     * @param CorbleDatabase Object Database connection layer
     * @return array With Worpools available on database
     */
    public static function getWordPools($corbleDatabase){
        $res = $corbleDatabase->getWordpools();
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
