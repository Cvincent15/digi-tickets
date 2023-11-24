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
      
      // Fetch the users_motorists_info_id
      $usersMotoristsInfoId = $user["user_id"];

      // Check if there is data in the motorist_info table for this user
    $stmt = $conn->prepare("SELECT * FROM motorist_info WHERE users_motorists_info_id = ?");
    $stmt->bind_param("i", $usersMotoristsInfoId);
    $stmt->execute();
    $motoristInfoResult = $stmt->get_result();

    if ($motoristInfoResult->num_rows > 0) {
        // Fetch the data from motorist_info
        $motoristInfo = $motoristInfoResult->fetch_assoc();
        
        // Populate the required input fields with data from motorist_info
        $civilStatus = $motoristInfo['civil_status'];
        $birthplace = $motoristInfo['birthplace'];
        $bloodType = $motoristInfo['blood_type'];
        $complexion = $motoristInfo['complexion'];
        $eyeColor = $motoristInfo['eye_color'];
        $hairColor = $motoristInfo['hair_color'];
        $weight = $motoristInfo['weight'];
        $height = $motoristInfo['height'];
        $organDonor = $motoristInfo['organ_donor'];
        
        // You can also populate other required fields here

        // You can also set a flag to indicate that data was found in motorist_info
        $motoristInfoExists = true;
    } else {
        // Data not found in motorist_info, set the flag to false
        $motoristInfoExists = false;
    }

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
  <img src="./images/ctmeusmall.png" class="d-inline-block align-text-middle">
  <span style="color: #1D3DD1; font-weight: bold;">CTMEU</span> <span style="font-weight: 600;">Motorist Portal</span>
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex">
        <ul class="navbar-nav me-2">
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
    <li><a class="dropdown-item" href="MotoristID.php">Digital ID</a></li>
    <li><a class="dropdown-item" href="MotoristTransaction.php">Transactions</a></li>
    <li><a class="dropdown-item" href="MotoristViolations.php">Violations</a></li>
    <li><a class="dropdown-item" href="MotoristDocuments.php">Documents</a></li>
    <li><a class="dropdown-item" href="php/logoutM.php" id="logout-button"><img src="./images/icon _logout_.png"> Log Out</a></li>
  </ul>
</div>
    </div>
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png'); padding-top: 60px; padding-bottom: 60px;" >
<section class="container bg-white w-75 text-dark mx-auto p-2 rounded-5">
<form id="profileForm" action="php/process_profile.php" method="post">
  <div class="row d-flex justify-content-center align-items-center"><div class="col-md-auto mb-4"><h1 class="reg"><img src="./images/Vector.png" style="margin-right: 10px;">Profile</h1></div></div>
  <ul class="nav nav-pills ms-4 justify-content-center align-items-center">
  <!--<li class="nav-item me-4">
    <a class="nav-link active" aria-current="page" href="#ShowAll">Show All</a>
  </li> -->
  <li class="nav-item me-4">
    <a class="nav-link" href="#Account">Account</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#Contact">Contact</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#Personal">Personal</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#Emergency">Emergency</a>
  </li>
  <li class="nav-item me-4">
    <a class="nav-link" href="#Address">Address</a>
  </li>
</ul>

