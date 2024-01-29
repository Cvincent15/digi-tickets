<?php
header('Content-Type: application/json');
session_start();
include 'database_connect.php';

if (isset($_POST['vehicleName'])) {
    $vehicleName = mysqli_real_escape_string($conn, $_POST['vehicleName']);

    // Assuming you have a 'vehicles' table with a 'name' column
    $query = "INSERT INTO vehicletype (vehicle_name) VALUES ('$vehicleName')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['vehicle_update_success'] = "Vehicle successfully added.";
           header('Location: ../settings');
    } else {
        $_SESSION['vehicle_update_failure'] = "Error! Cannot add vehicle. Please try again later.";
    header('Location: ../settings');
    }
} else {
    $_SESSION['vehicle_update_failure'] = "Error! Unknown command.";
    header('Location: ../settings');
}

// Close the database connection
$conn->close();
?>