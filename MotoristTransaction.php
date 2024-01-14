<?php
//MotoristTransaction.php
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

// Function to fetch vehicle_name based on vehicle_type
function fetchVehicleName($vehicleType, $conn) {
  // Perform a database query to fetch vehicle_name based on vehicle_type
  $query = "SELECT vehicle_name FROM vehicletype WHERE vehicle_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $vehicleType);
  $stmt->execute();
  $stmt->bind_result($vehicleName);
  
  // Check if the query was successful and if a row was returned
  if ($stmt->fetch()) {
      return $vehicleName;
  } else {
      // Return a default value or handle the error as needed
      return "Vehicle not found"; // Replace with your desired default value or error message
  }
}

// Fetch violation ticket data for the logged-in user
$stmt = $conn->prepare("SELECT * FROM violation_tickets WHERE driver_license = ?");
$stmt->bind_param("s", $driverLicense);
$stmt->execute();
$violationTickets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<link rel="stylesheet" href="css/styleguide.css" />
    <link rel="stylesheet" href="css/styleticket.css" />


<style>
.fine-steps {
    margin: 0;
    padding: 0;
    list-style-type: none;
  }

  .fine-steps > li {
    margin-bottom: 10px; /* Adjust this value to control the spacing between list items */
  }

  .fine-steps > li > ul > li {
    margin-bottom: 5px; /* Adjust this value to control the spacing between sub-list items */
  }
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
           <!-- <a class="nav-link" href="#">Contact</a> -->
          </li>
          <li class="nav-item">
          <!--  <a class="nav-link" href="#">Dashboard</a> -->
          </li>
        </ul>
        <div class="dropstart">
  <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
  <img src="./images/Icon.png" style="margin-right: 10px;"><?php echo "".$driverFirstName;  ?>
  </a>

  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="MotoristProfile.php">Profile</a></li>
    <li><a class="dropdown-item" href="MotoristID.php">Digital ID</a></li>
    <li><a class="dropdown-item" href="MotoristViolations.php">Violations</a></li>
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
  <div class="row d-flex justify-content-center align-items-center"><div class="col-md-auto mb-4"><h1 class="reg"><img src="./images/alternateinvoice.png" style="margin-right: 10px;">Transaction Overview</h1></div></div>
  <ul class="nav nav-pills ms-4">

    <!-- Update the "Unsettled" and "History" links to call JavaScript functions -->
    <li class="nav-item me-4">
        <a class="nav-link active" href="javascript:void(0);" onclick="toggleTab('unsettled')">Open</a>
    </li>
    <li class="nav-item me-4">
        <a class="nav-link" href="javascript:void(0);" onclick="toggleTab('history')">Closed</a>
    </li>
</ul>

<div class="row" id="unsettled">
    <div class="col"><br>
    <?php
$visibleTicketCount = 0; // Initialize a counter for visible tickets
$unsettledTicketCount = 0; // Initialize a counter for unsettled tickets

