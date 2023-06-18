<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];

    // Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Username already exists, perform an update instead of insert
        $updateQuery = "UPDATE users SET name = '$name', password = '$password', status = '$status' WHERE username = '$username'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "Account updated successfully.";
        } else {
            echo "Error updating account: " . $conn->error;
        }
    } else {
        // Username doesn't exist, perform an insert
        $insertQuery = "INSERT INTO users (name, username, password, status) VALUES ('$name', '$username', '$password', '$status')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "New account created successfully.";
        } else {
            echo "Error creating account: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();

        header("Location: ../ctmeucreate.php");
        die();
?>
