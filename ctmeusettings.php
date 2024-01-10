<?php
session_start();
include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: login");
  exit();
}
// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

if (!$result) {
  // Handle the database query error
  die("Database query failed: " . mysqli_error($conn));
}

// Store the users in an array
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
  $users[] = $row;
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
<body style="height: auto; background: linear-gradient(to bottom, #1F4EDA, #102077);">
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

        <!-- First Card -->
        <div class="card text-center mb-3" style="width: 45%;">
            <div class="card-body">
            <h2 class="card-title m-4" style="color: #1A3BB1; font-weight: 800;">Vehicle List</h1>
            <?php

  // Retrieve the user accounts from the database
  $sql = "SELECT * FROM vehicletype";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "
    <table id='vehicleTable'>
      <thead>
        <tr>
          <th>Vehicle Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>";
    while ($row = $result->fetch_assoc()) {
      echo "
                  <tr>
                    <td>" . $row["vehicle_name"] . "</td>
                    <td><button onclick='removeVehicle(this)'>Remove</button></td>
                  </tr>
                "; 
    

    }
    echo"</tbody>
    </table>
  ";
  }

  // Close the database connection
  $conn->close();
  ?>


<div>
  <label for="vehicleName">Vehicle Name:</label>
  <input type="text" id="vehicleName" name="vehicleName">
  <button onclick="addVehicle()">Add Vehicle</button>
</div>
            </div>
        </div>
        

        <!-- Second Card -->
        <div class="card text-center mb-3" style="width: 45%;">
            <div class="card-body">
                <h2 class="card-title m-4" style="color: #1A3BB1; font-weight: 800;">Violations</h1>
                
            </div>
        </div>

        <div class="card text-center mb-3" style="width: 95%; margin-top:10px;">
   <div class="card-body">
       <h2 class="card-title m-4" style="color: #1A3BB1; font-weight: 800;">Ticket Control Number</h2>
       <div class="table-container">
       <select id="userSelect">
         <option value="" disabled selected>Select a user</option>
         <?php foreach ($users as $user): ?>
             <option value="<?php echo $user['user_ctmeu_id']; ?>">
                <?php echo $user['username'] . ' (' . $user['first_name'] . ' ' . $user['last_name'] . ') ' . $user['role']; ?>
             </option>
         <?php endforeach; ?>
     </select>
   </div>
</div>

    </div>
    
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
    function addVehicle() {
      var vehicleNameInput = document.getElementById("vehicleName");
      var vehicleName = vehicleNameInput.value.trim();

      if (vehicleName !== "") {
        // Assuming you have a server-side PHP script to handle adding data to the database
        // Replace 'add_vehicle.php' with the actual filename of your PHP script
        fetch('php/addvehicles.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ vehicleName }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // If the server operation is successful, add the data to the table
            var table = document.getElementById("vehicleTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);

            cell1.innerHTML = vehicleName;
            cell2.innerHTML = '<button onclick="removeVehicle(this)">Remove</button>';

            // Clear the input field
            vehicleNameInput.value = "";
          } else {
            alert("Failed to add vehicle. Please try again.");
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert("An error occurred. Please try again.");
        });
      } else {
        alert("Please enter a valid vehicle name.");
      }
    }

    function removeVehicle(button) {
      var row = button.parentNode.parentNode;
      var vehicleName = row.cells[0].innerText;

      // Assuming you have a server-side PHP script to handle removing data from the database
      // Replace 'remove_vehicle.php' with the actual filename of your PHP script
      fetch('php/removevehicles.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ vehicleName }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // If the server operation is successful, remove the row from the table
          row.parentNode.removeChild(row);
        } else {
          alert("Failed to remove vehicle. Please try again.");
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again.");
      });
    }

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
<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>