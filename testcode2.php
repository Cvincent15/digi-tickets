<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <style>
    .error {
      color: red;
    }
  </style>
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
  </script>
</head>
<body>
  <h1>Registration Form</h1>
  <form>
    <label for="name">Name:</label>
    <input class="acc" type="text" id="name" onkeyup="validateName();" oninput="validateInput(this);" required>
    <div id="name-error" class="error" style="display: none;"></div>

    <label for="username">Username:</label>
    <input class="acc" type="text" id="username" onkeyup="validateUsername();" oninput="validateInput(this);" required>
    <div id="username-error" class="error" style="display: none;"></div>

    <label for="password">Password:</label>
    <input class="acc" type="password" id="password" onkeyup="validatePassword();" oninput="validateInput(this);" required>
    <div id="password-error" class="error" style="display: none;"></div>
  </form>
</body>
</html>