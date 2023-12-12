<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['filteredData'])) {
  // Retrieve the filtered data from the AJAX request
  $filteredData = json_decode($_POST['filteredData'], true);

  // Store the filtered data in a session variable
  $_SESSION['filtered_data'] = $filteredData;

  // Respond with a success message or any other response if needed
  echo json_encode(['success' => true]);
} else {
  // Respond with an error message if the filtered data is not received
  echo json_encode(['error' => 'Filtered data not received.']);
}
?>
