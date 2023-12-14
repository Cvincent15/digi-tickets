<?php
session_start();
include 'database_connect.php';

// Retrieve the login form data and trim it
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Use htmlspecialchars to sanitize user input to prevent XSS
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

// Prepare the query using placeholders for username
$stmt = $conn->prepare("SELECT driver_email, driver_password FROM users_motorists WHERE driver_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Close the statement and connection
$stmt->close();
$conn->close();

if ($user) {
    // Verify the hashed password
    if (password_verify($password, $user['driver_password'])) {
        // Password is correct, set the session variables
        $_SESSION['email'] = $email;
        header("Location: ../MotoristMain.php"); 
        exit(); // Always exit after a header redirect
    } else {
        // Password is incorrect, display an error message
        $_SESSION['login_errorM'] = "Invalid username or password";
        header('Location: ../motorist_login.php');
        exit();
    }
} else {
    // Password is incorrect, display an error message
    $_SESSION['login_errorM'] = "User not found";
    header('Location: ../motorist_login.php');
    exit();
}
?>
