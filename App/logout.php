<?php
if (!empty($_POST['username']) && !empty($_POST['apiKey'])) {
    $username = $_POST['username'];
    $apiKey = $_POST['apiKey'];
 
    if ($conn) {
        $sql = "SELECT * from users where username = '" . $username . "' and apiKey '" . $apiKey . "'"; 
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_assoc($res);
            $sqlUpdate = "UPDATE users set apiKey = '' where username = '" . $username . "'";
            if (mysqli_query($conn, $sqlUpdate)) { 
                    echo "success";
                } else echo "Logout failed";
            } else echo "Unauthorised to access"; 
        } else echo "Database connection failed";
    } else echo "All fields are required";

?>