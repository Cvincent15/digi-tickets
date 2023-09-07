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
  <link rel="stylesheet" href="css/motorist.css"/>
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
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
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png');">
<div class="container min-vh-100 text-center justify-content-center align-items-center">
  <div class="row">
    <div class="col">
      <h4>City Traffic Management and Enforcement Unit</h4>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h1>Motorist Portal</h1>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <img src="./images/ctmeu.png">
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h3>A front line government agency showcasing fast and efficient public service for a progressive land transport sector</h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
    <button type="button" class="btn btn-success btn-lg" style="background-color: #5CBA13;" onclick="redirectToRegister()">Register</button>
        <button type="button" class="btn btn-outline-light btn-lg" onclick="redirectToLogin()">Log In</button>
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