<?php
session_start();
include 'database_connect.php'; // Include your database connection code here

// Check if the user is logged in (you can add more checks as needed)
if (!isset($_SESSION['username'])) {
    // Handle unauthorized access, redirect, or return an error response
    echo "Unauthorized access";
    exit();
}

// Check if the request method is POST (you can add more validation)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated data from the client
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Update the database record based on the received data
    // For example, assuming you have a table named violation_tickets with a primary key 'id'
    // and a column 'is_settled', you can perform an UPDATE query like this:
    $ticketId = $requestData['ticket_id'];
    $isSettled = $requestData['is_settled'];

    $sql = "UPDATE violation_tickets SET is_settled = ? WHERE ticket_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $isSettled, $ticketId);

    if ($stmt->execute()) {
        // Database update successful
        echo "Database update successful";
    } else {
        // Database update failed
        echo "Database update failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>
