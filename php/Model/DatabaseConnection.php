<?php

/**
 * Class DatabaseConnection
 *
 * Class with methods to ececute sql statments on the corble database.
 */
class DatabaseConnection{
    private static $servername = "corble.ch";
    private static $username = "rigpdqdi_kaya";
    private static $password = "Zhaw-1234!";
    private static $db = "rigpdqdi_corbleCh";

    /**
     * Creates a connection to the database and executes a querry
     * @param $query String Querry to be executed on the Corble Database
     * @return bool|mysqli_result Result of querry
     */
    public static function executeQuery($query){
        // Create connection
        $conn = new mysqli(
            DatabaseLibrary::$servername,
            DatabaseLibrary::$username,
            DatabaseLibrary::$password,
            DatabaseLibrary::$db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn->query($query);
        }
    }

    /**
     * Creates a connection to the corble database and executes a insert querry
     * @param $query string with querry to be executed
     * @return int|string Result (Error-Code)
     */
    public static function executeInsertQuery($query)
    {
        // Create connection
        $conn = new mysqli(
            DatabaseLibrary::$servername,
            DatabaseLibrary::$username,
            DatabaseLibrary::$password,
            DatabaseLibrary::$db
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if ($conn->query($query) === TRUE) {
                return $conn->insert_id;
            }
            echo $query;
            echo("Error description: " . $conn->error);
            return 0;
        }
    }

}