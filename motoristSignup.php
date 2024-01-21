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
  <a class="navbar-brand" href="motorist-tickets.php">
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
        </ul>
        <button type="button" class="btn class=btn btn-primary active" style="margin-right: 20px;" onclick="redirectToRegister()">Register</button>
        <button type="button" class="btn transparent-btn btn-outline-primary" onclick="redirectToLogin()">Log In and Search</button>
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
            <p class="text-center mb-4"><img src="./images/Sample License.png"></br><!--<a href="#" style="text-decoration: none;">Show Backside</a></br> -->Do you have a Philippine Driver's License or Conductor's License?</p>
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
              <h2 class="h2 field mb-4">Input your License</h2>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control"  oninput="this.className = ''; formatLicenseNo(this);" placeholder="License No." name="licenseNo" minlength="13" maxlength="13"  >
            </div>
            <script>
                  function formatLicenseNo(input) {
                          // Remove any non-alphanumeric characters
                          const inputValue = input.value.replace(/[^A-Za-z0-9]/g, '');

                          // Capitalize the input value
                          const capitalizedValue = inputValue.toUpperCase();

                          // Add dashes at the 4th and 7th positions
                          const formattedValue = capitalizedValue.replace(/(.{3})(.{2})?(.{1,6})?/, function(match, p1, p2, p3) {
                              let result = p1;
                              if (p2) result += '-' + p2;
                              if (p3) result += '-' + p3;
                              return result;
                          });

                          // Update the input value
                          input.value = formattedValue;
                      }
            </script>
            <div class="col-md-6 mb-3">
              <div class="date-input-overlay"></div>
              <input type="date" class="form-control" id="datepicker" readonly placeholder="Expiry Date" name="expiry" pattern="\d{4}-\d{2}-\d{2}" title="Enter a date in the format YYYY-MM-DD" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control"  oninput="this.className = ''; formatSerialNo(this);" placeholder="Serial No. (back of your card)" name="serialNo" minlength="9" maxlength="9"  >
            </div>
            <script>
                function formatSerialNo(input) {
                  // Allow only numeric characters
                  const numericValue = input.value.replace(/\D/g, '');

                  // Update the input value
                  input.value = numericValue;
              }
            </script>
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
              <input type="date" class="form-control" id="datepicker2" oninput="this.className = ''" readonly placeholder="Date of Birth" name="birthday">
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
              <input type="text" class="form-control"  oninput="this.className = ''; validateEmails(this);" placeholder="Email Address" name="email" minlength="10" maxlength="50" >
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control"  oninput="this.className = ''; validateEmails(this);" placeholder="Confirm Email Address" name="email2" minlength="10" maxlength="50"  >
              
            </div>
            <div id="emailError" style="color: red; font-size: 12px; display: none;">Email addresses do not match</div>
            <script>
                function validateEmails(input) {
                  const emailInput = document.querySelector('input[name="email"]');
                  const confirmEmailInput = document.querySelector('input[name="email2"]');
                  const errorDiv = document.getElementById('emailError');

                  // Check if the email format is valid
                  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                  const isValidFormat = emailRegex.test(emailInput.value) && emailRegex.test(confirmEmailInput.value);

                  if (emailInput.value !== confirmEmailInput.value || !isValidFormat) {
                      errorDiv.style.display = 'block';
                  } else {
                      errorDiv.style.display = 'none';
                  }
              }
            </script>
          </div>
          <div class="row">
    <div class="col-md-6 mb-5">
        <div class="input-group">
            <span class="input-group-text">+63</span>
            <input type="text" class="form-control" id="phoneInput" placeholder="Mobile Phone" minlength="10" maxlength="10" name="phone" style="width: 30px;">


        </div>
    </div>
</div>
        <div class="row">
            <div class="col-md-6">
              <input type="password" class="form-control"  oninput="this.className = '';validatePasswords(this);" placeholder="Password" name="password" minlength="8" maxlength="25"  >
            </div>
            <div class="col-md-6 mb-3">
              <input type="password" class="form-control"  oninput="this.className = '';validatePasswords(this);" placeholder="Confirm Password" name="password2" minlength="8" maxlength="25"  >
            </div>
            <div id="passwordError" style="color: red; font-size: 12px; display: none;">Passwords do not match</div>

            <script>
                function validatePasswords(input) {
                    const passwordInput = document.querySelector('input[name="password"]');
                    const confirmPasswordInput = document.querySelector('input[name="password2"]');
                    const errorDiv = document.getElementById('passwordError');

                    if (passwordInput.value !== confirmPasswordInput.value) {
                        errorDiv.style.display = 'block';
                    } else {
                        errorDiv.style.display = 'none';
                    }
                }
            </script>
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

