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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
  /* Hide the radio buttons */
.btn-check {
    display: none;
}

/* Style the labels to look like buttons */
.btn-outline-primary {
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
}

/* Style the labels when selected */
.btn-check:checked + .btn-outline-primary {
    background-color: #007bff;
    color: #fff;
}
</style>

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
            <!-- <a class="nav-link" href="#">Contact</a> -->
          </li>
        </ul>
        <button type="button" class="btn class=btn btn-primary active" style="margin-right: 20px;" onclick="redirectToRegister()">Register</button>
        <button type="button" class="btn transparent-btn btn-outline-primary" onclick="redirectToLogin()">Log In</button>
    </div>
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png'); padding-top: 60px;" >
<section class="container bg-white w-75 text-dark mx-auto p-2 rounded-5">
<form id="signUpForm" action="php/motoristSigning.php" method="POST">
  <div class="row d-flex justify-content-center"><div class="col-md-auto mb-4"><h1 class="reg">Registration</h1></div></div>
        <!-- start step indicators -->
        <div class="form-header d-flex mb-4">
            <span class="stepIndicator">Existing License</span>
            <span class="stepIndicator">Nationality</span>
            <span class="stepIndicator">Personal Details</span>
            <span class="stepIndicator">Contact and Password</span>
        </div>
        <!-- end step indicators -->
    
        <!-- step one -->
        <div class="step">
            <p class="text-center mb-4"><img src="./images/Sample License.png"></br><a href="#" style="text-decoration: none;">Show Backside</a></br>Do you have a Philippine Driver's License or Conductor's License?</p>
            <div class="row d-flex justify-content-center">
            <div class="col-md-auto mb-4">
            <input type="checkbox" class="btn-check" id="btn-check-outlined-1" autocomplete="off">
            <label class="btn btn-outline-primary" for="btn-check-outlined-1">Yes</label><br>
            </div>
            <div class="col-md-auto mb-4">
              <input type="checkbox" class="btn-check" id="btn-check-outlined-2" autocomplete="off">
              <label class="btn btn-outline-primary" for="btn-check-outlined-2">No</label><br>
            </div>
        </div>
            <div >
            <div id="license-options" style="display: none;">
            <input type="checkbox" class="btn-check" id="btn-check-outlined-3" autocomplete="off">
              <label class="btn btn-outline-primary" for="btn-check-outlined-3">Driver's License</label><br>
            <input type="checkbox" class="btn-check" id="btn-check-outlined-4" autocomplete="off">
              <label class="btn btn-outline-primary" for="btn-check-outlined-4">Conductor's License</label><br>
            </div>
            <div id="input-fields" style="display: none;">
        <div class="row mt-4">
              <h2 class="h3 field mb-4">Complete all applicable fields</h2>
        </div>
        <div class="row">
              <h2 class="h2 field mb-4">Driver's License</h2>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="License No." name="licenseNo" minlength="10" maxlength="20"  >
            </div>
            <div class="col-md-6 mb-3">
              <input type="date" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Expiry Date" name="expiry" max="9999-12-31" min="1970-01-01">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Serial No. (back of your card)" name="serialNo" minlength="12" maxlength="12"  >
            </div>
        </div>
      </div>
        </div>
            </div>
        </div>
        
        
    
        <!-- step two -->
        <div class="step">
    <h2 class="text-center mb-4 mt-4">Are you a Filipino Citizen?</h2>
    <div class="row d-flex justify-content-center">
        <div class="col-md-auto mb-4">
            <input type="radio" class="btn-check" name="citizenship" id="btn-check-yes" autocomplete="off" value="1">
            <label class="btn btn-outline-primary" for="btn-check-yes">Yes</label><br>
        </div>
        <div class="col-md-auto mb-4">
            <input type="radio" class="btn-check" name="citizenship" id="btn-check-no" autocomplete="off" value="0">
            <label class="btn btn-outline-primary" for="btn-check-no">No</label><br>
            </div>
        </div>
    </div>
    
        <!-- step three -->
        <div class="step">
        <div class="container">
          <div class="row">
          <h2 class="h3 field mb-4">Name</h2>
            <div class="col-md-6">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Last Name" name="driverLname" minlength="5" maxlength="20"  >
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="First Name" name="driverFname" minlength="5" maxlength="20"  >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Middle Name" name="driverMname" minlength="5" maxlength="20"  >
            </div>
        </div>
      </div>
      <div class="container">
          <div class="row">
          <h2 class="h3 field mb-4">Birthdate</h2>
          <div class="col-md-6 mb-3">
              <input type="date" class="form-control" id="datepicker2" oninput="this.className = ''" placeholder="Date of Birth" name="birthday">
            </div>
            <div class="col-md-6">
              <select class="form-control" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <h2 class="h3 field mb-4">Mother's Maiden Name</h2>
            <div class="col-md-6">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Last Name" name="motherLname" minlength="5" maxlength="20"  >
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="First Name" name="motherFname" minlength="5" maxlength="20"  >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Middle Name" name="motherMname" minlength="5" maxlength="20"  >
            </div>
        </div>
      </div>
      </div>
      
      
        

