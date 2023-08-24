<?php
session_start();
//include 'php/database_connect.php';

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are already logged in
    header("Location: ctmeupage.php");
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
    <a href="ctmeupage.php" class="link noEnforcers"><b>Records</b></a>
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
    <!-- Display the row data here for editing or viewing -->
    <?php
    if (isset($_GET['data'])) {
        $rowData = json_decode($_GET['data'], true);
        $defaultNAText = "N/A"; // Default value for missing data
    ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ticket Details</h5>
            <table class="table">
                <tbody>
                <tr>
                      
                      <!--<th>Time: <?php echo $timeFormatted ?? ''; ?></th>-->
                  </tr>
                  <tr>
                      <th>Name</th>
                      <td><input type="text" class="form-control" id="name" name="name" value="<?php echo $rowData['name'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>License</th>
                      <td><input type="text" class="form-control" id="license" name="license" value="<?php echo $rowData['license'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>Address</th>
                      <td><input type="text" class="form-control" id="address" name="address" value="<?php echo $rowData['address'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>District</th>
                      <td><input type="text" class="form-control" id="district" name="district" value="<?php echo $rowData['district'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>Owner's Name</th>
                      <td><input type="text" class="form-control" id="owner" name="owner" value="<?php echo $rowData['owner'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>Owner's Address</th>
                      <td><input type="text" class="form-control" id="ownerAddress" name="ownerAddress" value="<?php echo $rowData['ownerAddress'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>License Plate</th>
                      <td><input type="text" class="form-control" id="plate" name="plate" value="<?php echo $rowData['plate'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>Type of Vehicle</th>
                      <td><input type="text" class="form-control" id="vehicle" name="vehicle" value="<?php echo $rowData['vehicle'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                  <tr>
                      <th>Place Occurred</th>
                      <td><input type="text" class="form-control" id="placeOccurred" name="placeOccurred" value="<?php echo $rowData['placeOccurred'] ?? $defaultNAText; ?>" readonly></td>
                  </tr>
                    
                    <!-- Add more rows for other details as needed -->
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="save-changes-btn">Edit</button>
        </div>
    </div>
    <?php
    } else {
        echo "<p>No data available.</p>";
    }
    ?>
</div>


    <!-- Table to display violations -->
    <div class="container">
        <div class="card">
            <div class="card-body" style="margin-top:10px;">
            <h5 class="card-title">Violations</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Violation Type</th>
                        <!-- Add more headers for other violation data as needed -->
                    </tr>
                </thead>
                <tbody id="violation-table-body">
                    <!-- Rows for violations will be dynamically added here -->
                </tbody>
            </table>
            </div>
        </div>
    </div>


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