<!-- Include the flatpickr library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <script>
    function redirectToRegister() {
      window.location.href = 'motoristSignup.php';
    }

    function redirectToLogin() {
      window.location.href = 'motorist-tickets.php';
    }
  </script>
  

  
<script>
  // Get the input element by its ID
const phoneInput = document.getElementById('phoneInput');

// Add an input event listener to the phone input field
phoneInput.addEventListener('input', function (e) {
    const inputValue = e.target.value;
    const sanitizedValue = inputValue.replace(/\D/g, ''); // Remove non-digit characters
    e.target.value = sanitizedValue;
});


// Get the current date
const currentDate = new Date();

// Format the current date as 'YYYY-MM-DD'
const currentYear2 = currentDate.getFullYear();
const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
const currentDay = String(currentDate.getDate()).padStart(2, '0');
const formattedCurrentDate = `${currentYear2}-${currentMonth}-${currentDay}`;

// Initialize flatpickr date picker with updated minimum date
flatpickr('#datepicker', {
    dateFormat: 'Y-m-d', // Set the desired date format
    maxDate: '2050-12-31', // Set the maximum selectable date
    minDate: formattedCurrentDate, // Set the minimum selectable date to today
});

// Calculate the minimum and maximum birth years based on age
const currentYear = new Date().getFullYear();
const minBirthYear = currentYear - 90; // Maximum age of 90 years
const maxBirthYear = currentYear - 18; // Minimum age of 18 years

// Initialize flatpickr date picker with dynamic minimum and maximum dates
flatpickr('#datepicker2', {
    dateFormat: 'Y-m-d', // Set the desired date format
    maxDate: `${maxBirthYear}-12-31`, // Maximum birth date
    minDate: `${minBirthYear}-01-01`, // Minimum birth date
});

  // Apply symbol restriction to all text input fields
const textInputs = document.querySelectorAll('input[type="text"]');
/*
textInputs.forEach(input => {
    input.addEventListener('input', function (e) {
        const inputValue = e.target.value;
        const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 .+\-]/g, ''); // Allow letters, numbers, spaces, hyphens
        e.target.value = sanitizedValue;
    });
});
*/
// Date validation function
function validateDate(dateString) {
    const date = new Date(dateString);
    return date >= new Date('1970-01-01') && date <= new Date('2050-12-31');
}

// Function to validate email and email confirmation
function validateEmail() {
    const emailInput = document.querySelector('input[name="email"]');
    const emailConfirmInput = document.querySelector('input[name="email2"]');
    const emailValue = emailInput.value;
    const emailConfirmValue = emailConfirmInput.value;

    if (emailValue === emailConfirmValue) {
        return true; // Email addresses match
    } else {
        return false; // Email addresses do not match
    }
}

// Function to validate password and password confirmation
function validatePassword() {
    const passwordInput = document.querySelector('input[name="password"]');
    const passwordConfirmInput = document.querySelector('input[name="password2"]');
    const passwordValue = passwordInput.value;
    const passwordConfirmValue = passwordConfirmInput.value;

    if (passwordValue === passwordConfirmValue) {
        return true; // Passwords match
    } else {
        return false; // Passwords do not match
    }
}

// Add event listeners to the email and password fields
const emailInput = document.querySelector('input[name="email"]');
const emailConfirmInput = document.querySelector('input[name="email2"]');
const passwordInput = document.querySelector('input[name="password"]');
const passwordConfirmInput = document.querySelector('input[name="password2"]');

emailInput.addEventListener('input', validateEmail);
emailConfirmInput.addEventListener('input', validateEmail);
passwordInput.addEventListener('input', validatePassword);
passwordConfirmInput.addEventListener('input', validatePassword);


// Add event listener to the date input
const dateInput = document.querySelector('input[name="birthday"]');

dateInput.addEventListener('input', function (e) {
    const inputValue = e.target.value;
    if (!validateDate(inputValue)) {
        e.target.setCustomValidity('Invalid date. Date must be between 01/01/1970 and 12/31/2050.');
    } else {
        e.target.setCustomValidity('');
    }
});

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
        const form = document.getElementById('signUpForm'); // Get the form by its id
        // Function to validate email and password confirmation

</script>
  <script src="./js/stepper.js"></script>
  <script src="js/jquery-3.6.4.js"></script>
</body>
</html>