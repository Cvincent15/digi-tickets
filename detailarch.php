<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Ticket Details</title>
</head>
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
    <a href="ctmeuarchive.php" class="link" id="noEnforcers"><b>Archive</b></a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" class="link noEnforcers">Create Accounts</a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>

<div class="container" style="margin-top:20px;">
    <!-- Display the row data here for editing or viewing -->
    <?php
    if (isset($_GET['data'])) {
      $rowData = json_decode($_GET['data'], true);
?>
</div>


    <!-- Add the table structure here -->
<div class="container" style="margin-top:20px;">
  <!-- Display the row data here -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Ticket Details</h5>
      <table class="table">
        <tbody id="table-body">
          <!-- Rows for document fields will be dynamically added here -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
    } else {
        echo "<p>No data available.</p>";
    }
    ?>


<script src="js/jquery-3.6.4.js"></script>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
  import { getFirestore, collection, doc,getDoc, getDocs, query, where, updateDoc, addDoc } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";

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
 // Check if user is logged in
 const isLoggedIn = sessionStorage.getItem('username') !== null;

 // Function to track changes and store them in Firestore
 const trackChanges = async (docId, changedField, oldValue, newValue) => {
    const changesCollection = collection(db, 'ChangeLog');

    // Add a new document with the changes
    await addDoc(changesCollection, {
      docId,
      changedField,
      oldValue,
      newValue,
      timestamp: new Date(),
    });
  };

 // Function to fetch all field names and their values from the document and display them
 const fetchDocumentData = async (docId) => {
    try {
      // Get the document reference based on the provided document ID
      const ticketDocRef = doc(db, 'archive', docId); // Reference to the Firestore document

      // Get the document data
      const docSnap = await getDoc(ticketDocRef);
      if (docSnap.exists()) {
        const ticketData = docSnap.data();

        const tableBody = document.getElementById('table-body');

        // Clear the existing table rows
        tableBody.innerHTML = '';

        // Loop through all fields and create rows in the table
        for (const [fieldName, fieldValue] of Object.entries(ticketData)) {
          const row = document.createElement('tr');
          const nameCell = document.createElement('td');
          const valueCell = document.createElement('td');

          nameCell.textContent = fieldName;
          valueCell.textContent = fieldValue;

          row.appendChild(nameCell);
          row.appendChild(valueCell);
          tableBody.appendChild(row);
        }
      } else {
        console.error('Document not found!');
      }
    } catch (error) {
      console.error('Error fetching document data:', error);
    }
  };

// Function to fetch violation data and populate the table
const fetchViolationData = async (docId) => {
    try {
      // Get the document reference based on the provided document ID
      const ticketDocRef = doc(db, 'archive', docId); // Reference to the Firestore document

      // Get the document data
      const docSnap = await getDoc(ticketDocRef);
      if (docSnap.exists()) {
        const ticketData = docSnap.data();

        // Check if the document has the 'violation' field and is an array
        if (Array.isArray(ticketData.violation)) {
          const violationTableBody = document.getElementById('violation-table-body');

          // Clear the existing table rows
          violationTableBody.innerHTML = '';

          // Loop through the violations and create rows in the table
          ticketData.violation.forEach((violation, index) => {
            const row = document.createElement('tr');
            const numCell = document.createElement('td');
            const violationCell = document.createElement('td');

            numCell.textContent = index + 1; // Add 1 to index to show a 1-based count
            violationCell.textContent = violation;

            row.appendChild(numCell);
            row.appendChild(violationCell);
            violationTableBody.appendChild(row);
          });
        }
      } else {
        console.error('Document not found!');
      }
    } catch (error) {
      console.error('Error fetching violation data:', error);
    }
  };

  // Call the fetchViolationData function when the page loads
  const queryParams = new URLSearchParams(window.location.search);
  const docId = queryParams.get('docId');
  if (docId) {
    fetchViolationData(docId);
    fetchDocumentData(docId);
  }




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
<!-- Add any other scripts you may need -->
</body>
</html>