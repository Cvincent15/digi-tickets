<?php
session_start();
include 'php/database_connect.php'; 


// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are not logged in
  header("Location: index.php");
  exit();
}

// Function to fetch vehicle_name based on vehicle_id
function fetchVehicleName($vehicleId, $conn) {
  // Perform a database query to fetch vehicle_name based on vehicle_id
  $query = "SELECT vehicle_name FROM vehicletype WHERE vehicle_id = $vehicleId";
  $result = mysqli_query($conn, $query);

  // Check if the query was successful and if a row was returned
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      return $row['vehicle_name'];
  } else {
      // Return a default value or handle the error as needed
      return "Vehicle not found"; // Replace with your desired default value or error message
  }
}


// Define a function to fetch data from the violation_tickets table
function fetchViolationTickets() {
  global $conn; // Assuming you have a database connection established

  // Specify the columns you want to fetch from the violation_tickets table
  $sql = "SELECT t.ticket_id, t.driver_name,  t.driver_license, t.vehicle_type, t.plate_no, t.date_time_violation, t.place_of_occurrence, t.user_ctmeu_id, t.user_id_motorists, t.is_settled
          FROM violation_tickets AS t
          LEFT JOIN violations AS v ON t.ticket_id = v.ticket_id_violations
          GROUP BY t.ticket_id"; // Modify this query as needed

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
function generatePDF($data) {
  require_once('TCPDF/tcpdf.php');

  // Create a new TCPDF instance with landscape orientation
  $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

  // Set document information
  $pdf->SetCreator('Your Name');
  $pdf->SetAuthor('Your Name');
  $pdf->SetTitle('CTMEU Traffic Violation Data');
  $pdf->SetSubject('Traffic Violation Data');
  $pdf->SetKeywords('CTMEU, traffic violation, PDF');

  // Add a page
  $pdf->AddPage();

  // Set font
  $pdf->SetFont('helvetica', '', 10);


  // Remove the line above the header
$pdf->SetLineStyle(array('width' => 0)); // Set line width to 0

// Define the table layout
$tbl = '<table width="100%" cellspacing="0" cellpadding="4" border="1">';
$tbl .= '<tr bgcolor="#cccccc">';
$tbl .= '<th style="width:30px; height:10px;">No.</th>';
$tbl .= '<th>Name</th>';
$tbl .= '<th>License No.</th>';
$tbl .= '<th>Place Occurred</th>';
$tbl .= '<th>Plate</th>';
$tbl .= '<th>Vehicle</th>';
$tbl .= '<th>Date Occurred</th>';
$tbl .= '<th>Account Status</th>';
$tbl .= '</tr>';

$ticketNumber = 1; // Initialize ticket number

// Populate the table rows with data
foreach ($data as $row) {
  include 'php/database_connect.php';
  $vehicleId = $row['vehicle_type'];
  $vehicleName = fetchVehicleName($vehicleId, $conn);
  $tbl .= '<tr>';
  $tbl .= '<td style="width:30px; height:10px;">' . $ticketNumber . '</td>'; // Use the ticket number as No.
  $tbl .= '<td>' . $row['driver_name'] . '</td>';
  $tbl .= '<td>' . $row['driver_license'] . '</td>';
  $tbl .= '<td>' . $row['place_of_occurrence'] . '</td>';
  $tbl .= '<td>' . $row['plate_no'] . '</td>';
  $tbl .= '<td>' . $vehicleName . '</td>';
  $tbl .= '<td>' . $row['date_time_violation'] . '</td>';
  $tbl .= '<td>' . ($row['is_settled'] == 0 ? 'Unsettled' : 'Settled') . '</td>';
  $tbl .= '</tr>';

  $ticketNumber++; // Increment ticket number
}

$tbl .= '</table>';

// Output the table to the PDF with header
$pdf->writeHTML('
  <div style="text-align: center; margin-top: 10px;">
      <h1 style="font-size: 14px; margin: 0;">Republika ng Pilipinas</h1>
      <p style="font-size: 12px; margin: 0;">Lungsod ng Santa Rosa</p>
      <p style="font-size: 10px; margin: 0;">Lalawigan ng Laguna</p>
      <p style="font-size: 16px; font-weight: bold; margin-bottom: 10px; margin: 0;">SANGAY NG PAMAMAHALA AT PAGPAPATUPAD NG TRAPIKO</p>
      <p style="font-size: 10px; margin-bottom: 20px; margin: 0;">(CITY TRAFFIC MANAGEMENT AND ENFORCEMENT UNIT)</p>
  </div>
  ' . $tbl, true, false, false, false, '');

// Add a row for signatures at the bottom of the table
$tblSignatures = '<table width="100%" cellspacing="0" cellpadding="8">';
$tblSignatures .= '<tr>';
$tblSignatures .= '<td colspan="2">Administrator\'s Signature: ____________________________</td>';
$tblSignatures .= '<td colspan="2" style="text-align: right;">Authorized By: ____________________________</td>';
$tblSignatures .= '</tr>';
$tblSignatures .= '</table>';

$pdf->writeHTML($tblSignatures, true, false, false, false, '');

// Return the PDF content as a string
return $pdf->Output('', 'S');
}

// Fetch the filtered data from the session variable
$filteredData = isset($_SESSION['filtered_data']) ? $_SESSION['filtered_data'] : $violationTickets;

if (isset($_POST['generate_pdf'])) {
  // Generate the PDF using the filtered data
  $_SESSION['preview_pdf_content'] = generatePDF($filteredData);
  header("Location: previewreport.php");
  exit();
}

// Define a function to filter data by date range
function filterDataByDate($data, $startMonth, $endMonth, $year) {
  $filteredData = array();

  foreach ($data as $row) {
    $ticketDate = strtotime($row['date_time_violation']);
    $ticketMonth = date('m', $ticketDate);
    $ticketYear = date('Y', $ticketDate);

    // Compare ticket month and year with the selected date range
    if (
      ($ticketYear == $year) &&
      ($ticketMonth >= $startMonth) &&
      ($ticketMonth <= $endMonth)
    ) {
      $filteredData[] = $row;
    }
  }

  return $filteredData;
}

$dataFound = false;

// Check if the filter button was clicked
if (isset($_POST['filter-button'])) {
  $startMonth = $_POST['start-month'];
  $endMonth = $_POST['end-month'];
  $year = $_POST['year'];

  // Filter the data based on the selected date range
  $filteredData = filterDataByDate($violationTickets, $startMonth, $endMonth, $year);

  // Check if any data is found after filtering
  if (!empty($filteredData)) {
      $dataFound = true;
  } else {
      echo "<script>alert('No Tickets found in the specified date');</script>";
  }
}

// Echo the $dataFound value to JavaScript when the page loads
echo '<script>var initialDataFound = ' . ($dataFound ? 'true' : 'false') . ';</script>';
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
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Data Hub</title>
</head>
<style>
  #vehicle-violations-table {
    margin: 0 auto; /* Center the table horizontally */
    width: 50%; /* Set the table width to 50% of the parent container */
  }

  #vehicle-violations-table th,
  #vehicle-violations-table td {
    padding: 8px; /* Add padding to table cells */
    text-align: center; /* Center text in cells */
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



  .card {
        margin: 2.5% auto;
        width: 700px; /* Adjust the width as needed */
        height: auto; /* Adjust the height as needed */
        text-align: left;
    }
    .table-container {
        max-width: 100%;
        overflow-x: hidden;
    }

  
</style>
<body style="height: auto;">

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
                // Do not display the "Create Accounts" link
            } else {
                // Display the "Create Accounts" link
            //    echo '<a href="ctmeurecords.php" class="nav-link">Reports</a>';


            echo '<a href="ctmeurecords.php" class="nav-link active" style="font-weight: 600;">Reports</a>';

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
                // Display the "Create Accounts" link
            //    echo '<a href="ctmeurecords.php" class="link">Reports</a>';
            }
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<li><a class="dropdown-item" href="ctmeuusers.php">User Account</a></li>';
            // Uncomment this line to show "Create Accounts" to other roles
            echo '<li><a class="dropdown-item" href="ctmeucreate.php">Create Account</a></li>';
            echo '<li><a class="dropdown-item" href="ctmeusettings.php">Ticket Form</a></li>';
            
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


