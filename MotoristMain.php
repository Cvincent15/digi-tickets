<?php
session_start();
include 'php/database_connect.php';

// Check if the user is logged in (you may want to add additional checks)
if (isset($_SESSION['email'])) {
  // Retrieve the session email
  $email = $_SESSION['email'];

  // Prepare a query to fetch user information based on the session email
  $stmt = $conn->prepare("SELECT * FROM users_motorists WHERE driver_email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();
  
  // Check if a row with the session email exists
  if ($result->num_rows > 0) {
      // Fetch the user's information
      $user = $result->fetch_assoc();
      $driverFirstName = $user['driver_first_name'];

      // Now, you can access the user's information, e.g., $user['driver_name'], $user['driver_age'], etc.
  } else {
      // User not found in the database
      echo "User not found in the database.";
  }

  // Close the statement
  $stmt->close();
} else {
  // Redirect the user to the login page if not logged in
  header("Location: ../motoristlogin.php");
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
          <li class="nav-item">
            <!-- <a class="nav-link" href="motoristlogin.php">Dashboard</a> -->
          </li>
        </ul>
      <div class="dropdown">
  <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <img src="./images/Icon.png" style="margin-right: 10px;"><?php echo "".$driverFirstName;  ?>
  </a>

  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="php/logoutM.php" id="logout-button">Logout?</a></li>
  </ul>
</div>
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