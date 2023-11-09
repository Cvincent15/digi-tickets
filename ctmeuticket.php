<?php
session_start();
include 'php/database_connect.php';

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
$user_ctmeu_id = $user['user_ctmeu_id'];
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <title>CTMEU Data Hub</title>
</head>
<style>
    /* Add custom CSS for styling the dropdown with checkboxes */
    .dropdown {
            position: relative;
            width:300px;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content label {
            display: block;
            padding: 10px;
        }

        .dropdown-content label input[type="checkbox"] {
            margin-right: 5px;
        }
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
<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFFFFF">
  <div class="container-fluid">
  <a class="navbar-brand" href="motoristlogin.php">
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-middle">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> <span style="font-weight: 600;"> Data Hub </span>
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
          <?php
    // Check the user's role (Assuming you have the role stored in a variable named $_SESSION['role'])
    if (isset($_SESSION['role'])) {
        $userRole = $_SESSION['role'];
        
        // Show the "User Account" link only for Enforcer users
        if ($userRole === 'Enforcer') {
            echo '<li class="nav-item">
            <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
          </li>';
        } else {
            // For other roles, show the other links
            if ($_SESSION['role'] === 'IT Administrator') {
                // Do not display the "Create Accounts" link
            } else {
                // Display the "Create Accounts" link
            //    echo '<a href="ctmeurecords.php" class="nav-link">Reports</a>';


            echo '<a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a>';

            echo '<li class="nav-item">
          <a class="nav-link" href="ctmeuarchive.php" style="font-weight: 600;">Archive</a>
        </li>';

       /* echo '<li class="nav-item">
            <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
          </li>'; */

            }
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<li class="nav-item">
            <a class="nav-link" href="ctmeupage.php" style="font-weight: 600; ">Records</a>
          </li>';



        
            
            
        }
    }
    ?>
          <li class="nav-item">
            <!-- <a class="nav-link" href="#">Contact</a> -->
          </li>
        </ul>
        <div class="dropdown-center">
  <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
  <img src="./images/Icon.png" style="margin-right: 10px;"><span id="welcome-text"></span>
  </button>
  <ul class="dropdown-menu">
  <?php
    // Check the user's role (Assuming you have the role stored in a variable named $_SESSION['role'])
    if (isset($_SESSION['role'])) {
        $userRole = $_SESSION['role'];
        
        // Show the "User Account" link only for Enforcer users
        if ($userRole === 'Enforcer') {
            echo '<li><a class="dropdown-item active" href="ctmeuusers.php">User Account</a></li>';
        } else {
            // For other roles, show the other links
            if ($_SESSION['role'] === 'IT Administrator') {
                // Do not display the "Create Accounts" link
            } else {
                // Display the "Create Accounts" link
            //    echo '<a href="ctmeurecords.php" class="link">Reports</a>';
            }
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<li><a class="dropdown-item active" href="ctmeuusers.php">User Account</a></li>';
            // Uncomment this line to show "Create Accounts" to other roles
            echo '<li><a class="dropdown-item" href="ctmeucreate.php">Create Account</a></li>';
            
        }
    }
    ?>
    <li><a class="dropdown-item" id="logout-button" style="cursor: pointer;">Log Out</a></li>
  </ul>
</div>
    </div>
    </div>
  </div>
</nav>

<div class="container card p-5 w-75">
    <h3>Input Ticket Info</h3>

    <form class="form-floating mb-3" method="post" action="./php/submit_ticket.php" id="ticketmaker">
        <!-- Add a hidden input field for user_ctmeu_id -->
        <input type="hidden" name="user_ctmeu_id" value="<?php echo $user_ctmeu_id; ?>">
<div class="row">
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue1" required minlength="10" maxlength="30" placeholder="Driver's Name" name="driver_name" required>
        <label for="floatingInputValue1">Driver's Name</label>
    </div>
    </div>
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue2" minlength="10" maxlength="50" placeholder="Address" name="driver_address" required>
        <label for="floatingInputValue2">Address</label>
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue3" minlength="10" maxlength="30" placeholder="Driver's License" name="driver_license" required>
        <label for="floatingInputValue3">License No.</label>
    </div>
    </div>
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue4" minlength="5" maxlength="30" placeholder="Address" name="issuing_district" required>
        <label for="floatingInputValue4">Issuing Disctrict</label>
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue5" minlength="3" maxlength="20" placeholder="Vehicle Type" name="vehicle_type" required>
        <label for="floatingInputValue5">Vehicle Type</label>
    </div>
    </div>
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue6" minlength="6" maxlength="7" placeholder="Plate No." name="plate_no" required>
        <label for="floatingInputValue6">Plate No.</label>
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue7" minlength="10" maxlength="10" placeholder="Certificate of Registration No." name="cor_no" required>
        <label for="floatingInputValue7">Certificate of Registration No.</label>
    </div>
    </div>
    <div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputValue8" minlength="5" maxlength="30" placeholder="Place Issued" name="place_issued" required>
        <label for="floatingInputValue7">Place Issued (COR)</label>
    </div>
    </div>
</div>
<div class="row">
    <div class="col">
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingInputValue9" minlength="10" maxlength="30" placeholder="Registered Owner" name="reg_owner" required>
        <label for="floatingInputValue9">Registered Owner</label>
    </div>
    </div>
    <div class="col">
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingInputValue10" minlength="10" maxlength="50" placeholder="Registered Owner Address" name="reg_owner_address" required>
        <label for="floatingInputValue10">Registered Owner Address</label>

    </div>
    </div>
</div>
<br>
<div class="row">
<div class="col">
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingInputValue11" minlength="2" maxlength="30" placeholder="Place of Occurrence" name="place_of_occurrence" required>
        <label for="floatingInputValue10">Place of Occurrence</label>

    </div>
    </div>
    <div class="col">
    <div class="input-group input-group-lg mb-3">
        <label class="input-group-text" for="inputGroupSelect01" name="place_issued">Violation/s</label>
        <div class="dropdown" id="inputGroupSelect01">
        <button type="button" onclick="toggleDropdown()" class="dropbtn input-group-text" style="width:300px; height:50px;">Select</button>
            <div id="optionsDropdown" class="dropdown-content">
            <label><input type="checkbox" name="violations[]" value="Driving without license">Driving without license</label>
            <label><input type="checkbox" name="violations[]" value="Driving with a delinquent, invalid, suspended ineffectual or revoked license">Driving with a delinquent, invalid, suspended ineffectual or revoked license</label>
            <label><input type="checkbox" name="violations[]" value="Fake or Counterfeit License">Fake or Counterfeit License</label>
            <label><input type="checkbox" name="violations[]" value="Defective horn or signaling device">Defective horn or signaling device</label>
            <label><input type="checkbox" name="violations[]" value="Defective brakes">Defective brakes</label>
            <label><input type="checkbox" name="violations[]" value="Tampered/marked plate or stickers">Tampered/marked plate or stickers</label>
            </div>
        </div>
    </div>
</div>

</div>

<button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
</div>


<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
<script>

    // Apply symbol restriction to all text input fields
    const form = document.getElementById('ticketmaker');
const inputs = form.querySelectorAll('input[type="text"]');

inputs.forEach(input => {
    input.addEventListener('input', function (e) {
        const inputValue = e.target.value;
        const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 \-]/g, ''); // Allow letters, numbers, spaces, @ symbol, and hyphens
        e.target.value = sanitizedValue;
    });
});

    // Custom JavaScript to show/hide the dropdown
    function toggleDropdown() {
            var dropdown = document.getElementById("optionsDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }

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

  $(document).ready(function () {
    // Display user data in placeholders
    $('#fname-text').text("First Name: " + '<?php echo $firstName; ?>');
    $('#lname-text').text("Last Name: " + '<?php echo $lastName; ?>');
    $('#stat-text').text("Role: " + '<?php echo $status; ?>');

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

        document.getElementById('welcome-text').textContent = firstName + ' ' + lastName;
    <?php } ?>
</script>
</body>
</html>