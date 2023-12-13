<?php
include "../php/database_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = array();

    // Validate and sanitize the login form data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            if (mysqli_num_rows($res) != 0) {
                $row = mysqli_fetch_assoc($res);

                if ($username == $row['username'] && password_verify($password, $row['password'])) {
                    try {
                        $apiKey = bin2hex(random_bytes(23));
                    } catch (Exception $e) {
                        $apiKey = bin2hex(uniqid($username, true));
                    }

                    $sqlUpdate = "UPDATE users SET apiKey = '$apiKey' WHERE username = '$username'";
                    if (mysqli_query($conn, $sqlUpdate)) {
                        $result = array(
                            "status" => "success",
                            "message" => "Login Successful",
                            "username" => $row['username'],
                            "apiKey" => $apiKey
                        );
                    } else {
                        $result = array("status" => "failed", "message" => "Something went wrong, please try again later...");
                    }
                } else {
                    $result = array("status" => "failed", "message" => "Invalid username or password");
                }
            } else {
                $result = array("status" => "failed", "message" => "User not found");
            }
        } else {
            $result = array("status" => "failed", "message" => "Database query error");
        }
    } else {
        $result = array("status" => "failed", "message" => "Username and password are required");
    }
} else {
    $result = array("status" => "failed", "message" => "Invalid request method");
}

echo json_encode($result, JSON_PRETTY_PRINT);
?>
