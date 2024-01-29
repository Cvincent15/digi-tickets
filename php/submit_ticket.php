<?php
session_start();
include 'database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are not logged in
    header("Location: login");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


$mail = new PHPMailer(true);

ini_set('log_errors', '1');
ini_set('error_log', './error.log');

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
    $remarks = filter_var($_POST['remarks'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $date = filter_var($_POST['date_violation'], FILTER_SANITIZE_STRING);
    $time = filter_var($_POST['time_violation'], FILTER_SANITIZE_STRING);
    $userInput = $_POST['userInputControlNumber'];
    $currentTicket = $_POST['currentTicket'];
    $cor_number = $_POST['cor_number'];
    
    $user_ctmeu_id = $_POST['user_ctmeu_id']; // Assuming this is an integer

    // Check if the currentTicket is less than or equal to endTicket
    $queryCheckTicketRange = "SELECT currentTicket, endTicket FROM users WHERE user_ctmeu_id = ?";
    $stmtCheckTicketRange = mysqli_prepare($conn, $queryCheckTicketRange);
    mysqli_stmt_bind_param($stmtCheckTicketRange, "i", $user_ctmeu_id);
    mysqli_stmt_execute($stmtCheckTicketRange);
    mysqli_stmt_bind_result($stmtCheckTicketRange, $currentTicketValue, $endTicketValue);
    mysqli_stmt_fetch($stmtCheckTicketRange);
    mysqli_stmt_close($stmtCheckTicketRange);
    $combinedTicket = $userInput . $currentTicket;
    
    if ($currentTicketValue >= $endTicketValue) {
        // Redirect back to ticket-creation with an error message
        header("Location: ../ticket-creation?error=maxTicketReached");
        exit();
    }

    // Insert the form data into the violation_tickets table using prepared statements
    $insertTicketQuery = "INSERT INTO violation_tickets (user_ctmeu_id, driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, reg_owner, reg_owner_address, date_violation, time_violation, place_of_occurrence, remarks, control_number, cor_number, uniqueCode, email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insertTicketQuery);

    if ($stmt) {
        // Bind parameters and execute the statement
        $uniqueCode = uniqid();
        mysqli_stmt_bind_param($stmt, "isssssssssssssiss", $user_ctmeu_id, $driverName, $driverAddress, $licenseNo, $issuingDistrict, $vehicleType, $plateNo, $regOwner, $regOwnerAddress, $date, $time, $placeOfOccurrence, $remarks, $combinedTicket, $cor_number, $uniqueCode, $email);

                
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'projectctmeu@gmail.com';                 
            $mail->Password = 'pjviupysohjkginv';                           
            $mail->SMTPSecure = 'tls';                            
            $mail->Port = 587;                                    

            //Recipients
            $mail->setFrom('projectctmeu@gmail.com', 'City Traffic Management and Enforcement Unit - City of Santa Rosa');
            $mail->addAddress($email);     

            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'CTMEU Traffic Violation E-Receipt';
            $mail->Body    = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
            </head>
            <body>
            
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td align="center" bgcolor="#F4F5F6" style="padding: 24px 0;">
                        <table cellspacing="0" cellpadding="0" border="0" width="388" style="background: #F4F5F6;">
                            <!-- Header -->
                            <tr>
                                <td align="center">
                                    <img src="https://ctmeu-hub.net/images/ctmeusmall.png" width="50" height="50" style="display: block;">
                                </td>
                            </tr>
                            <!-- Main Content -->
                            <tr>
                                <td align="center" bgcolor="#FFFFFF" style="padding: 16px; border-radius: 20px; border: 1px solid #EAEBED;">
                                    <!-- Ticket Number -->
                                    <div style="color: #161F33; font-size: 16px; font-family: Inter; font-weight: 400; line-height: 20px; margin-bottom: 16px;">
                                        Your ticket number is <strong>' . $combinedTicket . '</strong>
                                    </div>
                                    <!-- Website -->
                                    <div style="color: #161F33; font-size: 16px; font-family: Inter; font-weight: 400; line-height: 22px; margin-bottom: 16px;">
                                        If you wish to view your traffic ticket you can head to
                                        <strong style="color: #0867EC;">ctmeu-hub.net/search-ticket</strong>
                                    </div>
                                    <!-- Unique Code -->
                                    <div style="color: #161F33; font-size: 16px; font-family: Inter; font-weight: 400; line-height: 20px; margin-bottom: 16px;">
                                        Please use the following unique code:
                                    </div>
                                    <!-- Unique Code Button -->
                                    <div align="center" style="margin-bottom: 16px;">
                                        <table cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td bgcolor="#0867EC" align="center" style="border-radius: 4px;">
                                                    <div style="color: #FFFFFF; font-size: 20px; font-family: Inter; font-weight: 700; padding: 12px 24px;">
                                                    ' . $uniqueCode . '
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <!-- Footer -->
                            <tr>
                                <td align="center" style="padding: 0 16px;">
                                    <div style="color: #787D88; font-size: 12px; font-family: Inter; font-weight: 600; line-height: 18px; margin-bottom: 8px;">
                                        CITY TRAFFIC MANAGEMENT AND ENFORCEMENT UNIT
                                    </div>
                                    <div style="color: #787D88; font-size: 12px; font-family: Inter; font-weight: 400; line-height: 18px;">
                                        CTMEU Office, F. Gomez St., Brgy. Kanluran,<br>
                                        Santa Rosa, Laguna, Philippines, 4026
                                    </div>
                                    <div style="color: #787D88; font-size: 12px; font-family: Inter; font-weight: 400; line-height: 18px; margin-top: 8px;">
                                        Contact Number: 09487448484<br>
                                        Operating Hours: 8 AM - 5 PM
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            </body>
            </html>
            ';

            $mail->send();
            $_SESSION['success_message'] = 'Ticket sent successfully.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
        }

        if (mysqli_stmt_execute($stmt)) {
            // Check if any rows were affected by the insertion
            if (mysqli_affected_rows($conn) > 0) {
                // Get the ID of the newly inserted ticket
                $ticketID = mysqli_insert_id($conn);

                /*
                // Increment the currentTicket for the user
                $incrementTicketQuery = "UPDATE users SET currentTicket = currentTicket + 1 WHERE user_ctmeu_id = ?";
                $stmtIncrement = mysqli_prepare($conn, $incrementTicketQuery);
                mysqli_stmt_bind_param($stmtIncrement, "i", $user_ctmeu_id);
                mysqli_stmt_execute($stmtIncrement);
                mysqli_stmt_close($stmtIncrement);
                */

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
                            mysqli_stmt_bind_param($stmtInsertViolatorInfo, "sssssssi", $combinedTicket, $driverName, $violationName, $date, $time, $violationFine, $violationSection, $violationId);
                            mysqli_stmt_execute($stmtInsertViolatorInfo);
                            mysqli_stmt_close($stmtInsertViolatorInfo);
                     
                            // Execute the prepared statement for each violation only if it doesn't exist for the ticket
                            mysqli_stmt_execute($stmtViolation);
                     
                            // Check for errors in execution
                            if (mysqli_stmt_errno($stmtViolation) != 0) {
                                continue;
                            }
                        }
                     }

                    // Close the statement after the loop
                    mysqli_stmt_close($stmtViolation);

                    // Redirect to a success page or perform any other actions as needed
                    $_SESSION['success_message'] = 'Ticket sent successfully.';
                    //header("Location: ../ticket-creation");
                    echo '<script>window.location.href = "../ticket-creation";</script>';
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Error preparing violations statement.';
                    //header('Location: user-creation');
                    echo '<script>window.location.href = "../ticket-creation";</script>';
                    exit();
                    echo "Error preparing violations statement: " . mysqli_error($conn);
                }
            } else {
                $_SESSION['error_message'] = 'Error inserting ticket: Ticket insertion failed.';
                    //header('Location: user-creation');
                    echo '<script>window.location.href = "../ticket-creation";</script>';
                    exit();
                echo "Error inserting ticket: Ticket insertion failed.";
            }
        } else {
            $_SESSION['error_message'] = 'Error inserting ticket: Ticket insertion failed.';
                    //header('Location: user-creation');
                    echo '<script>window.location.href = "../ticket-creation";</script>';
                    exit();
            echo "Error inserting ticket: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = 'Error preparing ticket insertion: Ticket insertion failed.';
                    //header('Location: user-creation');
                    echo '<script>window.location.href = "../ticket-creation";</script>';
                    exit();
        echo "Error preparing ticket insertion: " . mysqli_error($conn);
    }
}

// If the script reaches this point, it means there was no POST request or an error occurred.
// You can display the form again or perform other actions.
?>
