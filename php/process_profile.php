<?php
session_start();
include 'database_connect.php';

if (isset($_POST['users_motorists_info_id'])) {
    // Retrieve data from the form
    $usersMotoristsInfoId = $_POST['users_motorists_info_id'];
    $areaCode = $_POST['dacode'];
    $civilStatus = $_POST['civilstatus'];
    $birthplace = $_POST['birthplace'];
    $bloodType = $_POST['bloodtype'];
    $complexion = $_POST['complexion'];
    $eyeColor = $_POST['eyecolor'];
    $hairColor = $_POST['haircolor'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $organDonor = $_POST['organdonor'];
    $emName = $_POST['emname'];
    $emAreaCode = $_POST['emareacode'];
    $emMobile = $_POST['emmobile'];
    $emAddress = $_POST['emaddress'];
    $address = $_POST['address'];

    // Check if a row with the given users_motorists_info_id already exists
    $stmt = $conn->prepare("SELECT * FROM motorist_info WHERE users_motorists_info_id = ?");
    $stmt->bind_param("s", $usersMotoristsInfoId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // A matching row exists, update the data
        $stmt = $conn->prepare("UPDATE motorist_info SET driver_area_code = ?, civil_status = ?, birthplace = ?, blood_type = ?, complexion = ?, eye_color = ?, hair_color = ?, weight = ?, height = ?, organ_donor = ?, em_name = ?, em_area_code = ?, em_mobile = ?, em_address = ?, address = ? WHERE users_motorists_info_id = ?");
        
        $stmt->bind_param("ssssssssssssssss", $areaCode, $civilStatus, $birthplace, $bloodType, $complexion, $eyeColor, $hairColor, $weight, $height, $organDonor, $emName, $emAreaCode, $emMobile, $emAddress, $address, $usersMotoristsInfoId);
        
        if ($stmt->execute()) {
            // Successfully updated the data
            header("Location: ../MotoristMain.php"); // Redirect to the main page
            exit();
        } else {
            // Error occurred while updating data
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // No matching row found, insert the data
        $stmt = $conn->prepare("INSERT INTO motorist_info (driver_area_code, civil_status, birthplace, blood_type, complexion, eye_color, hair_color, weight, height, organ_donor, em_name, em_area_code, em_mobile, em_address, address, users_motorists_info_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssssssssssssss", $areaCode, $civilStatus, $birthplace, $bloodType, $complexion, $eyeColor, $hairColor, $weight, $height, $organDonor, $emName, $emAreaCode, $emMobile, $emAddress, $address, $usersMotoristsInfoId);
        
        if ($stmt->execute()) {
            // Successfully inserted the data
            header("Location: ../MotoristMain.php"); // Redirect to the main page
            exit();
        } else {
            // Error occurred while inserting data
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    // Handle the case where the form data is not set
    echo "Form data not set.";
}

// Close the database connection
$conn->close();
?>
