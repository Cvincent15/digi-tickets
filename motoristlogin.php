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
    <link rel="stylesheet" href="css/style.css"/>
    <title>Motorists Login</title>
</head>
<body class="sidebar-collapse fixed" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="min-height: 658px;">
            <div class="bgslider" id="bgslider">
                <div class="col-md-4 card frost">
                <div class="toplayer login-card-body" style="margin-top:30%;">
          <div class="box-header with-border">
            <h2 class="box-title text-center"><strong>Motorists Login</strong></h2>
          </div>
          <div class="box-body login-box-msg">
            <section id="introduction">
              <p style="text-align:center;">Sign in to start your session</p>
            </section>

            <form action="php/loginM.php" method="post" accept-charset="utf-8">
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
                <input type="submit" name="Login" value="Sign in" id="Login" class="btn btn-primary btn-flat pull-right">
            </div>
            </form></div>
        </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>