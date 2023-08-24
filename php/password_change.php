<?php

session_start();
include 'database_connect.php'; // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: ../index.php");
    exit();
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
$firstName = $user['first_name'];
$lastName = $user['last_name'];
$status = $user['role'];

// Retrieve submitted data
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

// Validate the current password (you might want to implement a more secure validation)
if ($currentPassword === $user['password']) {
    // Check if the new password meets the minimum length requirement (e.g., 8 characters)
    if (strlen($newPassword) >= 8) {
        if ($newPassword === $confirmPassword) {
            // Update the user's password in the database
            $newPassword = mysqli_real_escape_string($conn, $newPassword);
            $updateQuery = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Password successfully updated
                echo "Password updated successfully.";
            } else {
                // Handle the database update error
                echo "Password update failed: " . mysqli_error($conn);
            }
        } else {
            echo "New password and confirm password do not match.";
        }
    } else {
        echo "New password should be at least 8 characters long.";
    }
} else {
    echo "Current password is incorrect.";
}
?>
