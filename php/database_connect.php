<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ctmeu";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>