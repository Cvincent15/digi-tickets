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

  // Specify the columns you want to fetch from the violation_tickets table
  $sql = "SELECT t.ticket_id, t.driver_name, t.driver_address, t.driver_license, t.issuing_district, t.vehicle_type, t.plate_no, t.cor_no, t.place_issued, t.reg_owner, t.reg_owner_address, t.date_time_violation, t.place_of_occurrence, t.user_ctmeu_id, t.user_id_motorists, t.is_settled, GROUP_CONCAT(v.violation_name SEPARATOR ', ') AS violations
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
  
  // Define the table layout
  $tbl = '<table width="100%" cellspacing="0" cellpadding="4" border="1">';
  $tbl .= '<tr bgcolor="#cccccc">';
  $tbl .= '<th>No.</th>';
  $tbl .= '<th>Name</th>';
  $tbl .= '<th>License No.</th>';
  $tbl .= '<th>Address</th>';
  $tbl .= '<th>District</th>';
  $tbl .= '<th>Owner</th>';
  $tbl .= '<th>Owner Address</th>';
  $tbl .= '<th>Place Occurred</th>';
  $tbl .= '<th>Plate</th>';
  $tbl .= '<th>Vehicle</th>';
  $tbl .= '<th>Violation</th>';
  $tbl .= '<th>Date Occurred</th>';
  $tbl .= '<th>Account Status</th>';
  $tbl .= '</tr>';
  
  $ticketNumber = 1; // Initialize ticket number

  // Populate the table rows with data
  foreach ($data as $row) {
    $tbl .= '<tr>';
    $tbl .= '<td>' . $ticketNumber . '</td>'; // Use the ticket number as No.
    $tbl .= '<td>' . $row['driver_name'] . '</td>';
    $tbl .= '<td>' . $row['driver_license'] . '</td>';
    $tbl .= '<td>' . $row['driver_address'] . '</td>';
    $tbl .= '<td>' . $row['issuing_district'] . '</td>';
    $tbl .= '<td>' . $row['reg_owner'] . '</td>';
    $tbl .= '<td>' . $row['reg_owner_address'] . '</td>';
    $tbl .= '<td>' . $row['place_of_occurrence'] . '</td>';
    $tbl .= '<td>' . $row['plate_no'] . '</td>';
    $tbl .= '<td>' . $row['vehicle_type'] . '</td>';
    // Inside the table loop
    if (!empty($row['violations'])) {
      $tbl .= '<td>' . $row['violations'] . '</td>';
    } else {
      $tbl .= '<td>Null</td>';
    }
    $tbl .= '<td>' . $row['date_time_violation'] . '</td>';
    $tbl .= '<td>' . ($row['is_settled'] == 0 ? 'Settled' : 'Unsettled') . '</td>';
    $tbl .= '</tr>';
    
    $ticketNumber++; // Increment ticket number
  }
  
  $tbl .= '</table>';
  
  // Output the table to the PDF
  $pdf->writeHTML($tbl, true, false, false, false, '');
  
  // Output the PDF as a download
  $pdf->Output('violation_tickets.pdf', 'D');
}



if (isset($_POST['generate_pdf'])) {
  // Generate the PDF when the form is submitted
  generatePDF($violationTickets);
}// Define a function to filter data by date range
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
    <a href="ctmeupage.php" class="link">Records</a>
    <a href="ctmeurecords.php" class="link"><b>Reports</b></a>
    <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a> -->
    <a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" id="noEnforcers"class="link">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
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
  <button class="btn btn-primary" id="filter-button" style="">Apply Filter</button>
</div>
</div>

<div class="container mt-1" style="display: none;">
<form method="post">
  <input type="hidden" id="filtered-data" name="filtered-data" value="">
  <button class="btn btn-primary" type="submit" name="generate_pdf">Generate PDF</button>
</form>

