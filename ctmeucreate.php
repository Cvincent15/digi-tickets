<?php
session_start();
include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: index.php");
  exit();
}

// Function to count the number of super administrators
function countSuperAdmins($conn) {
  $sql = "SELECT COUNT(*) as count FROM users WHERE role = 'Super Administrator'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return $row['count'];
}

?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <title>CTMEU Data Hub</title>
</head>
<style>
    .clickable-cell {
      cursor: pointer;
    }
  /*  .container {
      margin-top:10px;
      border-radius:10px;
      display: flex;
      justify-content: space-between;
      background-color: white;
      min-width: auto; 
    }*/ 

    .form-container {
      flex-basis: 50%;
      padding: 20px;
    }

    .table-container {
      flex-basis: 50%;
      padding: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100% auto;
    }

    th, td {
      text-align: left;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }

    form {
      margin-bottom: 20px;
    }

    input[type="text"], input[type="password"],input[type="number"], select {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

   /* button {
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin-right: 10px;
      border: none;
      cursor: pointer;
    } */

    button[type="submit"] {
      background-color: #4CAF50;
    }

    button[type="reset"] {
      background-color: #f44336;
    }

.search-container {
  text-align: center;
}

#search-bar {
  padding: 10px;
  width: 60%;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.error {
      color: red;
      font-size: 14px;
      margin-top: -8px;
      margin-bottom: 16px;
    }
    table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:hover {
            background-color: grey;
        }
  </style>
<body style="height: auto;">
<?php
// Check if the limit_reached session variable is set
if (isset($_SESSION["limit_reached"]) && $_SESSION["limit_reached"] === true) {
  // Display the Bootstrap Modal when the limit is reached
  echo '
  <div class="modal fade" id="limitReachedModal" tabindex="-1" aria-labelledby="limitReachedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="limitReachedModalLabel">User Limit Reached</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>User limit for this role has been reached.</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>';
  
  // Clear the session variable
  $_SESSION["limit_reached"] = false;
}
?>
<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFFFFF">
  <div class="container-fluid">
  <a class="navbar-brand" href="ctmeupage.php">
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
                echo '<li class="nav-item">
            <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
          </li>';
          //Reports page temporary but only super admin has permission
                echo '<a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a>';
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
            echo '<li><a class="dropdown-item" href="ctmeuusers.php">User Account</a></li>';
        } else {
            // For other roles, show the other links
            if ($_SESSION['role'] === 'IT Administrator') {
                // Do not display the "Create Accounts" link
            } else {
                echo '<li><a class="dropdown-item active" href="ctmeucreate.php">Create Account</a></li>';
            echo '<li><a class="dropdown-item" href="ctmeusettings.php">Ticket Form</a></li>';
            }
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<li><a class="dropdown-item" href="ctmeuusers.php">User Account</a></li>';
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
<div class="container bg-transparent mt-5" style="max-width: 90%;">
  <div class="row">
    <div class="col">
      <img src="./images/password illustration.png" class="img-fluid">
    </div>
    <div class="col">
    <form method="POST" action="register.php" id="registration-form" onsubmit="return validateForm()">
      <div class="card mx-auto rounded-4" style="max-width: 80%;">
        <h1 style="font-size: 30px; font-weight: 800; color: #1A3BB1;" class="ms-5 mt-5 mb-3">Create an account</h1>
        <div class="form-floating mx-5 mb-3">
  <input type="text" class="form-control" id="username" name="username" placeholder="Username" minlength="5" maxlength="25" oninput="validateUsername()" required>
  <label for="Username">Username:</label>
  <div class="error" id="username-error"></div>
</div>
        <div class="form-floating mx-5 mb-3">
        <input type="hidden" id="userCtmeuId" name="userCtmeuId">
  <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" minlength="10" maxlength="25" required>
  <label for="firstName">First Name:</label>
</div>
<div class="form-floating mx-5 mb-3">
  <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name" minlength="5" maxlength="25">
  <label for="lastName">Middle Name:</label>
</div>
<div class="form-floating mx-5 mb-3">
  <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" minlength="5" maxlength="25" required>
  <label for="lastName">Last Name:</label>
</div>
<div class="form-floating mx-5 mb-3">
  <input type="text" class="form-control" id="affixes" name="affixes" placeholder="Affixes" minlength="2" maxlength="5">
  <label for="lastName">Affixes (Optional):</label>
</div>
<div class="form-floating mx-5 mb-3">
  <input type="password" class="form-control" id="password" name="password" placeholder="Last Name" minlength="5" maxlength="25" oninput="validatePassword()" required>
  <label for="Password">Password:</label>
  <div class="error" id="password-error"></div>
</div>

<div class="form-floating mx-5 mb-3">
  <select class="form-select" id="role" name="role" aria-label="Floating label select example" required>
  <option value="Enforcer">Enforcer</option>
    <?php
    // Call countSuperAdmins function to get the count of super administrators
    $superAdminCount = countSuperAdmins($conn);

    $itAdminCount = countUsersByRole($conn, 'IT Administrator');

    // Check if the IT admin limit has been reached (e.g., limit is 4)
    if ($itAdminCount < 4) {
        echo '<option value="IT Administrator">IT Admin</option>';
    } else {
        echo '<option value="IT Administrator" disabled>IT Admin (Limit Reached)</option>';
    }

    // Check if the selected role is "IT Administrator" and disable "Super Administrator" if true
    if ($_POST['role'] === 'IT Administrator') {
        echo '<option value="Super Administrator" disabled>Super Admin (Disabled for IT Admin)</option>';
    } elseif ($superAdminCount < 2) {
        echo '<option value="Super Administrator">Super Admin</option>';
    } else {
        echo '<option value="Super Administrator" disabled>Super Admin (Limit Reached)</option>';
    }
    ?>
  </select><br>

  <label for="role">Role</label>
</div>
<div class="d-grid mx-5 mb-3">

  <button class="btn btn-success" id="create-button" type="submit">Create Account</button>
  <button type="submit" id="update-button" class="btn btn-success">Update Account</button><br>
  <?php
// Check if the logged-in user has the "Super Administrator" role to display the "Delete Account" button
if ($_SESSION['role'] === 'Super Administrator') {
    echo '<button type="button" id="delete-button" style="display:none;" class="btn btn-danger">Delete Account</button>
    <br>';
}
?>
  <button type="reset" id="reset-button" class="btn btn-secondary">Clear</button>
  <button type="button" id="reset-password-button" class="btn btn-warning" style="display: none;">Reset Password</button>
</div>
</div>
      </div>
    </div>
</div>

<?php

// Function to fetch data from the users table
function fetchUserData($conn) {
    // Initialize an empty array to store user data
    $userData = array();

    // Prepare and execute an SQL statement to retrieve data from the users table
    $sql = "SELECT first_name, middle_name, last_name, affixes, username, password, role, user_ctmeu_id FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch data row by row and store it in the $userData array
        while ($row = $result->fetch_assoc()) {
            $userData[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    return $userData;
}

// Call the fetchUserData function to retrieve user data
$userData = fetchUserData($conn);

// Function to fetch user data based on first name, last name, and role
function getUserData($conn, $firstName, $lastName, $role) {
  $sql = "SELECT * FROM users WHERE first_name = ? AND last_name = ? AND role = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $firstName, $lastName, $role);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}

// Function to count the number of users with a specific role
function countUsersByRole($conn, $role) {
  $sql = "SELECT COUNT(*) as count FROM users WHERE role = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $role);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row['count'];
}

// Function to check if a user with the same first name, last name, and role exists
function userExists($conn, $firstName, $lastName, $role, $userCtmeuId) {
  // Check if userCtmeuId is empty
  if (empty($userCtmeuId)) {
      return false;
  }
  
  $sql = "SELECT COUNT(*) as count FROM users WHERE first_name = ? AND last_name = ? AND role = ? AND user_ctmeu_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssi", $firstName, $lastName, $role, $userCtmeuId);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row['count'] > 0;
}

// Initialize variables for form fields
$firstName = $lastName = $role = $username = $password = '';
$updateMode = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $role = $_POST['role'];
    $username = $_POST['username'];

    // Check if a user with the same first name, last name, and role exists
if (userExists($conn, $firstName, $lastName, $role)) {
  // If a user exists, switch to update mode
  $updateMode = true;

  // Retrieve the existing user data for pre-filling the form
  $existingUserData = getUserData($conn, $firstName, $lastName, $role);

  // Set the form fields with existing user data
  $firstName = $existingUserData['first_name'];
  $lastName = $existingUserData['last_name'];
  $role = $existingUserData['role'];

  // Check if the userCtmeuId is empty, and update the "Create Account" button's display
  if (empty($existingUserData['user_ctmeu_id'])) {
      echo 'document.getElementById("create-button").style.display = "inline-block";';
  } else {
      echo 'document.getElementById("create-button").style.display = "none";';
  }
} else {
  // Check the role limits
  $superAdminLimit = 2;
  $itAdminLimit = 4;

  // Count the number of existing Super Administrators and IT Administrators
  $superAdminCount = countUsersByRole($conn, 'Super Administrator');
  $itAdminCount = countUsersByRole($conn, 'IT Administrator');

  // Check if the limit has been reached for the selected role
  if (($role === 'Super Administrator' && $superAdminCount >= $superAdminLimit) ||
      ($role === 'IT Administrator' && $itAdminCount >= $itAdminLimit)) {
      // Limit reached, display an error message
      $errorMessage = 'The limit for ' . $role . 's has been reached.';
  } else {
      // Generate a new password for creating a new user
      $password = generatePassword(); // Implement a function to generate a random password
      echo 'document.getElementById("update-button").style.display = "inline-block";'; // Show the "Create Account" button
  }
}

}

// Function to generate a random password (customize this function as needed)
function generatePassword() {
  // Generate a random password logic here
  return "new_password"; // Change this to your password generation logic
}
?>

<br>

</form>
      </div>
    </div>
    </div>


<div class="container mt-5">
  <div class="table-container">
  
<!-- Add this part in your HTML to populate the table with the fetched data -->
<table id="user-table">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // Loop through the $userData array and populate the table rows
        foreach ($userData as $user) {
            echo "<tr>";
            echo "<td class='clickable-cell'>" . $user['first_name'] . "</td>";
            echo "<td class='clickable-cell'>" . $user['last_name'] . "</td>";
            echo "<td class='clickable-cell'>" . $user['username'] . "</td>";
            echo "<td class='clickable-cell'>" . $user['role'] . "</td>";
            echo "<td class='user-ctmeu-id' style='display:none;'>" . $user['user_ctmeu_id'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
  </div>
  </div>

  
 
  
  <script>

    // Apply symbol restriction to all text input fields
const form = document.getElementById('registration-form');
const inputs = form.querySelectorAll('input[type="text"]');

inputs.forEach(input => {
    input.addEventListener('input', function (e) {
        const inputValue = e.target.value;
        const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 @\.,\-ñÑ]/g, ''); // Allow letters, numbers, spaces, @ symbol, dots, commas, hyphens, ñ, and Ñ
        e.target.value = sanitizedValue;
    });
});

    
document.getElementById('reset-button').addEventListener('click', function() {
    // Reload the current page when the Clear button is clicked
    location.reload();
});
  // Function to handle row selection and populate form fields with data
function handleRowSelection(row) {
    // Get the data associated with the clicked row
    const firstName = row.cells[0].textContent;
    const lastName = row.cells[1].textContent;
    const username = row.cells[2].textContent;
    const role = row.cells[3].textContent;
    const userCtmeuId = row.cells[4].textContent; // Get the user_ctmeu_id

    // Populate form fields with the data
    document.getElementById('firstName').value = firstName;
    document.getElementById('lastName').value = lastName;
    document.getElementById('username').value = username;
    document.getElementById('role').value = role;
    document.getElementById('userCtmeuId').value = userCtmeuId; // Set the user_ctmeu_id in a hidden input field
}

// Add a click event listener to the table rows to handle row selection
document.getElementById('user-table').addEventListener('click', function (event) {
    // Get the clicked row
    const row = event.target.parentElement;

    // Ensure the clicked element is a row and not the table header
    if (row && row.rowIndex > 0) {
        handleRowSelection(row);
    }
});

// Add a click event listener to the "Reset Password" button
document.getElementById('reset-password-button').addEventListener('click', function () {
    // Get the username from the form field
    const username = document.getElementById('username').value;

    // Make an AJAX request to reset the password
    resetPassword(username);
});

// Function to reset the password by making an AJAX request to the PHP script
function resetPassword(username) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/reset_password.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = xhr.responseText;
                if (response === 'success') {
                    // Password reset successful
                    alert('Password reset successful. New password: password123');
                } else {
                    // Password reset failed
                    alert('Password reset failed.');
                }
            } else {
                // Request failed
                alert('An error occurred while resetting the password.');
            }
        }
    };

    // Send the request with the username as data
    xhr.send('username=' + encodeURIComponent(username));
}


    // JavaScript function to hide the limitReachedPopup
    function hideLimitReachedPopup() {
        var popup = document.getElementById('limitReachedPopup');
        popup.style.display = 'none';
    }


