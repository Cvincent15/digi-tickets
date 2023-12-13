<?php
header('Content-Type: application/json');
// Assuming you have a database connection established in database_connect.php
include 'database_connect.php';

// Query to fetch vehicle_id and vehicle_name from the database
$query = "SELECT vehicle_id, vehicle_name FROM vehicletype";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the results and store them in an array
$vehicles = array();
while ($row = mysqli_fetch_assoc($result)) {
    $vehicle = array(
        'id' => $row['vehicle_id'],
        'name' => $row['vehicle_name']
    );
    $vehicles[] = $vehicle;
}

// Close the database connection
mysqli_close($conn);

// Return the vehicles in JSON format

echo json_encode($vehicles);
?>
