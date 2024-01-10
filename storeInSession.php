<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'php/database_connect.php';

$_SESSION['rowData'] = $_POST['rowData'];
if (isset($_SESSION['rowData'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Session variable not set.']);
}
?>