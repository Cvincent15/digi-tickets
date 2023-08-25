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
        <button type="button" class="btn class=btn btn-primary active" style="margin-right: 20px;" onclick="redirectToRegister()">Register</button>
        <button type="button" class="btn transparent-btn btn-outline-primary" onclick="redirectToLogin()">Log In</button>
    </div>
    </div>
  </div>
</nav>

<div class="masthead" style="background-image: url('./images/mainbg.png'); padding-top: 60px;" >
<section class="container bg-white w-75 text-dark mx-auto p-2 rounded-5">
<form id="signUpForm" action="#!">
  <div class="row d-flex justify-content-center"><div class="col-md-auto mb-4"><h1 class="reg">Registration</h1></div></div>
        <!-- start step indicators -->
        <div class="form-header d-flex mb-4">
            <span class="stepIndicator">Existing License</span>
            <span class="stepIndicator">Nationality</span>
            <span class="stepIndicator">Personal Details</span>
            <span class="stepIndicator">Contact</span>
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
            <div class="d-grid col-6 mx-auto">
            <div id="license-options" style="display: none;">
            <input type="checkbox" class="btn-check" id="btn-check-outlined-3" autocomplete="off">
              <label class="btn btn-outline-primary" for="btn-check-outlined-3">Driver's License</label><br>
            <input type="checkbox" class="btn-check" id="btn-check-outlined-4" autocomplete="off">
              <label class="btn btn-outline-primary" for="btn-check-outlined-4">Conductor's License</label><br>
            </div>
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
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="License No." name="licenseNo">
            </div>
            <div class="col-md-6 mb-3">
              <input type="date" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Expiry Date" name="expiry">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Serial No. (back of your card)" name="serialNo">
            </div>
        </div>
      </div>
        </div>
        </div>
        
        
    
        <!-- step two -->
        <div class="step">
            <h2 class="text-center mb-4 mt-4" >Are you a Filipino Citizen?</h2>
            <div class="row d-flex justify-content-center">
            <div class="col-md-auto mb-4">
            <input type="checkbox" class="btn-check" id="btn-check-outlined-5" autocomplete="off">
            <label class="btn btn-outline-primary" for="btn-check-outlined-5">Yes</label><br>
            </div>
            <div class="col-md-auto mb-4">
              <input type="checkbox" class="btn-check" id="btn-check-outlined-6" autocomplete="off">
              <label class="btn btn-outline-primary" for="btn-check-outlined-6">No</label><br>
            </div>
        </div>
        </div>
    
        <!-- step three -->
        <div class="step">
        <div class="container">
          <div class="row">
          <h2 class="h3 field mb-4">Name</h2>
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Last Name" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="First Name" name="fullname">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Middle Name" name="fullname">
            </div>
        </div>
      </div>
      <div class="container">
          <div class="row">
          <h2 class="h3 field mb-4">Birthdate</h2>
          <div class="col-md-6 mb-3">
              <input type="date" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Date of Birth" name="fullname">
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Gender" name="fullname">
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <h2 class="h3 field mb-4">Mother's Maiden Name</h2>
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Last Name" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="First Name" name="fullname">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Middle Name" name="fullname">
            </div>
        </div>
      </div>
      </div>
      
      
        

<!-- step four -->

        <div class="step">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Email Address" name="fullname">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="datepicker" oninput="this.className = ''" placeholder="Confirm Email Address" name="fullname">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-5">
              <input type="text" class="form-control" id="input1" oninput="this.className = ''" placeholder="Mobile Phone" name="fullname">
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
    $(document).ready(function() {
      $('#datepicker').datepicker();
    });
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
</script>
  <script src="./js/stepper.js"></script>
</body>
</html>