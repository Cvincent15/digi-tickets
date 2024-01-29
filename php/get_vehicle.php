<?php
header('Content-Type: application/json');
session_start();
include 'database_connect.php';

// Get the vehicle ID from the POST parameters
$vehicleId = $_POST['vehicleId'];

// Retrieve the vehicle from the database
$sql = "SELECT * FROM vehicletype WHERE vehicle_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vehicleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $vehicle = $result->fetch_assoc();
    echo json_encode(['success' => true, 'vehicle' => $vehicle]);
} else {
    echo json_encode(['success' => false]);
}

// Close the database connection
$conn->close();
?>