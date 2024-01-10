<?php
session_start();
include 'database_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit();
}

// Validate and sanitize the login form data
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    // Password is incorrect, display an error message
    $_SESSION['login_error'] = "Invalid Input Data.";
    header('Location: ../login');
    exit();
}

// Prepare the query using placeholders for username
$stmt = $conn->prepare("SELECT user_ctmeu_id, username, password, first_name, last_name, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Verify the hashed password
    if (password_verify($password, $user['password'])) {
        // Password is correct, set the session variable for username
        $_SESSION['username'] = $user['username'];

        // Now, you can use the username to fetch the user's primary key (user_ctmeu_id)
        $user_ctmeu_id = $user['user_ctmeu_id'];
        // ... you can use $user_ctmeu_id as needed

        // Set other session variables
        $_SESSION['user_ctmeu_id'] = $user_ctmeu_id;
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] == 'Enforcer') {
            header('Location: ../user-profile');
        } else {
            header('Location: ../records');
        }
        exit(); // Always exit after a header redirect
    } else {
        // Password is incorrect, display an error message
        $_SESSION['login_error'] = "Invalid username or password";
        header('Location: ../login');
        exit();
    }
} else {
    // Password is incorrect, display an error message
    $_SESSION['login_error'] = "User not found.";
    header('Location: ../login');
    exit();
}
?>
