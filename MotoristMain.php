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
          <li class="nav-item">
            <a class="nav-link" href="#">Dashboard</a>
          </li>
        </ul>
      <button class="btn transparent-btn me-2 btn-outline-primary">Register</button>
      <button class="btn transparent-btn btn-outline-primary">Login</button>
    </div>
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png');">
<div class="container min-vh-100 text-center justify-content-center align-items-center">
<div class="row min-vh-100 justify-content-center align-items-center">
  <div class="col">
    <h1 style="font-size:60px;">Welcome, User</h1></br>
    <h2>What would you like to do?</h2> </br>
    <button type="button" class="btn btn-light btn-lg main" onclick="redirectToProfile()"><img src="./images/Vector.png"></br>Profile</button>
    <button type="button" class="btn btn-light btn-lg main" onclick="redirectToId()"><img src="./images/alternatecard.png"></br>Digital ID</button>
    <button type="button" class="btn btn-light btn-lg main" onclick="redirectToTransaction()"><img src="./images/alternateinvoice.png"></br>Transactions</button> </br></br>
    <button type="button" class="btn btn-light btn-lg main" onclick="redirectToViolation()"><img src="./images/gavel.png"></br>Violations</button>
    <button type="button" class="btn btn-light btn-lg main" onclick="redirectToDocuments()"><img src="./images/alternate_file.png"></br>Documents</button>
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

    function redirectToProfile() {
      window.location.href = 'MotoristProfile.php';
    }

    function redirectToId() {
      window.location.href = 'MotoristId.php';
    }

    function redirectToTransaction() {
      window.location.href = 'MotoristTransaction.php';
    }

    function redirectToViolation() {
      window.location.href = 'MotoristViolations.php';
    }

    function redirectToDocuments() {
      window.location.href = 'MotoristDocuments.php';
    }
  </script>
</body>
</html>