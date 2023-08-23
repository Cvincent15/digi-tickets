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
            <p class="text-center mb-4">Create your account</p>
            <div class="mb-3">
                <input type="email" placeholder="Email Address" oninput="this.className = ''" name="email">
            </div>
            <div class="mb-3">
                <input type="password" placeholder="Password" oninput="this.className = ''" name="password">
            </div>
            <div class="mb-3">
                <input type="password" placeholder="Confirm Password" oninput="this.className = ''" name="password">
            </div>
        </div>
    
        <!-- step two -->
        <div class="step">
            <p class="text-center mb-4">Your presence on the social network</p>
            <div class="mb-3">
                <input type="text" placeholder="Linked In" oninput="this.className = ''" name="linkedin">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Twitter" oninput="this.className = ''" name="twitter">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Facebook" oninput="this.className = ''" name="facebook">
            </div>
        </div>
    
        <!-- step three -->
        <div class="step">
            <p class="text-center mb-4">We will never sell it</p>
            <div class="mb-3">
                <input type="text" placeholder="Full name" oninput="this.className = ''" name="fullname">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Mobile" oninput="this.className = ''" name="mobile">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Address" oninput="this.className = ''" name="address">
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
  <script src="./js/stepper.js"></script>
</body>
</html>