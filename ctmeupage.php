<?php
session_start();
include 'php/database_connect.php'; // Include your database connection code here

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are not logged in
    header("Location: login");
    exit();
}

// Check the user's role
if ($_SESSION['role'] === 'Enforcer') {
    // Redirect the user to ctmeutickets.php if their role is Enforcer
    header("Location: ticket-creation");
    exit();
}



// Define a function to fetch data from the violation_tickets table
function fetchViolationTickets()
{
    global $conn; // Assuming you have a database connection established

    // Write a SQL query to fetch data from the violation_tickets table
    $sql = "SELECT 
            violation_tickets.*,
            users.first_name, users.middle_name, users.last_name,
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
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>CTMEU Data Hub</title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    .ewan {
        background: white;
        border-radius: 20px;
        width: 80%;
        max-width: 1900px;
        margin: 0 auto;
        margin-top: 40px;
    }

    .tableContainer {
        width: 100%;
        overflow-x: scroll;
        background-color: white;
        padding: 2px;
    }

    /* width */
    ::-webkit-scrollbar {
        height: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        border-top: 1px solid #EEE;
        border-bottom: 1px solid #EEE;
        border-radius: 5px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: gray;
        border-radius: 10px;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        white-space: nowrap;
    }

    tr:hover {
        background-color: grey;
    }

    /* Centered Pagination styling */
    .pagination-container {
        text-align: center;
        /* Center the pagination links */
        margin-top: 20px;
    }

    .pagination {
        display: inline-block;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 6px 12px;
        margin: 2px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
    }

    .pagination .current-page {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    #page-info {
        font-weight: bold;
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

    .table-header {
        width: 100%;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .clickable-row {
        display: table-row;
    }
</style>

<body style="height: 100vh; background: linear-gradient(to bottom, #1F4EDA, #102077);">

    <form id="archive-form" action="php/archiverow.php" method="POST">
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
        <div class="ewan">
            <div class="table-header">
                <div class="search-container">
                    <input type="text" id="search-bar" placeholder="Search..." style="width: 300px;">
                    <select id="filter-select">
                        <option value="ticket number">Ticket Number</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                        <option value="driver's name">Driver's Name</option>
                        <option value="driver's address">Driver's Address</option>
                        <option value="license">License No.</option>
                        <option value="issuing district">Issuing District</option>
                        <option value="vehicle">Type of Vehicle</option>
                        <option value="plate no.">Plate No.</option>
                        <option value="registered owner">Registered Owner</option>
                        <option value="registered owner's address">Registered Owner's Address</option>
                        <option value="place of occurrence">Place of Occurrence</option>
                        <option value="violations">Violations</option>
                        <option value="status">Status</option>
                        <option value="issued by">Issued by</option>
                    </select>
                </div>
                <?php
                // Check if the user is a Super Administrator
                if ($_SESSION['role'] === 'Super Administrator') {
                    // Show the archive button, count, and "records are selected"
                    echo '<div><span id="checkbox-count">0</span> records are selected</div>';
                    //echo '<button type="submit" class="btn btn-primary mb-3 float-end" id="archive-button"><i class="bx bx-archive-in"></i></button>';
                    echo '<button type="button" id="archiveButton" class="btn btn-primary float-end" data-bs-target="#exampleModal"><i class="bx bx-archive-in"></i></button>';
                }


                ?>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Archive</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to archive the selected tickets?
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="archive-cancel-button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" id="archive-confirmation-button" class="btn btn-primary"
                                data-bs-dismiss="modal">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="successModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <i><img class="m-3" src="./images/check.png"></i> <!-- Check icon -->
                                <h5 class="modal-title mb-3" style="font-weight: 800;">Archived!</h5>
                                <p class="mb-3" style="font-weight: 500;">Selected tickets have been archived
                                    successfully.
                                </p>
                                <button type="submit" class="btn btn-primary mb-3" id="okButton" data-dismiss="modal"
                                    onclick="submitForm()" style="background-color: #0A157A;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="noSelectionModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h5 class="modal-title mb-3" style="font-weight: 800;">No Selection</h5>
                                <p class="mb-3" style="font-weight: 500;">Please select at least one ticket to archive.
                                </p>
                                <button type="button" class="btn btn-primary mb-3" data-bs-dismiss="modal"
                                    style="background-color: #0A157A;">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tableContainer">
                <table class="mb-5">
                    <!-- pagination works but needs to search for database and not on the screen only (enter key for submission)-->
                    <thead>
                        <tr class="align-items-center">
                            <th class="sortable-no" data-column="0">Ticket Number</th>
                            <?php
                            // Check if the user is a Super Administrator
                            if ($_SESSION['role'] === 'Super Administrator') {
                                // Show the archive button and checkboxes
                                echo '<th><input class="form-check-input" type="checkbox" id="select-all-checkbox"></th>';
                            }
                            ?>
                            <th class="sortable" data-column="2">Date<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="3">Time<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="4">Driver's Name <span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="5">Driver's Address<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="6">License No.<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="7">Issuing District<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="8">Type of Vehicle<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="9">Plate No.<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="10">Registered Owner<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="11">Registered Owner's Address<span
                                    class="sort-arrow"></span>
                            </th>
                            <th class="sortable" data-column="12">Place of Occurrence<span class="sort-arrow"></span>
                            </th>
                            
                            <th class="sortable" data-column="13">Violations<span class="sort-arrow"></span></th>

                            <th class="sortable" data-column="14">Status<span class="sort-arrow"></span></th>
                            <th class="sortable" data-column="15">Issued by<span class="sort-arrow"><span
                                    class="sort-arrow"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center" id="ticket-table-body">
                        <?php
                        $visibleTicketCount = 0; // Initialize a counter for visible tickets
                        $emptyResult = true;

                        // Define the number of records to display per page
                        $recordsPerPage = 50;

                        // Get the current page from the URL (default to page 1)
                        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

                        // Calculate the starting index for the current page
                        $startIndex = ($currentPage - 1) * $recordsPerPage;

                        // Loop through the fetched violation ticket data and populate the table rows
                        foreach ($violationTickets as $index => $ticket) {
                            $vehicleId = $ticket['vehicle_type'];
                            // Check if the is_settled value is 0 before making the row clickable
                            if ($ticket['is_settled'] == 0) {
                                $visibleTicketCount++; // Increment the visible ticket counter
                        
                                // Only display rows within the current page's range
                                if ($visibleTicketCount > $startIndex && $visibleTicketCount <= ($startIndex + $recordsPerPage)) {
                                    // Convert the row data to a JSON string
                                    $rowData = json_encode($ticket);

                                    echo "<tr class='clickable-row' data-index='$index' data-rowdata='$rowData' id='row-$index'>";
                                    // Display the visible ticket count in the "No." column
                                    echo "<td class='td-count'>" . $ticket['control_number'] . "<input type='hidden' value='" . $ticket['ticket_id'] . "'></td>";

                                    // Check the user's role to decide whether to show checkboxes
                                    if ($_SESSION['role'] === 'Super Administrator') {
                                        // Add a checkbox for archiving
                                        echo "<td><input class='form-check-input' type='checkbox' name='archive[]' value='" . $ticket['ticket_id'] . "'></td>";
                                    }

                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['date_violation'] . "</td>";
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['time_violation'] . "</td>";
                                    // Wrap the name in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['driver_name'] . "</td>";
                                    // Wrap the license in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['driver_address'] . "</td>";
                                    // Wrap the address in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['driver_license'] . "</td>";
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['issuing_district'] . "</td>";
                                    // Wrap the address in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['vehicle_name'] . "</td>";
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['plate_no'] . "    </td>";
                                    // Wrap the district in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['reg_owner'] . "</td>";
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['reg_owner_address'] . "</td>";
                                    // Wrap the district in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['place_of_occurrence'] . "</td>";

                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['concatenated_sections'] . "</td>";
                                    // Wrap the district in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . ($ticket['is_settled'] ? 'Settled' : 'Unsettled') . "</td>";
                                    // Wrap the district in a clickable <td>
                                    echo "<td class='clickable-cell' data-rowdata='$rowData'>" . $ticket['first_name'] . " " . $ticket['middle_name'] . " " . $ticket['last_name'] . "</td>";
                                    // Wrap the district in a clickable <td>
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination">
                    <?php
                    // Calculate the total number of pages
                    $totalPages = ceil($visibleTicketCount / $recordsPerPage);

                    for ($page = 1; $page <= $totalPages; $page++) {
                        if ($page == $currentPage) {
                            echo "<span class='current-page'>$page</span>";
                        } else {
                            echo "<a href='?page=$page'>$page</a>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="js/script.js"></script>
        <script src="js/jquery-3.6.4.js"></script>
        <script>
            // Apply symbol restriction to all text input fields
            const form = document.getElementById('search-bar');
            const inputs = form.querySelectorAll('input[type="text"]');

            inputs.forEach(input => {
                input.addEventListener('input', function (e) {
                    const inputValue = e.target.value;
                    const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 \-]/g,
                        ''); // Allow letters, numbers, spaces, and hyphens
                    e.target.value = sanitizedValue;
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const tableBody = document.getElementById("ticket-table-body");
                const headers = document.querySelectorAll(".sortable");
                let currentColumn = null;
                let isAscending = true;

                // Function to compare two table cells based on their content
                function compareCells(a, b) {
                    const aValue = a.textContent || a.innerText;
                    const bValue = b.textContent || b.innerText;
                    return aValue.localeCompare(bValue, undefined, {
                        numeric: true
                    });
                }

                // Function to sort the table rows
                function sortTable(column, order) {
                    const rows = Array.from(tableBody.querySelectorAll("tr"));

                    rows.sort((rowA, rowB) => {
                        const cellA = rowA.querySelectorAll("td")[column];
                        const cellB = rowB.querySelectorAll("td")[column];

                        if (order === "asc") {
                            return compareCells(cellA, cellB);
                        } else {
                            return compareCells(cellB, cellA);
                        }
                    });

                    tableBody.innerHTML = "";
                    rows.forEach((row) => {
                        tableBody.appendChild(row);
                    });
                }

                // Function to update the arrow icons
                function updateArrowIcons() {
                    headers.forEach((header) => {
                        header.classList.remove("asc", "desc");
                        const arrowIcon = header.querySelector(".sort-arrow");

                        // Check if arrowIcon is not null before updating its innerHTML
                        if (arrowIcon) {
                            arrowIcon.innerHTML = "";
                        }
                    });
                }


                // Event listener for header clicks
                headers.forEach((header, index) => {
                    header.addEventListener("click", () => {
                        const column = parseInt(header.getAttribute("data-column"));

                        if (column === currentColumn) {
                            // If clicked on the same column, toggle the sorting order
                            isAscending = !isAscending;
                        } else {
                            // If clicked on a different column, set it as the current column and sort in ascending order
                            currentColumn = column;
                            isAscending = true;
                            updateArrowIcons(); // Clear arrow icons in other headers
                        }

                        // Update the arrow icons and CSS class
                        header.classList.add(isAscending ? "asc" : "desc");
                        const arrowIcon = header.querySelector(".sort-arrow");
                        arrowIcon.innerHTML = isAscending ? "&#9650;" :
                            "&#9660;"; // Unicode symbols for up and down arrows

                        // Sort the table
                        sortTable(column, isAscending ? "asc" : "desc");
                    });
                });
            });
        </script>

        <script>
            function submitForm() {
                // Trigger form submission
                document.getElementById('archive-form').submit();
            }

            <?php
            // Check if the user is a Super Administrator
            if ($_SESSION['role'] === 'Super Administrator') {
                // Show the archive button and checkboxes
                echo "document.getElementById('select-all-checkbox').addEventListener('change', function () {
                  var checkboxes = document.querySelectorAll('tbody input[type=" . "checkbox" . "]');
                  checkboxes.forEach(function (checkbox) {
                      checkbox.checked = document.getElementById('select-all-checkbox').checked;
                  });
              });
          ";
            }

            ?>
            document.querySelectorAll('.clickable-cell').forEach(function (cell) {
    cell.addEventListener('click', function () {
        // Get the row data JSON string from the clicked cell's data-rowdata attribute
        var rowData = cell.getAttribute('data-rowdata');

        // Instead of appending data to the URL, send it to the server using AJAX
        $.ajax({
            type: 'POST',
            url: 'storeInSession.php', // This is a new PHP file you'll create to handle storing data in the session
            data: {rowData: rowData},
            dataType: 'json',
            success: function(response) {
                // Check the response from the server
                if (response.success) {
                    // Redirect to the details page
                    window.location.href = 'ticket-details';
                } else {
                    // Handle error
                    console.error('Failed to store data in session.');
                }
            },
    error: function(xhr, status, error) {
        // Log any error details for debugging
        console.error('AJAX request failed:', status, error, 'Response:', xhr.responseText);
    }
        });
    });
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

            function filterTable() {
            var filterSelect = document.getElementById('filter-select');
            var searchInput = document.getElementById('search-bar').value.toLowerCase();

            // Define an object to map filter keys to column names
            var columnMap = {
                'ticket number': 'control_number',
                'date': 'date_violation',
                'time': 'time_violation',
                'driver\'s name': 'driver_name',
                'driver\'s address': 'driver_address',
                'license': 'driver_license',
                'issuing district': 'issuing_district',
                'vehicle': 'vehicle_type',
                'plate no.': 'plate_no',
                'registered owner': 'reg_owner',
                'registered owner\'s address': 'reg_owner_address',
                'place of occurrence': 'place_of_occurrence',
                'violations': 'concatenated_sections',
                'status': 'is_settled',
                'issued by': 'first_name' // Assuming 'issued by' refers to the first name of the issuer
            };

            // Get the column name based on the selected filter key
            var columnName = columnMap[filterSelect.value];

            // Loop through the table rows and filter based on the selected column
            var rows = document.querySelectorAll('#ticket-table-body .clickable-row');
            rows.forEach(function (row) {
                var rowData = JSON.parse(row.getAttribute('data-rowdata'));

                // Get the cell value based on the selected column name
                var cellValue = String(rowData[columnName]).toLowerCase();

                if (cellValue.includes(searchInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }



            // Add event listeners to trigger filtering
            document.getElementById('filter-select').addEventListener('change', filterTable);
            document.getElementById('search-bar').addEventListener('input', filterTable);
            
        </script>
        <script>
            $(document).ready(function () {
                // Function to update the checkbox count
                function updateCheckboxCount() {
                    const checkedCheckboxes = $('input[type="checkbox"]:checked').length;
                    $('#checkbox-count').text(checkedCheckboxes);
                }

                // Attach a change event handler to checkboxes to update the count
                $('input[type="checkbox"]').change(updateCheckboxCount);

                // Call the function initially to set the count to the initial state
                updateCheckboxCount();
            });
        </script>

        <script>
            
            // Add an event listener to the "Yes" button in the "Archive" modal
            document.getElementById('archiveButton').addEventListener('click', function () {
                // Check if at least one checkbox is selected
                const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');

                if (selectedCheckboxes.length === 0) {
                    // Show the "No Selection" modal if no checkboxes are selected
                    $('#noSelectionModal').modal('show');
                } else {
                    // Hide the "No Selection" modal if it was shown previously
                    $('#noSelectionModal').modal('hide');

                    // Show the "Archive" modal
                    $('#exampleModal').modal('show');
                }
            });

            // Add an event listener to the "Yes" button in the "Archive" modal
            document.getElementById('archive-confirmation-button').addEventListener('click', function () {
                // Perform the necessary actions when the user clicks "Yes" in the "Archive" modal
                // For example, you can submit the form or perform an AJAX request here

                // After the action is completed, hide the "Archive" modal
                $('#exampleModal').modal('hide');

                // Show the "Success" modal only if the user clicked "Yes" in the "Archive" modal
                $('#successModal').modal('show');
            });

            // Add an event listener to the "No" button in the "Archive" modal
            document.getElementById('archive-cancel-button').addEventListener('click', function () {
                // If the user clicks "No" in the "Archive" modal, do not proceed to the "Success" modal
                $('#exampleModal').modal('hide');
            });

            // Function to refresh the page
            function refreshPage() {
                location.reload(true);
            }
        </script>
        <script src="js/script.js"></script>
        <script src="js/jquery-3.6.4.js"></script>
    </form>
</body>

</html>