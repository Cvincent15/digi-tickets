<?php
session_start();
include 'database_connect.php';

// Retrieve the login form data and trim it
$username = trim($_POST['username']);
$password = trim($_POST['password']);

echo "Debug: Username: " . $username . "<br>"; // Output the username
echo "Debug: Password: " . $password . "<br>"; // Output the password

// Prepare the query using placeholders for username
$stmt = $conn->prepare("SELECT * FROM users_motorists WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Verify the hashed password
    //echo "Debug: Hashed Password in DB: " . $user['password'] . "<br>"; // Output the hashed password in the database
    if (password_verify($password, $user['driver_password'])) {
        // Password is correct, set the session variables
        $_SESSION['username'] = $username;
    } else {
        // Password is incorrect, display an error message
        echo "Invalid username or password";
        header('Refresh: 5; URL= ../motorist_login.php');
    }
} else {
    // User not found, display an error message
    echo "User not found.";
    header('Refresh: 5; URL= ../motorist_ login.php');
}

// Close the statement and connection
$stmt->close();
$conn->close();


?>