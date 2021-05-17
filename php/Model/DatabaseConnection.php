<?php

/**
 * Class DatabaseConnection
 *
 * Class with methods to ececute sql statments on the corble database.
 */
class DatabaseConnection
{
    private $servername = "corble.ch";
    private $username = "rigpdqdi_kaya";
    private $password = "Zhaw-1234!";
    private $db = "rigpdqdi_corbleCh";

    /**
     * Creates a simple connection to the database:
     *  -> Use only if predefined query-methods are not sufficient
     * @return mysqli Returns a database connection to execute querries
     */
    public function createConnection()
    {
        return new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->db
        );
    }

    /**
     * Creates a connection to the database and executes a querry
     * @param $conn Database connection to run statement
     * @param $stmt Prepared and injectionsave sql statment
     * @return bool|mysqli_result Result of querry
     */
    public function executeQuery($conn, $stmt){
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();
            return $result;
        }
    }

    /**
     * Creates a connection to the corble database and executes a insert querry
     * @param $conn Database connection to run statement
     * @param $stmt Prepared and injectionsave sql statment
     * @return int|string Result (Error-Code)
     */
    public function executeInsertQuery($conn, $stmt){
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            if ($stmt->execute() === true) {
                $id = $conn->insert_id;
                $stmt->close();
                $conn->close();
                return $id;
            }
            $stmt->close();
            $conn->close();
            return 0;
        }
    }
}
