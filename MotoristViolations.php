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

      // Now, you can access the user's information, e.g., $user['driver_name'], $user['driver_age'], etc.
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.11.14/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

</head>

<body>

<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFFFFF">
  <div class="container-fluid">
  <a class="navbar-brand" href="motoristlogin.php">
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-top">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> Motorist Portal
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
          <li class="nav-item">
            <a class="nav-link" href="https://portal.lto.gov.ph/">LTO Official Page</a>
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" href="#">Contact</a> -->
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" href="motoristlogin.php">Dashboard</a> -->
          </li>
        </ul>
        <div class="dropdown">
  <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
  <img src="./images/Icon.png" style="margin-right: 10px;"><?php echo "".$driverFirstName;  ?>
  </a>

  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="php/logoutM.php" id="logout-button">Logout?</a></li>
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
    <li class="nav-item me-4">
        <!-- Add an onclick attribute to toggle visibility of 'unsettled' div -->
        <a class="nav-link active" aria-current="page" href="javascript:void(0);" onclick="toggleUnsettled()">Demerit Points</a>
    </li>
    <li class="nav-item me-4">
        <!-- Add an onclick attribute to hide 'unsettled' and show 'demerit' div -->
        <a class="nav-link" href="javascript:void(0);" onclick="showDemerit()">Unsettled</a>
    </li>
    <li class="nav-item me-4">
        <a class="nav-link" href="#unsettled">History</a>
    </li>
</ul>
<div class="row" id="demerit">
    <div class="col">
    <button type="button" class="btn btn-lg btn-primary ms-4 mt-5">0 Points</button>
    </div>
</div>
<div class="row" id="unsettled" style="display: none;">
    <div class="col">
    <table>
            <thead>
                <tr>
                    <th>No.</th>
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
      // Function to toggle visibility of 'unsettled' div
    function toggleUnsettled() {
        var unsettledDiv = document.getElementById("unsettled");
        if (unsettledDiv.style.display === "none") {
            unsettledDiv.style.display = "block";
        } else {
            unsettledDiv.style.display = "none";
        }
    }

    // Function to hide 'unsettled' and show 'demerit' div
    function showDemerit() {
        var unsettledDiv = document.getElementById("unsettled");
        var demeritDiv = document.getElementById("demerit");

        // Hide 'unsettled' div
        unsettledDiv.style.display = "none";

        // Show 'demerit' div
        demeritDiv.style.display = "block";
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
  <script>
    $(document).ready(function() {
      $('#datepicker').datepicker();
    });
  </script>
  <script src="./js/stepper.js"></script>
</body>
</html>