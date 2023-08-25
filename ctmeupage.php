<?php
session_start();
include 'php/database_connect.php'; // Include your database connection code here

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are not logged in
  header("Location: index.php");
  exit();
}

// Define a function to fetch data from the violation_tickets table
function fetchViolationTickets() {
  global $conn; // Assuming you have a database connection established

  // Write a SQL query to fetch data from the violation_tickets table
  $sql = "SELECT * FROM violation_tickets"; // Modify this query as needed

  // Execute the query
  $result = mysqli_query($conn, $sql);

  // Check if the query was successful
  if ($result) {
    // Initialize an empty array to store the fetched data
    $data = array();

    // Fetch data and store it in the array
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }

    // Return the fetched data
    return $data;
  } else {
    // Handle the error, e.g., display an error message
    echo "Error: " . mysqli_error($conn);
    return array(); // Return an empty array if there was an error
  }
}

// Fetch the violation ticket data
$violationTickets = fetchViolationTickets();
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Data Hub</title>
</head>
<style>
  .clickable-row {
    cursor: pointer;
    display: table-row;
  }

  .hidden {
  display: none;
  margin: auto;
}
#filter-select {
  padding: 10px;
  margin-left: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.search-container {
  text-align: center;
  margin: 20px 0;
}

#search-bar {
  padding: 10px;
  width: 50%;
  border: 1px solid #ccc;
  border-radius: 5px;
}


</style>
<body style="height: auto;">

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
    <a href="ctmeupage.php" class="link"><b>Records</b></a>
    <a href="ctmeurecords.php" class="link">Reports</a>
    <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a>-->
    <a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" id="noEnforcers"class="link">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>
<div class="search-container">
  <input type="text" id="search-bar" placeholder="Search...">
  <select id="filter-select">
    <option value="name">Name</option>
    <option value="license">License No.</option>
    <option value="address">Address</option>
    <option value="district">District</option>
  </select>
</div>

<div class="table-container">
<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>License No.</th>
            <th>Address</th>
            <th>District</th>
            <th><button class="btn btn-primary" id="toggle-archive-buttons"><i class='bx bx-show'></i></button></th>
        </tr>
    </thead>
    <tbody id="ticket-table-body">
    <?php
// Loop through the fetched violation ticket data and populate the table rows
foreach ($violationTickets as $index => $ticket) {
    // Convert the row data to a JSON string
    $rowData = json_encode($ticket);
    
    echo "<tr class='clickable-row' data-index='$index' data-rowdata='$rowData'>";
    echo "<td>" . ($index + 1) . "</td>";
    echo "<td>" . $ticket['driver_name'] . "</td>";
    echo "<td>" . $ticket['driver_license'] . "</td>";
    echo "<td>" . $ticket['driver_address'] . "</td>";
    echo "<td>" . $ticket['issuing_district'] . "</td>";
    echo "<td class='toggle-button-cell'></td>"; // Placeholder for the button
    echo "</tr>";
}
?>
    </tbody>
</table>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
<script>
  function rowClick(row) {
        // Get the row data JSON string
        var rowData = row.getAttribute('data-rowdata');
        
        // Redirect to the details page with the row data as a query parameter
        window.location.href = 'detailarch.php?data=' + encodeURIComponent(rowData);
    }
 // Add a click event listener to the toggle button in the table header
 document.getElementById('toggle-archive-buttons').addEventListener('click', function() {
        // Get all the rows in the table body
        var rows = document.querySelectorAll('#ticket-table-body .clickable-row');

        // Toggle the visibility of the buttons in each row
        rows.forEach(function(row) {
            var buttonCell = row.querySelector('.toggle-button-cell');
            buttonCell.innerHTML = buttonCell.innerHTML === '' ? "<button class='btn btn-primary'><i class='bx bx-show'></i></button>" : '';
        });
    });
  // Add a click event listener to the logout button
document.getElementById('logout-button').addEventListener('click', function() {
        // Perform logout actions here, e.g., clearing session, redirecting to logout.php
        // You can use JavaScript to redirect to the logout.php page.
        window.location.href = 'php/logout.php';
    });

    document.querySelectorAll('.clickable-row').forEach(function(row) {
        row.addEventListener('click', function() {
            // Get the row data JSON string
            var rowData = row.getAttribute('data-rowdata');
            
            // Redirect to the details page with the row data as a query parameter
            window.location.href = 'detailarch.php?data=' + encodeURIComponent(rowData);
        });
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