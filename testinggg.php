<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .form-container {
      max-width: 400px;
      margin: 50px auto;
    }

    label {
      display: block;
      margin-bottom: 8px;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-top: -8px;
      margin-bottom: 16px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <form action="your-server-endpoint" method="post" onsubmit="return validateForm()">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" oninput="validateUsername()">
    <div class="error" id="username-error"></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" oninput="validatePassword()">
    <div class="error" id="password-error"></div>

    <button type="submit">Create Account</button>
  </form>
</div>

<script>
  function validateUsername() {
    var username = document.getElementById('username').value;
    var usernameError = document.getElementById('username-error');

    // Your validation logic for the username
    if (username.length < 5) {
      usernameError.textContent = 'Username must be at least 5 characters long.';
    } else {
      usernameError.textContent = '';
    }
  }

  function validatePassword() {
    var password = document.getElementById('password').value;
    var passwordError = document.getElementById('password-error');

    // Your validation logic for the password
    if (password.length < 8) {
      passwordError.textContent = 'Password must be at least 8 characters long.';
    } else {
      passwordError.textContent = '';
    }
  }

  function validateForm() {
    // Additional validation logic for the entire form if needed
    // Return true to submit the form, or false to prevent submission
    return true;
  }
</script>

</body>
</html>
