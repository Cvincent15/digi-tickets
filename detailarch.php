<?php
session_start();
include 'php/database_connect.php'; // Include your database connection code here

// Function to fetch is_settled based on ticket_id
function fetchIsSettled($ticketId, $conn) {
    // Perform a database query to fetch is_settled based on ticket_id
    $query = "SELECT is_settled FROM violation_tickets WHERE ticket_id = $ticketId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['is_settled'];
    } else {
        return 0;
    }
}

// Function to fetch vehicle_name based on vehicle_id
function fetchVehicleName($vehicleId, $conn) {
    $query = "SELECT vehicle_name FROM vehicletype WHERE vehicle_id = $vehicleId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['vehicle_name'];
    } else {
        return "Vehicle not found";
    }
}

// Function to fetch ticket details including violation names based on ticket_id
function fetchTicketDetails($ticketId, $conn) {
    $query = "SELECT vt.ticket_id, vt.is_settled, u.first_name, u.last_name, GROUP_CONCAT(vl.violation_name SEPARATOR ', ') AS violation_names
              FROM violation_tickets vt
              INNER JOIN users u ON vt.user_ctmeu_id = u.user_ctmeu_id
              LEFT JOIN violations v ON vt.ticket_id = v.ticket_id_violations
              LEFT JOIN violationlists vl ON v.violationlist_id = vl.violation_list_ids
              WHERE vt.ticket_id = $ticketId
              GROUP BY vt.ticket_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return null;
    }
}

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Check if the data parameter is set in the URL
if (isset($_GET['data'])) {
    $rowData = json_decode(urldecode($_GET['data']), true);
    $ticketDetails = fetchTicketDetails($rowData['ticket_id'], $conn);

    if (!$ticketDetails) {
        echo "Error: Ticket details not found.";
        exit();
    }
} else {
    echo "Error: Row data not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Ticket Details</title>
</head>

<style>
  .readonly-input {
    border: none; /* Remove the border */
    outline: none; /* Remove the outline */
    background-color: transparent; /* Make the background color transparent */
}

.hidden-label {
    display: none; /* Hide the label */
  }
</style>
<body>

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
                echo '<li class="nav-item">
            <a class="nav-link" href="ctmeuticket.php" style="font-weight: 600;">Ticket</a>
          </li>';
          //Reports page temporary but only super admin has permission
                echo '<a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a>';
            } else {
                // Display the "Create Accounts" link
            //    echo '<a href="ctmeurecords.php" class="nav-link">Reports</a>';


            echo '<a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a>';

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
                echo '<li><a class="dropdown-item" href="ctmeucreate.php">Create Account</a></li>';
            echo '<li><a class="dropdown-item" href="ctmeusettings.php">Ticket Form</a></li>';
            }
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<li><a class="dropdown-item" href="ctmeuusers.php">User Account</a></li>';
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
<div class="container" style="margin-top:20px;">
    <!-- Display the row data here -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ticket Details</h5>
            <form id="details" method="POST" action="php/editDetails.php">
                <input type="hidden" name="ticket_id" value="<?php echo $rowData['ticket_id']; ?>">
                
                <table>
        <tr>
            <td><label for="driver_name">Driver Name:</label></td>
            <td><input class="readonly-input" type="text" id="driver_name" name="driver_name" minlength="10" maxlength="30" value="<?php echo $rowData['driver_name']; ?>" readonly required></td>
            
            <td><label for="driver_license">Driver's License No.:</label></td>
            <td><input class="readonly-input" type="text" id="driver_license" name="driver_license" minlength="13" maxlength="13" value="<?php echo $rowData['driver_license']; ?>" readonly required></td>
        </tr>
        <tr>
           
            <td><label for="vehicle_type">Vehicle Type:</label></td>
            <td> <?php 
            $vehicleId = $rowData['vehicle_type'];
            $vehicleName = fetchVehicleName($vehicleId, $conn);

            echo "". $vehicleName;

            ?></td>
            
            <td><label for="plate_no">Plate No.:</label></td>
            <td><input class="readonly-input" type="text" id="plate_no" name="plate_no" minlength="6" maxlength="7" value="<?php echo $rowData['plate_no']; ?>" readonly required></td>
        </tr>
       
        <!-- Add more rows for additional fields as needed -->
        <tr>
        <td><label for="date_time_violation">Date and Time of Violation:</label></td>
<td><input class="readonly-input" type="text" id="datepicker" value="<?php echo $rowData['date_time_violation']; ?>" name="date_time_violation" onclick="clearInput()" readonly required></td>

            <td><label for="place_of_occurrence">Place of Occurrence:</label></td>
            <td><input class="readonly-input" type="text" id="place_of_occurrence" name="place_of_occurrence" minlength="10" maxlength="50" value="<?php echo $rowData['place_of_occurrence']; ?>" readonly required></td>
        </tr>
        <tr>
            <td><label for="is_settled">Account Status:</label></td>
            <td>
                <?php
                // Check if is_settled key exists in rowData
                $isSettled = isset($rowData['is_settled']) ? $rowData['is_settled'] : null;

                // If is_settled is not in $rowData, fetch it based on ticket_id
                if ($isSettled === null) {
                    $ticketId = $rowData['ticket_id'];
                    $isSettled = fetchIsSettled($ticketId, $conn);
                }

                // Convert is_settled to "Yes" or "No"
                $accountStatus = ($isSettled == 1) ? 'Settled' : 'Unsettled';

                // Display is_settled as text
                echo '<span id="is_settled">' . $accountStatus . '</span>';
                ?>
            </td>
            <td><label for="enforcer_name">Issued by:</label></td>
            <td>
            <?php
            $enforcerName = $ticketDetails['first_name'] . ' ' . $ticketDetails['last_name'];
            echo '<p>' . $enforcerName . '</p>';
            ?>
    </td>
        </tr>
        <tr>
        <td><label for="violation_names">Violations:</label></td>
        <td colspan="3">
        <?php
    // Check if violation_names key exists in $ticketDetails
    if (isset($ticketDetails['violation_names'])) {
        // Split the violations string using both commas and pipes as separators
        $violationsArray = preg_split('/[,|]/', $ticketDetails['violation_names'], -1, PREG_SPLIT_NO_EMPTY);

        // Trim each violation to remove leading/trailing whitespaces
        $violationsArray = array_map('trim', $violationsArray);

        // Join the violations using a comma as a separator
        $formattedViolations = implode(', ', $violationsArray);

        // Display the formatted violations
        echo '<p>' . $formattedViolations . '</p>';
    }
