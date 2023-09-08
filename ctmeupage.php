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
  .clickable-cell {
    cursor: pointer;
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

/* Hide rows that don't match the search term */
.clickable-row {
  display: table-row;
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
      <button class="btn btn-primary" id="logout-button">Log out</button>
      <a href="ctmeupage.php" class="link">Records</a>
      <?php
      // Check if the user role is "IT Administrator"
      if ($_SESSION['role'] === 'IT Administrator') {
          // Do not display the "Create Accounts" link
      } else {
          // Display the "Create Accounts" link
          echo '<a href="ctmeurecords.php" class="link">Reports</a>';
      }
      ?>
      <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a>-->
      <a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>
      <a href="ctmeucreate.php" id="noEnforcers" class="link">Create Accounts</a>
      <a href="ctmeuusers.php" class="link">User Account</a>
    </div>
  </div>
</nav>
<div class="search-container">
  <input type="text" id="search-bar" placeholder="Search...">
  <select id="filter-select">
    <option value="name">Name</option>
    <option value="license">License No.</option>
    <option value="vehicle">Vehicle</option>
    <option value="place of occurrence">Place of Occurrence</option>
  </select>
</div>

<div class="table-container">
    <form id="archive-form" action="php/archiverow.php" method="POST">
        <button type="submit" class="btn btn-primary" id="archive-button"><i class='bx bx-archive-in'></i></button>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th><input type="checkbox" id="select-all-checkbox"></th>
                    <th>Name</th>
                    <th>License No.</th>
                    <th>Vehicle</th>
                    <th>Place of Occurrence</th>
                </tr>
            </thead>
            <tbody id="ticket-table-body">
            <?php
            $visibleTicketCount = 0; // Initialize a counter for visible tickets

            // Loop through the fetched violation ticket data and populate the table rows
            foreach ($violationTickets as $index => $ticket) {
                // Check if the is_settled value is 0 before making the row clickable
                if ($ticket['is_settled'] == 0) {
                    $visibleTicketCount++; // Increment the visible ticket counter

                    // Convert the row data to a JSON string
                    $rowData = json_encode($ticket);

                    echo "<tr>";
                    // Display the visible ticket count in the "No." column
                    echo "<td>" . $visibleTicketCount . "</td>";
                    // Add a checkbox for archiving
                    echo "<td><input type='checkbox' name='archive[]' value='" . $ticket['ticket_id'] . "'></td>";
                    // Wrap the name in a clickable <td>
                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['driver_name'] . "</td>";
                    // Wrap the license in a clickable <td>
                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['driver_license'] . "</td>";
                    // Wrap the address in a clickable <td>
                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['vehicle_type'] . "</td>";
                    // Wrap the district in a clickable <td>
                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['place_of_occurrence'] . "</td>";
                    echo "</tr>";
                } else {
                    // For rows with is_settled value other than 0, you can choose to display them differently or exclude them from the table.
                    // Example: Display a message or simply don't include them in the table.
                }
            }
            ?>
            </tbody>
        </table>
    </form>
</div>

<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
<script>
document.getElementById('select-all-checkbox').addEventListener('change', function () {
        var checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = document.getElementById('select-all-checkbox').checked;
        });
    });

  // Add a click event listener to the clickable cells
document.querySelectorAll('.clickable-cell').forEach(function(cell) {
    cell.addEventListener('click', function() {
        // Get the row data JSON string from the clicked cell's data-rowdata attribute
        var rowData = cell.getAttribute('data-rowdata');
        
        // Redirect to the details page with the row data as a query parameter
        // Exclude the bx-archive-in button from the row data
        var parsedRowData = JSON.parse(rowData);
        delete parsedRowData.is_settled; // Remove the is_settled property
        window.location.href = 'detailarch.php?data=' + encodeURIComponent(JSON.stringify(parsedRowData));
    });
});
  function rowClick(row) {
    // Get the row data JSON string
    var rowData = row.getAttribute('data-rowdata');
    
    // Redirect to the details page with the row data as a query parameter
    // Exclude the bx-archive-in button from the row data
    var parsedRowData = JSON.parse(rowData);
    delete parsedRowData.is_settled; // Remove the is_settled property
    window.location.href = 'detailarch.php?data=' + encodeURIComponent(JSON.stringify(parsedRowData));
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

        document.getElementById('welcome-text').textContent = 'Welcome, ' + role + ' ' + firstName + ' ' + lastName;
    <?php } ?>
    
    function filterTable() {
    var filterSelect = document.getElementById('filter-select');
    var searchInput = document.getElementById('search-bar').value.toLowerCase();

    // Define an object to map filter keys to column names
    var columnMap = {
        'name': 'driver_name',
        'license': 'driver_license',
        'vehicle': 'vehicle_type',
        'place of occurrence': 'place_of_occurrence'
    };

    // Get the column name based on the selected filter key
    var columnName = columnMap[filterSelect.value];

    // Loop through the table rows and filter based on the selected column
    var rows = document.querySelectorAll('#ticket-table-body .clickable-row');
    rows.forEach(function(row) {
        var rowData = JSON.parse(row.getAttribute('data-rowdata'));

        // Get the cell value based on the selected column name
        var cellValue = String(rowData[columnName]).toLowerCase();

        console.log("Search Input: " + searchInput);
        console.log("CellValue: " + cellValue);
        console.log("Filter Key: " + filterSelect.value);
        console.log("Row Data: ", rowData);

        if (cellValue.startsWith(searchInput)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


    
// Add event listeners to trigger filtering
document.getElementById('filter-select').addEventListener('change', filterTable);
document.getElementById('search-bar').addEventListener('input', filterTable);

</script>

</body>
</html>