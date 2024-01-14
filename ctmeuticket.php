<?php
session_start();
include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are already logged in
    header("Location: login");
    exit();
}

// Fetch user data based on the logged-in user's username
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle the database query error
    die("Database query failed: " . mysqli_error($conn));
}

// Fetch the user's data
$user = mysqli_fetch_assoc($result);
$firstName = $user['first_name'];
$lastName = $user['last_name'];
$status = $user['role'];
$user_ctmeu_id = $user['user_ctmeu_id'];
$currentTicket = $user['currentTicket'];
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <script src="./js/bootstrap.bundle.min.js"></script>
    <title>CTMEU Data Hub</title>
</head>
<style>
    /* Add custom CSS for styling the dropdown with checkboxes */
    .dropdown {
        position: relative;
        width: 300px;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        max-height: 200px;
        overflow-y: auto;
    }

    .dropdown-content a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: black;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown-content label {
        display: block;
        padding: 10px;
    }

    .dropdown-content label input[type="checkbox"] {
        margin-right: 5px;
    }

    .card {
        margin: 100px auto;
        width: 700px;
        /* Adjust the width as needed */
        height: auto;
        /* Adjust the height as needed */
        text-align: left;
    }

    button.Change {
        font-size: 18px;
        /* Adjust the font size as needed */
        padding: 12px 30px;
        /* Adjust the padding as needed */
    }

    #submitBtn:disabled {
   cursor: not-allowed;
}

#submitBtn:disabled:hover::after {
   content: "Contact your IT Administrator to generate your Control Number to create a ticket.";
   position: absolute;
   top: 100%;
   left: 50%;
   transform: translate(-50%, 0);
   background-color: #fff;
   border: 1px solid #ccc;
   padding: 10px;
   z-index: 1;
}
</style>

<body style="height: auto; background: linear-gradient(to bottom, #1F4EDA, #102077);">
<?php if (isset($_GET['error']) && $_GET['error'] == 'maxTicketReached'): ?>
<script>
    $(document).ready(function() {
        // Show Bootstrap modal with the error message
        $('#maxTicketReachedModal').modal('show');
    });
