<?php
session_start();
include 'database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if they are not logged in
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and sanitize/validate it
    $driverName = filter_input(INPUT_POST, 'driver_name', FILTER_SANITIZE_STRING);
    $driverAddress = filter_input(INPUT_POST, 'driver_address', FILTER_SANITIZE_STRING);
    $driverLicense = filter_input(INPUT_POST, 'driver_license', FILTER_SANITIZE_STRING);
    $issuingDistrict = filter_input(INPUT_POST, 'issuing_district', FILTER_SANITIZE_STRING);
    $vehicleType = filter_input(INPUT_POST, 'vehicle_type', FILTER_SANITIZE_STRING);
    $plateNo = filter_input(INPUT_POST, 'plate_no', FILTER_SANITIZE_STRING);
    $corNo = filter_input(INPUT_POST, 'cor_no', FILTER_SANITIZE_STRING);
    $placeIssued = filter_input(INPUT_POST, 'place_issued', FILTER_SANITIZE_STRING);
    $regOwner = filter_input(INPUT_POST, 'reg_owner', FILTER_SANITIZE_STRING);
    $regOwnerAddress = filter_input(INPUT_POST, 'reg_owner_address', FILTER_SANITIZE_STRING);
    $dateTimeViolation = filter_input(INPUT_POST, 'date_time_violation', FILTER_SANITIZE_STRING);
    $placeOfOccurrence = filter_input(INPUT_POST, 'place_of_occurrence', FILTER_SANITIZE_STRING);
    $ticketId = intval($_POST['ticket_id']); // Convert to an integer

    // Validate if necessary (e.g., minimum length for specific fields)
    if (strlen($driverName) < 2 || strlen($driverLicense) < 2 || empty($corNo) || empty($placeIssued)) {
        echo "InvalidInput";
        exit();
    }

    // Prepare an SQL statement using prepared statements to update the user data
    $sql = "UPDATE violation_tickets 
            SET driver_name = ?, 
                driver_address = ?,
                driver_license = ?,
                issuing_district = ?,
                vehicle_type = ?,
                plate_no = ?,
                cor_no = ?,
                place_issued = ?,
                reg_owner = ?,
                reg_owner_address = ?,
                date_time_violation = ?,
                place_of_occurrence = ?
            WHERE ticket_id = ?"; // Add WHERE clause to specify which record to update

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Define all parameters and their types in a single array
        $params = [
            "ssssssssssssi", // Types for all parameters (i for integer)
            &$driverName,
            &$driverAddress,
            &$driverLicense,
            &$issuingDistrict,
            &$vehicleType,
            &$plateNo,
            &$corNo,
            &$placeIssued,
            &$regOwner,
            &$regOwnerAddress,
            &$dateTimeViolation,
            &$placeOfOccurrence,
            &$ticketId,
        ];

        // Use call_user_func_array to bind parameters dynamically
        call_user_func_array([$stmt, 'bind_param'], $params);

        // Execute the SQL query
        if ($stmt->execute()) {
            // The update was successful
            // Redirect to a success page or back to the details page
            header("Location: ../ctmeupage.php");
            exit();
        } else {
            // Handle the error, e.g., display an error message
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }

} else {
    // If the request is not a POST request, redirect to an error page or handle it accordingly
    echo "Error: Invalid request method";
}

// Close the database connection
$conn->close();
?>
