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
    <script src= "https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js"></script>
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
                <td>1</td>
                <td>1234560</td>
                <td>Zsyra Almendral</td>
                <td>11345</td>
                <td>illegal parking</td>
                <td>Motorcycle Mio</td>
                <td>MMM-111</td>
                <td>2023/04/10, 11:11 AM</td>
            </tr>
            <tr>
                <td>2</td>
                <td>1234561</td>
                <td>Jeon Jungkook</td>
                <td>12345</td>
                <td>No License</td>
                <td>Tesla</td>
                <td>TSL-003</td>
                <td>2023/04/11, 4:50 PM</td>
            </tr>
            <tr>
                <td>3</td>
                <td>1234562</td>
                <td>Vincent Cosio</td>
                <td>54321</td>
                <td>no helmet</td>
                <td>Motorcycle Mio</td>
                <td>DDD-111</td>
                <td>2023/04/12, 1:21 PM</td>
            </tr>
            <tr>
                <td>4</td>
                <td>1234563</td>
                <td>Lorenz Artillagas</td>
                <td>32154</td>
                <td>illegal parking</td>
                <td>Motorcycle Mio</td>
                <td>EEE-111</td>
                <td>2023/04/13, 9:50 AM</td>
            </tr>
            <tr>
                <td>5</td>
                <td>1234564</td>
                <td>Kristine Casindac</td>
                <td>53241</td>
                <td>no helmet</td>
                <td>Motorcycle Mio</td>
                <td>FFF-555</td>
                <td>2023/04/14, 6:01 PM</td>
            </tr>
            <tr>
                <td>6</td>
                <td>1234565</td>
                <td>Jazzlyn Aquino</td>
                <td>24351</td>
                <td>illegal parking</td>
                <td>Motorcycle Mio</td>
                <td>GGG-333</td>
                <td>2023/04/15, 8:12 AM</td>
            </tr>
            <tr>
                <td>7</td>
                <td>1234566</td>
                <td>Dan Carlo Ramirez</td>
                <td>52132</td>
                <td>no helmet</td>
                <td>Motorcycle Mio</td>
                <td>HHH-444</td>
                <td>2023/04/16, 3:24 AM</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    </div>
<script src="js/script.js"></script>
<script src="js/jquery-3.6.4.js"></script>

<script type="module">
  
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCJYwTjdJbocOuQqUUPPcjQ49Y8R2eng0E",
    authDomain: "ctmeu-d5575.firebaseapp.com",
    projectId: "ctmeu-d5575",
    storageBucket: "ctmeu-d5575.appspot.com",
    messagingSenderId: "1062661015515",
    appId: "1:1062661015515:web:c0f4f62b1f010a9216c9fe",
    measurementId: "G-65PXT5618B"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const db = firebase.firestore();
</script>

<script>
    
 var currentPage = 0;
    var rowsPerPage = 5;
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