<div class="container m-4" id="ShowAll">
        <div id="Account">
        <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Account</h2>
        </div>
        <input type="hidden" name="users_motorists_info_id" value="<?php echo $usersMotoristsInfoId; ?>">

          <div class="row">
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="input1" value="<?php echo "".$driverFirstName." ".$driverMname." ".$driverLname;  ?>" name="fullname" readonly>
            </div>   
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input2"  value="<?php echo "".$driverFirstName;  ?>" name="dfname" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="input3"  value="<?php echo "".$driverLname;  ?>" name="dlname" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input4"  value="<?php echo "".$driverMname;  ?>" name="dmname" readonly>
            </div>   
          </div>
          </div>
          <div id="Contact">
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Contact</h2>
        </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input5"  value="<?php echo "".$email;  ?>" name="demail" readonly>
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control" id="input6"  placeholder="Area Code" name="dacode" minlength="4" maxlength="4" required>
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control" id="input7"  value="<?php echo "".$phone;  ?>" name="dmobile" readonly>
            </div>
        </div>
        </div>
        <div id="Personal">
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">General Information</h2>
        </div>
          <div class="row">
          <div class="col-md-6">
            <input type="text" class="form-control" id="input1"  value="<?php echo ($citizenship == 1) ? 'Filipino' : 'Non-Filipino'; ?>" name="citizenship" readonly>
          </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker"  placeholder="Civil Status" minlength="5" maxlength="20" value="<?php echo isset($motoristInfo['civil_status']) ? $motoristInfo['civil_status'] : ''; ?>" name="civilstatus" required>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
              <input type="date" class="form-control" id="input1"  value="<?php echo $birthday;  ?>" name="birthday" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker"  placeholder="Birthplace" value="<?php echo isset($motoristInfo['birthplace']) ? $motoristInfo['birthplace'] : ''; ?>" maxlength="20" minlength="5" name="birthplace" required>
            </div> 
          </div>
          </div>
          <div class="row">
              <h2 class="h2 field mb-0 mt-4 mb-2">Medical Information</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1"  value="<?php echo "".$gender;  ?>" name="gender" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" value="<?php echo isset($motoristInfo['blood_type']) ? $motoristInfo['blood_type'] : ''; ?>"  placeholder="Blood Type" minlength="1" maxlength="3" name="bloodtype" required>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
              <input type="text" class="form-control" id="input1"  placeholder="Complexion" value="<?php echo isset($motoristInfo['complexion']) ? $motoristInfo['complexion'] : ''; ?>" maxlength="15" minlength="5" name="complexion" required>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="input1"  placeholder="Organ Donor" minlength="4" maxlength="20" name="organdonor" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1"  placeholder="Eye Color" value="<?php echo isset($motoristInfo['eye_color']) ? $motoristInfo['eye_color'] : ''; ?>" maxlength="10" minlength="3" name="eyecolor" required>
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker"  placeholder="Hair Color" value="<?php echo isset($motoristInfo['hair_color']) ? $motoristInfo['hair_color'] : ''; ?>" maxlength="10" minlength="3" name="haircolor" required>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
  <input type="number" class="form-control" id="input1" placeholder="60" value="<?php echo isset($motoristInfo['weight']) ? $motoristInfo['weight'] : ''; ?>" name="weight" required
    min="20" max="300">
</div>

<div class="col-md-6 mb-3">
  <input type="number" class="form-control" id="datepicker" placeholder="167.64" value="<?php echo isset($motoristInfo['height']) ? $motoristInfo['height'] : ''; ?>" name="height" required
    min="150" max="250">
</div>

          </div>
          <div id="Emergency">
    <div class="row">
        <h2 class="h2 field mb-0 mt-4 mb-2">Emergency Contact</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control" id="input1" value="<?php echo isset($motoristInfo['em_name']) ? $motoristInfo['em_name'] : ''; ?>" placeholder="Name" maxlength="30" minlength="5" name="emname" required>
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" class="form-control" id="datepicker" value="<?php echo isset($motoristInfo['em_area_code']) ? $motoristInfo['em_area_code'] : ''; ?>" placeholder="Intl. Area Code" maxlength="4" minlength="4" name="emareacode" required>
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" class="form-control" id="datepicker" value="<?php echo isset($motoristInfo['em_mobile']) ? $motoristInfo['em_mobile'] : ''; ?>" placeholder="Mobile Number" minlength="13" maxlength="13" name="emmobile" required>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="input1" value="<?php echo isset($motoristInfo['em_address']) ? $motoristInfo['em_address'] : ''; ?>" placeholder="Address" minlength="5" maxlength="20" name="emaddress" required>
        </div>
    </div>
</div>
          <div id="Address">
    <div class="row">
        <h2 class="h2 field mb-0 mt-4 mb-2">Registered Address</h2>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="input1" value="<?php echo isset($motoristInfo['address']) ? $motoristInfo['address'] : ''; ?>" placeholder="Address" name="address" required>
        </div>
    </div>
</div>
      </div>
        <!-- start previous / next buttons -->
        <div class="form-footer d-flex justify-content-between">
    <button class="btn btn-danger ms-4" type="button" id="prevBtn" onclick="redirectToMain()">Cancel</button>
    <button class="btn btn-outline-primary me-4" type="submit" id="submitBtn">Save Changes</button>
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

    function redirectToMain() {
      window.location.href = 'MotoristMain.php';
    }
  </script>
</body>
</html>