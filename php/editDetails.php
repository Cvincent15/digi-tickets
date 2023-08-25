<?php
session_start();
include 'database_connect.php'; // Include your database connection code here

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if they are not logged in
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and sanitize it (you should validate and sanitize more)
    $driverName = mysqli_real_escape_string($conn, $_POST['driver_name']);
    $driverAddress = mysqli_real_escape_string($conn, $_POST['driver_address']);
    $driverLicense = mysqli_real_escape_string($conn, $_POST['driver_license']);
    $issuingDistrict = mysqli_real_escape_string($conn, $_POST['issuing_district']);
    $vehicleType = mysqli_real_escape_string($conn, $_POST['vehicle_type']);
    $plateNo = mysqli_real_escape_string($conn, $_POST['plate_no']);
    $corNo = isset($_POST['cor_no']) ? mysqli_real_escape_string($conn, $_POST['cor_no']) : null;
    $placeIssued = isset($_POST['place_issued']) ? mysqli_real_escape_string($conn, $_POST['place_issued']) : null;
    $regOwner = mysqli_real_escape_string($conn, $_POST['reg_owner']);
    $regOwnerAddress = mysqli_real_escape_string($conn, $_POST['reg_owner_address']);
    $dateTimeViolation = mysqli_real_escape_string($conn, $_POST['date_time_violation']);
    $placeOfOccurrence = mysqli_real_escape_string($conn, $_POST['place_of_occurrence']);

    // Prepare an SQL statement to update the user data
    $sql = "UPDATE violation_tickets 
            SET driver_name = '$driverName', 
                driver_address = '$driverAddress',
                driver_license = '$driverLicense',
                issuing_district = '$issuingDistrict',
                vehicle_type = '$vehicleType',
                plate_no = '$plateNo',
                reg_owner = '$regOwner',
                reg_owner_address = '$regOwnerAddress',
                date_time_violation = '$dateTimeViolation',
                place_of_occurrence = '$placeOfOccurrence'";

    // Only add cor_no and place_issued to the SQL statement if they are not empty
    if (!empty($corNo)) {
        $sql .= ", cor_no = '$corNo'";
    }
    if (!empty($placeIssued)) {
        $sql .= ", place_issued = '$placeIssued'";
    }

    // Add a WHERE clause to specify which user to update based on the ticket_id
    $sql .= " WHERE ticket_id = " . intval($_POST['ticket_id']);

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // The update was successful
        // Redirect to a success page or back to the details page
        header("Location: ../detailarch.php");
        exit();
    } else {
        // Handle the error, e.g., display an error message
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If the request is not a POST request, redirect to an error page or handle it accordingly
    echo "Error: Invalid request method";
}
?>
