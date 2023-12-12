<?php
include "../php/database_connect.php";
if (!empty($_POST['email']) && !empty($_POST['apiKey'])){
    $username = $_POST['username'];
    $apiKey = $_POST['apiKey'];
    $result = array();
    if($conn){
        $sql = "SELECT * from users where username = '".$username."' and apiKey ='".$apiKey."'";
        $res = mysqli_query($con, $sql); 
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_assoc($res);
            $result = array("status" => "success", "message" => "Data fetched successfully", "username" => $row['username'], "apiKey" => $row['apiKey']);
            } else $result = array("status" => "failed", "message" => "Unauthorised access");
        } else $result = array("status" => "failed", "message" => "Database connection failed");
    } else $result = array("status" => "failed", "message" => "All fields are required");

echo json_encode($result, JSON_PRETTY_PRINT);
?>
