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
  <form action="code.php" method="POST">
    <label for="full_name" >Full Name:</label><br>
    <input type="text" id="full_name" name="full_name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Phone Number:</label><br>
    <input type="text" id="password" name="phone" required><br><br>

    <label for="confirm_password">Password:</label><br>
    <input type="password" id="pasword" name="password" required><br><br>

    <label for="birthdate">Birthdate:</label><br>
    <input type="date" id="birthdate" name="birthdate" required><br><br>

    <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
  </form>
                        </center>
            </div>
        </div>
    </div>
    </div>

<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js"></script>
<script>
  function submitToFirebase(event) {
    event.preventDefault(); // Prevent the default form submission

    const fullName = document.getElementById("full_name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Create a new user with email and password
    firebase.auth().createUserWithEmailAndPassword(email, password)
      .then((userCredential) => {
        // User creation successful
        const user = userCredential.user;
        console.log("User created:", user);

        // You can add additional logic here, like redirecting to a new page
      })
      .catch((error) => {
        // Handle errors
        const errorCode = error.code;
        const errorMessage = error.message;
        console.error("Error:", errorCode, errorMessage);
      });
  }
</script>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.2.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.2.0/firebase-analytics.js";
  import { getAuth, createUserWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.2.0/firebase-auth.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCJYwTjdJbocOuQqUUPPcjQ49Y8R2eng0E",
    authDomain: "ctmeu-d5575.firebaseapp.com",
    databaseURL: "https://ctmeu-d5575-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "ctmeu-d5575",
    storageBucket: "ctmeu-d5575.appspot.com",
    messagingSenderId: "1062661015515",
    appId: "1:1062661015515:web:bd8622b373772f1016c9fe",
    measurementId: "G-MSESZ1DVDL"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>


<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>