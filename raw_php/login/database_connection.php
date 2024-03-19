<?php
// Database connection parameters
$SERVER_NAME = "127.0.0.1";
$USERNAME = "root";
$PASSWORD = "Devesh0905";
$DB_NAME = "RawPhp";

// Create a new database connection
$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DB_NAME);

// Check if the connection is successful
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//} else {
//    echo "Connected successfully";
//}

