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
<body style="height: auto;">

<nav class="navbar">
  <div class="logo">
    <img src="images/logo-ctmeu.png" alt="Logo">
  </div>
  <div class="navbar-text">
    <h2>City Traffic Management and Enforcement Unit</h1>
    <h1><b>Traffic Violation Data Hub</b></h2>
  </div>
  
  <div class="navbar-inner">
  <div class="navbar-right">
    <h5>Welcome, <?php echo $_SESSION['status']; ?> <?php echo $_SESSION['name']; ?></h5>
    <button class="btn btn-primary" onclick="location.href='php/logout.php'">Log out?</button>
    <a href="ctmeupage.php" class="link"><b>Records</b></a>
    <a href="#" class="link">Reports</a>
    <a href="ctmeuactlogs.php" class="link">Activity Logs</a>
    <?php if ($_SESSION['status'] == 'Super Admin') {?>
    <a href="ctmeucreate.php" class="link">Create Accounts</a>
    <?php }?>
  </div>
  </div>
</nav>

<div class="pagination" style="text-align:right; margin-top: 5px; margin-left:5px; margin-right:auto;">
    
    <div class="table-info" style="color:white;">
      <span id="tableNumber"></span>/<span id="totalTables"></span>
      <button id="prevBtn" onclick="previousPage()" class="disabled seek"><</button>
    <button class="seek" id="nextBtn" onclick="nextPage()">></button>
    </div>
  </div>

<div class="table-container">
<table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Ticket Number</th>
                <th>Driver's Name</th>
                <th>License No.</th>
                <th>Violation</th>
                <th>Vehicle Type</th>
                <th>Plate No.</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Replace the sample data below with the data fetched from your database -->
            <tr>
                <td>Data 1</td>
                <td>Data 2</td>
                <td>Data 3</td>
                <td>Data 4</td>
                <td>Data 5</td>
                <td>Data 6</td>
                <td>Data 7</td>
                <td>Data 8</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <tr>
                <td>Data 9</td>
                <td>Data 10</td>
                <td>Data 11</td>
                <td>Data 12</td>
                <td>Data 13</td>
                <td>Data 14</td>
                <td>Data 15</td>
                <td>Data 16</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>
<script>
    
 var currentPage = 0;
    var rowsPerPage = 10;
    var tableBody = document.getElementById("tableBody");
    var numRows = tableBody.rows.length;
    var numPages = Math.ceil(numRows / rowsPerPage);

    var tableNumberEl = document.getElementById("tableNumber");
    var totalTablesEl = document.getElementById("totalTables");

    function showPage(page) {
      var startRow = page * rowsPerPage;
      var endRow = startRow + rowsPerPage;

      for (var i = 0; i < numRows; i++) {
        if (i >= startRow && i < endRow) {
          tableBody.rows[i].style.display = "table-row";
        } else {
          tableBody.rows[i].style.display = "none";
        }
      }
      
      tableNumberEl.textContent = page + 1;
    }

    function nextPage() {
      if (currentPage < numPages - 1) {
        currentPage++;
        showPage(currentPage);
        document.getElementById("prevBtn").classList.remove("disabled");
      }

      if (currentPage === numPages - 1) {
        document.getElementById("nextBtn").classList.add("disabled");
      }
    }

    function previousPage() {
      if (currentPage > 0) {
        currentPage--;
        showPage(currentPage);
        document.getElementById("nextBtn").classList.remove("disabled");
      }

      if (currentPage === 0) {
        document.getElementById("prevBtn").classList.add("disabled");
      }
    }

    showPage(currentPage);

    totalTablesEl.textContent = numPages;
</script>
</body>
</html>