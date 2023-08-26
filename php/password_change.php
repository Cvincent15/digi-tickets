<?php
session_start();
include 'database_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the new password meets the minimum length requirement (e.g., 8 characters)
    if (strlen($newPassword) < 8) {
        echo "PasswordTooShort";
        exit; // Exit the script
    }

    // Fetch user data based on the logged-in user's username
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle the database query error
        die("Database query failed: " . mysqli_error($conn));
    }

    // Fetch the user's data
    $user = mysqli_fetch_assoc($result);
    $storedPassword = $user['password'];

    if (password_verify($currentPassword, $storedPassword)) {
        // Current password is correct, now check if new password matches the confirm password
        if ($newPassword === $confirmPassword) {
            // Update the password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Password updated successfully
                echo "success";
            } else {
                // Handle database error
                echo "Database error: " . mysqli_error($conn);
            }
        } else {
            echo "PasswordMismatch";
        }
    } else {
        echo "InvalidPassword";
    }
} else {
    // Handle invalid request
    echo "InvalidRequest";
}
?>
