<?php
header('Content-Type: application/json');
session_start();
include 'database_connect.php';

// Get the vehicle data from the POST parameters
$vehicleId2 = $_POST['vehicleId2'];
$vehicleNameE = $_POST['vehicleNameE'];

// Update the vehicle in the database
$sql = "UPDATE vehicletype SET vehicle_name = ? WHERE vehicle_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $vehicleNameE, $vehicleId2);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['vehicle_update_success'] = "Database update successful";
           header('Location: ../settings');
} else {
    $_SESSION['vehicle_update_failure'] = "Database update unsuccessful";
    header('Location: ../settings');
}

// Close the database connection
$conn->close();
?>