// Loop through the fetched violation ticket data and populate the counters
foreach ($violationTickets as $index => $ticket) {
    if ($ticket['is_settled'] == 1) {
        $visibleTicketCount++; // Increment the visible ticket counter
    } elseif ($ticket['is_settled'] == 0) {
        // Increment the unsettled ticket counter for rows with is_settled = 0
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
    echo '<th>Action</th>'; // Add a new column for the action button
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="ticket-table-body">';

    // Loop through the fetched violation ticket data and populate the table rows for unsettled tickets
foreach ($violationTickets as $index => $ticket) {
  if ($ticket['is_settled'] == 0) {
      $rowData = json_encode($ticket);
      $visibleTicketCount++;

      echo '<tr>';
      echo '<td>' . $visibleTicketCount . '</td>';
      echo '<td class="clickable-cell" data-ticket-details=\'' . htmlspecialchars($rowData, ENT_QUOTES, 'UTF-8') . '\'>' . $ticket['driver_name'] . '</td>';
      echo '<td class="clickable-cell" data-ticket-details=\'' . htmlspecialchars($rowData, ENT_QUOTES, 'UTF-8') . '\'>' . $ticket['driver_license'] . '</td>';
      
      // Call the fetchVehicleName function to get the vehicle name
      $vehicleName = fetchVehicleName($ticket['vehicle_type'], $conn);
      
      echo '<td class="clickable-cell" data-ticket-details=\'' . htmlspecialchars($rowData, ENT_QUOTES, 'UTF-8') . '\'>' . $vehicleName . '</td>';
      echo '<td class="clickable-cell" data-ticket-details=\'' . htmlspecialchars($rowData, ENT_QUOTES, 'UTF-8') . '\'>' . $ticket['place_of_occurrence'] . '</td>';
      echo '<td><button class="settle-button" data-ticket-index="' . $index . '" style="background-color:green; color:white; border-radius:10px;">Settle</button></td>';
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
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <img class="modal-title mx-auto" id="exampleModalLabel" src="images/ctmeu.jpg" style="width: 60px; height: 60px;">
      </div>
      <div class="modal-body" id="ticket-receipt">
        <!-- Receipt content goes here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="downloadReceiptBtn">Download Receipt</button>
      </div>
    </div>
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
      const receiptSection = document.getElementById('ticket-receipt');
document.addEventListener('DOMContentLoaded', function () {
    const clickableCells = document.querySelectorAll('.clickable-cell');
    const receiptSection = document.getElementById('ticket-receipt');

    clickableCells.forEach(function (cell) {
        cell.addEventListener('click', function () {
            const ticketDetails = JSON.parse(this.getAttribute('data-ticket-details'));
            // You can use this data to display the receipt or perform other actions
            receiptSection.innerHTML = generateReceiptHtml(ticketDetails);
        });
    });

    const settleButtons = document.querySelectorAll('.settle-button');
  settleButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      const ticketIndex = this.getAttribute('data-ticket-index');
      const ticketDetails = JSON.parse(clickableCells[ticketIndex].getAttribute('data-ticket-details'));

      // Fetch the receipt content and update the 'ticket-receipt' div
      fetch('php/generate_receipt.php', {
        method: 'POST',
        body: JSON.stringify({ ticketDetails: ticketDetails }),
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const receiptSection = document.getElementById('ticket-receipt');
          receiptSection.innerHTML = data.receipt;

          // Open the Bootstrap modal
          const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
          receiptModal.show();

          // Event listener for the Download Receipt button
          const downloadReceiptBtn = document.getElementById('downloadReceiptBtn');
          downloadReceiptBtn.addEventListener('click', function () {
            downloadReceipt();
            receiptModal.hide(); // Hide the modal after download
          });
        } else {
          console.error('Receipt generation failed');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  });

    function generateReceiptHtml(ticketDetails) {
        // Customize this function based on your receipt format
        return `
            <h2>Ticket Details</h2>
            <p><strong>Name:</strong> ${ticketDetails.driver_name}</p>
            <p><strong>License No.:</strong> ${ticketDetails.driver_license}</p>
            <p><strong>Vehicle:</strong> ${ticketDetails.vehicle_name}</p>
            <p><strong>Place of Occurrence:</strong> ${ticketDetails.place_of_occurrence}</p>
            <p><strong>Date:</strong> ${new Date().toLocaleString()}</p>
        `;
    }

    function downloadReceipt() {
    // Use html2canvas to capture the 'ticket-receipt' div as an image
    html2canvas(receiptSection).then(function (canvas) {
      // Convert the canvas to a data URL
      const imageDataUrl = canvas.toDataURL('image/png');

      // Create a link element and trigger a download
      const downloadLink = document.createElement('a');
      downloadLink.href = imageDataUrl;
      downloadLink.download = 'receipt.png';
      downloadLink.click();
    });
  }
});



      /*
// Add event listeners to the Settle buttons
const settleButtons = document.querySelectorAll('.settle-button');
settleButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        // Get the ticket index from the data attribute
        const ticketIndex = this.getAttribute('data-ticket-index');
        
        // Send an AJAX request to update the is_settled value of the ticket
        // You will need to implement the server-side code to handle this request
        // Here's a placeholder for the AJAX request:
        // Replace 'update_ticket.php' with the actual URL to update the ticket
        fetch('php/archiverow.php', {
            method: 'POST', // You can use POST or other HTTP methods based on your server-side implementation
            body: JSON.stringify({ ticketIndex: ticketIndex }), // Send the ticket index as JSON data
            headers: {
                'Content-Type': 'application/json' // Specify the content type as JSON
            }
        })
        .then(response => response.json()) // Parse the response as JSON
        .then(data => {
            if (data.success) {
                // Ticket updated successfully, you can perform any desired action here
                // For example, you can remove the row from the table or update the UI
                // based on the updated ticket status.
            } else {
                // Handle the case where the ticket update failed
            }
        })
        .catch(error => {
            // Handle errors from the fetch request
            console.error('Error:', error);
        });
    });
});
*/
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
        document.getElementById("history").style.display = "none";
    } else if (tabName === 'history') {
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