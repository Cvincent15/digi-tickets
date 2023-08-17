<?php
// Start the session
session_start();

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
    <a href="ctmeuactlogs.php" class="link"><b>Activity Logs</b></a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" id="noEnforcers"class="link">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>

  <div class="table-container">
  <div class="card">
            <div class="card-body">
                <h5 class="card-title">Changes History</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Changed Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody id="changes-table-body">
                        <!-- Rows for changes history will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
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

   // Function to fetch change log data from Firestore
  const fetchChangeLogData = async () => {
    const changeLogCollection = collection(db, "changelog");

    const querySnapshot = await getDocs(changeLogCollection);

    if (!querySnapshot.empty) {
      const changesTableBody = document.getElementById("changes-table-body");
      changesTableBody.innerHTML = "";

      querySnapshot.forEach((doc) => {
        const changeLogData = doc.data();
        const { timestamp, docId, newData } = changeLogData;

        // Create and populate the change log table row
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${timestamp.toDate().toLocaleString()}</td>
          <td>${docId}</td>
          <td>${newData.name}</td>
          <td>${newData.license}</td>
          <!-- Add more cells for other fields as needed -->
        `;

        // Append the row to the change log table body
        changesTableBody.appendChild(row);
      });
    }
  };

  // Fetch and display the change log data when the page loads
  fetchChangeLogData();

    

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
  // Get all elements with class "noEnforcers"
  const specialButtons = document.querySelectorAll('.noEnforcers');

  // Loop through each element and hide it
  specialButtons.forEach((button) => {
    button.style.display = 'none';
  });
}
     else {
      console.error('User document not found');
    }
    

      // Display the logged-in user's credentials
      const welcomeText = document.getElementById('welcome-text');
      welcomeText.textContent = `Welcome, ${role}: ${firstName} ${lastName}`;
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
</body>
</html>