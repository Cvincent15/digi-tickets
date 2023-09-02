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
    // Check if the 'archive' parameter is set
    if (isset($_POST['archive']) && is_array($_POST['archive'])) {
        $archiveIds = $_POST['archive'];

        // Update the database records based on the selected IDs
        // Assuming you have a table named violation_tickets with a primary key 'ticket_id'
        // and a column 'is_settled', you can perform an UPDATE query like this:
        $sql = "UPDATE violation_tickets SET is_settled = 1 WHERE ticket_id IN (";
        $sql .= implode(',', $archiveIds) . ")";

        if ($conn->query($sql) === TRUE) {
            // Database update successful
            echo "Database update successful";
            header('Location: ../ctmeupage.php');
        }
    } else {
        // No checkboxes were selected
        echo "No checkboxes were selected";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}

$conn->close();
?>