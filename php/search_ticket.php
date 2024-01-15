<?php
// Include your database connection file if not already included
include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data based on the search input
    $search_query = $_POST['search_query'];
    $sql = "SELECT * FROM violation_tickets WHERE ticket_id LIKE '%$search_query%'";
    $result = $conn->query($sql);

    // Process and display the data (you can customize this part)
    if ($result->num_rows > 0) {
        echo '<div class="row mx-5">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-6">';
            echo '<div class="mx-3 mt-3 fw-bolder">Driver\'s Name <br><div class="m-2 fw-normal">' . $row["driver_name"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Driver\'s License No. <br><div class="m-2 fw-normal">' . $row["driver_license"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Vehicle Type <br><div class="m-2 fw-normal">' . $row["vehicle_type"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">COR No. <br><div class="m-2 fw-normal">' . $row["driver_name"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Registered Owner <br><div class="m-2 fw-normal">' . $row["reg_owner"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Date and Time of Violation <br><div class="m-2 fw-normal">' . $row["date_violation"] . ' ' . $row["time_violation"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Violation/s <br><div class="m-2 fw-normal">' . $row["driver_name"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Account Status <br><div class="m-2 fw-normal">' . $row["is_settled"] . '</div><br></div>';
            // Add more fields as needed
            echo '</div>';
            echo '<div class="col-6">';
            echo '<div class="mx-3 mt-3 fw-bolder">Driver\'s Address <br><div class="m-2 fw-normal">' . $row["driver_address"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Issuing District <br><div class="m-2 fw-normal">' . $row["issuing_district"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Plate No. <br><div class="m-2 fw-normal">' . $row["plate_no"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Place Issued <br><div class="m-2 fw-normal">' . $row["driver_address"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Registered Owner\s Address <br><div class="m-2 fw-normal">' . $row["reg_owner_address"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Place of Occurrence <br><div class="m-2 fw-normal">' . $row["place_of_occurrence"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Driver\'s Name <br><div class="m-2 fw-normal">' . $row["driver_name"] . '</div><br></div>';
            // Add more fields as needed
            
            echo '</div>';
        }
        echo '</div>';
        
    } else {
        echo "No results found";
    }

    $conn->close();
}
?>