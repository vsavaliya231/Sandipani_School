<?php
// Unified database connection for Sandipani School
$host = "localhost";
$user = "root";
$pass = "";
$db   = "school_sdb";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>