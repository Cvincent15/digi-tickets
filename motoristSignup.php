<?php
session_start();
//include 'php/database_connect.php';

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are already logged in
    header("Location: motoristspage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/motorist.css"/>
    <link rel="stylesheet" href="css/Core.min.css"/>
    <link rel="stylesheet" href="css/38110691971776138.css"/>
    <link rel="stylesheet" href="css/Theme-Standard.min.css"/>
    <link rel="stylesheet" href="css/signup.css"/>
    <title>Motorists Login</title>
</head>
<body class="t-PageBody t-PageBody--hideLeft t-PageBody--hideActions overlay page__landing home apex-top-nav apex-icons-fontapex t-PageBody--noNav page__loaded">
<div class="__bgImage" style="transform: rotate3d(0.37383177570093457,0,0,1.2616822429906542deg) rotate3d(0,0.7661458333333333,0,2.661458333333333deg) translateZ(-80px)"></div>
    <header class = "t-Header" id="t-Header">
        <div class="t-Header-branding">
    <div class="t-Header-logo">
        <a class="t-Header-logo-link">
        <img src="./images/ctmeusmall.png" style="float:left;">
        </a>
    </div>
        <div class="t-Header-navBar">
            <ul class="t-NavigationBar">
                <li class="t-NavigationBar-item">
            <?php
            if(isset($_SESSION['status']))
            {
                echo "<h5 class='alert alert-success'>" .$_SESSION['status']."</h5>";
                unset($_SESSION['status']);
            }
            ?>
                    <a class="t-Button t-Button--icon t-Button--header t-Button--navBar">
                        <span class="t-Button-label">CTMEU Official Page</span>
                    </a>
                </li>
                <li class="t-NavigationBar-item">
                    <a class="t-Button t-Button--icon t-Button--header t-Button--navBar">
                        <span>
                            <img src="./images/user-plus-regular-24white.png">
                        </span>
                        <span class="t-Button-label">Register</span>
                    </a>
                </li>
                <li class="t-NavigationBar-item">
                    <a class="t-Button t-Button--icon t-Button--header t-Button--navBar">
                        <span>
                            <img src="./images/log-in-regular-24.png">
                        <span class="t-Button-label">Login</span>
                 </a>
            </li>
        </ul>
        </div>
</div>
</header>
<div class="t-Body">
            <div class="t-Body-main" style="margin-top: 68px;">
    </div>
    <div class="t-Body-contentInner">
        <div class="container">
            <div class="row">

            </div>

            <div class="row">
                <div class="col col-12 apex-col-auto content__center">
                    <div id="content" class>
                        <center>
                        <h2>Sign Up</h2>
  <form id="registration-form" action="code.php" method="POST">
    <label for="full_name" >Full Name:</label><br>
    <input type="text" id="full_name" name="full_name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="number">Phone Number:</label><br>
    <input type="text" id="number" name="phone" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <button class="show-password" id="toggle-password" type="button">Show/Hide Password</button><br>

    <label for="confirm_password">Confirm Password:</label><br>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    

    <label for="birthdate">Birthdate:</label><br>
    <input type="date" id="birthdate" name="birthdate" required><br><br>

    <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
  </form>

  <div id="error-modal" class="modal">
    <div class="modal-content">
        <span id="error-message" class="error-message">Password should have 1 capital letter, 1 special character, 1 numeric value</span>
        <button id="close-modal" class="btn btn-secondary">Close</button>
    </div>
</div>
                        </center>
            </div>
        </div>
    </div>
    </div>

    <script>
document.getElementById('registration-form').addEventListener('submit', function(event) {
    const passwordField = document.getElementById('password');
    const passwordValue = passwordField.value;

    if (!isValidPassword(passwordValue)) {
        const errorMessage = "Password must contain at least 8 characters, including at least 1 capital letter, 1 numeric digit, and 1 special character.";
        displayErrorModal(errorMessage);
        event.preventDefault(); // Prevent form submission
    }
});

document.getElementById('toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
    } else {
        passwordField.type = 'password';
    }
});

document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('error-modal').style.display = 'none';
});

function isValidPassword(password) {
    // Password complexity requirements
    const regex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}$/;
    return regex.test(password);
}

function displayErrorModal(message) {
    const modal = document.getElementById('error-modal');
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;
    modal.style.display = 'block';
}
</script>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>