</script>
<div class="modal fade" id="maxTicketReachedModal" tabindex="-1" aria-labelledby="maxTicketReachedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="maxTicketReachedModalLabel">Ticket Submission Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Error creating ticket: Max ticket reached. Please contact an IT Admin to renew your account.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
    <?php

    // Check if the user is already logged in
    if (!isset($_SESSION['username'])) {
        // Redirect the user to the greeting page if they are already logged in
        header("Location: login");
        exit();
    }

    // Fetch user data based on the logged-in user's username
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle the database query error
        die("Database query failed: " . mysqli_error($conn));
    }

    // Fetch the user's data
    $user = mysqli_fetch_assoc($result);
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];
    $status = $user['role'];


    ?>
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

    <div class="container card p-5 w-75">
        <h3>Input Ticket Info</h3>

        <form class="form-floating mb-3" method="post" action="./php/submit_ticket.php" id="ticketmaker">
            <!-- Add a hidden input field for user_ctmeu_id -->
            <input type="hidden" name="user_ctmeu_id" value="<?php echo $user_ctmeu_id; ?>">
            <div class="row">
            <div class="col">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="dateInput" placeholder="Date" name="date_violation">
            <label for="dateInput">Date</label>
        </div>
    </div>
    <div class="col">
        <div class="form-floating">
            <input type="text" class="form-control" id="timeInput" placeholder="Time" name="time_violation">
            <label for="timeInput">Time</label>
        </div>
    </div>
                
            </div>
            <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInputValue1"
                        maxlength="30" placeholder="Driver's Name" name="currentTicket" value="<?php echo $currentTicket; ?>" required readonly>
                    <label for="floatingInputValue1">Control Number</label>
                </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" minlength="10" maxlength="30"
                            placeholder="Email" name="email">
                        <label for="floatingInputValue1">Email</label>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" required minlength="10"
                            maxlength="30" placeholder="Driver's Name" name="driver_name" required>
                        <label for="floatingInputValue1">Driver's Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue3" minlength="10" maxlength="30"
                            placeholder="Driver's Adress" name="driver_address" required>
                        <label for="floatingInputValue3">Driver's Address</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue3" oninput="formatLicenseNo(this)" minlength="13" maxlength="13"
                            placeholder="License Number" name="driver_license" required>
                        <label for="floatingInputValue3">License Number</label>
                        <script>
                  function formatLicenseNo(input) {
                          // Remove any non-alphanumeric characters
                          const inputValue = input.value.replace(/[^A-Za-z0-9]/g, '');

                          // Capitalize the input value
                          const capitalizedValue = inputValue.toUpperCase();

                          // Add dashes at the 4th and 7th positions
                          const formattedValue = capitalizedValue.replace(/(.{3})(.{2})?(.{1,6})?/, function(match, p1, p2, p3) {
                              let result = p1;
                              if (p2) result += '-' + p2;
                              if (p3) result += '-' + p3;
                              return result;
                          });

                          // Update the input value
                          input.value = formattedValue;
                      }
            </script>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" required minlength="10"
                            maxlength="30" placeholder="Issuing District" name="issuing_district" reg_owner>
                        <label for="floatingInputValue1">Issuing District</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <select class="form-control" id="vehicleType" name="vehicle_type" required>
                            <option value="" disabled selected>Select Vehicle Type</option>
                            <?php
                            // Assuming you have a database connection file
                            include 'database_connect.php';

                            // Retrieve vehicle types from the database
                            $sql = "SELECT * FROM vehicletype";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["vehicle_id"] . "'>" . $row["vehicle_name"] . "</option>";
                                }
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                        </select>
                        <label for="vehicleType">Vehicle Type</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" required minlength="10"
                            maxlength="30" placeholder="Plate Number" name="plate_no" required>
                        <label for="floatingInputValue1">Plate Number</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" required minlength="10"
                            maxlength="30" placeholder="Registered Owner" name="reg_owner" required>
                        <label for="floatingInputValue1">Registered Owner</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue3" minlength="10" maxlength="30"
                            placeholder="Registered Owner's Address" name="reg_owner_address" required>
                        <label for="floatingInputValue3">Registered Owner's Address</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" required minlength="10"
                            maxlength="30" placeholder="Place of Occurrence" name="place_of_occurrence">
                        <label for="floatingInputValue1">Place of Violation</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputValue1" required
                            maxlength="30" placeholder="Remarks" name="remarks">
                        <label for="floatingInputValue1">Remarks</label>
                    </div>
                </div>
            
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" onclick="removeSelected()" style="margin-top:20px;">Remove
                        All</button>
                    <table id="selectedOptionsTable" style="margin-top:20px; margin-bottom:20px;">
                        <thead>
                            <tr>
                                <th>Violation Name - Section</th>
                                <th>Action</th>
                                <!-- Hidden column for violations[] -->
                                <th style="display: none;">Violations</th>
                            </tr>
                        </thead>
                        <tbody id="selectedOptions">
                            <!-- Selected options will be displayed here -->
                        </tbody>
                    </table>
                    <script>
                        // Event listener for the search input
                        $('#searchInput').on('input', function () {
                            const searchTerm = $(this).val();
                            populateDropdownFromServer(searchTerm); // Pass the search term to the server
                        });

                        // Function to populate the dropdown with data from the server
                        function populateDropdownFromServer(searchTerm) {
                            $.ajax({
                                url: 'php/getViolations.php', // Change this to your server-side script
                                type: 'GET',
                                data: { section: searchTerm }, // Pass the search term as a query parameter
                                dataType: 'json',
                                success: function (data) {
                                    const dropdownContent = $('.dropdown-content');
                                    dropdownContent.empty();

                                    data.forEach((violation) => {
                                        dropdownContent.append(
                                            `<a href="#" data-id="${violation.violation_list_ids}" onclick="selectOption(${violation.violation_list_ids}, '${violation.violation_name}', '${violation.violation_section}')">${violation.violation_name} - ${violation.violation_section}</a>`
                                        );
                                    });
                                },
                                error: function (error) {
                                    console.error('Error fetching data from the server:', error);
                                }
                            });
                        }

                        function selectOption(violationListId, violationName, violationSection) {
                            const selectedOptionsTable = $('#selectedOptionsTable');
                            const selectedOptionsBody = $('#selectedOptions');
                            const selectedViolationsInput = $('#selectedViolationsInput');
                            
                            // Check if the option is already selected
                            const isOptionSelected = $(`#selectedOptionsTable tbody tr[data-id="${violationListId}"]`).length > 0;

                            if (!isOptionSelected) {
                            // Remove any existing hidden input fields for the same violation
                            $(`#selectedOptionsTable tbody tr[data-id="${violationListId}"] td input[name="violations[]"]`).detach();

                            // Add a new row to the table
                            selectedOptionsBody.append(`<tr data-id="${violationListId}">
                                <td>${violationName} - ${violationSection}</td>
                                <td><button onclick="removeOption(${violationListId})">Remove</button></td>
                                <!-- Hidden input field for violations[] -->
                                <td style="display: none;"><input type="hidden" name="violations[]" value="${violationListId}"></td>
                            </tr>`);
                           
                            // Show the table row
                            $(`#selectedOptionsTable tbody tr[data-id="${violationListId}"]`).show();

                            } else {
                            // Provide a visual indication or alert that the option is already selected
                            alert(`Violation "${violationName} - ${violationSection}" is already selected.`);
                            }

                        }



                        // Function to remove a selected option
                        function removeOption(violationListId) {
                            $(`#selectedOptionsTable tbody tr[data-id="${violationListId}"]`).remove();
                        }

                        // Function to remove all selected options
                        function removeSelected() {
                            $('#selectedOptions').empty();
                        }

                        // Document ready function
                        $(document).ready(function () {
                            populateDropdownFromServer();

                            // Event listener for the search input
                            $('#searchInput').on('input', function () {
                                const searchTerm = $(this).val().toLowerCase();
                                const dropdownItems = $('.dropdown-content a');

                                dropdownItems.each(function () {
                                    const itemText = $(this).text().toLowerCase();
                                    $(this).toggle(itemText.includes(searchTerm));
                                });
                            });

                            // Toggle the dropdown visibility on click
                            $('.dropdown').on('click', function (e) {
                                e
                                    .stopPropagation(); // Prevent the document click event from closing the dropdown
                                $('.dropdown-content').show();
                            });

                            // Close the dropdown when clicking outside of it
                            $(document).on('click', function (e) {
                                if (!$(e.target).closest('.dropdown').length) {
                                    $('.dropdown-content').hide();
                                }
                            });
                        });
                    </script>
                </div>
                <div class="col">
                    <div class="input-group input-group-lg mb-3">
                        <label class="input-group-text form-control" for="inputGroupSelect01" name="violationlabel"
                            style="font-size: 1rem; width: 30px;">Violation/s</label>
                        <div class="dropdown" id="inputGroupSelect01">
                            
                            <input type="text" id="searchInput" onclick="toggleDropdown()"
                                class="dropbtn input-group-text" style="width:300px;padding: 1rem .75rem;
    padding-top: 1rem; padding-right: 0.75rem; padding-bottom: 1rem; padding-left: 0.75rem;"
                                placeholder="Search violations...">
                            <div class="dropdown-content">
                                <!-- Options will be dynamically loaded here -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3" id="submitBtn">Submit</button>