<div class="card align-items-center">
    <div class="date-filter-container">
  <label for="start-month">Start Month:</label>
  <select id="start-month">
  </select>

  <label for="end-month">End Month:</label>
  <select id="end-month"> 
  </select>

  <label for="year">Year:</label>
  <select id="year"></select>
  <button class="btn btn-primary" id="filter-button">Apply Filter</button>
</div>
</div>

<div class="container mt-1" style="display:none;">
<form method="post" target="_blank">
  <input type="hidden" id="filtered-data" name="filtered-data" value="">
  <button class="btn btn-primary" type="submit" name="generate_pdf">Generate PDF</button>
</form>

<div class="table-container mb-5">
<table id="vehicle-violations-table">
    <thead>
        <tr>
            <th>Vehicle Type</th>
            <th>Number of Violations</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>License No.</th>
            <th>Place Occurred</th>
            <th>Plate</th>
            <th>Vehicle</th>
            <th>Date Occurred</th>
            <th>Account Status</th>
        </tr>
    </thead>
    <tbody class="w-75" id="ticket-table-body">
    <?php
// Initialize $visibleTicketCount before the loop
$visibleTicketCount = 0;

// Loop through the fetched violation ticket data and populate the table rows
foreach ($violationTickets as $index => $ticket) {
    // Check if the is_settled value is 0 before making the row clickable
    $visibleTicketCount++; // Increment the visible ticket counter
    $vehicleId = $ticket['vehicle_type'];
    $vehicleName = fetchVehicleName($vehicleId, $conn);

    // Convert the row data to a JSON string
    $rowData = json_encode($ticket);

    echo "<tr class='clickable-row' data-rowdata='$rowData'>";
    // Display the visible ticket count in the "No." column
    echo "<td>" . $visibleTicketCount . "</td>";
    // Add the columns from the fetched data
    echo "<td>" . $ticket['driver_name'] . "</td>";
    echo "<td>" . $ticket['driver_license'] . "</td>";
    echo "<td>" . $ticket['place_of_occurrence'] . "</td>";
    echo "<td>" . $ticket['plate_no'] . "</td>";
    echo "<td>" . $vehicleName . "</td>";
    echo "<td>" . $ticket['date_time_violation'] . "</td>";
    echo "<td>" . ($ticket['is_settled'] == 0 ? 'Unsettled' : 'Settled') . "</td>";
    echo "</tr>";
}
?>

    </tbody>
