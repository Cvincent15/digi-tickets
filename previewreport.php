<?php
session_start();
include 'php/database_connect.php'; 
require_once('TCPDF/tcpdf.php');

// Function to fetch vehicle_name based on vehicle_id
function fetchVehicleName($vehicleId, $conn) {
    // Perform a database query to fetch vehicle_name based on vehicle_id
    $query = "SELECT vehicle_name FROM vehicletype WHERE vehicle_id = $vehicleId";
    $result = mysqli_query($conn, $query);
  
    // Check if the query was successful and if a row was returned
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['vehicle_name'];
    } else {
        // Return a default value or handle the error as needed
        return "Vehicle not found"; // Replace with your desired default value or error message
    }
  }

  
  function fetchViolationTickets()
  {
      global $conn; // Assuming you have a database connection established
  
      // Write a SQL query to fetch data from the violation_tickets table
      $sql = "SELECT 
              violation_tickets.*,
              CONCAT(users.first_name, ' ', IFNULL(users.middle_name, ''), ' ', users.last_name) AS driver_name,
              vehicletype.vehicle_name as vehicle_name,
              GROUP_CONCAT(DISTINCT violationlists.violation_section SEPARATOR ', ') AS concatenated_sections
          FROM violation_tickets
              JOIN vehicletype ON violation_tickets.vehicle_type = vehicletype.vehicle_id
              LEFT JOIN violations ON violation_tickets.ticket_id = violations.ticket_id_violations
              LEFT JOIN violationlists ON violations.violationlist_id = violationlists.violation_list_ids
              LEFT JOIN users ON users.user_ctmeu_id = violation_tickets.user_ctmeu_id
          WHERE violation_tickets.user_ctmeu_id IS NOT NULL
          GROUP BY violation_tickets.ticket_id;
      "; // Modify this query as needed
  
      // Execute the query
      $result = mysqli_query($conn, $sql);
  
      // Check if the query was successful
      if ($result) {
          // Initialize an empty array to store the fetched data
          $data = array();
  
          // Fetch data and store it in the array
          while ($row = mysqli_fetch_assoc($result)) {
              $data[] = $row;
          }
  
          // Return the fetched data
          return $data;
      } else {
          // Handle the error, e.g., display an error message
          echo "Error: " . mysqli_error($conn);
          return array(); // Return an empty array if there was an error
      }
  }

