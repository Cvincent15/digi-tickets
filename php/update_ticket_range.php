<?php
include 'database_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$startTicket = $data['startTicket'];
$endTicket = $data['endTicket'];

$query = "UPDATE users SET startTicket = '$startTicket', endTicket = '$endTicket', currentTicket = '$startTicket' WHERE user_ctmeu_id = '$userId'";
$result = mysqli_query($conn, $query);

if (!$result) {
 die("Database query failed: " . mysqli_error($conn));
}

echo json_encode(['success' => true]);
?>