// Add an event listener to the registration form to set the credentials
// document.getElementById('registration-form').addEventListener('submit');
</script>
  
  <script>
    // Add a new JavaScript function to disable the role dropdown
  function disableRoleDropdown() {
    document.getElementById('role').disabled = true;
  }

    // Function to populate form fields with the selected row data
  function populateFormFields(row) {
    const firstName = row.cells[0].textContent;
      const lastName = row.cells[1].textContent;
      const role = row.cells[3].textContent; // Status is in the 5th cell (index 4)
      /*const startTicket = row.cells[5].textContent; // Start Ticket is in the 6th cell (index 5)
      const endTicket = row.cells[6].textContent; */

    document.getElementById('firstName').value = firstName;
    document.getElementById('lastName').value = lastName;

    // Disable the role dropdown when an existing user is selected
    disableRoleDropdown();

    // Set the selected value in the dropdown list based on the status of the row
    const roleDropdown = document.getElementById('role');
    for (let i = 0; i < roleDropdown.options.length; i++) {
      if (roleDropdown.options[i].value === role) {
        roleDropdown.selectedIndex = i;
        break;
      }
    }


    
  }


// Add a click event listener to the logout button
document.getElementById('logout-button').addEventListener('click', function() {
        // Perform logout actions here, e.g., clearing session, redirecting to logout.php
        // You can use JavaScript to redirect to the logout.php page.
        window.location.href = 'php/logout.php';
    });


    function validateFName() {
      var nameInput = document.getElementById("firstName");
      var nameError = document.getElementById("fname-error");
      
      if (nameInput.value.length < 3) {
        nameError.innerHTML = "Name must be at least 3 characters long.";
        nameError.style.display = "block";
      } else {
        nameError.style.display = "none";
      }
    }

    function validateLName() {
      var nameInput = document.getElementById("lastName");
      var nameError = document.getElementById("lname-error");
      
      if (nameInput.value.length < 3) {
        nameError.innerHTML = "Name must be at least 3 characters long.";
        nameError.style.display = "block";
      } else {
        nameError.style.display = "none";
      }
    }

    var selectedRow = null;


    // Function to clear the form fields
    function clearFormFields() {
    selectedRow = null;
    document.getElementById("registration-form").reset();
    document.getElementById("create-button").textContent = "Create Account";
    document.getElementById("create-button").style.display = "inline-block";
    document.getElementById("update-button").style.display = "none";
    document.getElementById("delete-button").style.display = "none";

    // Enable the role dropdown when the form is cleared
    document.getElementById('role').disabled = false;

  }

  document.getElementById('reset-button').addEventListener('click', function (event) {
    // Clear the form fields and reset buttons' state
    clearFormFields();
  });


    document.getElementById("user-table").addEventListener("click", function(event) {
  var row = event.target.parentElement;
  if (selectedRow !== row) {
    populateFormFields(row);
    selectedRow = row;
    document.getElementById("create-button").style.display = "inline-block";
    document.getElementById("delete-button").style.display = "inline-block";
  } else {
    document.getElementById("delete-button").style.display = "none";
  }
});


