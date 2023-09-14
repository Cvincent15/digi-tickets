<?php
session_start();
include 'database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are not logged in
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user inputs
    $driverName = filter_var($_POST['driver_name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['driver_address'], FILTER_SANITIZE_STRING);
    $licenseNo = filter_var($_POST['driver_license'], FILTER_SANITIZE_STRING);
    $issuingDistrict = filter_var($_POST['issuing_district'], FILTER_SANITIZE_STRING);
    $vehicleType = filter_var($_POST['vehicle_type'], FILTER_SANITIZE_STRING);
    $plateNo = filter_var($_POST['plate_no'], FILTER_SANITIZE_STRING);
    $registrationNo = filter_var($_POST['cor_no'], FILTER_SANITIZE_STRING);
    $placeissued = filter_var($_POST['place_issued'], FILTER_SANITIZE_STRING);
    $registeredOwner = filter_var($_POST['reg_owner'], FILTER_SANITIZE_STRING);
    $ownerAddress = filter_var($_POST['reg_owner_address'], FILTER_SANITIZE_STRING);
    $placeOfOccurrence = filter_var($_POST['place_of_occurrence'], FILTER_SANITIZE_STRING);
    $user_ctmeu_id = $_POST['user_ctmeu_id']; // Assuming this is an integer

    // Insert the form data into the violation_tickets table using prepared statements
    $insertTicketQuery = "INSERT INTO violation_tickets (user_ctmeu_id, driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, cor_no, place_issued, reg_owner, reg_owner_address, place_of_occurrence)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insertTicketQuery);

    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "isssssssssss", $user_ctmeu_id, $driverName, $address, $licenseNo, $issuingDistrict, $vehicleType, $plateNo, $registrationNo, $placeissued, $registeredOwner, $ownerAddress, $placeOfOccurrence);

        if (mysqli_stmt_execute($stmt)) {
            // Check if any rows were affected by the insertion
            if (mysqli_affected_rows($conn) > 0) {
                // Get the ID of the newly inserted ticket
                $ticketID = mysqli_insert_id($conn);

                // Check if any violations were selected
                if (isset($_POST['violations']) && is_array($_POST['violations'])) {
                    $violations = $_POST['violations'];

                    // Insert each selected violation into the violations table with the ticket_id_violations foreign key using prepared statements
                    $insertViolationQuery = "INSERT INTO violations (ticket_id_violations, violation_name) VALUES (?, ?)";
                    $stmtViolation = mysqli_prepare($conn, $insertViolationQuery);

                    if ($stmtViolation) {
                        mysqli_stmt_bind_param($stmtViolation, "is", $ticketID, $violation);

                        foreach ($violations as $violation) {
                            $violation = filter_var($violation, FILTER_SANITIZE_STRING);
                            mysqli_stmt_execute($stmtViolation);
                        }
                    } else {
                        // Handle the prepared statement error for violation insertion
                        echo "Error inserting violations: " . mysqli_error($conn);
                    }
                }

                // Redirect to a success page or perform any other actions as needed
                header("Location: ../ctmeupage.php");
                exit();
            } else {
                // No rows were affected, indicating a failed insertion
                echo "Error inserting ticket: Ticket insertion failed.";
            }
        } else {
            // Handle the prepared statement error for ticket insertion
            echo "Error inserting ticket: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle the prepared statement error for ticket insertion
        echo "Error preparing ticket insertion: " . mysqli_error($conn);
    }
}

// If the script reaches this point, it means there was no POST request or an error occurred.
// You can display the form again or perform other actions.
?>
