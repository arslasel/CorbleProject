<?php
class CorbleDatabase
{
    private static $servername = "corble.ch";
    private static $username = "rigpdqdi_kaya";
    private static $password = "Zhaw-1234!";
    private static $db = "rigpdqdi_corbleCh";

    public static function executeQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            CorbleDatabase::$servername,
            CorbleDatabase::$username,
            CorbleDatabase::$password,
            CorbleDatabase::$db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn->query($query);
        }
    }

    public static function executeInsertQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            CorbleDatabase::$servername,
            CorbleDatabase::$username,
            CorbleDatabase::$password,
            CorbleDatabase::$db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if($conn->query($query) === TRUE){
                return $conn->insert_id;
            }
            echo $query;
            echo("Error description: " . $conn->error);
            return 0;
        }
    }


    public static function createConnection(){
        // Create connection
        return new mysqli(
            CorbleDatabase::$servername,
            CorbleDatabase::$username,
            CorbleDatabase::$password,
            CorbleDatabase::$db
        );

    }

    public static function checkIfUserExists($user){
        $sql = "SELECT COUNT(*) as matches FROM  tbl_player WHERE name = '".$user."'";
        $conn = self::createConnection();
        $result = $conn->query($sql);
        if($result){
            $row = $result->fetch_assoc();
            if($row['matches']==0){
                return false;
            }else{
                return true;
            }
        }
    }
}

return;
?>
<!-- >