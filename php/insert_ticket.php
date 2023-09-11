<?php
session_start();
include 'database_connect.php'; // Include your database connection settings here

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_name = $_POST["driver_name"];
    $driver_address = $_POST["driver_address"];
    $driver_license = $_POST["driver_license"];
    $issuing_district = $_POST["issuing_district"];
    $vehicle_type = $_POST["vehicle_type"];
    $plate_no = $_POST["plate_no"];
    $cor_no = $_POST["cor_no"];
    $place_issued = $_POST["place_issued"];
    $reg_owner = $_POST["reg_owner"];
    $reg_owner_address = $_POST["reg_owner_address"];
    $date_time_violation = $_POST["date_time_violation"]; // Assuming this is a string in the format "YYYY-MM-DD HH:MM:SS"
    $place_of_occurrence = $_POST["place_of_occurrence"];
    $is_settled = $_POST["is_settled"]; // Assuming this is either 0 or 1

    // Prepare and bind the SQL statement
    $insertQuery = "INSERT INTO violation_tickets (driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, cor_no, place_issued, reg_owner, reg_owner_address, date_time_violation, place_of_occurrence, is_settled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStatement = $conn->prepare($insertQuery);
    $insertStatement->bind_param("sssssssssssssi", $driver_name, $driver_address, $driver_license, $issuing_district, $vehicle_type, $plate_no, $cor_no, $place_issued, $reg_owner, $reg_owner_address, $date_time_violation, $place_of_occurrence, $is_settled);

    if ($insertStatement->execute()) {
        echo "Violation ticket inserted successfully.";
    } else {
        echo "Error inserting violation ticket: " . $insertStatement->error;
    }

    // Close the prepared statement
    $insertStatement->close();
}

// Close the database connection
$conn->close();
?>
