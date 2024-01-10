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
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Login</title>
</head>
<style>
    input::-ms-reveal,
input::-ms-clear {
   display: none;
}
</style>

<body class="sidebar-collapse fixed" style="height: auto;">
<div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


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
            <form class="form-floating mb-3" method="POST" action="php/login.php" accept-charset="utf-8" id="login-form">
              <div class="form-floating mb-3">
                <input type="text" name="username" value="" id="username"  placeholder="User Name" maxlength="20" size="50" autocomplete="off" class="form-control" required type="text" id="username" name="username" required>
                <label for="username" class="form-label">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" name="password" value="" id="password" autocomplete="off" placeholder="Password" class="form-control mb-4" maxlength="20" required>
                <label for="password" class="form-label">Password</label>
                <button type="button" id="togglePassword" class="btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">Show</button>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        // Apply symbol restriction to all text input fields
    const form = document.getElementById('login-form');
        const inputs = form.querySelectorAll('input[type="text"], input[type="password"]');

    //    inputs.forEach(input => {
     //       input.addEventListener('input', function (e) {
     //           const inputValue = e.target.value;
      //          const sanitizedValue = inputValue.replace(/[^A-Za-z0-9 \-]/g, ''); // Allow letters, numbers, spaces, and hyphens
       //         e.target.value = sanitizedValue;
       //     });
      //  });

    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');

    toggleButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            toggleButton.textContent = 'Show';
        }
    });

    // Function to show the Bootstrap modal
    function showAlert(message) {
        const modal = new bootstrap.Modal(document.getElementById('customModal'));
        document.getElementById('modalMessage').innerText = message;
        modal.show();
    }
    </script>
    <?php
    
// Check if there is a login error message
if (isset($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    // Clear the login error session variable
    unset($_SESSION['login_error']);
    // You can use $loginError to display the error message in your popup
    echo "<script>showAlert('$loginError');</script>";
}

    ?>
</body>
</html>