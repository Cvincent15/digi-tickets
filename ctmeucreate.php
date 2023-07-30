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
      width: 100%;
    }

    th, td {
      text-align: left;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }

    form {
      margin-bottom: 20px;
    }

    input[type="text"], input[type="password"], select {
      width: 100%;
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
    <option value="Enforcer">Enforcer</option>
      <option value="IT Administrator">IT Admin</option>
      <option value="Super Administrator">Super Admin</option>
    </select><br>

    <button id="submit-button" type="submit" value="Sign Up">Generate Account</button>
    <button type="reset">Clear</button>
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
  import { getFirestore, collection, doc, addDoc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";
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

      // Add the new document for IT Administrator or Super Administrator
      addDoc(usersCollection, {
        firstName: firstName,
        lastName: lastName,
        status: status,
        username: username,
        password: password
      })
      .then(() => {
        console.log('User created successfully!');
        // Reset form
        form.reset();
      })
      .catch((error) => {
        console.error('Error creating user:', error);
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

      if (status === 'IT Administrator') {
              // Disable the "Super Administrator" option for IT Administrators
              const statusSelect = document.getElementById('status');
              const superAdminOption = statusSelect.querySelector('option[value="Super Administrator"]');
              superAdminOption.disabled = true;
            }

      // Display the logged-in user's credentials
      const welcomeText = document.getElementById('welcome-text');
      welcomeText.textContent = `Welcome, ${status}: ${firstName} ${lastName}`;
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
        userData.push({ firstName, lastName, password, status, username });
      });

      return userData;
    };

    // Display user data in the table
    const displayUserData = async () => {
      const userData = await fetchUserData();
      const tableBody = document.querySelector('#user-table tbody');

      userData.forEach((user) => {
        const row = document.createElement('tr');
        const { firstName, lastName, password, status, username } = user;

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

        row.appendChild(firstNameCell);
        row.appendChild(lastNameCell);
        row.appendChild(usernameCell);
        row.appendChild(passwordCell);
        row.appendChild(statusCell);

        tableBody.appendChild(row);

        
      });
    };

    // Call the function to display user data
    displayUserData();
  </script>
  <script>

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
      document.getElementById("submit-button").textContent = "Submit";
    }

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

document.getElementById("delete-button").addEventListener("click", function(event) {
  if (selectedRow) {
    var username = selectedRow.cells[1].innerHTML;
    if (confirm("Are you sure you want to delete the account for username: " + username + "?")) {
      // Send an AJAX request to delete the account
      var xhttp = new XMLHttpRequest();
      xhttp.open("POST", "php/deleteaccount.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          alert(this.responseText);
          clearFormFields();
          document.getElementById("delete-button").style.display = "none";
          location.reload(); // Refresh the page
        }
      };
      xhttp.send("username=" + username);
    }
  }
});



    document.getElementById("signup-form").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent form submission

      var name = document.getElementById("name").value;
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      var status = document.getElementById("status").value;

      if (selectedRow) {
        // Update the selected row
        selectedRow.cells[0].innerHTML = name;
        selectedRow.cells[1].innerHTML = username;
        selectedRow.cells[2].innerHTML = password;
        selectedRow.cells[3].innerHTML = status;
        clearFormFields();
      } else {
        // Add a new row to the table
        var table = document.getElementById("user-table").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        var nameCell = newRow.insertCell(0);
        var usernameCell = newRow.insertCell(1);
        var passwordCell = newRow.insertCell(2);
        var statusCell = newRow.insertCell(3);

        nameCell.innerHTML = name;
        usernameCell.innerHTML = username;
        passwordCell.innerHTML = password;
        statusCell.innerHTML = status;
      }

      document.getElementById("signup-form").reset();
    });
  </script>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>