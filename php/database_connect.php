<?php
/*  When Web Hosted
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
*/


// Database credentials
$servername = "127.0.0.1:3306";
$username = "u919418953_CTMEUdevs";
$password = "ProjectCTMEU2023";
$dbname = "u919418953_ctmeu";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
