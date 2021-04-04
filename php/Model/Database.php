<?php
class CorbleDatabase{
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
}

return;
?>
<!-- >