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

    // You can now use $rowData to populate your form fields for editing
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Ticket Details</title>
</head>

<style>
  .readonly-input {
    border: none; /* Remove the border */
    outline: none; /* Remove the outline */
}
.hidden-label {
    display: none; /* Hide the label */
  }
</style>
<body>

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
    <a href="ctmeupage.php" class="link noEnforcers">Records</a>
    <a href="ctmeurecords.php" class="link noEnforcers">Reports</a>
    <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a> -->
    <a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" class="link noEnforcers">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>

<div class="container" style="margin-top:20px;">
    <!-- Display the row data here -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ticket Details</h5>
            <form method="POST" action="php/editDetails.php">
                <input type="hidden" name="ticket_id" value="<?php echo $rowData['ticket_id']; ?>">
                
                <table>
        <tr>
            <td><label for="driver_name">Driver Name:</label></td>
            <td><input class="readonly-input" type="text" id="driver_name" name="driver_name" value="<?php echo $rowData['driver_name']; ?>" readonly></td>
            
            <td><label for="driver_address">Driver Address:</label></td>
            <td><input class="readonly-input" type="text" id="driver_address" name="driver_address" value="<?php echo $rowData['driver_address']; ?>" readonly></td>
        </tr>
        <tr>
            <td><label for="driver_license">Driver License No.:</label></td>
            <td><input class="readonly-input" type="text" id="driver_license" name="driver_license" value="<?php echo $rowData['driver_license']; ?>" readonly></td>
            
            <td><label for="issuing_district">Issuing District:</label></td>
            <td><input class="readonly-input" type="text" id="issuing_district" name="issuing_district" value="<?php echo $rowData['issuing_district']; ?>" readonly></td>
        </tr>
        <tr>
            <td><label for="vehicle_type">Vehicle Type:</label></td>
            <td><input class="readonly-input" type="text" id="vehicle_type" name="vehicle_type" value="<?php echo $rowData['vehicle_type']; ?>" readonly></td>
            
            <td><label for="plate_no">Plate No.:</label></td>
            <td><input class="readonly-input" type="text" id="plate_no" name="plate_no" value="<?php echo $rowData['plate_no']; ?>" readonly></td>
        </tr>
        <!-- Add more rows for additional fields as needed -->
        <tr>
            <td><label for="cor_no">COR No.:</label></td>
            <td><input class="readonly-input" type="text" id="cor_no" name="cor_no" value="<?php echo $rowData['cor_no']; ?>" readonly></td>
            
            <td><label for="place_issued">Place Issued:</label></td>
            <td><input class="readonly-input" type="text" id="place_issued" name="place_issued" value="<?php echo $rowData['place_issued']; ?>" readonly></td>
        </tr>
        <!-- Add more rows for additional fields as needed -->
        <tr>
            <td><label for="reg_owner">Registered Owner:</label></td>
            <td><input class="readonly-input" type="text" id="reg_owner" name="reg_owner" value="<?php echo $rowData['reg_owner']; ?>" readonly></td>
            
            <td><label for="reg_owner_address">Registered Owner Address:</label></td>
            <td><input class="readonly-input" type="text" id="reg_owner_address" name="reg_owner_address" value="<?php echo $rowData['reg_owner_address']; ?>" readonly></td>
        </tr>
        <!-- Add more rows for additional fields as needed -->
        <tr>
            <td><label for="date_time_violation">Date and Time of Violation:</label></td>
            <td><input class="readonly-input" type="datetime-local" id="date_time_violation" name="date_time_violation" value="<?php echo $rowData['date_time_violation']; ?>" readonly></td>
            
            <td><label for="place_of_occurrence">Place of Occurrence:</label></td>
            <td><input class="readonly-input" type="text" id="place_of_occurrence" name="place_of_occurrence" value="<?php echo $rowData['place_of_occurrence']; ?>" readonly></td>
        </tr>
        <tr>
            <td><label for="is_settled">Account Status:</label></td>
            <td colspan="3">
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
        </tr>
        <!-- Add more rows for additional fields as needed -->
        <tr id="edit-row">
            <td></td>
            <td></td>
            <td></td>
            <td>
                <button type="button" id="edit-button">Edit Information</button>
                <button type="submit" id="save-button" style="display: none;">Save Changes</button>
            </td>
        </tr>
    </table>
</form>
</div>
</div>
</div>

<script src="js/jquery-3.6.4.js"></script>
<script>
    <?php if (isset($_SESSION['role']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) { ?>
    var role = '<?php echo $_SESSION['role']; ?>';
    var firstName = '<?php echo $_SESSION['first_name']; ?>';
    var lastName = '<?php echo $_SESSION['last_name']; ?>';

    document.getElementById('welcome-text').textContent = 'Welcome, ' + role + ' ' + firstName + ' ' + lastName;
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
</div>
</body>
</html>
