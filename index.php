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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    

    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Login</title>
</head>

<body class="sidebar-collapse fixed" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="min-height: 658px;">
            <div class="bgslider" id="bgslider">
                <div class="container d-flex justify-content-end align-items-center vh-100">
                    <div class="toplayer login-card-body p-5 rounded-4"  style="background-color: #FFFFFF;">
                        <div class="box-header with-border">
                            <h2 class="box-title text-center"><strong>CTMEU Login</strong></h2>
                        </div>
                        <div class="box-body login-box-msg">
                            <section id="introduction">
                                <p style="text-align:center;">Sign in to start your session</p>
                            </section>
                            <div class="card-body">
            <form  method="POST" action="php/login.php" accept-charset="utf-8" id="login-form">
              <div class="mb-3">
                <input type="text" name="username" value="" id="username" pattern="[a-zA-Z0-9 ]+" placeholder="User Name" maxlength="50" size="50" autocomplete="off" class="form-control" required type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password" value="" id="password" autocomplete="off" placeholder="Password" class="form-control mb-4" required>
              </div>
              <div class="d-flex justify-content-center">
              <button type="submit" name="loginButton" value="Log In" id="loginButton"  class="btn btn-primary rounded-5" style="background: linear-gradient(to bottom, #46A6FF, #0047FF); width: 100px;">Log In</button>
              </div>
            </form>
          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/jquery-3.6.4.js"></script>
    
</body>
</html>