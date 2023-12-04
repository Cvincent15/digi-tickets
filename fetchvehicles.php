<?php
header('Content-Type: application/json');
session_start();
include 'database_connect.php';

// Retrieve the user accounts from the database
$sql = "SELECT * FROM vehicletype";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table id='user-table'>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Vehicle Type</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td></td>
                <td>".$row["vehicle_name"]."</td>
              </tr>";
    }

    echo "</tbody>
        </table>";
}

// Close the database connection
$conn->close();
?>
