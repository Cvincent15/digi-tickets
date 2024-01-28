<?php
session_start();
include 'database_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $driverName = filter_input(INPUT_POST, 'driver_name', FILTER_SANITIZE_STRING);
    $driverAddress = filter_input(INPUT_POST, 'driver_address', FILTER_SANITIZE_STRING);
    $driverLicense = filter_input(INPUT_POST, 'driver_license', FILTER_SANITIZE_STRING);
    $issuingDistrict = filter_input(INPUT_POST, 'issuing_district', FILTER_SANITIZE_STRING);
    $plateNo = filter_input(INPUT_POST, 'plate_no', FILTER_SANITIZE_STRING);
    $regOwner = filter_input(INPUT_POST, 'reg_owner', FILTER_SANITIZE_STRING);
    $regOwnerAddress = filter_input(INPUT_POST, 'reg_owner_address', FILTER_SANITIZE_STRING);
    $corNo = filter_input(INPUT_POST, 'cor_number', FILTER_SANITIZE_NUMBER_INT);
  
    $placeOfOccurrence = filter_input(INPUT_POST, 'place_of_occurrence', FILTER_SANITIZE_STRING);
    $ticketId = intval($_POST['ticket_id']);

    if (strlen($driverName) < 2 || strlen($driverLicense) < 2 || empty($plateNo)) {
        echo "InvalidInput";
        exit();
    }

    $sql = "UPDATE violation_tickets 
            SET driver_name = ?, driver_address = ?, 
                driver_license = ?, issuing_district = ?,
                plate_no = ?, reg_owner = ?, reg_owner_address = ?, cor_number = ?,
                place_of_occurrence = ?
            WHERE ticket_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $params = [
            "sssssssisi",
            &$driverName,
            &$driverAddress,
            &$driverLicense,
            &$issuingDistrict,
            &$plateNo,
            &$regOwner,
            &$regOwnerAddress,
            &$corNo,
            &$placeOfOccurrence,
            &$ticketId,
        ];

        call_user_func_array([$stmt, 'bind_param'], $params);

        if ($stmt->execute()) {
            header("Location: ../records");
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