<div class="table-container mb-5" style="overflow-x: auto; overflow-y: auto; max-height: 600px; max-width: 100%;">
<table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>License No.</th>
                <th>Address</th>
                <th>District</th>
                <th>Owner</th>
                <th>Owner Address</th>
                <th>Place Occurred</th>
                <th>Plate</th>
                <th>Vehicle</th>
                <th>Violation</th>
                <th>Date Occurred</th>
                <th>Account Status</th>
            </tr>
        </thead>
        <tbody class="w-75" id="ticket-table-body">
            <?php
            $visibleTicketCount = 0; // Initialize a counter for visible tickets

            // Inside the loop that populates the table rows
foreach ($violationTickets as $index => $ticket) {
  // Check if the is_settled value is 0 before making the row clickable
      $visibleTicketCount++; // Increment the visible ticket counter

      // Convert the row data to a JSON string
      $rowData = json_encode($ticket);

      echo "<tr class='clickable-row' data-rowdata='$rowData'>";
      // Display the visible ticket count in the "No." column
      echo "<td>" . $visibleTicketCount . "</td>";
      // Add the columns from the fetched data
      echo "<td>" . $ticket['driver_name'] . "</td>";
      echo "<td>" . $ticket['driver_license'] . "</td>";
      echo "<td>" . $ticket['driver_address'] . "</td>";
      echo "<td>" . $ticket['issuing_district'] . "</td>";
      echo "<td>" . $ticket['reg_owner'] . "</td>";
      echo "<td>" . $ticket['reg_owner_address'] . "</td>";
      echo "<td>" . $ticket['place_of_occurrence'] . "</td>";
      echo "<td>" . $ticket['plate_no'] . "</td>";
      echo "<td>" . $ticket['vehicle_type'] . "</td>";
      // Inside the table loop
      if (!empty($ticket['violations'])) {
          echo "<td>" . $ticket['violations'] . "</td>";
      } else {
          echo "<td>Null</td>";
      }
      echo "<td>" . $ticket['date_time_violation'] . "</td>";
      echo "<td>" . ($ticket['is_settled'] == 0 ? 'No' : 'Yes') . "</td>";
      echo "</tr>";
  }
            ?>
        </tbody>
    </table>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

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
     
    // Add a click event listener to the "Generate PDF" button
document.querySelector('[name="generate_pdf"]').addEventListener('click', function() {
  // Get the filtered data as JSON
  var filteredData = JSON.stringify(filteredData);

  // Set the value of the hidden input field
  document.getElementById('filtered-data').value = filteredData;
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

  // Add a click event listener to the filter button
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
  });

  // Function to filter the table based on the selected date range
  function filterTableByDate(startMonth, endMonth, year) {
    var rows = document.querySelectorAll('#ticket-table-body .clickable-row');
    var dataFound = false; // Flag to track if data is found

    rows.forEach(function(row) {
      var rowData = JSON.parse(row.getAttribute('data-rowdata'));
      var ticketDateStr = rowData['date_time_violation'];
      var ticketDate = new Date(ticketDateStr);

      var ticketMonth = String(ticketDate.getMonth() + 1).padStart(2, '0'); // Add 1 because months are zero-based
      var ticketYear = String(ticketDate.getFullYear());

      if (
        (ticketYear == year) &&
        (ticketMonth >= startMonth) &&
        (ticketMonth <= endMonth)
      ) {
        row.style.display = ''; // Show the row if it matches the filter
        dataFound = true; // Data is found
      } else {
        row.style.display = 'none'; // Hide the row if it doesn't match the filter
      }
    });

    // Toggle visibility of table and "Generate PDF" button based on dataFound
    toggleTableAndPDFVisibility(dataFound);

    // Display alert if no data is found
    if (!dataFound) {
      alert('No Tickets found in the specified date.');
    }
  }

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

    document.getElementById('welcome-text').textContent = 'Welcome, ' + role + ' ' + firstName + ' ' + lastName;
  <?php } ?>
    </script>

</body>
</html>