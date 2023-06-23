<?php
session_start();
include 'fetchaccounts.php';
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];

    // Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $checkStatement = $conn->prepare($checkQuery);
    $checkStatement->bind_param("s", $username);
    $checkStatement->execute();
    $checkResult = $checkStatement->get_result();

    if ($checkResult->num_rows > 0) {
        // Username already exists, perform an update instead of insert
        $updateQuery = "UPDATE users SET name = ?, password = ?, status = ? WHERE username = ?";
        $updateStatement = $conn->prepare($updateQuery);
        $updateStatement->bind_param("ssss", $name, $password, $status, $username);

        if ($updateStatement->execute()) {
            echo "Account updated successfully.";
        } else {
            echo "Error updating account: " . $updateStatement->error;
        }

        // Close the prepared statement
        $updateStatement->close();
    } else {
        // Username doesn't exist, perform an insert
        $insertQuery = "INSERT INTO users (name, username, password, status) VALUES (?, ?, ?, ?)";
        $insertStatement = $conn->prepare($insertQuery);
        $insertStatement->bind_param("ssss", $name, $username, $password, $status);

        if ($insertStatement->execute()) {
            echo "New account created successfully.";
        } else {
            echo "Error creating account: " . $insertStatement->error;
        }

        // Close the prepared statement
        $insertStatement->close();
    }

    // Close the check statement
    $checkStatement->close();
}

// Close the database connection
$conn->close();

// Redirect back to the create page
header("Location: ../ctmeucreate.php");
exit();
?>
