<?php
session_start();
//include 'php/database_connect.php';

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
</style>
<body style="height: auto;">
<?php
include 'php/database_connect.php'; // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to the login page if not logged in
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

// Process password change request if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve submitted data
  $currentPassword = $_POST['currentPassword'];
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];

  // Validate the current password (you might want to implement a more secure validation)
  if ($currentPassword === $user['password']) {
      if ($newPassword === $confirmPassword) {
          // Validate the new password length
          if (validatePasswordLength($newPassword)) {
              // Update the user's password in the database
              $newPassword = mysqli_real_escape_string($conn, $newPassword);
              $updateQuery = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
              $updateResult = mysqli_query($conn, $updateQuery);

              if ($updateResult) {
                  // Password successfully updated
                  echo "Password updated successfully.";
              } else {
                  // Handle the database update error
                  echo "Password update failed: " . mysqli_error($conn);
              }
          } else {
              echo "New password should be at least 8 characters long.";
          }
      } else {
          echo "New password and confirm password do not match.";
      }
  } else {
      echo "Current password is incorrect.";
  }
}
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
            echo '<a href="ctmeuusers.php" class="link"><b>User Account</b></a>';
        }
    }
    ?>
</div>
  </div>
</nav>

<div class="card">
  <h1 style='text-align:center;'>User Details</h1>
  <h4 id='fname-text' style='margin-left:20px;'></h4>
  <h4 id='lname-text' style='margin-left:20px;'></h4>
  <h4 id='stat-text' style='margin-left:20px;'></h4><br>
  <form id="passwordChangeForm" style="text-align: center;">
    <div style="display: flex; justify-content: space-between; margin: 0 20px;">
      <h4 for="currentPassword" style="text-align: left;">Current Password:</h4>
      <input type="password" id="currentPassword" name="currentPassword" required>
    </div>

    <div style="display: flex; justify-content: space-between; margin: 0 20px;">
      <h4 for="newPassword" style="text-align: left;">New Password:</h4>
      <input type="password" id="newPassword" name="newPassword" required>
    </div>

    <div style="display: flex; justify-content: space-between; margin: 0 20px;">
      <h4 for="confirmPassword" style="text-align: left;">Confirm New Password:</h4>
      <input type="password" id="confirmPassword" name="confirmPassword" required>
    </div>

    <button class='btn btn-primary Change' type="submit" style='margin: 20px auto;'>Change Password</button>
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
  function validatePasswordLength($password) {
    return strlen($password) >= 8;
}

  $(document).ready(function () {
    // Display user data in placeholders
    $('#fname-text').text("First Name: " + '<?php echo $firstName; ?>');
    $('#lname-text').text("Last Name: " + '<?php echo $lastName; ?>');
    $('#stat-text').text("Role: " + '<?php echo $status; ?>');

    // Handle the password change form submission
    $('#passwordChangeForm').submit(function (e) {
        e.preventDefault();
        var currentPassword = $('#currentPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        // Send a POST request to your PHP script to process the password change
        $.post('php/password_change.php', {
            currentPassword: currentPassword,
            newPassword: newPassword,
            confirmPassword: confirmPassword
        }, function (data) {
            // Display the result of the password change operation
            alert(data);
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