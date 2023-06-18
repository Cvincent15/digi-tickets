<?php
session_start();
include 'php/database_connect.php';
?>

<!DOCTYPE html>
<html lang="en" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
    <title>CTMEU Data Hub</title>
</head>
<body class="sidebar-collapse fixed" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="min-height: 658px;">
            <div class="bgslider" id="bgslider">
                <div class="col-md-4 card frost">
                    <div class="toplayer" style="margin-top:30%;">
                        <div class="box-header with-border" style="margin:auto;">
                            <h2 class="box-title text-center">Welcome!</h2>
                        </div>
                        <div class="box-body login-box-msg">
                            <section id="introduction">
                                <p style="text-align:center;"> Please click or tap your destination.</p>
                            </section>
                            <div class="row">
                                <div class="col-12 landing">
                                    <p><a class="btn btn-lg btn-primary btn-block btn-flat landing" style="background-color:#243489;"href="ctmeulogin.php">CTMEU</a><br>
                                    <a class="btn btn-lg btn-danger btn-block btn-flat landing" style="background-color: maroon;" href="motoristlogin.php">Motorists</a></p>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
</body>
</html>