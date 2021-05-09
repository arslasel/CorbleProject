<?php

/**
 * Class DatabaseConnection
 *
 * Class with methods to ececute sql statments on the corble database.
 */
class DatabaseConnection{
    private $servername = "corble.ch";
    private $username = "rigpdqdi_kaya";
    private $password = "Zhaw-1234!";
    private $db = "rigpdqdi_corbleCh";

    /**
     * Creates a simple connection to the database:
     *  -> Use only if predefined query-methods are not sufficient
     * @return mysqli Returns a database connection to execute querries
     */
    public function createConnection(){
        return new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->db
        );
    }


    /**
     * Creates a connection to the database and executes a querry
     * @param $query String Querry to be executed on the Corble Database
     * @return bool|mysqli_result Result of querry
     */
    public function executeQuery($query){
        // Create connection
        $conn = $this->createConnection();

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
    public function executeInsertQuery($query){
        $conn = $this->createConnection();

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