<?php
include_once("Database.php");
class LobbyModel
{
    private $UserName; //name of the current user

    public function __construct()
    {
    }

    public function login($UserName)
    {
        // check if a user with the same name exists
        $foundSameUser = false;
        $queryResult = CorbleDatabase::executeQuery("SELECT * FROM  tbl_player");
        if ($queryResult->num_rows > 0) {
            while ($row = $queryResult->fetch_assoc()) {
                echo $row["name"];
                if ($row["name"] == $UserName) {
                    $foundSameUser = true;
                    break;
                }
            }
        }

        if ($foundSameUser) {
            return false;
        } else { // there is no user with the same name continue login
            $queryResult = CorbleDatabase::executeQuery(
                "INSERT INTO tbl_player (name)VALUES ('" . $UserName . "')"
            );
            $_SESSION["lobby_username"] = $UserName;
            return true;
        }
    }

    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }

    public function getUserName()
    {
        return $this->UserName;
    }
}
return;
