<?php
include 'database_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$maxITSA = $data['maxITSA'];
$maxEncoder = $data['maxEncoder'];

$query = "UPDATE maxaccess SET maxITSA = ?, maxEncoder = ? where access_id = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $maxITSA, $maxEncoder);

if ($stmt->execute()) {
   echo json_encode(['success' => true]);
} else {
   echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>