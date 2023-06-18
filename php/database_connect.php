<?php
// Get the absolute path to the directory containing this script
$scriptPath = dirname(__FILE__);

// Set the working directory to the parent directory
chdir($scriptPath . '/../');

// Load environment variables from a separate configuration file
$config = parse_ini_file('config/config.ini', true);

// Database configuration
$dbHost = $config['database']['host'];
$dbUser = $config['database']['username'];
$dbPass = $config['database']['password'];
$dbName = $config['database']['dbname'];

// Establish a secure database connection
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Check if the connection was successful
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>