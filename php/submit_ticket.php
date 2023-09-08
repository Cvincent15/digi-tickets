<?php
session_start();
include 'database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are not logged in
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form data
  $driverName = $_POST['driver_name'];
  $address = $_POST['driver_address'];
  $licenseNo = $_POST['driver_license'];
  $issuingDistrict = $_POST['issuing_district'];
  $vehicleType = $_POST['vehicle_type'];
  $plateNo = $_POST['plate_no'];
  $registrationNo = $_POST['cor_no'];
  $violations = $_POST['place_issued'];
  $registeredOwner = $_POST['reg_owner'];
  $ownerAddress = $_POST['reg_owner_address'];

  // Insert the form data into the database
  $query = "INSERT INTO violation_tickets (driver_name, driver_address, driver_license, issuing_district, vehicle_type, plate_no, cor_no, place_issued, reg_owner, reg_owner_address)
            VALUES ('$driverName', '$address', '$licenseNo', '$issuingDistrict', '$vehicleType', '$plateNo', '$registrationNo', '$violations', '$registeredOwner', '$ownerAddress')";

  if (mysqli_query($conn, $query)) {
    // Redirect to a success page or perform any other actions as needed
    header("Location: ../ctmeuopage.php");
    exit();
  } else {
    // Handle the database insert error
    echo "Error: " . mysqli_error($conn);
  }
}

// If the script reaches this point, it means there was no POST request or an error occurred.
// You can display the form again or perform other actions.
?>