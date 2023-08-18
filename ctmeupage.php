<?php
session_start();
//include 'php/database_connect.php';
?>

<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src= "https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
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
    <a href="ctmeupage.php" class="link"><b>Records</b></a>
    <a href="ctmeurecords.php" class="link">Reports</a>
    <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a>-->
    <a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>
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
                <th><button class="btn btn-primary" id="toggle-archive-buttons"><i class='bx bx-show'></i></button></th>
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

<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
  import { getFirestore, collection, doc, getDoc, addDoc, deleteDoc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";

  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCJYwTjdJbocOuQqUUPPcjQ49Y8R2eng0E",
    authDomain: "ctmeu-d5575.firebaseapp.com",
    projectId: "ctmeu-d5575",
    storageBucket: "ctmeu-d5575.appspot.com",
    messagingSenderId: "1062661015515",
    appId: "1:1062661015515:web:c0f4f62b1f010a9216c9fe",
    measurementId: "G-65PXT5618B"
  };

    // Initialize Firebase
    initializeApp(firebaseConfig);
    const db = getFirestore();

    const ticketTableBody = document.getElementById("ticket-table-body");
    

    // Function to fetch data from Firestore and populate the table
  const fetchData = async () => {
    const ticketCollection = collection(db, "Ticket");
    const querySnapshot = await getDocs(ticketCollection);

    let count = 1; // Counter for numbering rows

    // Clear existing table rows to avoid duplication
    ticketTableBody.innerHTML = "";

    querySnapshot.forEach((doc) => {
    const { address, time, license, name, district, owner, ownerAddress, plate, vehicle, placeOccurred } = doc.data();
    const docId = doc.id; // Get the auto-generated document ID
    if (address || time || license || name) {
      const row = document.createElement("tr");

      const countCell = document.createElement("td");
      countCell.textContent = count++;

      const addressCell = document.createElement("td");
      addressCell.textContent = address;

      /*const timeCell = document.createElement("td");
      timeCell.textContent = time ? formatTimestamp(time) : ''; // Check if time exists and call the formatTimestamp function
*/
      const licenseCell = document.createElement("td");
      licenseCell.textContent = license;

      const districtCell = document.createElement("td");
      districtCell.textContent = district;

      const nameCell = document.createElement("td");
      nameCell.textContent = name;

      // Archive button cell
      const archiveButtonCell = document.createElement("td");
      const archiveButton = document.createElement("button");
      archiveButton.innerHTML = "<i class='bx bx-archive-in'></i>";
      archiveButton.classList.add("btn", "btn-primary", "hidden", "archive-button");
      archiveButton.addEventListener("click", (event) => handleArchiveButtonClick(event, docId, row)); // Pass the event as well
      archiveButtonCell.appendChild(archiveButton);

      row.appendChild(countCell);
      row.appendChild(nameCell);
      row.appendChild(licenseCell);
      row.appendChild(addressCell);
      row.appendChild(districtCell);
      row.appendChild(archiveButtonCell); // Add the archive button cell to the row

      row.classList.add('clickable-row');

      ticketTableBody.appendChild(row);

      // Pass the row data and document ID as an object to the handleRowClick function
      row.addEventListener('click', () => handleRowClick({ address, time, license, name, district, owner, ownerAddress, plate, vehicle, placeOccurred, docId }));
    }
  });

  // JavaScript to toggle the visibility of archive buttons
document.getElementById("toggle-archive-buttons").addEventListener("click", () => {
  const archiveButtons = document.querySelectorAll(".archive-button");
  for (const button of archiveButtons) {
    button.classList.toggle("hidden");
  }
});

  // Function to handle archive button click
const handleArchiveButtonClick = async (event, docId, row) => {
  event.stopPropagation(); // Prevent the click event from bubbling up to the row's click event

  // Show a confirmation dialog to the user
  const confirmed = window.confirm('Are you sure you want to archive this ticket?');

  if (!confirmed) {
    // User clicked "Cancel", do nothing
    return;
  }

  try {
    // Get the document reference for the ticket
    const ticketRef = doc(db, 'Ticket', docId);

    // Get the ticket data before archiving
    const ticketSnapshot = await getDoc(ticketRef);
    const ticketData = ticketSnapshot.data();

    // Add the ticket data to the 'archive' collection
    const archiveCollection = collection(db, 'archive');
    await addDoc(archiveCollection, ticketData);

    // Delete the ticket from the 'Ticket' collection
    await deleteDoc(ticketRef);

    // Remove the row from the table
    ticketTableBody.removeChild(row);

    // Show an alert to indicate successful archival
    alert('Ticket archived successfully!');
  } catch (error) {
    console.error('Error archiving ticket:', error);
    // You can add error handling logic here, such as showing an error message to the user
  }
};

  };
 // Function to fetch data at intervals
 const autoLoadData = () => {
    fetchData().catch((error) => {
      console.error("Error fetching data:", error);
    });
  };

  // Set the time interval in milliseconds (e.g., 5000 ms for 5 seconds)
  const intervalTime = 20000;

  // Initial data fetch
  autoLoadData();

  // Start fetching data at intervals
  setInterval(autoLoadData, intervalTime);

    // Check if user is logged in
    const isLoggedIn = sessionStorage.getItem('username') !== null;

    if (isLoggedIn) {
      // Get the username from the session storage
      const username = sessionStorage.getItem('username');

      // Get the user document from Firestore
const usersCollection = collection(db, 'usersCTMEU');
const userQuery = query(usersCollection, where('username', '==', username));

function archiveRow(docId) {
  // Custom confirmation dialog
  const confirmation = confirm("Are you sure you want to archive this record?\n\nClick 'Yes' to proceed or 'No' to cancel.");
  if (confirmation) {
    const ticketDocRef = doc(db, 'Ticket', docId); // Reference to the Firestore document
    const archiveCollection = collection(db, 'archive'); // Reference to the "archive" collection

    // Fetch the original document data
    getDoc(ticketDocRef).then((docSnap) => {
      if (docSnap.exists()) {
        const originalData = docSnap.data();

        // Add the original data to the "archive" collection
        addDoc(archiveCollection, originalData)
          .then(() => {
            // Archive successful
            alert('Record archived successfully!');
            // Delete the original document from the "Ticket" collection
            deleteDoc(ticketDocRef)
              .then(() => {
                // Redirect back to the original page
                window.location.href = 'ctmeupage.php';
              })
              .catch((error) => {
                console.error('Error deleting document:', error);
                // You can add error handling logic here, such as showing an error message to the user
              });
          })
          .catch((error) => {
            console.error('Error archiving document:', error);
            // You can add error handling logic here, such as showing an error message to the user
          });
      } else {
        console.error('Document not found!');
      }
    })
    .catch((error) => {
      console.error('Error fetching original document data:', error);
    });
  } else {
    // The user canceled the archiving action
    alert('Archiving canceled.');
  }
}


getDocs(userQuery)
  .then((querySnapshot) => {
    if (!querySnapshot.empty) {
      const docSnapshot = querySnapshot.docs[0];
      const userData = docSnapshot.data();
      const role = userData.role;
      const firstName = userData.firstName;
      const lastName = userData.lastName;

      // Check if the status is "Enforcer"
      if (role === 'Enforcer') {
        const specialButton = document.getElementById('noEnforcers');
        specialButton.style.display = 'none';
      }
    

      // Display the logged-in user's credentials
      const welcomeText = document.getElementById('welcome-text');
      welcomeText.textContent = `Welcome, ${role}: ${firstName} ${lastName}`;

      // Check if the status is "Enforcer"
      if (role === 'Enforcer') {
            const specialButton = document.getElementById('noEnforcers');
            specialButton.style.display = 'none';
            // Redirect to ctmeuusers.php if the status is Enforcer
            window.location.href = 'ctmeuusers.php';
          }
    } else {
      console.error('User document not found');
    }
  })
  .catch((error) => {
    console.error('Error retrieving user document:', error);
  });


      // Logout button
      const logoutButton = document.getElementById('logout-button');
      logoutButton.addEventListener('click', () => {
        // End session
        sessionStorage.removeItem('username');

        // Redirect back to the login page (replace "login.html" with the actual login page)
        window.location.href = 'index.php';
      });
    } else {
      // User is not logged in, redirect to the login page
      window.location.href = 'index.php';
    }
    
// Get the search bar element
const searchBar = document.getElementById("search-bar");

// Add an event listener to the search bar input
searchBar.addEventListener("input", () => {
  const searchTerm = searchBar.value.toLowerCase(); // Get the search term and convert to lowercase

  // Loop through each row in the table body
  const rows = document.querySelectorAll(".clickable-row");
  rows.forEach((row) => {
    const nameCell = row.querySelector("td:nth-child(2)"); // Get the name cell
    const name = nameCell.textContent.toLowerCase(); // Get the name value and convert to lowercase

    // If the search term is found in the name, show the row; otherwise, hide the row
    if (name.includes(searchTerm)) {
      row.style.display = "table-row"; // Show the row
    } else {
      row.style.display = "none"; // Hide the row
    }
  });
});

// Get the filter select element
const filterSelect = document.getElementById("filter-select");

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


</script>
<script>
  // Function to handle row click and redirect to the detail page
  const handleRowClick = (row) => {
    const rowJSON = JSON.stringify(row);
    const docId = encodeURIComponent(row.docId);
    window.location.href = `detail.php?data=${encodeURIComponent(rowJSON)}&docId=${docId}`;
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
</script>

</body>
</html>