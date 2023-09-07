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
      $licenseNo = $user["driver_license"];
      $expiry = $user["driver_license_expiry"];
      $serialNo = $user["driver_license_serial"];
      $citizenship = $user["is_filipino"];
      $driverLname = $user["driver_last_name"];
      $driverMname = $user["driver_middle_name"];
      $birthday = $user["driver_birthday"];
      $gender = $user["driver_gender"];
      $motherLname = $user["mother_last_name"];
      $motherFname = $user["mother_first_name"];
      $motherMname = $user["mother_middle_name"];
      $email = $user["driver_email"];
      $phone = $user["driver_phone"];
      $password = $user["driver_password"];


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
  <link rel="stylesheet" href="css/motorist.css"/>
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.11.14/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
            <a class="nav-link" href="#">LTO Official Page</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="motoristlogin.php">Dashboard</a>
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

<div class="masthead" style="background-image: url('./images/mainbg.png'); padding-top: 60px; padding-bottom: 60px;" >
<section class="container bg-white w-75 text-dark mx-auto p-2 rounded-5">
<form id="profileForm" action="#!">
  <div class="row d-flex justify-content-center align-items-center"><div class="col-md-auto mb-4"><h1 class="reg"><img src="./images/Vector.png" style="margin-right: 10px;">Profile</h1></div></div>
  <ul class="nav nav-pills ms-4">
  <li class="nav-item me-4">
    <a class="nav-link active" aria-current="page" href="#">Show All</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#">Account</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#">Contact</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#">Personal</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#">Emergency</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#">Address</a>
  </li>
</ul>

<div class="container m-4">
        <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Account</h2>
        </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="<?php echo "".$driverFirstName;  ?>" name="fullname">
            </div>   
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="First Name" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Last Name" name="fullname">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Middle Name" name="fullname">
            </div>   
          </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Contact</h2>
        </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Email" name="fullname">
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Intl. Area Code" name="fullname">
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Mobile Number" name="fullname">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Middle Name" name="fullname">
            </div>   
          </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">General Information</h2>
        </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Nationality" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Civil Status" name="fullname">
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Birthdate" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Birthplace" name="fullname">
            </div> 
          </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Medical Information</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Gender" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Blood Type" name="fullname">
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Complexion" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Body Type" name="fullname">
            </div> 
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Eye Color" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Hair Color" name="fullname">
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Weight" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Height" name="fullname">
            </div> 
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Organ Donor" name="fullname">
            </div>
        </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Emergency Contact</h2>
        </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Name" name="fullname">
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Intl. Area Code" name="fullname">
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Mobile Number" name="fullname">
            </div>
        </div>
        <div class="row">
            <div class="col">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Address" name="fullname">
            </div>   
          </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Registered Address</h2>
        </div>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Address" name="fullname">
            </div>
        </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Permanent Address</h2>
        </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="House Number" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Street/Village" name="fullname">
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Provice" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="City/Municipality" name="fullname">
            </div> 
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Barangay" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Zip Code" name="fullname">
            </div>
        </div>
      </div>
        <!-- start previous / next buttons -->
        <div class="form-footer d-flex justify-content-between">
    <button class="btn btn-danger ms-4" type="button" id="prevBtn" onclick="nextPrev(-1)">Cancel</button>
    <button class="btn btn-outline-primary me-4" type="button" id="nextBtn" onclick="nextPrev(1)">Save Changes</button>
</div>
        <!-- end previous / next buttons -->
    </form>
   </section>
</div>
    <script>
    function redirectToRegister() {
      window.location.href = 'motoristSignup.php';
    }

    function redirectToLogin() {
      window.location.href = 'motorist_login.php';
    }
  </script>
  <script>
    $(document).ready(function() {
      $('#datepicker').datepicker();
    });
  </script>
  <script src="./js/stepper.js"></script>
</body>
</html>