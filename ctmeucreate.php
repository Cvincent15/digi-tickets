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
    .container {
      margin-top:10px;
      border-radius:10px;
      display: flex;
      justify-content: space-between;
      background-color: white;
      min-width: auto; 
    }

    .form-container {
      flex-basis: 50%;
      padding: 20px;
    }

    .table-container {
      flex-basis: 50%;
      padding: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100% auto;
    }

    th, td {
      text-align: left;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }

    form {
      margin-bottom: 20px;
    }

    input[type="text"], input[type="password"],input[type="number"], select {
      width: 70%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin-right: 10px;
      border: none;
      cursor: pointer;
    }

    button[type="submit"] {
      background-color: #4CAF50;
    }

    button[type="reset"] {
      background-color: #f44336;
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
    <a href="ctmeuactlogs.php" class="link">Activity Logs</a>
    <!-- firebase only super admin can access this -->
    <a href="ctmeucreate.php" class="link"><b>Create Accounts</b></a>
    <a href="ctmeuusers.php" class="link">User Account</a>
  </div>
  </div>
</nav>
<div class="container">
    <div class="form-container">
  <form method="POST" id="signup-form">
    <label for="name">First Name:</label>
    <input type="text" id="firstName" name="firstName" onkeyup="validateFName();" required><br>
    <div id="fname-error" class="error" style="display: none;"></div>

    <label for="username">Last Name:</label>
    <input type="text" id="lastName" name="lastName" onkeyup="validateLName();" required><br>
    <div id="lname-error" class="error" style="display: none;"></div>

    <label for="status">Status:</label>
    <select id="status" required>
    <option value="empty" disabled></option>
      <option value="Super Administrator">Super Admin</option>
      <option value="IT Administrator">IT Admin</option>
    <option value="Enforcer">Enforcer</option>
    </select><br>
    <div class="ticket-container" id="ticket-container">
  <label for="startTicket">Start Ticket Number (for Enforcers):</label>
  <input type="number" id="startTicketInput" name="startTicketInput" oninput="validateInput(this)">
  <div id="start-ticket-error" class="error" style="display: none;"></div>

  <label for="endTicket">End Ticket Number (for Enforcers):</label>
  <input type="number" id="endTicketInput" name="endTicketInput" oninput="validateInput(this)">
  <div id="end-ticket-error" class="error" style="display: none;"></div>
</div>
    <button id="submit-button" type="submit" value="Sign Up">Create Account</button>
    <button type="submit" id="update-button" style="display: none;">Update Account</button>
    <button type="reset"  id="reset-button">Clear</button>
    <button id="delete-button" type="button" style="display: none;">Delete</button>
  </form>
  </div>
  <div class="table-container">
  <table id="user-table">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Status</th>
        <th>Start Ticket</th>
        <th>End Ticket</th>
      </tr>
    </thead>
    <tbody>
      <!-- Table body will be populated dynamically -->
    </tbody>
  </table>
  </div>
  </div>
  <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
  import { getFirestore, collection, doc, addDoc, getDocs, query, where, deleteDoc, updateDoc } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCJYwTjdJbocOuQqUUPPcjQ49Y8R2eng0E",
    authDomain: "ctmeu-d5575.firebaseapp.com",
    databaseURL: "https://ctmeu-d5575-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "ctmeu-d5575",
    storageBucket: "ctmeu-d5575.appspot.com",
    messagingSenderId: "1062661015515",
    appId: "1:1062661015515:web:c0f4f62b1f010a9216c9fe",
    measurementId: "G-65PXT5618B"
  };

   // Initialize Firebase
   initializeApp(firebaseConfig);
    const db = getFirestore();

    // Handle form submission
    const form = document.getElementById('signup-form');
