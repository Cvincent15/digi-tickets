<?php
session_start();
include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: index.php");
  exit();
}




?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Data Hub</title>
</head>
<style>
   .card {
        margin: 100px auto;
        width: 700px; /* Adjust the width as needed */
        height: auto; /* Adjust the height as needed */
        text-align: left;
    }
    button.Change {
        font-size: 18px; /* Adjust the font size as needed */
        padding: 12px 30px; /* Adjust the padding as needed */
    }
    table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
</style>
<body style="height: auto;">
<?php

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: index.php");
  exit();
}

// Fetch user data based on the logged-in user's username
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle the database query error
    die("Database query failed: " . mysqli_error($conn));
}

// Fetch the user's data
$user = mysqli_fetch_assoc($result);
$firstName = $user['first_name'];
$lastName = $user['last_name'];
$status = $user['role'];


?>

<nav class="navbar">
  <div class="logo">
    <img src="images/logo-ctmeu.png" alt="Logo">
  </div>
  <div class="navbar-text">
    <h2>City Traffic Management and Enforcement Unit</h1>
    <h1><b>Traffic Violation Data Hub</b></h2>
  </div>
  
  <div class="navbar-inner">
  <div class="navbar-right">
    <h5 id="welcome-text"></h5>
    <button class="btn btn-primary" id="logout-button">Log out?</button>
    
    <?php
    // Check the user's role (Assuming you have the role stored in a variable named $_SESSION['role'])
    if (isset($_SESSION['role'])) {
        $userRole = $_SESSION['role'];
        
        // Show the "User Account" link only for Enforcer users
        if ($userRole === 'Enforcer') {
            echo '<a href="ctmeuusers.php" class="link"><b>User Account</b></a>';
        } else {
            // For other roles, show the other links
            echo '<a href="ctmeupage.php" class="link">Records</a>';
            echo '<a href="ctmeurecords.php" class="link">Reports</a>';
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>';
            // Uncomment this line to show "Create Accounts" to other roles
            echo '<a href="ctmeucreate.php" id="noEnforcers" class="link">Create Accounts</a>';
            echo '<li><a class="dropdown-item" href="ctmeusettings.php">Settings</a></li>';
            echo '<a href="ctmeuusers.php" class="link"><b>User Account</b></a>';
        }
    }
    ?>
</div>
  </div>
</nav>

<div class="card">
  <form action="php/insert_ticket.php" method="post">
        <table>
            <tr>
                <th colspan="2">Driver Information</th>
            </tr>
            <tr>
                <td>Driver Name:</td>
                <td><input type="text" name="driver_name" required></td>
            </tr>
            <tr>
                <td>Driver Address:</td>
                <td><input type="text" name="driver_address" required></td>
            </tr>
            <tr>
                <td>Driver License:</td>
                <td><input type="text" name="driver_license" required></td>
            </tr>
            <tr>
                <td>Issuing District:</td>
                <td><input type="text" name="issuing_district" required></td>
            </tr>
            <tr>
                <td>Vehicle Type:</td>
                <td><input type="text" name="vehicle_type" required></td>
            </tr>
            <tr>
                <td>Plate Number:</td>
                <td><input type="text" name="plate_no" required></td>
            </tr>
            <tr>
                <td>COR Number:</td>
                <td><input type="number" name="cor_no"></td>
            </tr>
            <tr>
                <td>Place Issued:</td>
                <td><input type="text" name="place_issued"></td>
            </tr>
            <tr>
                <th colspan="2">Registered Owner Information</th>
            </tr>
            <tr>
                <td>Registered Owner:</td>
                <td><input type="text" name="reg_owner" required></td>
            </tr>
            <tr>
                <td>Owner Address:</td>
                <td><input type="text" name="reg_owner_address" required></td>
            </tr>
            <tr>
                <th colspan="2">Violation Details</th>
            </tr>
            <tr>
                <td>Date and Time of Violation:</td>
                <td><input type="datetime-local" name="date_time_violation" required></td>
            </tr>
            <tr>
                <td>Place of Occurrence:</td>
                <td><input type="text" name="place_of_occurrence" required></td>
            </tr>
            <tr>
                <td><input type="hidden" name="is_settled" value=0></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Submit">
    </form>
</div>

  <div class="table-container">
  
<table>
        
        <tbody id="ticket-table-body">
            <!-- Replace the sample data below with the data fetched from your database -->
           
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
<script>

$(document).ready(function () {
    // Add a click event listener to the Change Password button
    $('#changePasswordButton').click(function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get the form data
        var currentPassword = $('#currentPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        // Send an AJAX request to password_change.php
        $.ajax({
            type: 'POST',
            url: 'php/password_change.php',
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword,
                confirmPassword: confirmPassword
            },
            success: function (response) {
                if (response === "success") {
                    // Password updated successfully
                    alert('Password updated successfully!');
                } else if (response === "PasswordMismatch") {
                    alert('New password and confirm password do not match!');
                } else if (response === "InvalidPassword") {
                    alert('Current password is incorrect');
                } else {
                    alert('An error occurred: ' + response);
                }
            },
            error: function (xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    });
});


// Add a click event listener to the logout button
document.getElementById('logout-button').addEventListener('click', function() {
        // Perform logout actions here, e.g., clearing session, redirecting to logout.php
        // You can use JavaScript to redirect to the logout.php page.
        window.location.href = 'php/logout.php';
    });

    // Check if the user is logged in and update the welcome message
    <?php if (isset($_SESSION['role']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) { ?>
        var role = '<?php echo $_SESSION['role']; ?>';
        var firstName = '<?php echo $_SESSION['first_name']; ?>';
        var lastName = '<?php echo $_SESSION['last_name']; ?>';

        document.getElementById('welcome-text').textContent = 'Welcome, ' + role + ' ' + firstName + ' ' + lastName;
    <?php } ?>
</script>
</body>
</html>