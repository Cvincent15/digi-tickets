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
                    <a class="t-Button t-Button--icon t-Button--header t-Button--navBar">
                        <span class="t-Button-label">CTMEU Official Page</span>
                    </a>
                </li>
                <li class="t-NavigationBar-item">
                    <a class="t-Button t-Button--icon t-Button--header t-Button--navBar" href='motoristSignup.php'>
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
                            <h3 style="width:90%;margin-bottom: 12px; ">City Traffic Management and Enforcement Unit</h3>
                            <div class="logos"><img class="logo" src="./images/ctmeu.png"></div>
                            <h1><b>CTMEU Portal</b></h1>
                            <h3>The City of Santa Rosa shall be a model in local governance effectively responding to the welfare of its people through innovative policies and programs, and integrated strategy anchored on.</h3>
                        </center>
                
                <div class="container">
                    <div class="row">
                        <div class="col col-12 apex-col-auto">
                            <button class="t-Button js-ignoreChange register-button btn__animate  t-Button--large t-Button--danger t-Button--pillStart" type="button" id="openButton">
                                <span class="t-Button-label">REGISTER NOW</span>
                            </button>
                            <button class="t-Button js-ignoreChange login-button btn__animate  t-Button--large" type="button" id="loginButton"
                                <span class="t-Button-label">LOG IN</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        // Get a reference to the button
        const buttonSignup = document.getElementById("openButton");
        const buttonLogin = document.getElementById("loginButton")

        // Add a click event listener
        buttonSignup.addEventListener("click", function() {
            // Navigate to the new page
            window.location.href = "motoristSignup.php";
        });

        buttonLogin.addEventListener("click", function() {
            // Navigate to the new page
            window.location.href = "motorist_login.php";
        });
    </script>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>