function validateInput(input) {
    const maxLength = 9;
    if (input.value.length > maxLength) {
      input.value = input.value.slice(0, maxLength);
    }
  }

// Function to show or hide the ticket fields based on the selected role
function showHideTicketFields() {
  const role = document.getElementById('role').value;
  const ticketContainers = document.querySelectorAll('.ticket-container');

  if (role === 'Enforcer') {
    // Show the ticket containers
    ticketContainers.forEach(container => {
      container.style.display = 'block';
    });
  } else {
    // Hide the ticket containers
    ticketContainers.forEach(container => {
      container.style.display = 'none';
    });
  }
}

// Add an event listener to the role dropdown to trigger the show/hide function
document.getElementById('role').addEventListener('change', showHideTicketFields);

// Call the show/hide function initially to set the correct display on page load
showHideTicketFields();

// Check if the user is logged in and update the welcome message
<?php if (isset($_SESSION['role']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) { ?>
        var role = '<?php echo $_SESSION['role']; ?>';
        var firstName = '<?php echo $_SESSION['first_name']; ?>';
        var lastName = '<?php echo $_SESSION['last_name']; ?>';

        document.getElementById('welcome-text').textContent =  firstName + ' ' + lastName;
    <?php } ?>

     // Check if a user with the same first name, last name, and role exists
     <?php if ($updateMode) { ?>
            // If a user exists, switch to update mode
            document.getElementById('create-button').style.display = 'none';
            document.getElementById('update-button').style.display = 'inline-block';
        <?php } else { ?>
            // If not, switch back to create mode
            document.getElementById('create-button').style.display = 'inline-block';
            document.getElementById('update-button').style.display = 'none';
        <?php } ?>

        // Add click event listener to the table rows instead of individual cells
document.getElementById('user-table').addEventListener('click', function (event) {
    // Get the clicked row and its cells
    const row = event.target.parentElement;
    const cells = row.cells;

    // If a row is clicked and not the table header row
    if (row && row.rowIndex > 0) {
        selectedRowUid = row.getAttribute('data-uid');
        // Populate form fields with the selected row data
        populateFormFields(row);

        // Show the "Delete Account" button
        document.getElementById('create-button').style.display = 'none';
        document.getElementById('update-button').style.display = 'none';
        document.getElementById('delete-button').style.display = 'inline-block';
    } else {
        // Clear the form fields and hide the buttons
        clearFormFields();
        document.getElementById('create-button').style.display = 'inline-block';
        document.getElementById('update-button').style.display = 'none';
        document.getElementById('delete-button').style.display = 'none';
    }
});

<?php
// Check if the logged-in user has the "Super Administrator" role
if ($_SESSION['role'] === 'Super Administrator') {
    echo '
    // Add an event listener to the "Delete Account" button
    document.getElementById(\'delete-button\').addEventListener(\'click\', function() {
        // Get the user information from the form fields
        const firstNameToDelete = document.getElementById(\'firstName\').value;
        const lastNameToDelete = document.getElementById(\'lastName\').value;
        const roleToDelete = document.getElementById(\'role\').value;

        // Check if the user is trying to delete themselves
        if (firstNameToDelete === \'' . $_SESSION['first_name'] . '\' &&
            lastNameToDelete === \'' . $_SESSION['last_name'] . '\' &&
            roleToDelete === \'' . $_SESSION['role'] . '\') {
            alert("You cannot delete yourself.");
            return;
        }

        // Confirm the deletion with the user
        if (confirm("Are you sure you want to delete this user account?")) {
            // Perform the delete action here using an AJAX request or redirect to a PHP script that handles the deletion
            // You can use the following code to send an AJAX request to a PHP script for deletion:

            
            const xhr = new XMLHttpRequest();
            xhr.open(\'POST\', \'php/deleteaccount.php\', true);
            xhr.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response here, e.g., show a success message
                    alert("Deleted Successfully");
                    location.reload();
                    // Optionally, reload the user table or perform other actions
                }
            };
            xhr.send(\'firstName=\' + encodeURIComponent(firstNameToDelete) +
                    \'&lastName=\' + encodeURIComponent(lastNameToDelete) +
                    \'&role=\' + encodeURIComponent(roleToDelete));
            

            // Alternatively, you can redirect to a PHP script that handles the deletion
            // window.location.href = \'delete_user.php?firstName=\' + encodeURIComponent(firstNameToDelete) +
            //                        \'&lastName=\' + encodeURIComponent(lastNameToDelete) +
            //                        \'&role=\' + encodeURIComponent(roleToDelete);
        }
    });
    ';
}
?>


// JavaScript code: Add a click event listener to the "Update Account" button
document.getElementById('update-button').addEventListener('click', function() {
    // Get the user information from the form fields
    const firstNameToUpdate = document.getElementById('firstName').value;
    const lastNameToUpdate = document.getElementById('lastName').value;
    const roleToUpdate = document.getElementById('role').value;

    // Check if the user is trying to update themselves
    if (firstNameToUpdate === '<?php echo $_SESSION['first_name']; ?>' &&
        lastNameToUpdate === '<?php echo $_SESSION['last_name']; ?>' &&
        roleToUpdate === '<?php echo $_SESSION['role']; ?>') {
        alert("You cannot update your own account.");
        return;
    }

    // Get the user_ctmeu_id from the hidden input field
    const userCtmeuIdToUpdate = document.getElementById('userCtmeuId').value;

    // Create an object with the data to be updated
    const userDataToUpdate = {
        firstName: firstNameToUpdate,
        lastName: lastNameToUpdate,
        role: roleToUpdate,
        userCtmeuId: userCtmeuIdToUpdate
    };

    // Ask for confirmation before updating
    const confirmation = confirm("Are you sure you want to update this account?");
    if (!confirmation) {
        return; // User canceled the update
    }

    // Send an AJAX request to update the user data
    fetch('php/update_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userDataToUpdate),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update successful
            alert('User data updated successfully.');
            location.reload(); // Reload the page or update the table as needed
        } else {
            // Update failed
            alert('Failed to update user data.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating user data.');
    });
});

// JavaScript code: Check if there is an existing user with the same data
function checkExistingData() {
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const role = document.getElementById('role').value.trim();
    const userCtmeuId = document.getElementById('userCtmeuId').value.trim(); // Get userCtmeuId

    // Get all the rows in the user table
    const tableRows = document.querySelectorAll('#user-table tbody tr');

    // Variable to track if a match is found
    let matchFound = false;

    // Loop through the table rows and compare data
    for (const row of tableRows) {
        const rowFirstName = row.cells[0].textContent.trim();
        const rowLastName = row.cells[1].textContent.trim();
        const rowRole = row.cells[3].textContent.trim();
        const rowUserCtmeuId = row.querySelector('.user-ctmeu-id').textContent.trim(); // Get user_ctmeu_id

        // Check if there is a match based on firstName, lastName, role, and userCtmeuId
        if (rowFirstName === firstName && rowLastName === lastName && rowRole === role && rowUserCtmeuId === userCtmeuId) {
            // Match found, set the matchFound flag to true
            matchFound = true;
            break; // No need to continue checking
        }
    }

    // Get the Create and Update buttons
    const createButton = document.getElementById('create-button');
    const updateButton = document.getElementById('update-button');

    // If a match is found and userCtmeuId is not empty, show the Update button; otherwise, hide it
    if (matchFound || userCtmeuId !== '') {
        createButton.style.display = 'none';
        updateButton.style.display = 'inline-block';
    } else {
        // If no match is found or userCtmeuId is empty, show the Create button and hide the Update button
        createButton.style.display = 'inline-block';
        updateButton.style.display = 'none';
    }
}

// Add an input event listener to each input field and userCtmeuId field
document.getElementById('firstName').addEventListener('input', checkExistingData);
document.getElementById('lastName').addEventListener('input', checkExistingData);
document.getElementById('role').addEventListener('input', checkExistingData);
document.getElementById('userCtmeuId').addEventListener('input', checkExistingData);

// Initial check to hide the Update button if there is no matching user or userCtmeuId is empty
checkExistingData();

function validateUsername() {
    var username = document.getElementById('username').value;
    var usernameError = document.getElementById('username-error');

    // Your validation logic for the username
    if (username.length < 5) {
      usernameError.textContent = 'Username must be at least 5 characters long.';
    } else {
      usernameError.textContent = '';
    }
  }

  function validatePassword() {
    var password = document.getElementById('password').value;
    var passwordError = document.getElementById('password-error');

    // Your validation logic for the password
    if (password.length < 8) {
      passwordError.textContent = 'Password must be at least 8 characters long.';
    } else {
      passwordError.textContent = '';
    }
  }

  function validateForm() {
    // Additional validation logic for the entire form if needed
    // Return true to submit the form, or false to prevent submission
    return true;
  }
  </script>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>