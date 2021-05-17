<?php

/**
 * Class PlayerModel
 *
 * Object that represents a player with name and database-index
 */
class PlayerModel
{
    private $name;
    private $index;

    /**
     * PlayerModel constructor.
     * @param $name String Name of the player
     * @param $index String Database index of the player
     */
    public function __construct($name, $index){
        $this->name = $name;
        $this->index = $index;
    }

    /**
     * Return the database index of a player by his name
     * @param $corbleDatabase Object Database connection
     * @param $name String Name of player
     * @return mixed Name of player
     */
    public static function getPlayerIndexByName($corbleDatabase, $name){
        return $corbleDatabase->getPlayerByIndex($name);
    }

    /**
     * Getter for name of player
     * @return String Name of player
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Getter for database index of player
     * @return String Database indes of player
     */
    public function getIndex(){
        return $this->index;
    }
}

return;
