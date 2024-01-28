<?php
// Include your database connection file if not already included
include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data based on the search input
    $search_query = $_POST['search_query'];
    $unique_code = $_POST['unique_code'];
    // Modify the SQL query to include a JOIN clause
    $sql = "SELECT violation_tickets.*, vehicletype.vehicle_name
            FROM violation_tickets
            LEFT JOIN vehicletype ON violation_tickets.vehicle_type = vehicletype.vehicle_id
            WHERE violation_tickets.control_number LIKE '%$search_query%' AND violation_tickets.uniqueCode = '$unique_code'";
    $result = $conn->query($sql);

    // Process and display the data (you can customize this part)
    if ($result->num_rows > 0 ) {
        
        while ($row = $result->fetch_assoc()) {
            
        // Display the "Ticket Details" and "No." header
        echo '<div class="modal-header mx-5"><h3 class="modal-title mt-3" id="searchResultsModalLabel" style="color: #1A3BB1; font-weight: 700;">Ticket Details</h3>';
        echo '<h3 class="modal-title mt-3" id="searchResultsModalLabel" style="color: maroon; font-weight: 400;">No. ' . $row["control_number"] . '</h3> </div>';

        echo '<div class="row mx-5">';
            echo '<div class="col-6">';
            echo '<div class="mx-3 mt-3 fw-bolder">Driver\'s Name <br><div class="m-2 fw-normal">' . $row["driver_name"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Driver\'s License No. <br><div class="m-2 fw-normal">' . $row["driver_license"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Vehicle <br><div class="m-2 fw-normal">' . $row["vehicle_name"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">COR No. <br><div class="m-2 fw-normal">' . $row["cor_number"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Registered Owner <br><div class="m-2 fw-normal">' . $row["reg_owner"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Date and Time of Violation <br><div class="m-2 fw-normal">' . $row["date_violation"] . ' ' . $row["time_violation"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Account Status <br><div class="m-2 fw-normal">' . ($row["is_settled"] ? 'Settled' : 'Unsettled') . '</div><br></div>';
            // Modified code to fetch and display multiple violations
            echo '<div class="mx-3 fw-bolder">Violation/s <br>';
            echo '<div class="m-2 fw-normal">';
            
             // Fetch violations associated with the current ticket
             $ticketId = $row["ticket_id"]; // Assuming control_number is the primary key in violation_tickets
             $sqlViolations = "SELECT violations.*, violationlists.violation_name, violationlists.violation_section, violationlists.violation_fine
                               FROM violations
                               LEFT JOIN violationlists ON violations.violationlist_id = violationlists.violation_list_ids
                               WHERE violations.ticket_id_violations = $ticketId";
             $resultViolations = $conn->query($sqlViolations);
 
             $totalFines = 0; // Initialize total fines
 
             if ($resultViolations->num_rows > 0) {
                 while ($violationRow = $resultViolations->fetch_assoc()) {
                     // Display violation list details
                     echo $violationRow["violation_name"] . ' | ' . $violationRow["violation_section"] . ' | Fines: ₱' . $violationRow["violation_fine"] . '<br>';
                     $totalFines += $violationRow["violation_fine"]; // Accumulate fines
                 }
             } else {
                 echo 'No violations found';
             }
 
             echo '</div></div>';
            echo '</div>';
            echo '<div class="col-6">';
            echo '<div class="mx-3 mt-3 fw-bolder">Driver\'s Address <br><div class="m-2 fw-normal">' . $row["driver_address"] . '</div><br></div> 
            <div class="mx-3 fw-bolder">Issuing District <br><div class="m-2 fw-normal">' . $row["issuing_district"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Plate No. <br><div class="m-2 fw-normal">' . $row["plate_no"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Place Issued <br><div class="m-2 fw-normal">' . $row["driver_address"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Registered Owner\s Address <br><div class="m-2 fw-normal">' . $row["reg_owner_address"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Place of Occurrence <br><div class="m-2 fw-normal">' . $row["place_of_occurrence"] . '</div><br></div>
            <div class="mx-3 fw-bolder">Remarks <br><div class="m-2 fw-normal">' . $row["remarks"] . '</div><br></div>';
            // Add more fields as needed
            
            echo '</div>';
        }
        echo '</div>';
        // Display total fines at the bottom
        echo '<div class="mx-5 mt-3 fw-bolder text-end">Total Fines: $' . $totalFines . '</div>';
        
    } else {
        echo "No results found";
    }

    $conn->close();
}
?>