</table>

</div>
  </div>

</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>


// Global variable to store filtered data
var filteredData = [];

// Function to map vehicle types to names
function mapVehicleType(vehicleType) {
  switch (vehicleType) {
    case '1':
      return 'Car';
    case '2':
      return 'Motorcycle';
    case '3':
      return 'Truck';
    case '2':
      return 'Bus';
    case '4':
      return 'Van';
    case '5':
      return 'Tricycle';
    case '6':
      return 'E-Bike';
    // Add more cases for other vehicle types if needed
    default:
      return 'Unknown Vehicle Type';
  }
}

// Function to update the vehicle violations table
function updateVehicleViolationsTable(data) {
  var vehicleViolationsTable = document.getElementById('vehicle-violations-table');
  var tbody = vehicleViolationsTable.querySelector('tbody');

  // Clear existing rows
  tbody.innerHTML = '';

  // Count violations for each vehicle type
  var vehicleCounts = {};
  data.forEach(function (row) {
    var vehicleType = row['vehicle_type']; // Use the vehicle_type directly
    var vehicleName = mapVehicleType(vehicleType); // Map numeric type to name

    if (vehicleType in vehicleCounts) {
      vehicleCounts[vehicleType]++;
    } else {
      vehicleCounts[vehicleType] = 1;
    }

    // Populate the new table
    var rowElement = document.createElement('tr');
    rowElement.innerHTML = `<td>${vehicleName}</td><td>${vehicleCounts[vehicleType]}</td>`;
    tbody.appendChild(rowElement);
  });
}



// Add an event listener to the "Apply Filter" button
document.getElementById('filter-button').addEventListener('click', function() {
  // Filter the table based on the selected date range (Replace with your own logic)
  var filteredData = calculateStatusCounts(); // Calculate data from the table

});

