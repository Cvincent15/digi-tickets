<?php
session_start();
include 'database_connect.php';

// Check if the username is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {
    $username = $_POST["username"];

    // Delete the account from the database
    $deleteQuery = "DELETE FROM users WHERE username = ?";
    $deleteStatement = $conn->prepare($deleteQuery);
    $deleteStatement->bind_param("s", $username);

    if ($deleteStatement->execute()) {
        echo "Account deleted successfully.";
    } else {
        echo "Error deleting account: " . $deleteStatement->error;
    }

    // Close the prepared statement
    $deleteStatement->close();

    // Redirect back to the same page
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Close the database connection
$conn->close();
?>
