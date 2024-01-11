<?php
session_start();
include 'database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are not logged in
    header("Location: login");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user inputs
    $selectedViolations = isset($_POST['violations']) ? $_POST['violations'] : [];
    $driverName = filter_var($_POST['driver_name'], FILTER_SANITIZE_STRING);
    $driverAddress = filter_var($_POST['driver_address'], FILTER_SANITIZE_STRING);
    $licenseNo = filter_var($_POST['driver_license'], FILTER_SANITIZE_STRING);
    $issuingDistrict = filter_var($_POST['issuing_district'], FILTER_SANITIZE_STRING);
    $vehicleType = filter_var($_POST['vehicle_type'], FILTER_SANITIZE_STRING);
    $plateNo = filter_var($_POST['plate_no'], FILTER_SANITIZE_STRING);
    $regOwner = filter_var($_POST['reg_owner'], FILTER_SANITIZE_STRING);
    $regOwnerAddress = filter_var($_POST['reg_owner_address'], FILTER_SANITIZE_STRING);
    $placeOfOccurrence = filter_var($_POST['place_of_occurrence'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date_violation'], FILTER_SANITIZE_STRING);
    $time = filter_var($_POST['time_violation'], FILTER_SANITIZE_STRING);
    $currentTicket = $_POST['currentTicket'];
    $user_ctmeu_id = $_POST['user_ctmeu_id']; // Assuming this is an integer

    // Check if the currentTicket is less than or equal to endTicket
    $queryCheckTicketRange = "SELECT currentTicket, endTicket FROM users WHERE user_ctmeu_id = ?";
    $stmtCheckTicketRange = mysqli_prepare($conn, $queryCheckTicketRange);
    mysqli_stmt_bind_param($stmtCheckTicketRange, "i", $user_ctmeu_id);
    mysqli_stmt_execute($stmtCheckTicketRange);
    mysqli_stmt_bind_result($stmtCheckTicketRange, $currentTicketValue, $endTicketValue);
    mysqli_stmt_fetch($stmtCheckTicketRange);
    mysqli_stmt_close($stmtCheckTicketRange);

    if ($currentTicketValue >= $endTicketValue) {
        // Redirect back to ctmeuticket.php with an error message
        header("Location: ../ctmeuticket.php?error=maxTicketReached");
        exit();
    }

    // Insert the form data into the violation_tickets table using prepared statements
    $insertTicketQuery = "INSERT INTO violation_tickets (user_ctmeu_id, driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, reg_owner, reg_owner_address, date_violation, time_violation, place_of_occurrence, control_number)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insertTicketQuery);

    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "isssssssssssi", $user_ctmeu_id, $driverName, $driverAddress, $licenseNo, $issuingDistrict, $vehicleType, $plateNo, $regOwner, $regOwnerAddress, $date, $time, $placeOfOccurrence, $currentTicket);

        if (mysqli_stmt_execute($stmt)) {
            // Check if any rows were affected by the insertion
            if (mysqli_affected_rows($conn) > 0) {
                // Get the ID of the newly inserted ticket
                $ticketID = mysqli_insert_id($conn);

                // Increment the currentTicket for the user
                $incrementTicketQuery = "UPDATE users SET currentTicket = currentTicket + 1 WHERE user_ctmeu_id = ?";
                $stmtIncrement = mysqli_prepare($conn, $incrementTicketQuery);
                mysqli_stmt_bind_param($stmtIncrement, "i", $user_ctmeu_id);
                mysqli_stmt_execute($stmtIncrement);
                mysqli_stmt_close($stmtIncrement);

                // Insert each selected violation into the violations table with the ticket_id_violations foreign key using prepared statements
                $insertViolationQuery = "INSERT INTO violations (violationlist_id, ticket_id_violations) VALUES (?, ?)";
                $stmtViolation = mysqli_prepare($conn, $insertViolationQuery);

                if ($stmtViolation) {
                    mysqli_stmt_bind_param($stmtViolation, "ii", $violationId, $ticketID);

                    // Use array_unique to remove duplicate violations
                    $selectedViolations = array_unique($selectedViolations);

                    foreach ($selectedViolations as $violationId) {
                        // Check if the violation already exists for the ticket
                        $checkViolationQuery = "SELECT COUNT(*) FROM violations WHERE violationlist_id = ? AND ticket_id_violations = ?";
                        $stmtCheckViolation = mysqli_prepare($conn, $checkViolationQuery);
                        mysqli_stmt_bind_param($stmtCheckViolation, "ii", $violationId, $ticketID);
                        mysqli_stmt_execute($stmtCheckViolation);
                        mysqli_stmt_bind_result($stmtCheckViolation, $violationCount);
                        mysqli_stmt_fetch($stmtCheckViolation);
                        mysqli_stmt_close($stmtCheckViolation);

                        if ($violationCount == 0) {
                            // Execute the prepared statement for each violation only if it doesn't exist for the ticket
                            mysqli_stmt_execute($stmtViolation);

                            // Check for errors in execution
                            if (mysqli_stmt_errno($stmtViolation) != 0) {
                                // Handle the error (you can log it or echo for debugging)
                                echo "Error inserting violation: " . mysqli_stmt_error($stmtViolation);
                                break;  // Exit the loop on error
                            }
                        }
                    }

                    // Close the statement after the loop
                    mysqli_stmt_close($stmtViolation);

                    // Redirect to a success page or perform any other actions as needed
                    header("Location: ../ctmeuticket.php");
                    exit();
                } else {
                    // Handle the prepared statement error for violation insertion
                    echo "Error preparing violations statement: " . mysqli_error($conn);
                }
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
