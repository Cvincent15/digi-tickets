<?php
session_start();
include 'php/database_connect.php';

if(isset($_POST['register_btn'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $raw_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // New field
    $birthdate = $_POST['birthdate'];

    // Check if the email already exists in the database
    $email_check_sql = "SELECT * FROM motorist_users WHERE driver_email = '$email'";
    $email_check_result = mysqli_query($conn, $email_check_sql);

    // Check if the phone number already exists in the database
    $phone_check_sql = "SELECT * FROM motorist_users WHERE driver_phone = '$phone'";
    $phone_check_result = mysqli_query($conn, $phone_check_sql);

    if (mysqli_num_rows($email_check_result) > 0) {
        echo "Email already exists. Please use a different email.";
    } elseif (mysqli_num_rows($phone_check_result) > 0) {
        echo "Phone number already exists. Please use a different phone number.";
    } elseif ($raw_password !== $confirm_password) {
        echo "Passwords do not match. Please confirm your password correctly.";
    } else {
        // Hash the password
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO motorist_users (driver_name, driver_email, driver_phone, driver_password, birthday) VALUES ('$full_name', '$email', '$phone', '$hashed_password', '$birthdate')";

        if (mysqli_query($conn, $sql)) {
            // Registration successful
            $_SESSION['status'] = "Registration successful!";
                mysqli_close($conn);

// Redirect to motoristlogin.php
                header("Location: motoristlogin.php");
            exit(); 
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
