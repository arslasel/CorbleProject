<?php
    $servername = "corble.ch";
    $username = "rigpdqdi_kaya";
    $password = "Zhaw-1234!";
    $db = "rigpdqdi_corbleCh";
        
    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    $funktioniert = $conn->query("SELECT * FROM test;");
    #Fetch_asscoc ; num_rows
?>