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

// Function to fetch ticket details including violation names based on ticket_id
function fetchTicketDetails($ticketId, $conn) {
    $query = "SELECT vt.ticket_id, vt.is_settled, u.first_name, u.last_name, GROUP_CONCAT(v.violation_name SEPARATOR ', ') AS violation_names
              FROM violation_tickets vt
              INNER JOIN users u ON vt.user_ctmeu_id = u.user_ctmeu_id
              LEFT JOIN violations v ON vt.ticket_id = v.ticket_id_violations
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
    header("Location: index.php");
    exit();
}

// Check if the data parameter is set in the URL
if (isset($_GET['data'])) {
    // Decode the JSON data passed in the URL
    $rowData = json_decode(urldecode($_GET['data']), true);

    // Fetch ticket details including is_settled, first_name, and last_name
    $ticketDetails = fetchTicketDetails($rowData['ticket_id'], $conn);

    if (!$ticketDetails) {
        // Handle the case where ticket details are not found
        echo "Error: Ticket details not found.";
        exit();
    }
} else {
    // If no data parameter is set, handle it accordingly (e.g., show an error message)
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
  <a class="navbar-brand" href="motoristlogin.php">
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
                // Display the "Create Accounts" link
            //    echo '<a href="ctmeurecords.php" class="link">Reports</a>';
            }
            // Uncomment this line to show "Activity Logs" to other roles
            // echo '<a href="ctmeuactlogs.php" class="link">Activity Logs</a>';
            echo '<li><a class="dropdown-item " href="ctmeuusers.php">User Account</a></li>';
            // Uncomment this line to show "Create Accounts" to other roles
            echo '<li><a class="dropdown-item" href="ctmeucreate.php">Create Account</a></li>';
            
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
            
            <td><label for="driver_license">Driver License No.:</label></td>
            <td><input class="readonly-input" type="text" id="driver_license" name="driver_license" minlength="13" maxlength="13" value="<?php echo $rowData['driver_license']; ?>" readonly required></td>
        </tr>
        <tr>
            <td><label for="vehicle_type">Vehicle Type:</label></td>
            <td><input class="readonly-input" type="text" id="vehicle_type" name="vehicle_type" minlength="3" maxlength="20" value="<?php echo $rowData['vehicle_type']; ?>" readonly required></td>
            
            <td><label for="plate_no">Plate No.:</label></td>
            <td><input class="readonly-input" type="text" id="plate_no" name="plate_no" minlength="6" maxlength="7" value="<?php echo $rowData['plate_no']; ?>" readonly required></td>
        </tr>
       
        <!-- Add more rows for additional fields as needed -->
        <tr>
        <td><label for="date_time_violation">Date and Time of Violation:</label></td>
<td><input class="readonly-input" type="datetime-local" id="date_time_violation" value="<?php echo $rowData['date_time_violation']; ?>" name="date_time_violation" onclick="clearInput()" readonly required></td>


            
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
                $accountStatus = ($isSettled == 1) ? 'Yes' : 'No';

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
        $encodedViolationNames = htmlspecialchars($ticketDetails['violation_names']);

        // Display the encoded string as a single list item
        echo '<p>' . $encodedViolationNames . '</p>';
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
