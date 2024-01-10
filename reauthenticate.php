<?php
session_start();
include 'php/database_connect.php'; // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login"); // Redirect to the login page if not logged in
    exit();
}

// Handle the reauthentication form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = trim($_POST['currentPassword']);
    $username = $_SESSION['username'];

    // Retrieve the stored password from the database
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle the database query error
        die("Database query failed: " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);
    $storedPassword = $user['password'];

    // Verify the entered current password against the stored password
    if (password_verify($currentPassword, $storedPassword)) {
        // Password is correct, allow access to perform the sensitive action
        // Redirect to the password change page or any other sensitive action page
        echo('Correct password!');
    } else {
        // Password verification failed, display an error message
        $error = "Password verification failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reauthenticate</title>
</head>
<body>
    <h1>Reauthenticate</h1>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="post">
        <label for="currentPassword">Enter Your Current Password:</label>
        <input type="password" id="currentPassword" name="currentPassword" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
