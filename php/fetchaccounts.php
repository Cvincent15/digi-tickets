<?php
session_start();
include 'database_connect.php';

// Retrieve the user accounts from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table id='user-table'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["name"]."</td>
                <td>".$row["username"]."</td>
                <td>".$row["password"]."</td>
                <td>".$row["status"]."</td>
              </tr>";
    }

    echo "</tbody>
        </table>";
} else {
    echo "No user accounts found.";
}

// Close the database connection
$conn->close();
?>
