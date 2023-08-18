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
  .card {
        margin: 100px auto;
        width: 700px; /* Adjust the width as needed */
        height: auto; /* Adjust the height as needed */
        text-align: left;
    }
  .clickable-row {
    cursor: pointer;
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
    <a href="ctmeurecords.php" class="link"><b>Reports</b></a>
    <!--<a href="ctmeuactlogs.php" class="link">Activity Logs</a> -->
    <a href="ctmeuarchive.php" class="link" id="noEnforcers">Archive</a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" id="noEnforcers"class="link">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>
<div class="card">
  <button class="btn btn-primary" onclick="generatePDF()" style="margin:0;">GENERATE PDF</button>
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
                <th>Owner</th>
                <th>Owner Address</th>
                <th>Place Occurred</th>
                <th>Plate</th>
                <th>Vehicle</th>
                <th>Violation</th>
            </tr>
        </thead>
        <tbody id="ticket-table-body">
            <!-- Replace the sample data below with the data fetched from your database -->
           
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
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
  const { address, time, license, name, district, owner, ownerAddress, plate, vehicle, placeOccurred, violation } = doc.data();
  const docId = doc.id; // Get the auto-generated document ID
  if (address || time || license || name) {
    const row = document.createElement("tr");

    const countCell = document.createElement("td");
    countCell.textContent = count++;

    const addressCell = document.createElement("td");
    addressCell.textContent = address;

    const licenseCell = document.createElement("td");
    licenseCell.textContent = license;

    const nameCell = document.createElement("td");
    nameCell.textContent = name;
    
    const districtCell = document.createElement("td");
    districtCell.textContent = district;

    const ownerCell = document.createElement("td");
    ownerCell.textContent = owner;

    const ownerAddressCell = document.createElement("td");
    ownerAddressCell.textContent = ownerAddress;

    const placeOccurredCell = document.createElement("td");
    placeOccurredCell.textContent = placeOccurred;

    const plateCell = document.createElement("td");
    plateCell.textContent = plate;

    const vehicleCell = document.createElement("td");
    vehicleCell.textContent = vehicle;

    const violationCell = document.createElement("td");
    violationCell.textContent = violation;

    row.appendChild(countCell);
    row.appendChild(nameCell);
    row.appendChild(licenseCell);
    row.appendChild(addressCell);
    row.appendChild(districtCell);
    row.appendChild(ownerCell);
    row.appendChild(ownerAddressCell);
    row.appendChild(placeOccurredCell);
    row.appendChild(plateCell);
    row.appendChild(vehicleCell);
    row.appendChild(violationCell);

    row.classList.add('clickable-row');

    ticketTableBody.appendChild(row);

    // Pass the row data and document ID as an object to the handleRowClick function
    row.addEventListener('click', () => handleRowClick({ address, time, license, name, district, owner, ownerAddress, plate, vehicle, placeOccurred, violation, docId }));
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
  const intervalTime = 10000;

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

    function generatePDF() {
  const doc = new jsPDF();

  // Get the table element
  const table = document.querySelector('table');

  // Extract rows from the table
  const rows = table.querySelectorAll('tbody tr');

  // Define the starting position for the PDF table
  let yPos = 25;

  // Define column widths
  const colWidths = [10, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40];

  // Loop through each row and extract data
  rows.forEach((row, rowIndex) => {
    const cells = row.querySelectorAll('td');
    const rowData = [];

    cells.forEach((cell, cellIndex) => {
      rowData.push(cell.textContent);
    });

    // Create a new line in the PDF
    doc.text(10, yPos, rowData.join(' | '));
    yPos += 10;

    // Check if a new page is needed
    if (yPos >= 280) {
      doc.addPage();
      yPos = 10;
    }
  });

  // Save the PDF
  doc.save('CTMEU_Report.pdf');
}
</script>
</body>
</html>