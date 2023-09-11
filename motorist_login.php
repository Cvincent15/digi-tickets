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
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-top">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> Motorist Portal
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
          <li class="nav-item">
            <a class="nav-link" href="https://portal.lto.gov.ph/">LTO Official Page</a>
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
  <form method="POST" action="./php/motoristlogin.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-Mail</label>
                                <input type="text" class="form-control" id="email" name="email" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required maxlength="20">
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
    function redirectToRegister() {
      window.location.href = 'motoristSignup.php';
    }

    function redirectToLogin() {
      window.location.href = 'motorist_login.php';
    }
  </script>
</body>
</html>