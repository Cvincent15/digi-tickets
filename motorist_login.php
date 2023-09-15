<?php
session_start();
include 'php/database_connect.php';

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // Redirect the user to the greeting page if they are already logged in
    header("Location: MotoristMain.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CTMEU</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/motorist.css"/>
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>

<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFFFFF">
  <div class="container-fluid">
  <a class="navbar-brand" href="motoristlogin.php">
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-middle">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> <span style="font-weight: 600;">Motorist Portal</span>
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
          <li class="nav-item">
            <a class="nav-link" href="https://portal.lto.gov.ph/" style="font-weight: 600;">LTO Official Page</a>
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" href="#">Contact</a> -->
          </li>
        </ul>
        <button type="button" class="btn transparent-btn btn-outline-primary" style="margin-right: 20px;" onclick="redirectToRegister()">Register</button>
        <button type="button" class="btn class=btn btn-primary active" onclick="redirectToLogin()">Log In</button>
    </div>
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png');">
    <div class="container text-center">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col">
              <p>City Traffic Management and Enforcement Unit</p>
              <h1>Motorist Portal</h1>
              <img src="./images/ctmeu.png">
          </div>
<div class="col login rounded-4">         
  <div class="mb-3 mt-3">
  <div class="toplayer login-card-body p-5 rounded-4">
  <form class="form-floating mb-3" method="POST" action="./php/motoristlogin.php" id="loginM">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="email" placeholder="email" name="email" required maxlength="50">
                                <label for="email" class="form-label">E-Mail</label>
                            </div>
                            <div class="form-floating mb-3" style="position: relative;">
    <input type="password" class="form-control" id="password" placeholder="password" name="password" required maxlength="20">
    <label for="password" class="form-label">Password</label>
    <button type="button" id="togglePassword" class="btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">Show</button>
</div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
<p class="mt-3">Dont Have an Account? <a href="motoristSignup.php">Create One</a></p>
            </div>
  </div>
        </div>
    </div>
</div>
    <script>
      // Apply symbol restriction to all text input fields
const form = document.getElementById('loginM');
const inputs = form.querySelectorAll('input[type="text"], input[type="password"]');

inputs.forEach(input => {
    input.addEventListener('input', function (e) {
        const inputValue = e.target.value;
        const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 @.\-]/g, ''); // Allow letters, numbers, spaces, @ symbol, and hyphens
        e.target.value = sanitizedValue;
    });
});

    function redirectToRegister() {
      window.location.href = 'motoristSignup.php';
    }

    function redirectToLogin() {
      window.location.href = 'motorist_login.php';
    }

    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');

    toggleButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            toggleButton.textContent = 'Show';
        }
    });

  </script>
</body>
</html>