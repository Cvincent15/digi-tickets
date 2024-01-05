<?php
session_start();
include 'database_connect.php';

ini_set('log_errors', '1');
ini_set('error_log', './error.log');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $violationsData = isset($_POST['violations']) ? $_POST['violations'] : '';
$decodedViolations = urldecode($violationsData);
$violationsArray = explode('|', $decodedViolations);
    $driverName = filter_var($_POST['driver_name'], FILTER_SANITIZE_STRING);
    $driverAddress = filter_var($_POST['driver_address'], FILTER_SANITIZE_STRING);
    $licenseNo = filter_var($_POST['driver_license'], FILTER_SANITIZE_STRING);
    $issuingDistrict = filter_var($_POST['issuing_district'], FILTER_SANITIZE_STRING);
    $vehicleType = filter_var($_POST['vehicle_type'], FILTER_SANITIZE_STRING);
    $plateNo = filter_var($_POST['plate_no'], FILTER_SANITIZE_STRING);
    $regOwner = filter_var($_POST['reg_owner'], FILTER_SANITIZE_STRING);
    $regOwnerAddress = filter_var($_POST['reg_owner_address'], FILTER_SANITIZE_STRING);
    $placeOfOccurrence = filter_var($_POST['place_of_occurrence'], FILTER_SANITIZE_STRING);
    $date_time = filter_var($_POST['date_time'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $user_ctmeu_id = isset($_POST['user_ctmeu_id']) ? (int)$_POST['user_ctmeu_id'] : 0;

    // Insert the form data into the violation_tickets table using prepared statements
    $insertTicketQuery = "INSERT INTO violation_tickets (user_ctmeu_id, driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, reg_owner, reg_owner_address, date_time_violation, place_of_occurrence, email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insertTicketQuery);

    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "isssssssssss", $user_ctmeu_id, $driverName, $driverAddress, $licenseNo, $issuingDistrict, $vehicleType, $plateNo, $regOwner, $regOwnerAddress, $date_time, $placeOfOccurrence, $email);

        if (mysqli_stmt_execute($stmt)) {
            // Get the ID of the newly inserted ticket
            $ticketID = mysqli_insert_id($conn);

            // Process violations data
            $selectedViolations = [];

            if (!empty($violationsArray)) {
    // Remove duplicate values
    $selectedViolations = array_unique($violationsArray);
}

           // Insert each selected violation into the violations table with the ticket_id_violations foreign key using prepared statements
$insertViolationQuery = "INSERT INTO violations (violationlist_id, ticket_id_violations) VALUES (?, ?)";
$stmtViolation = mysqli_prepare($conn, $insertViolationQuery);

if ($stmtViolation) {
    mysqli_stmt_bind_param($stmtViolation, "ii", $violationId, $ticketID);

    foreach ($selectedViolations as $violationString) {
        // Lookup the violationlist_id for the given violation string
        $lookupViolationQuery = "SELECT violation_list_ids FROM violationlists WHERE violation_name = ?";
        $stmtLookupViolation = mysqli_prepare($conn, $lookupViolationQuery);
        mysqli_stmt_bind_param($stmtLookupViolation, "s", $violationString);
        mysqli_stmt_execute($stmtLookupViolation);
        mysqli_stmt_bind_result($stmtLookupViolation, $violationId);
        mysqli_stmt_fetch($stmtLookupViolation);
        mysqli_stmt_close($stmtLookupViolation);

        if ($violationId !== null) {
            // Proceed with the insertion
            mysqli_stmt_execute($stmtViolation);

            if (mysqli_stmt_errno($stmtViolation) != 0) {
                // Handle the error (you can log it or echo for debugging)
                $error = "Error inserting violation: " . mysqli_stmt_error($stmtViolation);
                error_log($error);
                echo json_encode(['error' => $error]);
                exit();  // Exit the script on error
            }
        } else {
            // Handle the case where violationlist_id could not be found
            $error = "Violation ID not found for: $violationString";
            error_log($error);
            echo json_encode(['error' => $error]);
            // Decide if you want to exit the script, continue with the next violation, or handle it differently
        }
    }

    mysqli_stmt_close($stmtViolation);

    // Return a success response
    echo json_encode(['success' => true]);
    exit();
} else {
    // Handle the prepared statement error for violation insertion
    $error = "Error preparing violations statement: " . mysqli_error($conn);
    error_log($error);
    echo json_encode(['error' => $error]);
    exit();  // Exit the script on error
}

        } else {
            // Handle the prepared statement error for ticket insertion
            $error = "Error inserting ticket: " . mysqli_error($conn);
            error_log($error);
            echo json_encode(['error' => $error]);
            exit();  // Exit the script on error
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle the prepared statement error for ticket insertion
        $error = "Error preparing ticket insertion: " . mysqli_error($conn);
        error_log($error);
        echo json_encode(['error' => $error]);
        exit();  // Exit the script on error
    }
}

// If the script reaches this point, it means there was no POST request or an error occurred.
// You can display the form again or perform other actions.
?>
