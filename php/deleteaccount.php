<?php
session_start();
/*
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or perform other actions if the user is not logged in
    header("Location: ../index.php"); // Change "login.php" to your actual login page
    exit();
}
*/

// Include your database connection code here
include 'database_connect.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user information to be deleted from the POST request
    $firstNameToDelete = $_POST['firstName'];
    $lastNameToDelete = $_POST['lastName'];
    $roleToDelete = $_POST['role'];

    // Check if the user is trying to delete themselves
    if ($firstNameToDelete === $_SESSION['first_name'] &&
        $lastNameToDelete === $_SESSION['last_name'] &&
        $roleToDelete === $_SESSION['role']) {
        echo "You cannot delete yourself.";
        exit();
    }

    // Prepare and execute an SQL statement to delete the user account
    $sql = "DELETE FROM users WHERE first_name = ? AND last_name = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstNameToDelete, $lastNameToDelete, $roleToDelete);

    if ($stmt->execute()) {
        // Deletion was successful
        echo "User account deleted successfully.";
        header("Location: ../ctmeucreate.php"); // Change "error.php" to your actual error page
    }
    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    /*
    // If the request method is not POST, redirect to an error page or perform other actions
    header("Location: error.php"); // Change "error.php" to your actual error page
    */
    exit();
}
?>