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
    // Get the form data and sanitize it
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
    $ticketId = intval($_POST['ticket_id']); // Convert to an integer

    // Prepare an SQL statement using prepared statements to update the user data
    $sql = "UPDATE violation_tickets 
            SET driver_name = ?, 
                driver_address = ?,
                driver_license = ?,
                issuing_district = ?,
                vehicle_type = ?,
                plate_no = ?,
                reg_owner = ?,
                reg_owner_address = ?,
                date_time_violation = ?,
                place_of_occurrence = ?";

    // Only add cor_no and place_issued to the SQL statement if they are not empty
    if (!empty($corNo)) {
        $sql .= ", cor_no = ?";
    }
    if (!empty($placeIssued)) {
        $sql .= ", place_issued = ?";
    }

    // Add a WHERE clause to specify which user to update based on the ticket_id
    $sql .= " WHERE ticket_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameters to the prepared statement
        $stmt->bind_param("ssssssssssi",
            $driverName,
            $driverAddress,
            $driverLicense,
            $issuingDistrict,
            $vehicleType,
            $plateNo,
            $regOwner,
            $regOwnerAddress,
            $dateTimeViolation,
            $placeOfOccurrence,
            $ticketId
        );

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
