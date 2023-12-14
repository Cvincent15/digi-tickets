<?php
session_start();
include 'database_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $driverName = filter_input(INPUT_POST, 'driver_name', FILTER_SANITIZE_STRING);
    $driverLicense = filter_input(INPUT_POST, 'driver_license', FILTER_SANITIZE_STRING);
    $plateNo = filter_input(INPUT_POST, 'plate_no', FILTER_SANITIZE_STRING);
    $dateTimeViolation = filter_input(INPUT_POST, 'date_time_violation', FILTER_SANITIZE_STRING);
    $placeOfOccurrence = filter_input(INPUT_POST, 'place_of_occurrence', FILTER_SANITIZE_STRING);
    $ticketId = intval($_POST['ticket_id']);

    if (strlen($driverName) < 2 || strlen($driverLicense) < 2 || empty($plateNo)) {
        echo "InvalidInput";
        exit();
    }

    $sql = "UPDATE violation_tickets 
            SET driver_name = ?, 
                driver_license = ?,
                plate_no = ?,
                date_time_violation = ?,
                place_of_occurrence = ?
            WHERE ticket_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $params = [
            "sssssi",
            &$driverName,
            &$driverLicense,
            &$plateNo,
            &$dateTimeViolation,
            &$placeOfOccurrence,
            &$ticketId,
        ];

        call_user_func_array([$stmt, 'bind_param'], $params);

        if ($stmt->execute()) {
            header("Location: ../ctmeupage.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "Error: Invalid request method";
}

$conn->close();
?>