?>
</td>

    </tr>
        <!-- Add more rows for additional fields as needed -->
        <tr id="edit-row">
            <td></td>
            <td></td>
            <td></td>
            <td>
                <button class="btn btn-primary" type="button" id="edit-button">Edit Information</button>
                <button class="btn btn-success"type="submit" id="save-button" style="display: none;background-color:#5CBA13;">Save Changes</button>
            </td>
        </tr>
    </table>
</form>
</div>
</div>
</div>

<script src="js/jquery-3.6.4.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Get the current date
    const currentDate = new Date();

    // Format the current date as 'YYYY-MM-DD'
    const currentYear = currentDate.getFullYear();
    const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
    const currentDay = String(currentDate.getDate()).padStart(2, '0');
    const formattedCurrentDate = `${currentYear}-${currentMonth}-${currentDay}`;

    // Initialize flatpickr date and time picker
    flatpickr('#datepicker', {
        enableTime: true, // Enable time picker
        dateFormat: 'Y-m-d H:i', // Set the desired date and time format
        maxDate: '2050-12-31', // Set the maximum selectable date
        minDate: formattedCurrentDate, // Set the minimum selectable date to today
        altInput: true, // Use an alternate input field for better accessibility
        altFormat: 'F j, Y H:i', // Set the format for the alternate input field
        time_24hr: true, // Use 24-hour time format
    });
</script>

<script>
     function clearInput() {
    document.getElementById("date_time_violation").value = "";
  }
  // Get the input element by ID
  const dateTimeInput = document.getElementById("date_time_violation");

  // Set the maximum and minimum date values
  dateTimeInput.max = "2050-12-31T23:59";
  dateTimeInput.min = "1970-01-01T00:00";

  // Add an event listener to check the value when it changes
  dateTimeInput.addEventListener("change", function() {
    const selectedDateTime = new Date(this.value).getTime();
    const minDateTime = new Date(this.min).getTime();
    const maxDateTime = new Date(this.max).getTime();

    if (selectedDateTime < minDateTime || selectedDateTime > maxDateTime) {
      alert("Please enter a valid date and time within the specified range.");
      this.value = ""; // Clear the input value
    }
  });
</script>

<script>
    
  // Add a click event listener to the logout button
document.getElementById('logout-button').addEventListener('click', function() {
        // Perform logout actions here, e.g., clearing session, redirecting to logout.php
        // You can use JavaScript to redirect to the logout.php page.
        window.location.href = 'php/logout.php';
    });

    // Apply symbol restriction to all text input fields
    const form = document.getElementById('details');
        const inputs = form.querySelectorAll('input[type="text"]');

        inputs.forEach(input => {
            input.addEventListener('input', function (e) {
                const inputValue = e.target.value;
                const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 \-]/g, ''); // Allow letters, numbers, spaces, and hyphens
                e.target.value = sanitizedValue;
            });
        });

    <?php if (isset($_SESSION['role']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) { ?>
    var role = '<?php echo $_SESSION['role']; ?>';
    var firstName = '<?php echo $_SESSION['first_name']; ?>';
    var lastName = '<?php echo $_SESSION['last_name']; ?>';

    document.getElementById('welcome-text').textContent = firstName + ' ' + lastName;
    <?php } ?>

    // Add a click event listener to the "Edit Information" button
    document.getElementById('edit-button').addEventListener('click', function() {
        // Check if is_settled key exists in rowData
        var isSettled = <?php echo isset($rowData['is_settled']) ? $rowData['is_settled'] : 0; ?>;

        // Check if is_settled is 1 (settled)
        if (isSettled === 1) {
            // If settled, hide the "Edit Information" button and return
            document.getElementById('edit-button').style.display = 'none';
            return;
        }

        // Get all the input elements in the form
        var inputs = document.querySelectorAll('input');

        // Loop through the inputs and toggle the readonly-input class
        inputs.forEach(function(input) {
            input.classList.toggle('readonly-input');
            input.readOnly = !input.readOnly; // Toggle the readonly property
        });

        // Toggle the button text between "Edit Information" and "Save Changes"
        var editButton = document.getElementById('edit-button');
        var saveButton = document.getElementById('save-button');
        if (editButton.style.display === 'none') {
            editButton.style.display = 'block';
            saveButton.style.display = 'none';
            editButton.textContent = 'Edit Information';
        } else {
            editButton.style.display = 'none';
            saveButton.style.display = 'block';
            editButton.textContent = 'Cancel';
        }
    });
    // Check the is_settled value and hide the "Edit Information" button if needed
    var isSettledValue = '<?php echo $accountStatus; ?>';
    if (isSettledValue === 'Yes') {
        document.getElementById('edit-row').style.display = 'none';
    }
</script>
<!-- Add any other scripts you may need -->
<script src="./js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