form.addEventListener('submit', (e) => {
  e.preventDefault();

  // Get form values
  const firstName = document.getElementById('firstName').value;
  const lastName = document.getElementById('lastName').value;
  const status = document.getElementById('status').value;
  const startTicket = document.getElementById('startTicketInput').value;
const endTicket = document.getElementById('endTicketInput').value;


let selectedRowUid = null;
  let selectedStartTicket = null;
    let selectedEndTicket = null;

  // Create abbreviated status
  let abbreviatedStatus = '';
  if (status === 'Enforcer') {
    abbreviatedStatus = 'enf';
  } else if (status === 'IT Administrator') {
    abbreviatedStatus = 'ita';
  } else if (status === 'Super Administrator') {
    abbreviatedStatus = 'sua';
  }

  // Generate a random password
  const password = generateRandomPassword();

  function generateRandomPassword() {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const length = 8;
  let password = '';

  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    password += characters.charAt(randomIndex);
  }

  return password;
}

      // Create username based on status and name
      const username = abbreviatedStatus + firstName.charAt(0).toUpperCase() + lastName;
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
  // Get all elements with class "noEnforcers"
  const specialButtons = document.querySelectorAll('.noEnforcers');

  // Loop through each element and hide it
  specialButtons.forEach((button) => {
    button.style.display = 'none';
  });
}
     else {
      console.error('User document not found');
    }// Display the logged-in user's credentials
      const welcomeText = document.getElementById('welcome-text');
      welcomeText.textContent = `Welcome, ${status}: ${firstName} ${lastName}`;
      // Display the logged-in user's credentials
      const fnameText = document.getElementById('fname-text');
      fnameText.textContent = `First Name: ${firstName}`;
      const lnameText = document.getElementById('lname-text');
      lnameText.textContent = `Last Name: ${lastName}`;
      const statText = document.getElementById('stat-text');
      statText.textContent = `Status: ${status}`;
    } else {
      console.error('User document not found');
    }
  })
  .catch((error) => {
    console.error('Error retrieving user document:', error);
  });
      

      const usernameQuery = query(usersCollection, where('username', '==', username));
      

       // Fetch "IT Administrator" users and "Super Administrator" users and check the count
  const itAdminQuery = query(usersCollection, where('status', '==', 'IT Administrator'));
  const superAdminQuery = query(usersCollection, where('status', '==', 'Super Administrator'));


      Promise.all([getDocs(itAdminQuery), getDocs(superAdminQuery)])
    .then(([itAdminSnapshot, superAdminSnapshot]) => {
      if (status === 'IT Administrator' && itAdminSnapshot.size >= 4) {
        alert('Maximum number of IT Administrators reached');
        return;
      }

      if (status === 'Super Administrator' && superAdminSnapshot.size >= 2) {
        alert('Maximum number of Super Administrators reached');
        return;
      }

      getDocs(usernameQuery)
      .then((querySnapshot) => {
        if (querySnapshot.empty) {
          // If username does not exist, add the new document
          addDoc(usersCollection, {
            firstName: firstName,
            lastName: lastName,
            status: status,
            username: username,
            password: password,
            startTicket: status === 'Enforcer' ? Number(startTicket) : null,
            endTicket: status === 'Enforcer' ? Number(endTicket) : null,
          })
            .then(() => {
              console.log('User created successfully!');
              // Reset form
              form.reset();
            })
            .catch((error) => {
              console.error('Error creating user:', error);
            });
        } else {
          // If username exists, update the existing document
          if (selectedRowUid) {
            updateAccount(selectedRowUid, firstName, lastName, status, username, password, startTicket, endTicket);
          } else {
            console.error('Error: UID not provided for updating user');
          }
        }
      })
      .catch((error) => {
        console.error('Error checking username:', error);
      });
    })
    .catch((error) => {
      console.error('Error fetching users:', error);
    });
  
    });

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
      welcomeText.textContent = `Welcome, ${status}: ${firstName} ${lastName}`;
      // Display the logged-in user's credentials
      const fnameText = document.getElementById('fname-text');
      fnameText.textContent = `First Name: ${firstName}`;
      const lnameText = document.getElementById('lname-text');
      lnameText.textContent = `Last Name: ${lastName}`;
      const statText = document.getElementById('stat-text');
      statText.textContent = `Status: ${status}`;
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

    // Fetch user data from Firestore
    const fetchUserData = async () => {
    const usersCollection = collection(db, 'usersCTMEU');
    const querySnapshot = await getDocs(usersCollection);
    const userData = [];

    querySnapshot.forEach((doc) => {
      const data = doc.data();
      const { firstName, lastName, password, status, username } = data;
      userData.push({ firstName, lastName, password, status, username, uid: doc.id });
    });

    return userData;
  };

    // Function to display user data in the table
  const displayUserData = async () => {
    const userData = await fetchUserData();
    const tableBody = document.querySelector('#user-table tbody');

    userData.forEach((user) => {
      const row = document.createElement('tr');
      const { firstName, lastName, password, status, username, startTicket, endTicket, uid } = user; // Retrieve the 'uid' from the user object

        const firstNameCell = document.createElement('td');
        firstNameCell.textContent = firstName;

        const lastNameCell = document.createElement('td');
        lastNameCell.textContent = lastName;

        const passwordCell = document.createElement('td');
        passwordCell.textContent = password;

        const statusCell = document.createElement('td');
        statusCell.textContent = status;

        const usernameCell = document.createElement('td');
        usernameCell.textContent = username;

        const startTicketCell = document.createElement('td');

        const endTicketCell = document.createElement('td');

        // Check if the user is an enforcer and has startTicket and endTicket properties
    if (status === 'Enforcer' && typeof startTicket === 'number' && typeof endTicket === 'number') {
      startTicketCell.textContent = startTicket;
      endTicketCell.textContent = endTicket;
    } else {
      startTicketCell.textContent = ''; // Set to an empty string if not applicable
      endTicketCell.textContent = ''; // Set to an empty string if not applicable
    }

        row.appendChild(firstNameCell);
        row.appendChild(lastNameCell);
        row.appendChild(usernameCell);
        row.appendChild(passwordCell);
        row.appendChild(statusCell);
        row.appendChild(startTicketCell);
        row.appendChild(endTicketCell);

        tableBody.appendChild(row);

        row.setAttribute('data-uid', uid); // Set the data-uid attribute to store the user's uid
        
      });
    };

    // Call the function to display user data
    displayUserData();

    

