<?php
include 'database_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];

$query = "SELECT startTicket, endTicket FROM users WHERE user_ctmeu_id = '$userId'";
$result = mysqli_query($conn, $query);

if (!$result) {
 die("Database query failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);
$startTicket = $user['startTicket'];
$endTicket = $user['endTicket'];

if ($startTicket !== NULL && $endTicket !== NULL) {
 $query = "SELECT MAX(endTicket) AS maxEndTicket FROM users";
 $result = mysqli_query($conn, $query);
 $maxEndTicket = mysqli_fetch_assoc($result)['maxEndTicket'];
 $startTicket = $maxEndTicket === NULL ? 1 : $maxEndTicket + 1;
} else if ($startTicket === NULL && $endTicket === NULL) {
   $query = "SELECT MAX(endTicket) AS maxEndTicket FROM users";
   $result = mysqli_query($conn, $query);
   $maxEndTicket = mysqli_fetch_assoc($result)['maxEndTicket'];
   $startTicket = $maxEndTicket === NULL ? 1 : $maxEndTicket + 1;
  }

$endTicket = $startTicket + 49;

echo json_encode(['startTicket' => $startTicket, 'endTicket' => $endTicket]);
?>