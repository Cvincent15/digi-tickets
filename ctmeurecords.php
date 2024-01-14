<?php
session_start();
include 'php/database_connect.php'; 


// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are not logged in
  header("Location: login");
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

// Fetch violation types from the database
$violationQuery = "SELECT violation_name, violation_section FROM violationlists";
$violationResult = mysqli_query($conn, $violationQuery);
$violations = [];
while ($violationRow = mysqli_fetch_assoc($violationResult)) {
    $violations[] = $violationRow;
}


function fetchViolationTickets()
{
    global $conn; // Assuming you have a database connection established

    // Write a SQL query to fetch data from the violation_tickets table
    $sql = "SELECT 
            violation_tickets.*,
            CONCAT(users.first_name, ' ', IFNULL(users.middle_name, ''), ' ', users.last_name) AS driver_name,
            vehicletype.vehicle_name as vehicle_name,
            GROUP_CONCAT(DISTINCT violationlists.violation_section SEPARATOR ', ') AS concatenated_sections
        FROM violation_tickets
            JOIN vehicletype ON violation_tickets.vehicle_type = vehicletype.vehicle_id
            LEFT JOIN violations ON violation_tickets.ticket_id = violations.ticket_id_violations
            LEFT JOIN violationlists ON violations.violationlist_id = violationlists.violation_list_ids
            LEFT JOIN users ON users.user_ctmeu_id = violation_tickets.user_ctmeu_id
        WHERE violation_tickets.user_ctmeu_id IS NOT NULL
        GROUP BY violation_tickets.ticket_id;
    "; // Modify this query as needed

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
  $pdf->SetTitle('CTMEU Traffic Violation Data');
  $pdf->SetSubject('Traffic Violation Data');
  $pdf->SetKeywords('CTMEU, traffic violation, PDF');

  // Add a page
  $pdf->AddPage();
  
  $pdf->Image('images/santarc.jpg', 45, 15, 25, 0, 'JPG');
  $pdf->Image('images/ctmeu.jpg', 230, 15, 25, 0, 'JPG');
  // Set font size and style for the first part of the header text

// Set draw color and fill color to white
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetFillColor(255, 255, 255);

$pdf->SetFont('helvetica', '', 12);

// Set position for the first part of the header text
$pdf->SetXY(10, 10); // Adjust the X and Y coordinates as needed

// Concatenate the lines into a single string
$headerText = "
Republika ng Pilipinas
";

// Output the header text using a single MultiCell call
$pdf->MultiCell(0, 8, $headerText, 0, 'C');

// Set font size for the second part of the header text
$pdf->SetFont('helvetica', '', 10);

// Adjust the Y-coordinate to position the next part on the same line
$pdf->SetY($pdf->GetY() - 5); // Subtract the height of the previous MultiCell

// Output the second part of the header text using MultiCell
$pdf->MultiCell(0, 8, "
Lungsod ng Santa Rosa\n
", 0, 'C');

// Set font size for the third part of the header text
$pdf->SetFont('helvetica', '', 8);

// Adjust the Y-coordinate to position the next part on the same line
$pdf->SetY($pdf->GetY() - 7); // Subtract the height of the previous MultiCell

// Output the third part of the header text using MultiCell
$pdf->MultiCell(0, 8, "
Lalawigan ng Laguna
", 0, 'C');

// Set font size and style for the second part of the header text
$pdf->SetFont('helvetica', 'B', 14);

// Output the second part of the header text using MultiCell
$pdf->MultiCell(0, 8, "SANGAY NG PAMAMAHALA AT PAGPAPATUPAD NG TRAPIKO", 0, 'C');

// Set font size for the third part of the header text
$pdf->SetFont('helvetica', '', 8);

// Output the third part of the header text using MultiCell
$pdf->MultiCell(0, 8, "(CITY TRAFFIC MANAGEMENT AND ENFORCEMENT UNIT)", 0, 'C');

// Reset font for the rest of the content
$pdf->SetFont('helvetica', '', 8);

  // Remove the line above the header
$pdf->SetLineStyle(array('width' => 0)); // Set line width to 0

// Define the table layout
$tbl = '<table width="100%" cellspacing="0" cellpadding="4" border="1">';
$tbl .= '<tr bgcolor="#cccccc">';
$tbl .= '<th style="width:2%;">#</th>'; // Adjust the width as needed
$tbl .= '<th width="5%">Ticket No.</th>';
$tbl .= '<th width="5%">Date Occurred</th>';
$tbl .= '<th width="5%">Time Occurred</th>';
$tbl .= '<th width="10%">Driver\'s Name</th>';
$tbl .= '<th width="10%">Driver\'s Address</th>';
$tbl .= '<th width="10%">License No.</th>';
$tbl .= '<th width="8%">Issuing District</th>';
$tbl .= '<th width="7%">Vehicle</th>';
$tbl .= '<th width="5%">Plate No.</th>';
$tbl .= '<th width="10%">Registered Owner</th>';
$tbl .= '<th width="10%">Registered Owner\'s Address</th>';
$tbl .= '<th width="5%">Place of Violation</th>';
$tbl .= '<th width="5%">Violations</th>';
$tbl .= '<th width="6%">Account Status</th>';
$tbl .= '</tr>';

$ticketNumber = 1; // Initialize ticket number

// Populate the table rows with data
foreach ($data as $row) {

  $tbl .= '<tr>';
  $tbl .= '<td style="width:2%;">' . $ticketNumber . '</td>'; // Use the ticket number as No.
  $tbl .= '<td width="5%">' . $row['control_number'] . '</td>';
  $tbl .= '<td width="5%">' . $row['date_violation'] . '</td>';
  $tbl .= '<td width="5%">' . $row['time_violation'] . '</td>';
  $tbl .= '<td width="10%">' . $row['driver_name'] . '</td>';
  $tbl .= '<td width="10%">' . $row['driver_address'] . '</td>';
  $tbl .= '<td width="10%">' . $row['driver_license'] . '</td>';
  $tbl .= '<td width="8%">' . $row['issuing_district'] . '</td>';
  $tbl .= '<td width="7%">' . $row['vehicle_name'] . '</td>';
  $tbl .= '<td width="5%">' . $row['plate_no'] . '</td>';
  $tbl .= '<td width="10%">' . $row['reg_owner'] . '</td>';
  $tbl .= '<td width="10%">' . $row['reg_owner_address'] . '</td>';
  $tbl .= '<td width="5%">' . $row['place_of_occurrence'] . '</td>';
  $tbl .= '<td width="5%">'. $row['concatenated_sections'] .'</td>';
  $tbl .= '<td width="6%">' . ($row['is_settled'] == 0 ? 'Unsettled' : 'Settled') . '</td>';
  $tbl .= '</tr>';
 
  $ticketNumber++; // Increment ticket number
 }
 
 $tbl .= '</table>';

// Output the table to the PDF
$pdf->writeHTML($tbl, true, false, false, false, '');


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
  $filteredData = json_decode($_POST['filtered-data'], true);
  $violationFilter = $_POST['violation_filter'];
  $filteredData = filterDataByDate($filteredData, null, null, null, $violationFilter);
  $_SESSION['preview_pdf_content'] = generatePDF($filteredData);
  header("Location: previewreport.php");
  exit();
}

// Define a function to filter data by date range, vehicle type, and violation
function filterDataByDate($data, $startDate, $endDate, $vehicleType, $violationFilter) {
  $filteredData = array();

  foreach ($data as $row) {
      $ticketDateTimeStr = $row['date_violation'] . ' ' . $row['time_violation'];
      $ticketDateTime = strtotime($ticketDateTimeStr);

      $startDateTime = strtotime($startDate);
      $endDateTime = strtotime($endDate);

      // Check if the violation matches the selected violation (if any)
      $matchesViolation = !$violationFilter || strpos($row['concatenated_sections'], $violationFilter) !== false;

      // Compare ticket date and time with the selected date and time range
      // and check if the vehicle type and violation match the selected filters (if any)
      if (
          (!$startDate || $ticketDateTime >= $startDateTime) &&
          (!$endDate || $ticketDateTime <= $endDateTime) &&
          (!$vehicleType || $row['vehicle_type'] == $vehicleType) &&
          $matchesViolation
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
  $vehicleType = $_POST['vehicle_filter']; // Get the selected vehicle type from the POST data

  // Filter the data based on the selected date range and vehicle type
  $filteredData = filterDataByDate($violationTickets, $startMonth, $endMonth, $year, $vehicleType);

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
        width: 800px; /* Adjust the width as needed */
        height: auto; /* Adjust the height as needed */
        text-align: left;
    }
    .table-container {
        max-width: 100%;
        overflow-x: scroll;
    }
    .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 10vh;
        }

        form {
            text-align: center;
        }

  
</style>
<body style="height: auto; background: linear-gradient(to bottom, #1F4EDA, #102077);">

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


<div class="card">
<div class="date-filter-container mx-auto">
<div class="row">
    <div class="col-sm-5 mt-3 mb-3 text-left" style="font-weight: 700;"> Start Date and Time Default:All</div>
    <div class="col-sm-7 mt-3 mb-3 text-right" style="font-weight: 700;"> End Date and Time Default:All</div>
</div>
<div class="row">
    <div class="col-sm mb-3 ms-3">
        <input type="date" id="start-date" class="form-control mb-3" />
        <input type="time" id="start-time" class="form-control mb-3" />
    </div>
    <div class="col-sm">
        <input type="date" id="end-date" class="form-control mb-3" />
        <input type="time" id="end-time" class="form-control mb-3" />
    </div>
    <div class="row">
    <div class="col-sm mb-3 ms-3">
    <select class="form-control" id="vehicle-filter" name="vehicle_filter">
        <option value="">All Vehicles</option>
        <?php
        
        // Fetch vehicle types from the database
        $vehicleQuery = "SELECT vehicle_id, vehicle_name FROM vehicletype";
        $vehicleResult = mysqli_query($conn, $vehicleQuery);
        while ($vehicleRow = mysqli_fetch_assoc($vehicleResult)) {
            echo "<option value='" . $vehicleRow['vehicle_id'] . "'>" . $vehicleRow['vehicle_name'] . "</option>";
        }
        ?>
    </select>
</div>
   <!-- Violations Filter with Search Function -->
<div class="col-sm mb-3 ms-3" style="max-width:400px;">
    <div class="input-group input-group-lg mb-3">
        <label class="input-group-text form-control" for="violations-filter" style="font-size: 1rem; width: 30px;">Violations</label>
        <select class="form-control select2" id="violations-filter">
            <option value="">All Violations</option>
            <?php foreach ($violations as $violation): ?>
                <option value="<?php echo htmlspecialchars($violation['violation_section']); ?>">
                    <?php echo htmlspecialchars($violation['violation_name']) . " (" . htmlspecialchars($violation['violation_section']) . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

</div>
</div>
<div class="row">
        <div class="col text-center">
            <button class="btn btn-primary mb-3" id="filter-button">Apply Filter</button>
        </div>
    </div>
</div>

<div class="container mt-1" style="display:none;">
<div class="container" style="margin-top: 100px;">
    <form method="post" target="_blank">
        <input type="hidden" id="filtered-data" name="filtered-data" value="">
        <input type="hidden" id="violation-filter-value" name="violation_filter" value="">
        <button class="btn btn-light" style="--bs-btn-padding-y: 1.5rem; --bs-btn-padding-x: 8rem; --bs-btn-font-size: 1rem; font-weight: 800; color: #0A157A;" type="submit" name="generate_pdf">
            <img src="./images/alternate_file.png">Print Report
        </button>
    </form>
</div>

<div class="table-container mb-5">
<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Ticket No.</th>
            <th>Date Occurred</th>
            <th>Time Occurred</th>
            <th>Driver's Name</th>
            <th>Driver's Address</th>
            <th>License No.</th>
            <th>Issuing District</th>
            <th>Vehicle</th>
            <th>Plate No.</th>
            <th>Registered Owner</th>
            <th>Registered Owner's Address</th>
            <th>Place of Violation</th>
            <th>Violations</th>
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
    
    // Convert the row data to a JSON string
    $rowData = json_encode($ticket);

    echo "<tr class='clickable-row' data-rowdata='$rowData'>";
    // Display the visible ticket count in the "No." column
    echo "<td>" . $visibleTicketCount . "</td>";
    echo "<td>" . $ticket['control_number'] . "</td>";
    // Add the columns from the fetched data
    echo "<td>" . $ticket['date_violation'] . "</td>";
    echo "<td>" . $ticket['time_violation'] . "</td>";
    echo "<td>" . $ticket['driver_name'] . "</td>";
    echo "<td>" . $ticket['driver_address'] . "</td>";
    echo "<td>" . $ticket['driver_license'] . "</td>";
    echo "<td>" . $ticket['issuing_district'] . "</td>";
    echo "<td>" . $ticket['vehicle_name'] . "</td>";
    echo "<td>" . $ticket['plate_no'] . "</td>";
    echo "<td>" . $ticket['reg_owner'] . "</td>";
    echo "<td>" . $ticket['reg_owner_address'] . "</td>";
    echo "<td>" . $ticket['place_of_occurrence'] . "</td>";
    echo "<td>". $ticket['concatenated_sections'] ."</td>";
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


$(document).ready(function() {
          $('.select2').select2({
              placeholder: "Default: All Violations",
              allowClear: true,
              width: '100%' // Adjust as needed
          });
      });
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
    case '4':
      return 'Bus'; // Corrected case for '4' (Bus)
    case '5':
      return 'Van';
    case '6':
      return 'Tricycle'; // Corrected case for '6' (Tricycle)
    case '7':
      return 'E-Bike'; // Added case for '7' (E-Bike)
    // Add more cases for other vehicle types if needed
    default:
      return 'Unknown Vehicle Type';
  }
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
     
     
     document.querySelector('[name="generate_pdf"]').addEventListener('click', function () {
 // Set the value of the hidden input field
 document.getElementById('filtered-data').value = JSON.stringify(filteredData);
 document.getElementById('violation-filter-value').value = $('#violations-filter').val();
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

  

  function filterTableByDate(startDate, startTime, endDate, endTime, vehicleType, violationFilter) {
   var startDateTime = startDate && startTime ? new Date(startDate + 'T' + startTime) : null;
   var endDateTime = endDate && endTime ? new Date(endDate + 'T' + endTime) : null;

   var rows = document.querySelectorAll('#ticket-table-body .clickable-row');
   var dataFound = false;

   // Clear the previous filtered data
   filteredData.length = 0;

   rows.forEach(function (row) {
        var rowData = JSON.parse(row.getAttribute('data-rowdata'));
        var ticketDateTimeStr = rowData['date_violation'] + 'T' + rowData['time_violation'];
        var ticketDateTime = new Date(ticketDateTimeStr);

        var matchesVehicleType = !vehicleType || rowData['vehicle_type'] == vehicleType;
        var matchesViolation = true; // Assume true until proven otherwise

        // If a violation filter is set, split the concatenated sections and check for an exact match
        if (violationFilter) {
            var sections = rowData['concatenated_sections'].split(', ');
            matchesViolation = sections.includes(violationFilter);
        }

        if (
            (!startDateTime || ticketDateTime >= startDateTime) &&
            (!endDateTime || ticketDateTime <= endDateTime) &&
            matchesVehicleType &&
            matchesViolation
        ) {
            row.style.display = ''; // Show the row if it matches the filter
            dataFound = true; // Data is found
            filteredData.push(rowData); // Add the filtered row data to the array
        } else {
            row.style.display = 'none'; // Hide the row if it doesn't match the filter
        }
    });
    
   toggleTableAndPDFVisibility(dataFound);
   // Display alert if no data is found
   if (!dataFound) {
       alert('No Tickets found in the specified date and time range.');
   }
}


// Add an event listener to the "Apply Filter" button
document.getElementById('filter-button').addEventListener('click', function() {
   var startDate = document.getElementById('start-date').value;
   var startTime = document.getElementById('start-time').value;
   var endDate = document.getElementById('end-date').value;
   var endTime = document.getElementById('end-time').value;
   var vehicleType = document.getElementById('vehicle-filter').value;
   var violationFilter = $('#violations-filter').val();

   var startDateTime = startDate && startTime ? new Date(startDate + 'T' + startTime) : null;
   var endDateTime = endDate && endTime ? new Date(endDate + 'T' + endTime) : null;

   // Check if the start date and time is after the end date and time
   if (startDateTime && endDateTime && startDateTime > endDateTime) {
       alert('Invalid date range. The end date and time must be later than the start date and time.');
       return; // Exit the function without filtering the table
   }

   // Filter the table based on the selected date range
   filterTableByDate(startDate, startTime, endDate, endTime, vehicleType, violationFilter);
   toggleTableAndPDFVisibility(filteredData.length > 0);
});



// Add an event listener to the "Apply Filter" button
toggleTableAndPDFVisibility(initialDataFound);


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