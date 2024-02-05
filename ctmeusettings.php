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
    .remove-button {
      background-color: transparent;
      color: maroon;;
      height: 30px;
      border: 2px solid maroon;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
      display: flex;
      justify-content: center;
      align-items: center;

    }
    .remove-button:hover {
      background-color: maroon;
      color: #fff;
    }

    .edit-button {
      background-color: transparent;
      color: #0D6EFD;;
      height: 30px;
      border: 2px solid #0D6EFD;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
      display: flex;
      justify-content: center;
      align-items: center;

    }
    .edit-button:hover {
      background-color: #0D6EFD;
      color: #fff;
    }
    .form-button {
      background-color: #0D6EFD;
      color: #fff;
      height: 30px;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;

      display: flex;
      justify-content: center;
      align-items: center;
      width: 200px;
    }
    .form-button:hover {
      background-color: #1930A0;
    }

    .form-buttonContainer {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    #updateMaxPersonnelButton  {
      background-color: #0D6EFD;
      color: #fff;
      height: 30px;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      justify-content: center;
      align-items: center;

      width: 100px;
      margin: 0 auto;
    }
    #updateMaxPersonnelButton:hover {
      background-color: #1930A0;
    }
    
    .table-container{
      display:flex;
      flex-direction: column;
    }


    .list-group-item {
    border: none;
    position: relative;
    overflow: hidden;
}

    .list-group-item .btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .list-group-item button {
        position: absolute;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: opacity 0.1s ease;
    }
    .list-group-item:hover button {
        opacity: 1;
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
            <a class="nav-link" href="ticket-creation" style="font-weight: 600;">Add Ticket</a>
          </li>';
                                     echo '<li class="nav-item">
          <a class="nav-link" href="settings" style="font-weight: 600; ">Ticket Form</a>
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
        <div class="container ticket-details">
  <div class="card w-100">
    <div class="card-body">
      <div class="row">
        <div class="col-4 border-end">
          <h1 class="card-title m-4" style="color: #1A3BB1; font-weight: 1000;">Ticket Settings</h1>
          <div class="row">
            <div class="list-group ms-5 fw-medium" id="list-tab" role="tablist" style="width: calc(100% - 80px);"> <!-- Adjust width to make it shorter -->
              <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Violations</a>
              <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Vehicle List</a>
              <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages">Max Personnel</a>
            </div>
          </div>
        </div>
        <div class="col-8" style="overflow-y: auto;">
          <style>
            @media (min-width: 992px) {
              .col-8 {
                max-height: 600px;
              }
            }
            @media (max-width: 991.98px) {
              .col-8 {
                max-height: 400px; /* Adjust as needed */
              }
            }
          </style>
          <div class="tab-content mt-5 ms-5 pt-4" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
              <h5 class="fw-bold">
                <img class="me-2" src="images/highlight.png">Violations 
              </h5>
              <form class="d-flex mt-5 mb-3">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              </form>
              <?php
              // Assuming you have already established a MySQL database connection
              include 'php/database_connect.php';
              // Query to retrieve data from the database
              $query = "SELECT violation_name FROM violationlists";
              $result = mysqli_query($conn, $query);

              // Check if query was successful
              if ($result) {
                  echo '<ul class="list-group">';
                  // Loop through each row in the result set
                  while ($row = mysqli_fetch_assoc($result)) {
                      // Output each row as a list item
                      echo '<li class="list-group-item border-bottom mx-3">' . htmlspecialchars($row['violation_name']) . '</li>';
                  }
                  echo '</ul>';
              } else {
                  echo "Error: " . mysqli_error($conn);
              }

              ?>
            </div>
            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
              <h5 class="fw-bold"><img class="me-2" src="images/highlight.png">Vehicle List</h5>
              <div class="list-group rounded-4 mt-3 me-5 mb-5 border"> <!-- Added border class -->
                <div class="input-group">
                  <input type="text" class="form-control border-0 border-top-3 rounded-4" placeholder="Add Vehicle Type">
                  <button class="btn border-start-0" type="button"><img src="images/addbutton.png"></button>
                </div>
                <a href="#" class="list-group-item list-group-item-action border" data-item="1">A second button item<button class="btn btn-primary border-0 bg-transparent"><img src="images/menu.png"></button></a>
                <a href="#" class="list-group-item list-group-item-action border" data-item="2">A third button item<button class="btn btn-primary border-0 bg-transparent"><img src="images/menu.png"></button></a>
                <a href="#" class="list-group-item list-group-item-action border" data-item="3">A fourth button item<button class="btn btn-primary border-0 bg-transparent"><img src="images/menu.png"></button></a>
              </div>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-danger">Cancel</button>
                <button type="button" class="btn btn-success">Save Changes</button>
              </div>
            </div>
            <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
              <h5 class="fw-bold"><img class="me-2" src="images/highlight.png">Max Personnel</h5>
              <h8>Maximum IT Admin/Super Admin: </h8>
              <h8>Maximum Encoder: </h8>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary">Update</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-remove-modal" tabindex="-1" aria-labelledby="edit-remove-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-remove-modal-label">Edit/Remove Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Do you want to edit or remove this item?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit-btn" data-bs-toggle="modal" data-bs-target="#edit-modal">Edit</button>
        <button type="button" class="btn btn-danger" id="remove-btn">Remove</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">Edit Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Add input fields for editing here -->
        <input type="text" id="edited-text" class="form-control" placeholder="Enter edited text">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="save-edit-btn">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" role="dialog" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
    <div class="modal-content modal-content-full">
      <div class="modal-header">
        <h5 class="modal-title" id="editVehicleModalTitle">Edit Vehicle</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editVehicleForm" method="POST" action="./php/edit_vehicle.php">
          <input type="hidden" name="vehicleId2" id="vehicleId2">
          <div class="form-group">
            <label for="vehicleNameE">Vehicle Name</label>
            <input type="text" class="form-control" id="vehicleNameE" name="vehicleNameE">
          </div>
          <!-- Add more fields as needed -->
          <button type="submit" class="btn btn-primary" id="saveChangesButton">Save changes</button>
        </form>
      </div>
    </div>
 </div>
</div>

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
          <th>Edit</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>";
    while ($row = $result->fetch_assoc()) {
      echo "
      <tr>
        <td>" . $row["vehicle_name"] . "</td>
        <td><button type='button' class='edit-button' onclick='editVehicle(\"" . $row["vehicle_id"] . "\")'>Edit</button></td>
        <td><button class='remove-button' onclick='removeVehicle(this)'>Remove</button></td>
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


<div class="form-buttonContainer">
<form id="addVehicleForm" method="POST" action="./php/addvehicles.php">
  <label for="vehicleName">Vehicle Name:</label>
  <input type="text" id="vehicleName" name="vehicleName">
  <button type="submit" class="form-button">Add Vehicle</button>
</form>
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

    <?php 


// Check for error message
if (isset($_SESSION['vehicle_update_failure'])) {
    echo '
    <div class="modal" tabindex="-1" role="dialog" id="errorModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-full">
          <div class="modal-header">
            <h5 class="modal-title">Error</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>' . $_SESSION['vehicle_update_failure'] . '</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script>
    $(document).ready(function(){
        $("#errorModal").modal("show");
    });
    </script>
    ';
    unset($_SESSION['vehicle_update_failure']); // Clear the message
}

// Check for success message
if (isset($_SESSION['vehicle_update_success'])) {
    echo '
    <div class="modal" tabindex="-1" role="dialog" id="successModal">
      <div class="modal-dialog" role="document">
      <div class="modal-content modal-content-full">
          <div class="modal-header">
            <h5 class="modal-title">Success</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>' . $_SESSION['vehicle_update_success'] . '</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script>
    $(document).ready(function(){
        $("#successModal").modal("show");
    });
    </script>
    ';
    unset($_SESSION['vehicle_update_success']); // Clear the message
}

?>  
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

    function editVehicle(vehicleId2) {
 // Assuming you have a server-side PHP script to handle fetching data from the database
 // Replace 'get_vehicle.php' with the actual filename of your PHP script
 document.getElementById('vehicleId2').value = vehicleId2;

 $('#editVehicleModal').modal('show');
 
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

<script>
  $(document).ready(function() {
  $('.list-group-item button').click(function(e) {
    e.preventDefault();
    var listItem = $(this).closest('.list-group-item');
    var itemNumber = listItem.data('item');
    
    // Display a popup/modal
    $('#edit-remove-modal').modal('show');
    
    // Set data attribute for identification of the selected list item
    $('#edit-remove-modal').data('selected-item', itemNumber);
  });
  
  
  // Handle remove button click
  $('#remove-btn').click(function() {
    var selectedItem = $('#edit-remove-modal').data('selected-item');
    alert('Remove item ' + selectedItem);
    $('#edit-remove-modal').modal('hide');
    // Add your remove functionality here
  });
});
</script>
<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>