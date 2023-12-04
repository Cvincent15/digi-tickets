<?php
header('Content-Type: application/json');
session_start();
include 'database_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['vehicleName'])) {
    $vehicleName = mysqli_real_escape_string($conn, $data['vehicleName']);

    // Assuming you have a 'vehicles' table with a 'name' column
    $query = "DELETE FROM vehicles WHERE name = '$vehicleName'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}

// Close the database connection
$conn->close();
?>
