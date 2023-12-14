<?php

include 'database_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$query = "SELECT violation_list_ids, violation_name FROM violationlists";
$result = mysqli_query($conn, $query);

$data = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Sanitize the data before using it
        $violationListId = mysqli_real_escape_string($conn, $row['violation_list_ids']);
        $violationName = mysqli_real_escape_string($conn, $row['violation_name']);

        // Add sanitized data to the array
        $data[] = array(
            'violation_list_ids' => $violationListId,
            'violation_name' => $violationName
        );
    }
} else {
    // Return a default value or handle the error as needed
    $data[] = array(
        'violation_list_ids' => 0,
        'violation_name' => "Violation not found"
    );
}

// Close the connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

?>
