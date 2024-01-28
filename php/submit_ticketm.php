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
    $issuingDistrict = filter_var($_POST['cor_number'], FILTER_SANITIZE_STRING);
    $vehicleType = filter_var($_POST['vehicle_type'], FILTER_SANITIZE_STRING);
    $plateNo = filter_var($_POST['plate_no'], FILTER_SANITIZE_STRING);
    $regOwner = filter_var($_POST['reg_owner'], FILTER_SANITIZE_STRING);
    $regOwnerAddress = filter_var($_POST['reg_owner_address'], FILTER_SANITIZE_STRING);
    $placeOfOccurrence = filter_var($_POST['place_of_occurrence'], FILTER_SANITIZE_STRING);
    $remarks = filter_var($_POST['remarks'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date_violation'], FILTER_SANITIZE_STRING);
    $time = filter_var($_POST['time_violation'], FILTER_SANITIZE_STRING);
    $currentTicket = $_POST['currentTicket'];
    $cor_number = $_POST['cor_number'];
    $user_ctmeu_id = isset($_POST['user_ctmeu_id']) ? (int)$_POST['user_ctmeu_id'] : 0;
    
    // Check if the currentTicket is less than or equal to endTicket
    $queryCheckTicketRange = "SELECT currentTicket, endTicket FROM users WHERE user_ctmeu_id = ?";
    $stmtCheckTicketRange = mysqli_prepare($conn, $queryCheckTicketRange);
    mysqli_stmt_bind_param($stmtCheckTicketRange, "i", $user_ctmeu_id);
    mysqli_stmt_execute($stmtCheckTicketRange);
    mysqli_stmt_bind_result($stmtCheckTicketRange, $currentTicketValue, $endTicketValue);
    mysqli_stmt_fetch($stmtCheckTicketRange);
    mysqli_stmt_close($stmtCheckTicketRange);

    if ($currentTicketValue >= $endTicketValue) {
        // say something like contact IT Admin to renew your control number
        
    }

    // Insert the form data into the violation_tickets table using prepared statements
    $insertTicketQuery = "INSERT INTO violation_tickets (user_ctmeu_id, driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, reg_owner, reg_owner_address, date_violation, time_violation, place_of_occurrence, remarks, control_number, cor_number)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insertTicketQuery);

    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "isssssssssssssi", $user_ctmeu_id, $driverName, $driverAddress, $licenseNo, $issuingDistrict, $vehicleType, $plateNo, $regOwner, $regOwnerAddress, $date, $time, $placeOfOccurrence, $remarks, $currentTicket, $cor_number);

        if (mysqli_stmt_execute($stmt)) {
            // Get the ID of the newly inserted ticket
            $ticketID = mysqli_insert_id($conn);

            // Process violations data
            $selectedViolations = [];
            
                // Increment the currentTicket for the user
                $incrementTicketQuery = "UPDATE users SET currentTicket = currentTicket + 1 WHERE user_ctmeu_id = ?";
                $stmtIncrement = mysqli_prepare($conn, $incrementTicketQuery);
                mysqli_stmt_bind_param($stmtIncrement, "i", $user_ctmeu_id);
                mysqli_stmt_execute($stmtIncrement);
                mysqli_stmt_close($stmtIncrement);

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
        
                        // Check if the violation already exists for the ticket
                        $checkViolationQuery = "SELECT COUNT(*) FROM violations WHERE violationlist_id = ? AND ticket_id_violations = ?";
                        $stmtCheckViolation = mysqli_prepare($conn, $checkViolationQuery);
                        mysqli_stmt_bind_param($stmtCheckViolation, "ii", $violationId, $ticketID);
                        mysqli_stmt_execute($stmtCheckViolation);
                        mysqli_stmt_bind_result($stmtCheckViolation, $violationCount);
                        mysqli_stmt_fetch($stmtCheckViolation);
                        mysqli_stmt_close($stmtCheckViolation);
                        
                        if ($violationCount == 0) {
                            // Fetch violation_name, violation_fine, and violation_section from violationlists table
                            $fetchViolationInfoQuery = "SELECT violation_name, violation_fine, violation_section FROM violationlists WHERE violation_list_ids = ?";
                            $stmtFetchViolationInfo = mysqli_prepare($conn, $fetchViolationInfoQuery);
                            mysqli_stmt_bind_param($stmtFetchViolationInfo, "i", $violationId);
                            mysqli_stmt_execute($stmtFetchViolationInfo);
                            mysqli_stmt_bind_result($stmtFetchViolationInfo, $violationName, $violationFine, $violationSection);
                            mysqli_stmt_fetch($stmtFetchViolationInfo);
                            mysqli_stmt_close($stmtFetchViolationInfo);
                            
                            // Insert the fetched data into the violator_info table
                            $insertViolatorInfoQuery = "INSERT INTO violator_info (TCT_NUMBER, DRIVER_NAME, VIOLATION_NAME, VIOLATION_DATE, VIOLATION_TIME, VIOLATION_FINE, VIOLATION_SECTION, violationL_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmtInsertViolatorInfo = mysqli_prepare($conn, $insertViolatorInfoQuery);
                            mysqli_stmt_bind_param($stmtInsertViolatorInfo, "issssssi", $currentTicket, $driverName, $violationName, $date, $time, $violationFine, $violationSection, $violationId);
                            mysqli_stmt_execute($stmtInsertViolatorInfo);
                            mysqli_stmt_close($stmtInsertViolatorInfo);
                            
                         }

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
