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

       // Delete the database records based on the selected IDs
       // Assuming you have a table named violation_tickets with a primary key 'ticket_id'
       // and a column 'is_settled', you can perform a DELETE query like this:
       $sql = "DELETE FROM violation_tickets WHERE ticket_id IN (";
       $sql .= implode(',', $archiveIds) . ")";

       if ($conn->query($sql) === TRUE) {
           // Database update successful
           echo "Database update successful";
           header('Location: ../records');
       }
   } else {
       // No checkboxes were selected
       echo "No checkboxes were selected";
       header('Refresh: 1; URL= ../records');
   }
} else {
   // Invalid request method
   echo "Invalid request method";
   header('Refresh: 1; URL= ../records');
}

$conn->close();
?>
