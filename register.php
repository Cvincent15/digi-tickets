
<?php
session_start();
// Include your database connection code here
include 'php/database_connect.php';

// Function to count the number of users with a specific role
function countUsersWithRole($role) {
    global $conn;
    global $count;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}

// Function to check if a user with the same first name and last name exists
function userExists($firstName, $lastName) {
    global $conn;
    $stmt = $conn->prepare("SELECT username FROM users WHERE LOWER(first_name) = LOWER(?) AND LOWER(last_name) = LOWER(?)");
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count > 0;
}

// Function to check if a username already exists
function usernameExists($username) {
    global $conn;
    $usernameLower = strtolower($username); // Convert the username to lowercase
    $stmt = $conn->prepare("SELECT user_ctmeu_id FROM users WHERE LOWER(username) = ?");
    $stmt->bind_param("s", $usernameLower);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count > 0;
}


// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form and trim it
    $firstName = trim($_POST["firstName"]);
    $middleName = trim($_POST["middleName"]);
    $lastName = trim($_POST["lastName"]);
    $affixes = trim($_POST["affixes"]);
    $role = trim($_POST["role"]);
    $username = trim($_POST["username"]);
    $masterlist = trim($_POST["employeeid"]);

    // Set the default password for everyone
    $password = trim($_POST["password"]);

    // Hash the password (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Fetch the current counts of IT Administrators and Super Administrators from the maxaccess table
   $query = "SELECT maxITSA, maxEncoder FROM maxaccess where access_id = 1";
   $result = mysqli_query($conn, $query);
   $access = mysqli_fetch_assoc($result);
   $maxITSA = $access['maxITSA'];
   $maxEncoder = $access['maxEncoder'];
   
   // Count the number of existing users with the selected role
   $existingCount = countUsersWithRole($role);

   if (userExists($firstName, $lastName)) {
    $_SESSION['error_message'] = 'A user with the same first name and last name already exists. Please try with a different name.';
    header('Location: user-creation');
    exit();
    } elseif (usernameExists($username)) {
        $_SESSION['error_message'] = 'This username is already taken. Please choose a different username.';
        header('Location: user-creation');
        exit();
    } else {
        // Initialize the count variable
        $count = 0;

        // Check if the limit for the selected role has been reached
   if (($role === "Super Administrator" && $existingCount >= $maxITSA) ||
   ($role === "IT Administrator" && $existingCount >= $maxEncoder)) {
   echo "<script>alert('The limit for this role has been reached. Please choose a different role.');</script>";
   header('Location: user-creation');
}  else {
            // Prepare an SQL statement to insert the user data into the database
if (empty($masterlist)) {
    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, affixes, role, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstName, $middleName, $lastName, $affixes, $role, $username, $hashedPassword);
 } else {
    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, affixes, role, username, password, employee_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $firstName, $middleName, $lastName, $affixes, $role, $username, $hashedPassword, $masterlist);
 }
            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Registration successful.';
                header('Location: user-creation');
                exit();
            } else {
                // Registration failed
                echo "Error: " . $stmt->error;
            }

            // Close the statement and database connection
            $stmt->close();
        }
    }

    $conn->close();
}
?>
