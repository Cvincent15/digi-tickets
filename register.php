<?php
// Include your database connection code here
include 'php/database_connect.php';

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form and trim it
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $role = trim($_POST["role"]);
    $username = trim($_POST["username"]);
    
    // Set the default password for everyone
    $password = "password123";

    // Hash the password (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert the user data into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, role, username, password) VALUES (?, ?, ?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("sssss", $firstName, $lastName, $role, $username, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        header('Location: ctmeucreate.php');
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
