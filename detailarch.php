<?php
session_start();
include 'php/database_connect.php'; // Include your database connection code here



// Function to fetch is_settled based on ticket_id
function fetchIsSettled($ticketId, $conn) {
    // Perform a database query to fetch is_settled based on ticket_id
    // Replace 'your_query_here' with the actual query to retrieve is_settled
    $query = "SELECT is_settled FROM violation_tickets WHERE ticket_id = $ticketId";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if a row was returned
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['is_settled'];
    } else {
        // Return a default value or handle the error as needed
        return 0; // Default to 'No' if not found
    }
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


// Function to fetch ticket details including violation names based on ticket_id
function fetchTicketDetails($ticketId, $conn) {
    $query = "SELECT vt.ticket_id, vt.is_settled, u.first_name, u.last_name,
                     GROUP_CONCAT(CONCAT(vl.violation_name, ' - ', vl.violation_section, ' - ', vl.violation_fine) SEPARATOR '|||') AS concatenated_violations
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
    // Redirect the user to the login page if they are not logged in
    header("Location: login");
    exit();
}

// Check if the session has the 'rowData'
if (isset($_SESSION['rowData'])) {
    $rowData = json_decode($_SESSION['rowData'], true);
    
    // Fetch ticket details including is_settled, first_name, and last_name
    $ticketDetails = fetchTicketDetails($rowData['ticket_id'], $conn);

    if (!$ticketDetails) {
        // Handle the case where ticket details are not found
        echo "Error: Ticket details not found.";
        exit();
    }
} else {
    header("Location: records");
    exit();
}

unset($_SESSION['rowData']);
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

  .fine-right {
    float: right; /* Align the fines to the right */
}

.total-fines {
    text-align: right; /* Align the total fines text to the right */
}
</style>
<body>

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
                                    
                                    echo '<li class="nav-item"> <a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a> </li>';
                                } else {
                                    // Display the "Create Accounts" link
                                    //    echo '<a href="ctmeurecords.php" class="nav-link">Reports</a>';
                        
                                    echo '<li class="nav-item">
            <a class="nav-link" href="ticket-creation" style="font-weight: 600;">Ticket</a>
          </li>';
                                    echo '<a href="ctmeurecords.php" class="nav-link" style="font-weight: 600;">Reports</a>';

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
            
            <td><label for="driver_license">Driver's Address:</label></td>
            <td><input class="readonly-input" type="text" id="driver_address" name="driver_address" minlength="13" maxlength="13" value="<?php echo $rowData['driver_address']; ?>" readonly required></td>
        </tr>
        <tr>
        <td><label for="driver_license">Driver License No.:</label></td>
            <td><input class="readonly-input" type="text" id="driver_license" name="driver_license" minlength="13" maxlength="13" value="<?php echo $rowData['driver_license']; ?>" readonly required></td>
            
            <td><label for="driver_license">Issuing District:</label></td>
            <td><input class="readonly-input" type="text" id="issuing_district" name="issuing_district" minlength="20" maxlength="20" value="<?php echo $rowData['issuing_district']; ?>" readonly required></td>
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
        <tr>
        <td><label for="driver_license">Registered Owner:</label></td>
            <td><input class="readonly-input" type="text" id="reg_owner" name="reg_owner" minlength="13" maxlength="13" value="<?php echo $rowData['reg_owner']; ?>" readonly required></td>
            
            <td><label for="driver_license">Registered Owner's Address:</label></td>
            <td><input class="readonly-input" type="text" id="reg_owner_address" name="reg_owner_address" minlength="20" maxlength="20" value="<?php echo $rowData['reg_owner_address']; ?>" readonly required></td>
        </tr>
       
        <!-- Add more rows for additional fields as needed -->
        <tr>
        <tr><td><label for="date_violation">Date of Violation:</label></td>
<td><?php echo $rowData['date_violation']; ?></td>
<td><label for="place_of_occurrence">Place of Occurrence:</label></td>
<td><input class="readonly-input" type="text" id="place_of_occurrence" name="place_of_occurrence" minlength="10" maxlength="50" value="<?php echo $rowData['place_of_occurrence']; ?>" readonly required></td>
</tr>


            
<td><label for="time_violation">Time of Violation:</label></td>
<td><?php echo $rowData['time_violation']; ?></td>
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
       // Encode the entire concatenated violation names string
       $totalFines = 0;
$encodedViolationNames = htmlspecialchars($ticketDetails['concatenated_violations']);

// Display the encoded string as bullet points
echo '<ul>';
$violationsList = explode('|||', $ticketDetails['concatenated_violations']);
foreach ($violationsList as $violation) {
    list($violationName, $violationSection, $violationFine) = explode(' - ', $violation);
    $totalFines += floatval($violationFine); // Accumulate the total fines
    echo '<li> Violation: ' . htmlspecialchars($violationName) . ' - Section: ' . htmlspecialchars($violationSection) . '<span class="fine-right">' . htmlspecialchars(number_format($violationFine, 2)) . '</span></li>';
}
echo '</ul>';

// Display the total fines at the bottom
echo '<p class="total-fines">Total Fines: <span class="fine-right">' . htmlspecialchars(number_format($totalFines, 2)) . '</span></p>';

        ?>
</td>

    </tr>
        <!-- Add more rows for additional fields as needed -->
        
        <tr id="edit-row">
            <td></td>
            <td></td>
            <td></td>
            <td>
            <button class="btn btn-primary" type="button" id="edit-button" <?php echo ($rowData['is_settled'] == 1) ? 'style="display:none;"' : ''; ?>>Edit Information</button>
                <button class="btn btn-success"type="submit" id="save-button" style="display: none;background-color:#5CBA13;">Save Changes</button>
            </td>
        </tr>
    </table>
</form>
</div>
</div>
</div>

<script src="js/jquery-3.6.4.js"></script>


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