// Function to delete a user from the table and database
function deleteUser(username) {
    const tableBody = document.querySelector('#user-table tbody');
    const rows = tableBody.getElementsByTagName('tr');
    let rowIndexToDelete = -1;

    // Find the index of the row to delete
    for (let i = 0; i < rows.length; i++) {
      const row = rows[i];
      if (row.cells[2].textContent === username) {
        rowIndexToDelete = i;
        break;
      }
    }

    if (rowIndexToDelete !== -1) {
      // Remove the row from the table
      tableBody.removeChild(rows[rowIndexToDelete]);

      // Delete the user document from Firestore
      deleteUserDocument(username);
    }
  }

    
// Function to delete a user document
function deleteUserDocument(username) {
    // Create a reference to the 'usersCTMEU' collection
    const usersCollection = collection(db, 'usersCTMEU');

    // Create a query to find the document with the provided username
    const queryToDelete = query(usersCollection, where('username', '==', username));
    
    getDocs(queryToDelete)
      .then((querySnapshot) => {
        if (!querySnapshot.empty) {
          // Delete the document from Firestore
          const docSnapshot = querySnapshot.docs[0];
          const docRef = doc(usersCollection, docSnapshot.id);
          return deleteDoc(docRef);
        } else {
          console.error('Error: Account not found.');
        }
      })
      .then(() => {
        console.log('Account deleted successfully.');
        // Refresh the page to show the updated user data
        location.reload();
      })
      .catch((error) => {
        console.error('Error deleting account:', error);
      });
}

  // Add an event listener to the "Delete" button
  document.getElementById('delete-button').addEventListener('click', function (event) {
    const username = selectedRow.cells[2].textContent;
    if (confirm("Are you sure you want to delete the account for username: " + username + "?")) {
      // Call the function to delete the user from the table and the database
      deleteUser(username);

      // Clear the form fields and hide the buttons after deletion
      clearFormFields();
    }
  });

  
