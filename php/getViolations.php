<?php

include 'database_connect.php';

// Get the search term from the query parameter if it exists
$searchTerm = isset($_GET['section']) ? $_GET['section'] : '';

// Prepare the SQL query
$query = "SELECT violation_list_ids, violation_name, violation_section FROM violationlists";
$params = [];

if (!empty($searchTerm)) {
    // If a search term is provided, search for an exact match in violation_section
    $query .= " WHERE violation_section = ?";
    $params[] = $searchTerm;
}

$stmt = mysqli_prepare($conn, $query);

// Bind the search term parameter if it exists
if (!empty($searchTerm)) {
    mysqli_stmt_bind_param($stmt, "s", ...$params);
}

// Execute the query
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'violation_list_ids' => $row['violation_list_ids'],
            'violation_name' => $row['violation_name'],
            'violation_section' => $row['violation_section']
        );
    }
} else {
    // No results found, handle as needed
}

// Close the statement and connection
mysqli_stmt_close($stmt);
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

?>