// Function to calculate Settled and Unsettled counts from the table
function calculateStatusCounts() {
  var table = document.getElementById('ticket-table-body');
  var rowCount = table.rows.length;
  var settledCount = 0;
  var unsettledCount = 0;

  for (var i = 0; i < rowCount; i++) {
    var statusCell = table.rows[i].cells[7].textContent; // Assuming the status is in the 13th cell (index 12)
    if (statusCell === 'Settled') {
      settledCount++;
    } else if (statusCell === 'Unsettled') {
      unsettledCount++;
    }
  }

  return [settledCount, unsettledCount];
}
</script>

    <script>
     const yearSelect = document.getElementById("year");
        const currentYear = new Date().getFullYear();
        const yearsPast = 50;
        const yearsFuture = 50;
        const startYear = currentYear - yearsPast;
        const endYear = currentYear + yearsFuture;

        for (let year = startYear; year <= endYear; year++) {
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }

        // Set the default value to the current year
        yearSelect.value = currentYear;
     
        document.querySelector('[name="generate_pdf"]').addEventListener('click', function () {
  // Set the value of the hidden input field
  document.getElementById('filtered-data').value = JSON.stringify(filteredData);
});



    // Function to toggle the visibility of the table and "Generate PDF" button container
  function toggleTableAndPDFVisibility(show) {
    var container = document.querySelector('.container');
    var generatePDFButton = document.querySelector('[name="generate_pdf"]');
    
    if (show) {
      container.style.display = 'block';
      generatePDFButton.style.display = 'block';
    } else {
      container.style.display = 'none';
      generatePDFButton.style.display = 'none';
    }
  }

// Add an event listener to the "Apply Filter" button
document.getElementById('filter-button').addEventListener('click', function() {
  // Get the selected start month, end month, and year
  var startMonth = document.getElementById('start-month').value;
  var endMonth = document.getElementById('end-month').value;
  var year = document.getElementById('year').value;

  // Check if the start month is after the end month
  if (year == '' || startMonth > endMonth) {
    alert('Invalid date range. Please select a valid date range.');
    return; // Exit the function without filtering the table
  }
  
  // Filter the table based on the selected date range
    filterTableByDate(startMonth, endMonth, year);
    updateVehicleViolationsTable(filteredData);
    toggleTableAndPDFVisibility(filteredData.length > 0);

  
  $.ajax({
  type: 'POST',
  url: 'filter_handler.php',
  data: { filteredData: JSON.stringify(filteredData) },
  dataType: 'json',  // Specify the expected data type
  success: function(response) {
    console.log(response);
    // Handle the server response if needed
  },
  error: function(xhr, status, error) {
    console.error(xhr.responseText);
    // Handle errors if needed
  }
});
});



function filterTableByDate(startMonth, endMonth, year) {
  var rows = document.querySelectorAll('#ticket-table-body .clickable-row');
  var dataFound = false;

  filteredData = []; // Clear the previous filtered data

  rows.forEach(function (row) {
    var rowData = JSON.parse(row.getAttribute('data-rowdata'));
    var ticketDateStr = rowData['date_time_violation'];
    var ticketDate = new Date(ticketDateStr);

    var ticketMonth = String(ticketDate.getMonth() + 1).padStart(2, '0'); // Add 1 because months are zero-based
    var ticketYear = String(ticketDate.getFullYear());

    if (
      ticketYear == year &&
      ticketMonth >= startMonth &&
      ticketMonth <= endMonth
    ) {
      row.style.display = ''; // Show the row if it matches the filter
      dataFound = true; // Data is found

      // Add the filtered row data to the array
      filteredData.push(rowData);
    } else {
      row.style.display = 'none'; // Hide the row if it doesn't match the filter
    }
  });

  

  // Display alert if no data is found
  if (!dataFound) {
    alert('No Tickets found in the specified date.');
  }
}
toggleTableAndPDFVisibility(initialDataFound);

  // Function to populate the month options
  function populateMonthOptions() {
    var startMonthSelect = document.getElementById('start-month');
    var endMonthSelect = document.getElementById('end-month');

    // Define an array of month names
    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // Populate start and end month options
    for (var i = 1; i <= 12; i++) {
      var monthValue = String(i).padStart(2, '0'); // Add leading zero if needed
      var monthName = monthNames[i - 1];

      // Create option elements and add them to the selects
      var startOption = document.createElement('option');
      startOption.value = monthValue;
      startOption.textContent = monthName;
      startMonthSelect.appendChild(startOption);

      var endOption = document.createElement('option');
      endOption.value = monthValue;
      endOption.textContent = monthName;
      endMonthSelect.appendChild(endOption);
    }
  }

  // Call the function to populate month options when the page loads
  window.addEventListener('load', populateMonthOptions);

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