<span id="controlNumberMessage" style="display: none; margin-left: 10px; color: red;">Contact your IT Administrator to generate your Control Number to create a ticket.</span>
        </form>
    </div>


    <script src="js/script.js"></script>
    <script src="js/jquery-3.6.4.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    
    <script>
window.onload = function() {
   var controlNumberInput = document.getElementById('floatingInputValue1');
   var submitButton = document.getElementById('submitBtn');
   var controlNumberMessage = document.getElementById('controlNumberMessage');

   // Function to toggle the disabled state of the submit button and message display
   function toggleSubmitButton() {
       if (controlNumberInput.value === '') {
           submitButton.disabled = true;
           controlNumberMessage.style.display = 'inline';
       } else {
           submitButton.disabled = false;
           controlNumberMessage.style.display = 'none';
       }
   }

   // Initial check
   toggleSubmitButton();

   // Listen for changes to the Control Number input field
   controlNumberInput.addEventListener('input', toggleSubmitButton);
};

        // Get the current date
        const currentDate = new Date();

        // Format the current date as 'YYYY-MM-DD'
        const currentYear = currentDate.getFullYear();
        const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
        const currentDay = String(currentDate.getDate()).padStart(2, '0');
        const formattedCurrentDate = `${currentYear}-${currentMonth}-${currentDay}`;

        // Initialize flatpickr date and time picker
        // Initialize flatpickr for the date input
        flatpickr('#dateInput', {
            dateFormat: 'Y-m-d', // Set the desired date format
        });

        // Initialize flatpickr for the time input
        flatpickr('#timeInput', {
            enableTime: true, // Enable time picker
            noCalendar: true, // Hide the calendar
            dateFormat: 'h:i K', // Set the desired time format
            time_24hr: false // Use 12-hour format with AM/PM
        });
        
        // Apply symbol restriction to all text input fields
        const form = document.getElementById('ticketmaker');
        const inputs = form.querySelectorAll('input[type="text"]');

        inputs.forEach(input => {
            input.addEventListener('input', function (e) {
                const inputValue = e.target.value;
                const sanitizedValue = inputValue.replace(/[^A-Za-z0-9@.\-: ]/g,
                    ''); // Allow letters, numbers, spaces, @ symbol, and hyphens
                e.target.value = sanitizedValue;
            });
        });

        // Custom JavaScript to show/hide the dropdown
        function toggleDropdown() {
            var dropdown = $('#inputGroupSelect01');

            if (dropdown.hasClass('show')) {
                dropdown.removeClass('show');
            } else {
                dropdown.addClass('show');
            }
        }

        // Close the dropdown when clicking outside of it
        $(document).on('click', function (e) {
            var dropdown = $('#inputGroupSelect01');

            if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
                dropdown.removeClass('show');
            }
        });

        $(document).ready(function () {
            // Add a click event listener to the Change Password button
            $('#changePasswordButton').click(function (e) {
                e.preventDefault(); // Prevent the form from submitting normally

                // Get the form data
                var currentPassword = $('#currentPassword').val();
                var newPassword = $('#newPassword').val();
                var confirmPassword = $('#confirmPassword').val();

                // Send an AJAX request to password_change.php
                $.ajax({
                    type: 'POST',
                    url: 'php/password_change.php',
                    data: {
                        currentPassword: currentPassword,
                        newPassword: newPassword,
                        confirmPassword: confirmPassword
                    },
                    success: function (response) {
                        if (response === "success") {
                            // Password updated successfully
                            alert('Password updated successfully!');
                        } else if (response === "PasswordMismatch") {
                            alert('New password and confirm password do not match!');
                        } else if (response === "InvalidPassword") {
                            alert('Current password is incorrect');
                        } else {
                            alert('An error occurred: ' + response);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('AJAX error: ' + error);
                    }
                });
            });
        });

        $(document).ready(function () {
            // Display user data in placeholders
            $('#fname-text').text("First Name: " + '<?php echo $firstName; ?>');
            $('#lname-text').text("Last Name: " + '<?php echo $lastName; ?>');
            $('#stat-text').text("Role: " + '<?php echo $status; ?>');

        });

        // Add a click event listener to the logout button
        document.getElementById('logout-button').addEventListener('click', function () {
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