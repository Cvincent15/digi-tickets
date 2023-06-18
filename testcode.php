<?php
include 'php/database_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    .container {
      display: flex;
      justify-content: space-between;
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
</head>
<body>
  <div class="container">
    <div class="form-container">
  <form id="create-account-form" method="POST" action="php/createaccount.php">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" onkeyup="validateName();" oninput="validateInput(this);" required><br>
    <div id="name-error" class="error" style="display: none;"></div>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" onkeyup="validateUsername();" oninput="validateInput(this);" required><br>
    <div id="username-error" class="error" style="display: none;"></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" onkeyup="validatePassword();" oninput="validateInput(this);" required><br>
    <div id="password-error" class="error" style="display: none;"></div>

    <label for="status">Status:</label>
    <select id="status" name="status">
    <option value="empty"></option>
      <option value="Enforcer">Enforcer</option>
      <option value="IT Personnel">IT Personnel</option>
      <option value="Super Admin">Super Admin</option>
    </select><br>

    <button id="submit-button" type="submit">Submit</button>
    <button type="reset">Clear</button>
  </form>
  </div>
  <div class="table-container">
  <?php
  
// Retrieve the user accounts from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table id='user-table'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["name"]."</td>
                <td>".$row["username"]."</td>
                <td>".$row["password"]."</td>
                <td>".$row["status"]."</td>
              </tr>";
    }

    echo "</tbody>
        </table>";
} else {
    echo "No user accounts found.";
}

  ?>
  </div>
  </div>
  <script>
function validateInput(input) {
      const regex = /^[a-zA-Z0-9]+$/; // Alphanumeric regex pattern
      const value = input.value;

      if (!regex.test(value)) {
        input.style.borderColor = "red";
      } else {
        input.style.borderColor = "";
      }
    }

    function validateName() {
      var nameInput = document.getElementById("name");
      var nameError = document.getElementById("name-error");
      
      if (nameInput.value.length < 3) {
        nameError.innerHTML = "Name must be at least 3 characters long.";
        nameError.style.display = "block";
      } else {
        nameError.style.display = "none";
      }
    }

    function validateUsername() {
      var usernameInput = document.getElementById("username");
      var usernameError = document.getElementById("username-error");

      if (usernameInput.value.length < 5) {
        usernameError.innerHTML = "Username must be at least 5 characters long.";
        usernameError.style.display = "block";
      } else {
        usernameError.style.display = "none";
      }
    }

    function validatePassword() {
      var passwordInput = document.getElementById("password");
      var passwordError = document.getElementById("password-error");

      if (passwordInput.value.length < 8) {
        passwordError.innerHTML = "Password must be at least 8 characters long.";
        passwordError.style.display = "block";
      } else {
        passwordError.style.display = "none";
      }
    }

    var selectedRow = null;

    // Function to populate the form fields with the selected row data
    function populateFormFields(row) {
      var nameField = document.getElementById("name");
      var usernameField = document.getElementById("username");
      var passwordField = document.getElementById("password");
      var statusField = document.getElementById("status");

      nameField.value = row.cells[0].innerHTML;
      usernameField.value = row.cells[1].innerHTML;
      passwordField.value = row.cells[2].innerHTML;
      statusField.value = row.cells[3].innerHTML;
    }

    // Function to clear the form fields
    function clearFormFields() {
      selectedRow = null;
      document.getElementById("create-account-form").reset();
      document.getElementById("submit-button").textContent = "Submit";
    }

    document.getElementById("user-table").addEventListener("click", function(event) {
      var row = event.target.parentElement;
      if (selectedRow !== row) {
        populateFormFields(row);
        selectedRow = row;
        document.getElementById("submit-button").textContent = "Update";
      } else {
        clearFormFields();
      }
    });

    document.getElementById("create-account-form").addEventListener("submit", function(event) {
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

      document.getElementById("create-account-form").reset();
    });
  </script>
</body>
</html>