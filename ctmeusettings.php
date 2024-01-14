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
// Fetch violations from the database
$violationQuery = "SELECT violation_name, violation_section FROM violationlists";
$violationResult = mysqli_query($conn, $violationQuery);

// Fetch maxITSA and maxEncoder from the maxaccess table
$query = "SELECT maxITSA, maxEncoder FROM maxaccess";
$result = mysqli_query($conn, $query);
if (!$result) {
   die("Database query failed: " . mysqli_error($conn));
}
$access = mysqli_fetch_assoc($result);
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
            <a class="nav-link" href="ticket-creation" style="font-weight: 600;">Ticket</a>
          </li>';
                            } else {
                                // For other roles, show the other links
                                if ($_SESSION['role'] === 'IT Administrator') {
                                    echo '<li class="nav-item">
            <a class="nav-link" href="ticket-creation" style="font-weight: 600;">Ticket</a>
          </li>';
                                    //Reports page temporary but only super admin has permission
                                    
                                    echo '<li class="nav-item"> <a href="reports" class="nav-link" style="font-weight: 600;">Reports</a> </li>';
                                } else {
                                    // Display the "Create Accounts" link
                                    //    echo '<a href="reports" class="nav-link">Reports</a>';
                        
                                    echo '<li class="nav-item">
            <a class="nav-link" href="ticket-creation" style="font-weight: 600;">Ticket</a>
          </li>';
                                    echo '<a href="reports" class="nav-link" style="font-weight: 600;">Reports</a>';

                                    echo '<li class="nav-item">
          <a class="nav-link" href="archives" style="font-weight: 600;">Archive</a>
        </li>';

                                    /* echo '<li class="nav-item">
                                         <a class="nav-link" href="ticket-creation" style="font-weight: 600;">Ticket</a>
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
<!-- Violations Table Card -->

<div class="card text-center mb-3" style="width: 45%;">
    <div class="card-body">
        <h2 class="card-title m-4" style="color: #1A3BB1; font-weight: 800;">Violations</h2>
        <!-- Search input -->
        <input type="text" id="violationSearchInput" onkeyup="searchViolations()" placeholder="Search for violations..." class="form-control mb-3">
        <table id='violationTable'>
            <thead>
                <tr>
                    <th>Violation Name</th>
                    <th>Violation Section</th>
                </tr>
            </thead>
        </table>
        <div style="max-height: 300px; overflow-y: auto;">
            <table class="table">
                <tbody>
                    <?php
                    while ($violationRow = mysqli_fetch_assoc($violationResult)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($violationRow['violation_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($violationRow['violation_section']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
<!-- Ticket Control Number card -->
<div class="card text-center mb-3 mr-3" style="width: 45%; margin-top:10px;">
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
          <p>Start Ticket: <input type="number" id="startTicket" readonly></p>
          <p>End Ticket: <input type="number" id="endTicket" readonly></p>
          <button id="updateButton">Update</button>
      </div>
  </div>
</div>
<!-- Max Personnel card -->
<div class="card text-center mb-3 ml-10" style="width: 45%; margin-top:10px;">
 <div class="card-body">
     <h2 class="card-title m-4" style="color: #1A3BB1; font-weight: 800;">Max Personnel</h2>
     <div class="table-container">
         <p>Maximum IT Admin/Super Admin: <input type="number" id="maxITSA" name="maxITSA" value="<?php echo $access['maxITSA']; ?>"></p>
         <p>Maximum Encoder: <input type="number" id="maxEncoder" name="maxEncoder" value="<?php echo $access['maxEncoder']; ?>"></p>
         <button id="updateMaxPersonnelButton">Update</button>
     </div>
 </div>
</div>
</div>

<script>
document.getElementById('maxITSA').value = <?php echo $access['maxITSA']; ?>;
document.getElementById('maxEncoder').value = <?php echo $access['maxEncoder']; ?>;

document.getElementById('updateMaxPersonnelButton').addEventListener('click', function() {
 var maxITSA = document.getElementById('maxITSA').value;
 var maxEncoder = document.getElementById('maxEncoder').value;

 if (maxITSA !== "" && maxEncoder !== "") {
     fetch('php/update_max_personnel.php', {
         method: 'POST',
         headers: {
             'Content-Type': 'application/json',
         },
         body: JSON.stringify({ maxITSA, maxEncoder }),
     })
     .then(response => response.json())
     .then(data => {
         if (data.success) {
             alert("Max personnel updated successfully.");
             window.location.reload();
         } else {
             alert("Failed to update max personnel. Please try again.");
         }
     })
     .catch(error => {
         console.error('Error:', error);
         alert("An error occurred. Please try again.");
     });
 } else {
     alert("Please enter valid values.");
 }
});
</script>

       </div>
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
 function searchViolations() {
    var input, filter, tbody, tr, td, i, txtValue;
    input = document.getElementById("violationSearchInput");
    filter = input.value.toUpperCase();
    tbody = document.querySelector("#violationTable + div > table > tbody");
    tr = tbody.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        if (td.length > 0) { // Ensure that the row has cells
            // Concatenate the text from the 'Violation Name' and 'Violation Section' columns
            txtValue = td[0].textContent + " " + td[1].textContent;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
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

    document.getElementById('updateButton').addEventListener('click', function() {
      var userId = document.getElementById('userSelect').value;
      var startTicket = document.getElementById('startTicket').value;
      var endTicket = document.getElementById('endTicket').value;

      if (userId !== "" && startTicket !== "" && endTicket !== "") {
          fetch('php/update_ticket_range.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify({ userId, startTicket, endTicket }),
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("Ticket range updated successfully.");
                  window.location.reload();
              } else {
                  alert("Failed to update ticket range. Please try again.");
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert("An error occurred. Please try again.");
          });
      } else {
          alert("Please select a user and enter valid ticket numbers.");
      }
    });
    // Check if the user is logged in and update the welcome message
    <?php if (isset($_SESSION['role']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) { ?>
        var role = '<?php echo $_SESSION['role']; ?>';
        var firstName = '<?php echo $_SESSION['first_name']; ?>';
        var lastName = '<?php echo $_SESSION['last_name']; ?>';
        
document.getElementById('userSelect').addEventListener('change', function() {
   var userId = this.value;
   if (userId !== "") {
       fetch('php/get_ticket_range.php', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json',
           },
           body: JSON.stringify({ userId }),
       })
       .then(response => response.json())
       .then(data => {
           document.getElementById('startTicket').value = data.startTicket;
           document.getElementById('endTicket').value = data.endTicket;
       })
       .catch(error => {
           console.error('Error:', error);
           alert("An error occurred. Please try again.");
       });
   }
});

        document.getElementById('welcome-text').textContent = firstName + ' ' + lastName;
    <?php } ?>

</script>
<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>