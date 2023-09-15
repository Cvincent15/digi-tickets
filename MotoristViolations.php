<?php
session_start();
include 'php/database_connect.php';

// Check if the user is logged in (you may want to add additional checks)
if (isset($_SESSION['email'])) {
    // Retrieve the session email
    $email = $_SESSION['email'];

    // Prepare a query to fetch user information based on the session email
    $stmt = $conn->prepare("SELECT * FROM users_motorists WHERE driver_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row with the session email exists
    if ($result->num_rows > 0) {
        // Fetch the user's information
        $user = $result->fetch_assoc();
        $driverFirstName = $user['driver_first_name'];
        $driverLicense = $user['driver_license'];

        // Check if there are rows in violation_tickets where driver_license matches and user_id_motorists is null
        $stmt = $conn->prepare("SELECT * FROM violation_tickets WHERE driver_license = ? AND user_id_motorists IS NULL");
        $stmt->bind_param("s", $driverLicense);
        $stmt->execute();
        $result = $stmt->get_result();

        // If there are matching rows, update them to link with the current user
        if ($result->num_rows > 0) {
            $updateStmt = $conn->prepare("UPDATE violation_tickets SET user_id_motorists = ? WHERE driver_license = ? AND user_id_motorists IS NULL");
            $updateStmt->bind_param("ss", $user['user_id'], $driverLicense);
            $updateStmt->execute();
        }

        // Fetch violation ticket data for the logged-in user
        $stmt = $conn->prepare("SELECT * FROM violation_tickets WHERE driver_license = ?");
        $stmt->bind_param("s", $driverLicense);
        $stmt->execute();
        $violationTickets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    } else {
        // User not found in the database
        echo "User not found in the database.";
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect the user to the login page if not logged in
    header("Location: ../motoristlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CTMEU</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/motorist.css"/>
  
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>

/* table */
.table-container {
  margin: 0 auto;
  max-width: 1200px;
  min-width: 800px;
  margin-top: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 10px;
  overflow: hidden; /* Ensures that rounded corners are applied */
}

th {
  background-color: maroon;
  color: white;
}

tr:nth-child(even) {
  background-color: rgb(209, 209, 209);
}

tr:nth-child(odd) {
  background-color: white;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.pagination {
  display: inline-block;
  margin: auto;
  text-align: right;
}

.pagination button {
  background-color: #4CAF50;
  color: white;
  padding: 8px 16px;
  text-decoration: none;
  border: none;
  cursor: pointer;
}

.pagination button:hover {
  background-color: #45a049;
}

.pagination button.disabled {
  background-color: #ddd;
  color: #b8b8b8;
  cursor: not-allowed;
}

.table-info {
  text-align: center;
  margin-bottom: 10px;
  color: white;
}
thead {
  position: sticky;
  top: 0;
  background-color: #f5f5f5;
}

.seek{
  border-radius: 10px;
  background-color: red;
}


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

</head>

<body>

<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFFFFF">
  <div class="container-fluid">
  <a class="navbar-brand" href="motoristlogin.php">
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-middle">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> <span style="font-weight: 600;">Motorist Portal</span>
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
          <li class="nav-item">
            <a class="nav-link" href="https://portal.lto.gov.ph/" style="font-weight: 600;">LTO Official Page</a>
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" href="#">Contact</a> -->
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" href="motoristlogin.php">Dashboard</a> -->
          </li>
        </ul>
        <div class="dropstart">
  <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
  <img src="./images/Icon.png" style="margin-right: 10px;"><?php echo "".$driverFirstName;  ?>
  </a>

  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="MotoristProfile.php">Profile</a></li>
    <li><a class="dropdown-item" href="MotoristID.php">Digital ID</a></li>
    <li><a class="dropdown-item" href="MotoristTransaction.php">Transactions</a></li>
    <li><a class="dropdown-item" href="MotoristDocuments.php">Documents</a></li>
    <li><a class="dropdown-item" href="php/logoutM.php" id="logout-button"><img src="./images/icon _logout_.png"> Log Out</a></li>
  </ul>
</div>
    </div>
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png'); padding-top: 60px; padding-bottom: 60px;" >
<section class="container bg-white w-75 text-dark mx-auto p-2 rounded-5">
<form id="profileForm" action="#!">
  <div class="row d-flex justify-content-center align-items-center"><div class="col-md-auto mb-4"><h1 class="reg"><img src="./images/alternateinvoice.png" style="margin-right: 10px;">Violations</h1></div></div>
  <ul class="nav nav-pills ms-4">
    <!-- Update the "Demerit Points" tab -->
    <li class="nav-item me-4">
        <a class="nav-link active" aria-current="page" href="javascript:void(0);" onclick="toggleTab('demerit')">Demerit Points</a>
    </li>

    <!-- Update the "Unsettled" and "History" links to call JavaScript functions -->
    <li class="nav-item me-4">
        <a class="nav-link" href="javascript:void(0);" onclick="toggleTab('unsettled')">Unsettled</a>
    </li>
    <li class="nav-item me-4">
        <a class="nav-link" href="javascript:void(0);" onclick="toggleTab('history')">History</a>
    </li>
</ul>
<?php
$zeroPointsCount = 0; // Initialize a counter for violations with 0 points

// Loop through the fetched violation ticket data and populate the counters
foreach ($violationTickets as $index => $ticket) {
    if ($ticket['is_settled'] == 0) {
        $zeroPointsCount++; // Increment the count for violations with is_settled = 0
    }
}
?>
<div class="row" id="demerit">
    <div class="col">
    <button type="button" class="btn btn-lg btn-primary ms-4 mt-5"><?php echo $zeroPointsCount; ?> Points</button>
    </div>
</div>
<div class="row" id="unsettled" style="display: none;">
    <div class="col"><br>
    <?php
$visibleTicketCount = 0; // Initialize a counter for visible tickets
$unsettledTicketCount = 0; // Initialize a counter for unsettled tickets

// Loop through the fetched violation ticket data and populate the counters
foreach ($violationTickets as $index => $ticket) {
    if ($ticket['is_settled'] == 1) {
        $visibleTicketCount++; // Increment the visible ticket counter
    } elseif ($ticket['is_settled'] == 0) {
        // Increment the unsettled ticket counter for rows with is_settled = 1
        $unsettledTicketCount++;
        
    }
}

// Check if there are unsettled tickets
if ($unsettledTicketCount > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>No.</th>';
    echo '<th>Name</th>';
    echo '<th>License No.</th>';
    echo '<th>Vehicle</th>';
    echo '<th>Place of Occurrence</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="ticket-table-body">';

    // Loop through the fetched violation ticket data and populate the table rows for unsettled tickets
    foreach ($violationTickets as $index => $ticket) {
        if ($ticket['is_settled'] == 0) {
            // Convert the row data to a JSON string
            $rowData = json_encode($ticket);
            $visibleTicketCount++; // Decrement the visible ticket counter

            echo '<tr>';
            // Display the visible ticket count in the "No." column
            echo '<td>' . $visibleTicketCount . '</td>';
            // Wrap the name in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['driver_name'] . '</td>';
            // Wrap the license in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['driver_license'] . '</td>';
            // Wrap the address in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['vehicle_type'] . '</td>';
            // Wrap the district in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['place_of_occurrence'] . '</td>';
            echo '</tr>';
            
        }
    }

    echo '</tbody>';
    echo '</table>';
} else {
  // Center the image and link vertically and horizontally
  echo '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 300px;">';
  echo '<img src="images/empty.jpg" style="width: 300px; height: 300px;" alt="Empty Table" />';
  echo '<br>';
  echo '<a href="http://www.freepik.com" style="text-align: center;">Designed by stories / Freepik</a>';
  echo '</div>';
}
?>

    </div>
</div>

<div class="row" id="history" style="display: none;">
<div class="col"><br>
<?php
$visibleTicketCount = 0; // Initialize a counter for visible tickets
$unsettledTicketCount = 0; // Initialize a counter for unsettled tickets

// Loop through the fetched violation ticket data and populate the counters
foreach ($violationTickets as $index => $ticket) {
    if ($ticket['is_settled'] == 0) {
        $visibleTicketCount++; // Increment the visible ticket counter
    } elseif ($ticket['is_settled'] == 1) {
        // Increment the unsettled ticket counter for rows with is_settled = 1
        $unsettledTicketCount++;
    }
}

// Check if there are unsettled tickets
if ($unsettledTicketCount > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>No.</th>';
    echo '<th>Name</th>';
    echo '<th>License No.</th>';
    echo '<th>Vehicle</th>';
    echo '<th>Place of Occurrence</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="ticket-table-body">';

    // Loop through the fetched violation ticket data and populate the table rows for unsettled tickets
    foreach ($violationTickets as $index => $ticket) {
        if ($ticket['is_settled'] == 1) {
            // Convert the row data to a JSON string
            $rowData = json_encode($ticket);
            $visibleTicketCount++; // Decrement the visible ticket counter

            echo '<tr>';
            // Display the visible ticket count in the "No." column
            echo '<td>' . $visibleTicketCount . '</td>';
            // Wrap the name in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['driver_name'] . '</td>';
            // Wrap the license in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['driver_license'] . '</td>';
            // Wrap the address in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['vehicle_type'] . '</td>';
            // Wrap the district in a clickable <td>
            echo '<td class="clickable-cell" data-rowdata="' . $rowData . '">' . $ticket['place_of_occurrence'] . '</td>';
            echo '</tr>';
            
        }
    }

    echo '</tbody>';
    echo '</table>';
} else {
  // Center the image and link vertically and horizontally
  echo '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 300px;">';
  echo '<img src="images/empty.jpg" style="width: 300px; height: 300px;" alt="Empty Table" />';
  echo '<br>';
  echo '<a href="http://www.freepik.com" style="text-align: center;">Designed by stories / Freepik</a>';
  echo '</div>';
}
?>


    </div>
</div>

<div class="row">
    <div class="col">
    <button type="button" class="btn btn-lg btn-danger ms-4 mt-5" onclick="redirectToMain()">Close</button>
    </div>
</div>
    </form>
   </section>
</div>
    <script>
      // Function to toggle visibility of table sections
function toggleTab(tabName) {
    // Check if the clicked tab is already active
    const clickedTab = document.querySelector(`[onclick="toggleTab('${tabName}')"]`);
    if (clickedTab.classList.contains('active')) {
        return; // Do nothing if the clicked tab is already active
    }

    // Remove the 'active' class from all links
    document.querySelectorAll('.nav-link').forEach(function(link) {
        link.classList.remove('active');
    });

    // Add the 'active' class to the clicked link
    clickedTab.classList.add('active');

    var tableDiv = document.getElementById(tabName);

    // Hide all table divs except the selected one
    if (tabName === 'unsettled') {
        document.getElementById("demerit").style.display = "none";
        document.getElementById("history").style.display = "none";
    } else if (tabName === 'history') {
        document.getElementById("demerit").style.display = "none";
        document.getElementById("unsettled").style.display = "none";
    } else if (tabName === 'demerit') {
        document.getElementById("history").style.display = "none";
        document.getElementById("unsettled").style.display = "none";
    }

    // Toggle the visibility of the selected table
    if (tableDiv.style.display === "none") {
        tableDiv.style.display = "block";
    } else {
        tableDiv.style.display = "none";
    }
}

    function redirectToRegister() {
      window.location.href = 'motoristSignup.php';
    }

    function redirectToLogin() {
      window.location.href = 'motorist_login.php';
    }

    function redirectToMain() {
      window.location.href = 'MotoristMain.php';
    }
  </script>
</body>
</html>