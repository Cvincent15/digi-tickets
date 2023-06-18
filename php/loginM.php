<?php
session_start();
include 'database_connect.php';

// Retrieve the login form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare the query using placeholders
$stmt = $conn->prepare("SELECT * FROM users_motorists WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$user = $result->fetch_assoc();

/*
if ($user) {
    // Set the session variables
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $_SESSION['status'] = $status;
    header('Location: ../ctmeupage.php');
    exit();
} else {
    // Credentials are incorrect, display an error message
    echo "Invalid username or password";
}
*/

// Prepare a database query to fetch the user's data
$query = "SELECT * FROM users_motorists WHERE username = '$username'";

// Execute the query
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the user's data from the result set
    $row = mysqli_fetch_assoc($result);

    // Extract the required information
    $name = $row['name'];
    $_SESSION['name'] = $name;
    
    header('Location: ../motoristspage.php');
    exit();
} else {
    // Display an error message if the user was not found
    echo "User not found.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>