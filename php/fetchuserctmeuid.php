<?php
session_start();
include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Sanitize and validate user input
    $username = $_SESSION['username'];

    // Fetch user_ctmeu_id based on username
    $query = "SELECT user_ctmeu_id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userCtmeuId);

        $response = array();

        if (mysqli_stmt_fetch($stmt)) {
            $response['user_ctmeu_id'] = $userCtmeuId;
        } else {
            $response['error'] = "User not found";
        }

        mysqli_stmt_close($stmt);

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle the prepared statement error
        $response['error'] = "Error preparing statement: " . mysqli_error($conn);

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Invalid request method
    http_response_code(400); // Bad Request
    echo "Invalid request method.";
}
?>
