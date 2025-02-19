<?php
$servername = "127.0.0.1:3306";
$username = "u873311945_defi";
$password = "Defirecovery123";
$dbname = "u873311945_defi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>