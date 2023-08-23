<?php
session_start();
//include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
  // Redirect the user to the greeting page if they are already logged in
  header("Location: index.php");
  exit();
}
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
  .clickable-row {
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
    <a href="ctmeurecords.php" class="link">Reports</a>
    <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a>-->
    <a href="ctmeuactlogs.php" class="link" id="noEnforcers"><b>Archive</b></a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" id="noEnforcers"class="link">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>
<div class="search-container">
  <input type="text" id="search-bar" placeholder="Search...">
  <select id="filter-select">
    <option value="name">Name</option>
    <option value="license">License No.</option>
    <option value="address">Address</option>
    <option value="district">District</option>
  </select>
</div>

<div class="table-container">
<table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>License No.</th>
                <th>Address</th>
                <th>District</th>
            </tr>
        </thead>
        <tbody id="ticket-table-body">
            <!-- Replace the sample data below with the data fetched from your database -->
           
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>

<script>
  // Function to handle row click and redirect to the detail page
const handleRowClick = (row) => {
  const rowJSON = JSON.stringify(row);
  const docId = encodeURIComponent(row.docId);
  window.location.href = `detailarch.php?data=${encodeURIComponent(rowJSON)}&docId=${docId}`;
};
  function formatTimestamp(time) {
  const timestamp = new Date(time.seconds * 1000 + time.nanoseconds / 1000000);
  const formattedTime = timestamp.toLocaleString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
    timeZoneName: 'short'
  });
  return formattedTime;
}

// Get the filter select element
const filterSelect = document.getElementById("filter-select");
// Get the search bar element
const searchBar = document.getElementById("search-bar");

// Add an event listener to the filter select
filterSelect.addEventListener("change", () => {
  searchTable(); // Call the searchTable function to update the table based on the selected filter
});

// Add an event listener to the search bar input
searchBar.addEventListener("input", () => {
  searchTable(); // Call the searchTable function to update the table based on the search term
});

// Function to search and filter the table
const searchTable = () => {
  const filterValue = filterSelect.value; // Get the selected filter value
  const searchTerm = searchBar.value.toLowerCase(); // Get the search term and convert to lowercase

  // Loop through each row in the table body
  const rows = document.querySelectorAll(".clickable-row");
  rows.forEach((row) => {
    const cell = row.querySelector(`td:nth-child(${getFilterIndex(filterValue)})`); // Get the cell based on the selected filter
    const cellValue = cell.textContent.toLowerCase(); // Get the cell value and convert to lowercase

    // If the search term is found in the cell value, show the row; otherwise, hide the row
    if (cellValue.includes(searchTerm)) {
      row.style.display = "table-row"; // Show the row
    } else {
      row.style.display = "none"; // Hide the row
    }
  });
};

// Function to get the index of the selected filter for the table cell
const getFilterIndex = (filterValue) => {
  switch (filterValue) {
    case "name":
      return 2; // Name column
    case "license":
      return 3; // License No. column
    case "address":
      return 4; // Address column
    case "district":
      return 5; // District column
    default:
      return 0; // Default to the first column
  }
};

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