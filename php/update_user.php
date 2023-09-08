<?php
session_start();
include 'database_connect.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $json_data = file_get_contents("php://input");
    $user_data = json_decode($json_data, true);

    // Check if user data is valid
    if ($user_data && isset($user_data['firstName'], $user_data['lastName'], $user_data['role'], $user_data['userCtmeuId'])) {
        // Prepare and execute the SQL update statement using prepared statements
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, role=? WHERE user_ctmeu_id=?");
        $stmt->bind_param("sssi", $user_data['firstName'], $user_data['lastName'], $user_data['role'], $user_data['userCtmeuId']);

        if ($stmt->execute()) {
            // Update successful
            $response = array('success' => true);
        } else {
            // Update failed
            $response = array('success' => false);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Invalid user data
        $response = array('success' => false);
    }

    // Send the JSON response back to the JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle non-POST requests (if needed)
    http_response_code(405); // Method Not Allowed
}
?>