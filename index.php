<?php
session_start();
//include 'php/database_connect.php';

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are already logged in
    header("Location: ctmeupage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Login</title>
</head>

<body class="sidebar-collapse fixed" style="height: auto;">

    <div class="wrapper">
        <div class="content-wrapper" style="min-height: 658px;">
            <div class="bgslider" id="bgslider">
                <div class="col-md-4 card frost">
                <div class="toplayer login-card-body" style="margin-top:30%;">
          <div class="box-header with-border">
            <h2 class="box-title text-center"><strong>CTMEU Login</strong></h2>
          </div>
          <div class="box-body login-box-msg">
            <section id="introduction">
              <p style="text-align:center;">Sign in to start your session</p>
            </section>

            <form method="post" accept-charset="utf-8" id="login-form">
                <div class="form-group">
                    <div class="input-group mb-0 landing">
                        <input type="text" name="username" value="" id="username" pattern="[a-zA-Z0-9 ]+" placeholder="User Name" maxlength="50" size="50" autocomplete="off" class="form-control" required>
                    </div>
                </div>

            <div class="form-group landing">
                <div class="input-group">
                    <input type="password" name="password" value="" id="password" autocomplete="off" placeholder="Password" class="form-control" required>
                </div>
            </div>

            <div class="text-right landing">
                <input type="submit" name="Login" value="Log In" id="Login" class="btn btn-primary btn-flat pull-right">
            </div>
            </form></div>
        </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
  import { getFirestore, collection, doc, addDoc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";
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
    appId: "1:1062661015515:web:c0f4f62b1f010a9216c9fe",
    measurementId: "G-65PXT5618B"
  };

    // Initialize Firebase
    initializeApp(firebaseConfig);
    const db = getFirestore();

    // Check if user credentials are valid
    const checkCredentials = async (username, password) => {
      const usersCollection = collection(db, 'usersCTMEU');
      const q = query(usersCollection, where('username', '==', username), where('password', '==', password));
      const querySnapshot = await getDocs(q);
      return !querySnapshot.empty;
    };

    // Handle form submission
    const form = document.getElementById('login-form');
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Get form values
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;

      // Check if user credentials are valid
      const isValidCredentials = await checkCredentials(username, password);

      if (isValidCredentials) {
        // Start session
        sessionStorage.setItem('username', username);

        // Redirect to another page (replace "dashboard.html" with the actual page you want to redirect to)
        window.location.href = 'ctmeupage.php';
      } else {
        alert('Invalid username or password');
      }
    });

  </script>
</body>
</html>