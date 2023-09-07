<?php
session_start();
include 'database_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    // Sanitize and validate the input
    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Check if the new password meets the minimum length requirement (e.g., 8 characters)
    if (strlen($newPassword) < 8) {
        echo "PasswordTooShort";
        exit; // Exit the script
    }

    // Fetch user data based on the logged-in user's username
    $username = $_SESSION['username'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result) {
        // Handle the database query error
        echo "Database error: " . mysqli_error($conn);
        exit;
    }

    // Fetch the user's data
    $user = $result->fetch_assoc();
    $storedPassword = $user['password'];

    if (password_verify($currentPassword, $storedPassword)) {
        // Current password is correct, now check if the new password matches the confirm password
        if ($newPassword === $confirmPassword) {
            // Update the password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Use a prepared statement for the update query
            $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $hashedPassword, $username);
            if ($updateStmt->execute()) {
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

    // Close the prepared statements
    $stmt->close();
    $updateStmt->close();
} else {
    // Handle invalid request
    echo "InvalidRequest";
}
?>