// Function to fetch violation data and populate the table
const fetchViolationData = async (docId) => {
    try {
      // Get the document reference based on the provided document ID
      const ticketDocRef = doc(db, 'Ticket', docId); // Reference to the Firestore document

      // Get the document data
      const docSnap = await getDoc(ticketDocRef);
      if (docSnap.exists()) {
        const ticketData = docSnap.data();

        // Check if the document has the 'violation' field and is an array
        if (Array.isArray(ticketData.violation)) {
          const violationTableBody = document.getElementById('violation-table-body');

          // Clear the existing table rows
          violationTableBody.innerHTML = '';

          ticketData.violation.forEach((violation, index) => {
  const row = document.createElement('tr');
  const numCell = document.createElement('td');
  const violationCell = document.createElement('td');

  numCell.textContent = index + 1; // Add 1 to index to show a 1-based count

  // Create a <span> element to hold the violation description
  const violationDescriptionSpan = document.createElement('span');
  violationDescriptionSpan.textContent = violation;

  // Append the description element inside violationCell
  violationCell.appendChild(violationDescriptionSpan);

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
  }


// Add event listener for the "Edit" / "Save Changes" button
const saveChangesBtn = document.getElementById('save-changes-btn');
  saveChangesBtn.addEventListener('click', () => {
    const addressInput = document.getElementById('address');
    const licenseInput = document.getElementById('license');
    const nameInput = document.getElementById('name');
    const ownerInput = document.getElementById('owner');
    const districtInput = document.getElementById('district');
    const ownerAddressInput = document.getElementById('ownerAddress');
    const plateInput = document.getElementById('plate');
    const vehicleInput = document.getElementById('vehicle');
    const placeOccurredInput = document.getElementById('placeOccurred');

    if (saveChangesBtn.textContent === 'Edit') {
      // Switch to edit mode
      addressInput.readOnly = false;
      ownerInput.readOnly = false;
      licenseInput.readOnly = false;
      nameInput.readOnly = false;
      districtInput.readOnly = false;
      ownerAddressInput.readOnly = false;
      plateInput.readOnly = false;
      vehicleInput.readOnly = false;
      placeOccurredInput.readOnly = false;
      saveChangesBtn.textContent = 'Save Changes';
    } else {
      // Save changes to Firestore
      const newData = {
        address: addressInput.value,
        owner: ownerInput.value,
        ownerAddress: ownerAddressInput.value,
        district: districtInput.value,
        plate: plateInput.value,
        vehicle: vehicleInput.value,
        license: licenseInput.value,
        placeOccurred: placeOccurredInput.value,
        name: nameInput.value
        // Add other fields as needed
      };

      

      // Update the Firestore document with the new data
      const docId = "<?php echo $_GET['docId'] ?? ''; ?>"; // Retrieve the document ID from query parameters

      const ticketDocId = "<?php echo $_GET['docId'] ?? ''; ?>";
      
    // Check if docId exists and is not empty before proceeding with the update
    if (docId) {
      // Update the Firestore document with the new data
      const ticket = collection(db, 'Ticket'); // Replace 'usersCTMEU' with your actual collection name
      const docRef = doc(ticket, ticketDocId); // Get the reference to the specific document

      const newData = {
        address: addressInput.value,
        owner: ownerInput.value,
        ownerAddress: ownerAddressInput.value,
        district: districtInput.value,
        plate: plateInput.value,
        vehicle: vehicleInput.value,
        license: licenseInput.value,
        placeOccurred: placeOccurredInput.value,
        name: nameInput.value,
        // Add other fields as needed
      };

      updateDoc(docRef, newData) // Use updateDoc() to update specific fields
        .then(() => {
          // Update successful, switch back to view mode
          addressInput.readOnly = true;
          ownerInput.readOnly = true;
          ownerAddressInput.readOnly = true;
          plateInput.readOnly = true;
          districtInput.readOnly = true;
          vehicleInput.readOnly = true;
          licenseInput.readOnly = true;
          nameInput.readOnly = true;
          placeOccurredInput.readOnly = true;
          saveChangesBtn.textContent = 'Edit';
          // Fetch and display violation data if it exists
          fetchViolationData(docId);

          

          // After saving changes, update the displayed data
          const tableData = {
            address: addressInput.value,
            owner: ownerInput.value,
            ownerAddress: ownerAddressInput.value,
            district: districtInput.value,
            plate: plateInput.value,
            vehicle: vehicleInput.value,
            license: licenseInput.value,
            placeOccurred: placeOccurredInput.value,
            name: nameInput.value
          };

          const queryParams = new URLSearchParams(window.location.search);
          const docId = queryParams.get('docId');
          queryParams.set('data', JSON.stringify(tableData));
          if (docId) {
    fetchViolationData(docId);
  }
        

          // Update the URL with the new data
          history.replaceState(null, null, '?' + queryParams.toString());

          // Track changes before updating the Firestore document
          for (const field in newData) {
            if (newData.hasOwnProperty(field) && newData[field] !== rowData[field]) {
              // Call the tracking function for each changed field
              trackChanges(ticketDocId, field, rowData[field], newData[field]);
            }
          }
        

        })
        
        .catch((error) => {
          console.error('Error updating document:', error);
          // You can add error handling logic here, such as showing an error message to the user
        });
    } else {
      console.error('Document ID not found in query parameters.');
      // You can add error handling logic here, such as showing an error message to the user
    }
} 

  });

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