// Add an event listener to the "Update" button
document.getElementById('update-button').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const status = document.getElementById('status').value;
    const startTicket = document.getElementById('startTicketInput').value;
    const endTicket = document.getElementById('endTicketInput').value;

    // Create abbreviated status
    let abbreviatedStatus = '';
    if (status === 'Enforcer') {
      abbreviatedStatus = 'enf';
    } else if (status === 'IT Administrator') {
      abbreviatedStatus = 'ita';
    } else if (status === 'Super Administrator') {
      abbreviatedStatus = 'sua';
    }

    // Create username based on status and name
    const username = abbreviatedStatus + firstName.charAt(0).toUpperCase() + lastName;

    // Create a reference to the 'usersCTMEU' collection
    const usersCollection = collection(db, 'usersCTMEU');

    // Create a query to find the document with the selectedRowUid
    const queryToUpdate = query(usersCollection, where('__name__', '==', selectedRowUid));

    // Fetch the existing document data from Firestore
    getDocs(queryToUpdate)
      .then((querySnapshot) => {
        if (!querySnapshot.empty) {
          const docSnapshot = querySnapshot.docs[0];
          const existingData = docSnapshot.data();
          const existingPassword = existingData.password; // Preserve the existing password

          // Update the document with the new data, preserving the existing password
          return updateDoc(doc(usersCollection, docSnapshot.id), {
            firstName: firstName,
            lastName: lastName,
            status: status,
            username: username,
            password: existingPassword, // Use the existing password instead of generating a new one
            startTicket: status === 'Enforcer' ? Number(startTicket) : null,
            endTicket: status === 'Enforcer' ? Number(endTicket) : null,
          });
        } else {
          console.error('Error: Account not found.');
        }
      })
      .then(() => {
        console.log('Account updated successfully.');
        // Clear the form fields and hide the buttons after updating
        clearFormFields();
        // Refresh the page to show the updated user data
        location.reload();
      })
      .catch((error) => {
        console.error('Error updating account:', error);
      });
  });
    
  </script>
  <script>
    

    // Function to populate form fields with the selected row data
  function populateFormFields(row) {
    const firstName = row.cells[0].textContent;
      const lastName = row.cells[1].textContent;
      const status = row.cells[4].textContent; // Status is in the 5th cell (index 4)
      const startTicket = row.cells[5].textContent; // Start Ticket is in the 6th cell (index 5)
      const endTicket = row.cells[6].textContent;

    document.getElementById('firstName').value = firstName;
    document.getElementById('lastName').value = lastName;

    // Set the selected value in the dropdown list based on the status of the row
    const statusDropdown = document.getElementById('status');
    for (let i = 0; i < statusDropdown.options.length; i++) {
      if (statusDropdown.options[i].value === status) {
        statusDropdown.selectedIndex = i;
        break;
      }
    }

    // Show/hide ticket fields based on the selected status
    showHideTicketFields();

    
  }

  // Function to show/hide ticket fields based on the selected status
  function showHideTicketFields() {
    const status = document.getElementById('status').value;
    const ticketContainer = document.querySelector('.ticket-container');

    if (status === 'Enforcer') {
    ticketContainer.style.display = 'block';
    document.getElementById('startTicketInput').required = true;
    document.getElementById('endTicketInput').required = true;
  } else {
    ticketContainer.style.display = 'none';
    document.getElementById('startTicketInput').required = false;
    document.getElementById('endTicketInput').required = false;
  }
  }




  // Add click event listener to the table rows instead of individual cells
  document.getElementById('user-table').addEventListener('click', function (event) {
    // Get the clicked row and its cells
    const row = event.target.parentElement;
    const cells = row.cells;

    // If a row is clicked and not the table header row
    if (row && row.rowIndex > 0) {
      selectedRowUid = row.getAttribute('data-uid');
      // Populate form fields with the selected row data
      populateFormFields(row);

      // Show the "Update Account" button and "Delete" button
      document.getElementById('submit-button').style.display = 'none';
      document.getElementById('update-button').style.display = 'inline-block';
      document.getElementById('delete-button').style.display = 'inline-block';

      
      
    } else {
      // Clear the form fields and hide the buttons
      clearFormFields();
      document.getElementById('submit-button').style.display = 'inline-block';
      document.getElementById('update-button').style.display = 'none';
      document.getElementById('delete-button').style.display = 'none';

    }
  });

  

    function validateFName() {
      var nameInput = document.getElementById("firstName");
      var nameError = document.getElementById("fname-error");
      
      if (nameInput.value.length < 3) {
        nameError.innerHTML = "Name must be at least 3 characters long.";
        nameError.style.display = "block";
      } else {
        nameError.style.display = "none";
      }
    }

    function validateLName() {
      var nameInput = document.getElementById("lastName");
      var nameError = document.getElementById("lname-error");
      
      if (nameInput.value.length < 3) {
        nameError.innerHTML = "Name must be at least 3 characters long.";
        nameError.style.display = "block";
      } else {
        nameError.style.display = "none";
      }
    }

    var selectedRow = null;


    // Function to clear the form fields
    function clearFormFields() {
    selectedRow = null;
    document.getElementById("signup-form").reset();
    document.getElementById("submit-button").textContent = "Create Account";
    document.getElementById("submit-button").style.display = "inline-block";
    document.getElementById("update-button").style.display = "none";
    document.getElementById("delete-button").style.display = "none";
  }

  document.getElementById('reset-button').addEventListener('click', function (event) {
    // Clear the form fields and reset buttons' state
    clearFormFields();
  });


    document.getElementById("user-table").addEventListener("click", function(event) {
  var row = event.target.parentElement;
  if (selectedRow !== row) {
    populateFormFields(row);
    selectedRow = row;
    document.getElementById("submit-button").textContent = "Update";
    document.getElementById("delete-button").style.display = "inline-block";
  } else {
    clearFormFields();
    document.getElementById("delete-button").style.display = "none";
  }
});


function validateInput(input) {
    const maxLength = 9;
    if (input.value.length > maxLength) {
      input.value = input.value.slice(0, maxLength);
    }
  }

    

    function showHideTicketFields() {
    const status = document.getElementById('status').value;
    const ticketContainer = document.querySelector('.ticket-container');

    if (status === 'Enforcer') {
      ticketContainer.style.display = 'block';
    } else {
      ticketContainer.style.display = 'none';
    }
  }

   // Add an event listener to the status dropdown to trigger the show/hide function
   document.getElementById('status').addEventListener('change', showHideTicketFields);

// Call the show/hide function initially to set the correct display on page load
showHideTicketFields();

  </script>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>