<?php

/**
 * Class WordpoolModel
 *
 */
class WordpoolModel
{
    private $indx;
    private $name;

    /**
     * WordpoolModel constructor.
     * @param $indx int Database index of wordpool
     * @param $name string String with name of wordpool
     */
    public function __construct($indx, $name)
    {
        $this->indx = $indx;
        $this->name = $name;
    }

    /**
     * Getter for the database index of the Wordpool
     * @return integer database index
     */
    public function getIndx()
    {
        return $this->indx;
    }

    /**
     * Returns name of Wordpool
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Creates a list of Wordpools
     * @return array With worpools available on database
     */
    public static function getWordPools($corbleDatabase)
    {
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
