<?php
session_start();
include 'database_connect.php'; // Include your database connection code here

// Check if the user is logged in and has the necessary permissions
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Super Administrator') {
    // Redirect or handle unauthorized access
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Assuming you have a function to delete tickets in your database
function deleteTicket($ticketId) {
    global $conn; // Assuming you have a database connection established

    // Write a SQL query to delete a ticket
    $sql = "DELETE FROM violation_tickets WHERE ticket_id = $ticketId";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the deletion was successful
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'selectedRows' parameter is set in the POST data
    if (isset($_POST['selectedRows'])) {
        $selectedRows = json_decode($_POST['selectedRows'], true);

        // Loop through the selected rows and delete them
        foreach ($selectedRows as $row) {
            // Assuming 'ticket_id' is the identifier for each row
            $ticketId = $row['ticket_id'];
            $success = deleteTicket($ticketId);

            // Handle success or failure (you may log errors, etc.)
        }

        // Respond with a success message or any relevant data
        echo json_encode(['success' => true, 'message' => 'Selected rows deleted successfully']);
        exit();
    }
}

// If the request is not valid, respond with an error message
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit();
?>
