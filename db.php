<?php
// Database Configuration
$host = "localhost";
$user = "root";
$pass = "";
$db   = "school_sdb";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");
?>
