<?php
session_start();
//include 'php/database_connect.php';

// Check if the user is already logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the greeting page if they are already logged in
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Edit Ticket</title>
  <style>
    /* Add your custom styles here */
  </style>
</head>
<body>
  <div id="edit-form-container">
    <h1>Edit Ticket</h1>
    <form id="edit-form">
      <label for="address">Address:</label>
      <input type="text" id="address" name="address" required>
      <br>

      <label for="district">District No.:</label>
      <input type="text" id="district" name="district" required>
      <br>

      <label for="license">License No.:</label>
      <input type="text" id="license" name="license" required>
      <br>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      <br>

      <button type="submit">Save</button>
    </form>
  </div>

  <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js"></script>
  <script src="edit.js"></script>
</body>
</html>
