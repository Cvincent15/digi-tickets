<?php
session_start();
// Include the database connection file
include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Retrieve form data (replace these field names with your actual form field names)
$licenseNo = $_POST["licenseNo"];
$expiry = $_POST["expiry"];
$serialNo = $_POST["serialNo"];
$citizenship = $_POST["citizenship"];
$driverLname = $_POST["driverLname"];
$driverFname = $_POST["driverFname"];
$driverMname = $_POST["driverMname"];
$birthday = $_POST["birthday"];
$gender = $_POST["gender"];
$motherLname = $_POST["motherLname"];
$motherFname = $_POST["motherFname"];
$motherMname = $_POST["motherMname"];
$email = $_POST["email"];
$phone = $_POST["phone"];

    // Add the "+639" prefix to the phone number
    $phoneWithPrefix = "+639" . $phone;

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create an SQL statement to insert the data into the database
    $sql = "INSERT INTO users_motorists (driver_license, driver_license_expiry, driver_license_serial, is_filipino, driver_last_name, driver_first_name, driver_middle_name, driver_birthday, driver_gender, mother_last_name, mother_first_name, mother_middle_name, driver_email, driver_phone, driver_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssssssssssssss", $licenseNo, $expiry, $serialNo, $citizenship, $driverLname, $driverFname, $driverMname, $birthday, $gender, $motherLname, $motherFname, $motherMname, $email, $phoneWithPrefix, $hashedPassword);
    if ($stmt->execute()) {
        // Data insertion was successful
        echo "<p>" . htmlspecialchars("Data inserted successfully.", ENT_QUOTES, 'UTF-8') . "</p>";
        header("Location: ../MotoristMain.php"); 
    } else {
        // Data insertion failed
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
} else {
// Handle cases where the request method is not POST (optional)
echo "Invalid request method.";
}
?>