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
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Data Hub</title>
</head>
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
    <a href="ctmeurecords.php" class="link"><b>Reports</b></a>
    <a href="ctmeuactlogs.php" class="link">Activity Logs</a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" id="noEnforcers"class="link">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>
<!--
<div class="pagination" style="text-align:right; margin-top: 5px; margin-left:5px; margin-right:auto;">
    
    <div class="pagination" style="color:white;">
      <span id="tableNumber"></span>/<span id="totalTables"></span>
      <button id="previous-btn" class="disabled seek"><</button>
    <button class="seek" id="next-btn">></button>
    </div>
  </div>
-->
<div class="table-container">
<table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>License No.</th>
                <th>District No.</th>
                <th>Address</th>
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
  import { getFirestore, collection, doc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";

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
      const { address, district, license, name } = doc.data();
      const docId = doc.id; // Get the auto-generated document ID
      if (address && district && license && name) {
      const row = document.createElement("tr");

      const countCell = document.createElement("td");
      countCell.textContent = count++;

      const addressCell = document.createElement("td");
      addressCell.textContent = address;

      const districtCell = document.createElement("td");
      districtCell.textContent = district;

      const licenseCell = document.createElement("td");
      licenseCell.textContent = license;

      const nameCell = document.createElement("td");
      nameCell.textContent = name;

        row.appendChild(countCell);
        row.appendChild(addressCell);
        row.appendChild(districtCell);
        row.appendChild(licenseCell);
        row.appendChild(nameCell);

      ticketTableBody.appendChild(row);

      // Pass the row data and document ID as an object to the handleRowClick function
      row.addEventListener('click', () => handleRowClick({ address, district, license, name, docId }));
      }
    });
  };
 // Function to fetch data at intervals
 const autoLoadData = () => {
    fetchData().catch((error) => {
      console.error("Error fetching data:", error);
    });
  };

  // Set the time interval in milliseconds (e.g., 5000 ms for 5 seconds)
  const intervalTime = 5000;

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


getDocs(userQuery)
  .then((querySnapshot) => {
    if (!querySnapshot.empty) {
      const docSnapshot = querySnapshot.docs[0];
      const userData = docSnapshot.data();
      const status = userData.status;
      const firstName = userData.firstName;
      const lastName = userData.lastName;

      // Check if the status is "Enforcer"
      if (status === 'Enforcer') {
        const specialButton = document.getElementById('noEnforcers');
        specialButton.style.display = 'none';
      }
    

      // Display the logged-in user's credentials
      const welcomeText = document.getElementById('welcome-text');
      welcomeText.textContent = `Welcome, ${status}: ${firstName} ${lastName}`;

      // Check if the status is "Enforcer"
      if (status === 'Enforcer') {
            const specialButton = document.getElementById('noEnforcers');
            specialButton.style.display = 'none';
            // Redirect to ctmeuactlogs.php if the status is Enforcer
            window.location.href = 'ctmeuactlogs.php';
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
</script>
<script>
  // Function to handle row click and redirect to the detail page
  const handleRowClick = (row) => {
    const rowJSON = JSON.stringify(row);
    const docId = encodeURIComponent(row.docId);
    window.location.href = `detail.php?data=${encodeURIComponent(rowJSON)}&docId=${docId}`;
  };
</script>

</body>
</html>