<?php
session_start();
include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: login");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
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
<body style="height: 100vh; background: linear-gradient(to bottom, #1F4EDA, #102077);">
<?php

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: login");
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
                <a class="navbar-brand" href="records">
                    <img src="./images/ctmeusmall.png" class="d-inline-block align-text-middle">
                    <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> <span style="font-weight: 600;"> Data
                        Hub
                    </span>
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
                                    echo '<li class="nav-item">
            <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
          </li>';
                                    //Reports page temporary but only super admin has permission
                                    
                                    echo '<li class="nav-item"> <a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a> </li>';
                                } else {
                                    // Display the "Create Accounts" link
                                    //    echo '<a href="ctmeurecords.php" class="nav-link">Reports</a>';
                        
                                    echo '<li class="nav-item">
            <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
          </li>';
                                    echo '<a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a>';

                                    echo '<li class="nav-item">
          <a class="nav-link" href="archives" style="font-weight: 600;">Archive</a>
        </li>';

                                    /* echo '<li class="nav-item">
                                         <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
                                       </li>'; */

                                }
                                // Uncomment this line to show "Activity Logs" to other roles
                                // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
                                echo '<li class="nav-item">
            <a class="nav-link" href="records" style="font-weight: 600; ">Records</a>
          </li>';

                            }
                        }
                        ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#">Contact</a> -->
                        </li>
                    </ul>
                    <div class="dropdown-center">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="./images/Icon.png" style="margin-right: 10px;"><span id="welcome-text"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            // Check the user's role (Assuming you have the role stored in a variable named $_SESSION['role'])
                            if (isset($_SESSION['role'])) {
                                $userRole = $_SESSION['role'];

                                // Show the "User Account" link only for Enforcer users
                                if ($userRole === 'Enforcer') {
                                    echo '<li><a class="dropdown-item" href="user-profile">User Account</a></li>';
                                } else {
                                    // For other roles, show the other links
                                    if ($_SESSION['role'] === 'IT Administrator') {
                                        // Do not display the "Create Accounts" link
                                    } else {
                                        echo '<li><a class="dropdown-item" href="user-creation">Create Account</a></li>';
                                        echo '<li><a class="dropdown-item" href="settings">Ticket Form</a></li>';
                                    }
                                    // Uncomment this line to show "Activity Logs" to other roles
                                    // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
                                    echo '<li><a class="dropdown-item" href="user-profile">User Account</a></li>';
                                    // Uncomment this line to show "Create Accounts" to other roles
                            

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
<div class="container justify-content-center align-items-center mx-auto">
    <div class="row">
<div class="card text-center mb-3" style="width: 35%;">
  <div class="card-body">
    <h2 class="card-title m-4" style="color: #1A3BB1; font-weight: 800;">User Details</h1>
    <div class="row pt-4 pb-4 ps-4 border-bottom align-text-middle text-start">
        <div class="col">
            First Name
        </div>
        <div class="col" style="font-weight: 600;">
        <?php echo $firstName; ?>
        </div>
    </div>
    <div class="row pt-4 pb-4 ps-4 border-bottom align-text-middle text-start">
        <div class="col">
            Last Name
        </div>
        <div class="col" style="font-weight: 600;">
        <?php echo $lastName; ?>
        </div>
    </div>
    <div class="row pt-4 pb-4 ps-4 align-text-middle text-start">
        <div class="col">
            Role
        </div>
        <div class="col" style="font-weight: 600;">
        <?php if ($status == 'IT Administrator') {
    echo "Encoder";
} elseif ($status == 'Super Administrator') {
    echo "IT Admin/Super Admin";
} else {
    echo $status;
} ?>
        </div>
    </div>
  </div>
</div>
</div>
<div class="row">
<button class="btn btn-primary" type="button" style="width: 35%; height: 3rem; margin: 20px auto; color: #122CA6; background-color: #FFFFFF; font-weight: 600;" data-toggle="modal" data-target="#passwordModal">Change Password</button>
</div>
</div>
<div class="modal fade" id="passwordModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-5">
            <div class="container">
                <div class="row">
                <div class="col-md-6 d-flex justify-content-center"> <!-- Centered the column content -->
    <img class="m-4" src="./images/password illustration.png" >
</div>
                    <div class="col-md-6 p-5 rounded-5" style="height: auto; background: linear-gradient(to bottom, #1F4EDA, #102077);">
                        <h1 class="text-center" style="color: #FFFFFF; font-weight: 700;">Set your password</h1>
                        <h6 class="text-center" style="color: #FFFFFF;">In order to keep your account safe you need to create a strong password.</h6> <!-- Closed the h6 tag -->
                        <form id="passwordChangeForm" class="form-floating w-auto" method="POST" >
                            <div class="card m-2 w-auto">
                            <div class="form-floating m-4 mb-3" style="position: relative;">
                                <input type="password" class="form-control" id="currentPassword" placeholder="password" name="currentPassword" required maxlength="20">
                                <label for="currentPassword" for="password" class="form-label">Current Password</label>
                                <button type="button" id="togglePassword" class="btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">Show</button>
                            </div>
                            <div class="form-floating ms-4 me-4 mb-3" style="position: relative;">
                            <input type="password" class="form-control" id="newPassword" placeholder="password" name="newPassword" required maxlength="20" onkeyup="checkPasswordRequirements()">
                                <label for="newPassword" class="form-label">New Password</label> <!-- Changed "for" attribute to match the input id -->
                                <button type="button" id="toggleNewPassword" class="btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">Show</button>
                            </div>
                            <div class="form-floating ms-4 me-4 mb-3" style="position: relative;">
                                <input type="password" class="form-control" id="confirmPassword" placeholder="password" name="confirmPassword" required maxlength="20">
                                <label for="confirmPassword" class="form-label">Confirm Password</label> <!-- Changed "for" attribute to match the input id -->
                            </div>
                            <div>
        <h9 class="ms-5 me-5" style="font-weight: bold;">Password must contain: </h9>
        <p class="ms-5 me-5 mt-3 mb-1">
            <span class="requirement-indicator">
                <span class="indicator-circle red-circle" id="length-indicator"></span> Between 8 to 20 characters
            </span>
        </p>
        <p class="ms-5 me-5 mt-1 mb-1">
            <span class="requirement-indicator">
                <span class="indicator-circle red-circle" id="uppercase-indicator"></span> At least 1 Uppercase Letter
            </span>
        </p>
        <p class="ms-5 me-5 mt-1 mb-1">
            <span class="requirement-indicator">
                <span class="indicator-circle red-circle" id="number-indicator"></span> At least 1 Number
            </span>
        </p>
        <p class="ms-5 me-5 mt-1">
            <span class="requirement-indicator">
                <span class="indicator-circle red-circle" id="special-char-indicator"></span> At least 1 Special Character
            </span>
        </p>
    </div>

                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="button" style="color: #122CA6; background-color: #FFFFFF; font-weight: 600;" id="changePasswordButton">Change Password</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
        </div>
    </div>
</div>

<div class="modal fade" id="successModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <i><img class="m-3" src="./images/check.png"></i> <!-- Check icon -->
                    <h5 class="modal-title mb-3" style="font-weight: 800;">Password Changed!</h5>
                    <p class="mb-3" style="font-weight: 500;">Your password has been changed successfully.</p>
                    <button type="button" class="btn btn-primary mb-3" id="okButton" data-dismiss="modal" style="background-color: #0A157A;">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="card">
  <h1 style='text-align:center;'>User Details</h1>
  <h4 id='fname-text' style='margin-left:20px;'></h4>
  <h4 id='lname-text' style='margin-left:20px;'></h4>
  <h4 id='stat-text' style='margin-left:20px;'></h4><br>
  <form id="passwordChangeForm" style="text-align: center;" method="POST">
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

            <button class='btn btn-primary Change' type="submit" style='margin: 20px auto;' id="changePasswordButton">Change Password</button>

        </form>
</div>  -->

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

    // Apply symbol restriction to all text input fields
    const form = document.getElementById('passwordChangeForm');
        const inputs = form.querySelectorAll('input[type="text"], input[type="password"]');

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
                // Close the first modal (passwordModal)
                $('#passwordModal').modal('hide');
                
                // Show the success modal (successModal)
                $('#successModal').modal('show');
                
                // You can also clear the form fields if needed
                $('#currentPassword').val('');
                $('#newPassword').val('');
                $('#confirmPassword').val('');
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

        // Add a click event listener to the "OK" button in the success modal
        $('#okButton').click(function () {
            // Reload the page
            location.reload();
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

    const passwordInput = document.getElementById('currentPassword');
    const toggleButton = document.getElementById('togglePassword');
    const newPasswordInput = document.getElementById('newPassword');
    const toggleNewButton = document.getElementById('toggleNewPassword');

    toggleButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            toggleButton.textContent = 'Show';
        }
    });

    toggleNewButton.addEventListener('click', function () {
        if (newPasswordInput.type === 'password') {
            newPasswordInput.type = 'text';
            toggleNewButton.textContent = 'Hide';
        } else {
            newPasswordInput.type = 'password';
            toggleNewButton.textContent = 'Show';
        }
    });

    function checkPasswordRequirements() {
            const password = document.getElementById('newPassword').value;
            const lengthIndicator = document.getElementById('length-indicator');
            const uppercaseIndicator = document.getElementById('uppercase-indicator');
            const numberIndicator = document.getElementById('number-indicator');
            const specialCharIndicator = document.getElementById('special-char-indicator');

            // Check password length
            if (password.length >= 8 && password.length <= 20) {
                lengthIndicator.classList.remove('red-circle');
                lengthIndicator.classList.add('green-circle');
            } else {
                lengthIndicator.classList.remove('green-circle');
                lengthIndicator.classList.add('red-circle');
            }

            // Check for at least 1 uppercase letter
            if (/[A-Z]/.test(password)) {
                uppercaseIndicator.classList.remove('red-circle');
                uppercaseIndicator.classList.add('green-circle');
            } else {
                uppercaseIndicator.classList.remove('green-circle');
                uppercaseIndicator.classList.add('red-circle');
            }

            // Check for at least 1 number
            if (/\d/.test(password)) {
                numberIndicator.classList.remove('red-circle');
                numberIndicator.classList.add('green-circle');
            } else {
                numberIndicator.classList.remove('green-circle');
                numberIndicator.classList.add('red-circle');
            }

            // Check for at least 1 special character (you can define your own set of special characters)
            const specialChars = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-|=]/;
            if (specialChars.test(password)) {
                specialCharIndicator.classList.remove('red-circle');
                specialCharIndicator.classList.add('green-circle');
            } else {
                specialCharIndicator.classList.remove('green-circle');
                specialCharIndicator.classList.add('red-circle');
            }
        }

        const specialChars = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\\/\-|=]/;
    if (specialChars.test(password)) {
        specialCharIndicator.classList.remove('red-circle');
        specialCharIndicator.classList.add('green-circle');
    } else {
        specialCharIndicator.classList.remove('green-circle');
        specialCharIndicator.classList.add('red-circle');
    }
</script>
<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>