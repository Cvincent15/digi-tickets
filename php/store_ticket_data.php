<?php
session_start();
include 'database_connect.php';
if (isset($_POST['index'])) {
    $index = $_POST['index'];

    // Store the selected ticket data in the session
    $_SESSION['selected_ticket'] = $violationTickets[$index];

    // Return a success response
    echo 'Session data stored successfully';
} else {
    // Return an error response
    echo 'Error: Index not provided';
}
?>
