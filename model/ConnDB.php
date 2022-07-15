<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "store";  

    // Create connection
    $conn = new mysqli($servername, $username, $password,$db);

    // Check connection
    if ($conn->connect_error) 
    {
        // echo $conn->connect_errno;
        die("Connection failed: " . $conn->connect_error);
    }
    // echo "Connected Database Server Successfully";
?>