$violationTickets = fetchViolationTickets();
function generatePDF($data) {
    require_once('TCPDF/tcpdf.php');
  
    // Create a new TCPDF instance with landscape orientation
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
  
    // Set document information
    $pdf->SetTitle('CTMEU Traffic Violation Data');
    $pdf->SetSubject('Traffic Violation Data');
    $pdf->SetKeywords('CTMEU, traffic violation, PDF');
  
    // Add a page
    $pdf->AddPage();
    
    $pdf->Image('images/santarc.jpg', 45, 15, 25, 0, 'JPG');
    $pdf->Image('images/ctmeu.jpg', 230, 15, 25, 0, 'JPG');
    // Set font size and style for the first part of the header text
  
  // Set draw color and fill color to white
  $pdf->SetDrawColor(255, 255, 255);
  $pdf->SetFillColor(255, 255, 255);
  
  $pdf->SetFont('helvetica', '', 12);
  
  // Set position for the first part of the header text
  $pdf->SetXY(10, 10); // Adjust the X and Y coordinates as needed
  
  // Concatenate the lines into a single string
  $headerText = "
  Republika ng Pilipinas
  ";
  
  // Output the header text using a single MultiCell call
  $pdf->MultiCell(0, 8, $headerText, 0, 'C');
  
  // Set font size for the second part of the header text
  $pdf->SetFont('helvetica', '', 10);
  
  // Adjust the Y-coordinate to position the next part on the same line
  $pdf->SetY($pdf->GetY() - 5); // Subtract the height of the previous MultiCell
  
  // Output the second part of the header text using MultiCell
  $pdf->MultiCell(0, 8, "
  Lungsod ng Santa Rosa\n
  ", 0, 'C');
  
  // Set font size for the third part of the header text
  $pdf->SetFont('helvetica', '', 8);
  
  // Adjust the Y-coordinate to position the next part on the same line
  $pdf->SetY($pdf->GetY() - 7); // Subtract the height of the previous MultiCell
  
  // Output the third part of the header text using MultiCell
  $pdf->MultiCell(0, 8, "
  Lalawigan ng Laguna
  ", 0, 'C');
  
  // Set font size and style for the second part of the header text
  $pdf->SetFont('helvetica', 'B', 14);
  
  // Output the second part of the header text using MultiCell
  $pdf->MultiCell(0, 8, "SANGAY NG PAMAMAHALA AT PAGPAPATUPAD NG TRAPIKO", 0, 'C');
  
  // Set font size for the third part of the header text
  $pdf->SetFont('helvetica', '', 8);
  
  // Output the third part of the header text using MultiCell
  $pdf->MultiCell(0, 8, "(CITY TRAFFIC MANAGEMENT AND ENFORCEMENT UNIT)", 0, 'C');
  
  // Reset font for the rest of the content
  $pdf->SetFont('helvetica', '', 8);
  
    // Remove the line above the header
  $pdf->SetLineStyle(array('width' => 0)); // Set line width to 0
  
  // Define the table layout
  $tbl = '<table width="100%" cellspacing="0" cellpadding="4" border="1">';
  $tbl .= '<tr bgcolor="#cccccc">';
  $tbl .= '<th style="width:2%;">#</th>'; // Adjust the width as needed
  $tbl .= '<th width="5%">Ticket No.</th>';
  $tbl .= '<th width="5%">Date Occurred</th>';
  $tbl .= '<th width="5%">Time Occurred</th>';
  $tbl .= '<th width="10%">Driver\'s Name</th>';
  $tbl .= '<th width="10%">Driver\'s Address</th>';
  $tbl .= '<th width="10%">License No.</th>';
  $tbl .= '<th width="8%">Issuing District</th>';
  $tbl .= '<th width="5%">Vehicle</th>';
  $tbl .= '<th width="5%">Plate No.</th>';
  $tbl .= '<th width="10%">Registered Owner</th>';
  $tbl .= '<th width="10%">Registered Owner\'s Address</th>';
  $tbl .= '<th width="5%">Place of Violation</th>';
  $tbl .= '<th width="5%">Violations</th>';
  $tbl .= '<th width="5%">Account Status</th>';
  $tbl .= '</tr>';
  
  $ticketNumber = 1; // Initialize ticket number
  
  // Populate the table rows with data
  foreach ($data as $row) {
    include 'php/database_connect.php';
  
    $tbl .= '<tr>';
    $tbl .= '<td style="width:2%;">' . $ticketNumber . '</td>'; // Use the ticket number as No.
    $tbl .= '<td width="5%">' . $row['control_number'] . '</td>';
    $tbl .= '<td width="5%">' . $row['date_violation'] . '</td>';
    $tbl .= '<td width="5%">' . $row['time_violation'] . '</td>';
    $tbl .= '<td width="10%">' . $row['driver_name'] . '</td>';
    $tbl .= '<td width="10%">' . $row['driver_address'] . '</td>';
    $tbl .= '<td width="10%">' . $row['driver_license'] . '</td>';
    $tbl .= '<td width="8%">' . $row['issuing_district'] . '</td>';
    $tbl .= '<td width="5%">' . $row['vehicle_name'] . '</td>';
    $tbl .= '<td width="5%">' . $row['plate_no'] . '</td>';
    $tbl .= '<td width="10%">' . $row['reg_owner'] . '</td>';
    $tbl .= '<td width="10%">' . $row['reg_owner_address'] . '</td>';
    $tbl .= '<td width="5%">' . $row['place_of_occurrence'] . '</td>';
    $tbl .= '<td width="5%">'. $row['concatenated_sections'] .'</td>';
    $tbl .= '<td width="5%">' . ($row['is_settled'] == 0 ? 'Unsettled' : 'Settled') . '</td>';
    $tbl .= '</tr>';
   
    $ticketNumber++; // Increment ticket number
   }
   
   $tbl .= '</table>';
  
  // Output the table to the PDF
  $pdf->writeHTML($tbl, true, false, false, false, '');
  
  
  // Add a row for signatures at the bottom of the table
  $tblSignatures = '<table width="100%" cellspacing="0" cellpadding="8">';
  $tblSignatures .= '<tr>';
  $tblSignatures .= '<td colspan="2">Administrator\'s Signature: ____________________________</td>';
  $tblSignatures .= '<td colspan="2" style="text-align: right;">Authorized By: ____________________________</td>';
  $tblSignatures .= '</tr>';
  $tblSignatures .= '</table>';
  
  $pdf->writeHTML($tblSignatures, true, false, false, false, '');
  
  // Return the PDF content as a string
  return $pdf->Output('', 'S');
  }

  // Get the generated PDF content from the session variable
$pdfContent = isset($_SESSION['preview_pdf_content']) ? $_SESSION['preview_pdf_content'] : '';

// Check if PDF content is available in the session
if (isset($_SESSION['preview_pdf_content'])) {
    // Output PDF content
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="preview.pdf"');
    echo $_SESSION['preview_pdf_content'];

    // Clear the session variable after displaying the PDF
    unset($_SESSION['preview_pdf_content']);
} else {
    // Handle the case when no PDF content is found
    echo "PDF content not available.";
}

// Clear the session variable
unset($_SESSION['preview_pdf_content']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview PDF</title>
</head>
<body>
    <div>
        <!-- Display the generated PDF content directly in the HTML -->
        <object data="data:application/pdf;base64,<?php echo base64_encode($pdfContent); ?>" type="application/pdf" width="100%" height="600px">
            <p>Your browser does not support PDF embedding. You can <a href="data:application/pdf;base64,<?php echo base64_encode($pdfContent); ?>" download="preview.pdf">download the PDF</a> instead.</p>
        </object>
    </div>
    
</body>
</html>