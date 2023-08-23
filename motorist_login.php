<?php
session_start();
include './php/database_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CTMEU</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/motorist.css"/>
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>

<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #FFFFFF">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-top">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> Motorist Portal
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
          <li class="nav-item">
            <a class="nav-link" href="#">LTO Official Page</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
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
<div class="col login">         
  <div class="mb-3 mt-3">
  <form action="./php/motoristlogin.php" method="post">
    <label for="email" class="form-label"></label>
    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
  </div>
  <div class="mb-3">
    <label for="pwd" class="form-label"></label>
    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
  </div>
  <?php if (isset($login_error)) { ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $login_error; ?>
        </div>
      <?php } ?>
  <div class="form-check mb-3">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" name="remember"> Remember me
    </label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<p>Dont Have an Account? <a href="motoristSignup.php">Create One</a></p>
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