<!-- step four -->

        <div class="step">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Email Address" name="email" minlength="10" maxlength="25" >
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Confirm Email Address" name="email2" minlength="10" maxlength="25"  >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="number" class="form-control"  oninput="this.className = ''" placeholder="Mobile Phone" name="phone" min="11" max="11">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Password" name="password" minlength="8" maxlength="25"  >
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control"  oninput="this.className = ''" placeholder="Confirm Password" name="password2" minlength="8" maxlength="25"  >
            </div>
          </div>
      </div>
        </div>
        
        <!-- start previous / next buttons -->
        <div class="form-footer d-flex">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
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
    const yesButton = document.getElementById('btn-check-outlined-1');
    const noButton = document.getElementById('btn-check-outlined-2');
    const licenseOptions = document.getElementById('license-options');
    const inputFields = document.getElementById('input-fields');
    const driverLicenseCheckbox = document.getElementById('btn-check-outlined-3');
        const conductorLicenseCheckbox = document.getElementById('btn-check-outlined-4');

    yesButton.addEventListener('change', () => {
        if (yesButton.checked) {
            licenseOptions.style.display = 'grid';
            noButton.checked = false;
            enableInputFields(true);
        } else {
            licenseOptions.style.display = 'none';
        }
    });
    noButton.addEventListener('change', () => {
            if (noButton.checked) {
                licenseOptions.style.display = 'none';
                inputFields.style.display = 'none';
                yesButton.checked = false;
                enableInputFields(false); // Deselect the "Yes" option
            }
        });
        driverLicenseCheckbox.addEventListener('change', () => {
            if (driverLicenseCheckbox.checked) {
                inputFields.style.display = 'block';
                conductorLicenseCheckbox.checked = false;
                enableInputFields(true);
            } else {
                inputFields.style.display = 'none';
            }
        });

        conductorLicenseCheckbox.addEventListener('change', () => {
            if (conductorLicenseCheckbox.checked) {
                inputFields.style.display = 'block';
                driverLicenseCheckbox.checked = false;
                enableInputFields(true);
            } else {
                inputFields.style.display = 'none';
            }
        });

        function enableInputFields(enable) {
            const inputElements = inputFields.querySelectorAll('input');
            inputElements.forEach(input => {
                input.disabled = !enable;
            });
        }

        // Add event listeners for email and password confirm fields
const emailInput = document.querySelector('input[name="email"]');
const emailConfirmInput = document.querySelector('input[name="email2"]');
const passwordInput = document.querySelector('input[name="password"]');
const passwordConfirmInput = document.querySelector('input[name="password2"]');

emailInput.addEventListener('input', validateEmailMatch);
emailConfirmInput.addEventListener('input', validateEmailMatch);
passwordInput.addEventListener('input', validatePasswordMatch);
passwordConfirmInput.addEventListener('input', validatePasswordMatch);

// Function to validate email fields
function validateEmailMatch() {
    const emailValue = emailInput.value;
    const emailConfirmValue = emailConfirmInput.value;

    if (emailValue !== emailConfirmValue) {
        emailConfirmInput.setCustomValidity("Email addresses do not match");
    } else {
        emailConfirmInput.setCustomValidity('');
    }
}

// Function to validate password fields
function validatePasswordMatch() {
    const passwordValue = passwordInput.value;
    const passwordConfirmValue = passwordConfirmInput.value;

    if (passwordValue !== passwordConfirmValue) {
        passwordConfirmInput.setCustomValidity("Passwords do not match");
    } else {
        passwordConfirmInput.setCustomValidity('');
    }
}
</script>
  <script src="./js/stepper.js"></script>
  <script src="js/jquery-3.6.4.js"></script>
</body>
</html>