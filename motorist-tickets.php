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
<link rel="stylesheet" href="css/ticketStyle.css"/>
    <title>CTMEU Login</title>

</head>

<body class="sidebar-collapse fixed" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="min-height: 658px;">
            <div class="bgslider" id="bgslider">
                <div class="container d-flex align-items-center justify-content-center pt-5">
                    <div class="col" style="width: 98%; height: 90vh; background: white; box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.50); border-radius: 1.25rem">
                        <div class="row" style="width: 100%; height: 40%; background: linear-gradient(180deg, #062690 0%, #00105A 100%); border-top-left-radius: 1.25rem; border-top-right-radius: 1.25rem; border-bottom-right-radius: 2.5rem; border-bottom-left-radius: 2.5rem; margin: .3px;">
                        <h1 class="d-flex align-items-center justify-content-center mb-0"><img src="./images/ctmeu-small.png"></h1>
                        <h1 class="d-flex align-items-center justify-content-center mt-0" style="color: #FFF; text-align: center;font-family: Inter;font-size: 2.5rem; font-style: normal; font-weight: 600; line-height: normal;">Check a Violation Ticket Status</h1>
<form class="d-flex mx-auto mb-5" style=" width: 50%;" id="search-form">
    <div class="input-group">
        <input class="form-control" type="search" id="search-query" placeholder="Search" aria-label="Search">
        <button class="btn btn-primary" type="button" onclick="searchData()">Search</button>
    </div>
</form>
                    </div>
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col d-flex align-items-center justify-content-center mx-auto">
                            <h1 class="d-flex align-items-center justify-content-center mt-5 pt-5"><img src="./images/search-placeholder.png"></h1>
                            </div>
                            <div class="col pt-5">
                                <h1>Log In</h1>
                                <h6>Manage Violations and More</h6>
                                <form class="form-floating mb-3 me-5" method="POST" action="php/login.php" accept-charset="utf-8" id="login-form">
              <div class="form-floating mb-3">
                <input type="text" name="username" value="" id="username" placeholder="User Name" maxlength="20" size="50" autocomplete="off" class="form-control" required="">
                <label for="username" class="form-label">Username</label>
              </div>
              <div class="form-floating">
                <input type="password" name="password" value="" id="password" autocomplete="off" placeholder="Password" class="form-control mb-2" maxlength="20" required="">
                <label for="password" class="form-label">Password</label>
            </div>
            <p class="text-end mt-0"><a href="#" style="text-decoration: none;">Forgot your password?</a></p>
            <div class="d-grid gap-2 col-12 mx-auto">
  <button class="btn btn-primary" type="button">Log In</button>
</div>
            </form>
            <p class="text-center mt-0">Don't have an account? Sign Up</p>
                            </div>
                        </div>
                        <div class="row text-center pt-3">
                        <p>
      <a href="#terms-of-service" style="text-decoration: none;">Terms of Service</a> •
      <a href="#privacy-policy" style="text-decoration: none;">Privacy policy</a>
    </p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>

    <div class="modal fade" id="searchResultsModal" tabindex="-1" aria-labelledby="searchResultsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header mx-5">
                <h3 class="modal-title mt-3" id="searchResultsModalLabel" style="color: #1A3BB1; font-weight: 700;">Ticket Details</h3>
                <h3 class="modal-title mt-3" id="searchResultsModalLabel" style="color: #1A3BB1; font-weight: 400;">No. 400078</h3>
            </div>
            <div class="modal-body pb-0" id="searchResultsModalBody">
                <!-- Search results will be displayed here -->
            </div>
            <div class="modal-footer mx-5 pt-0"  style="border-top: none;">
    <div style="flex-grow: 1;"> <!-- This div will take up the remaining space to push the close button to the left -->
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
    </div>
    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="background-color: #1735C3;"><img class="me-1" src="./images/exportButton.png">Export</button>
</div>
    </div>
</div>
<script>
    function searchData() {
        var searchQuery = document.getElementById('search-query').value;

        $.ajax({
            type: 'POST',
            url: './php/search_ticket.php',
            data: { search_query: searchQuery },
            success: function (response) {
                // Display the search results in a modal
                $('#searchResultsModalBody').html(response);
                $('#searchResultsModal').modal('show');
            }
        });
    }
</script>
    <script src="js/script.js"></script>
    <script src="js/jquery-3.6.4.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
</body>
</html>