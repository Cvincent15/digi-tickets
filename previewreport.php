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

  
// Define a function to fetch data from the violation_tickets table
function fetchViolationTickets() {
  global $conn; // Assuming you have a database connection established

  // Specify the columns you want to fetch from the violation_tickets table
  $sql = "SELECT t.ticket_id, t.driver_name,  t.driver_license, t.vehicle_type, t.plate_no, t.date_time_violation, t.place_of_occurrence, t.user_ctmeu_id, t.user_id_motorists, t.is_settled
          FROM violation_tickets AS t
          LEFT JOIN violations AS v ON t.ticket_id = v.ticket_id_violations
          GROUP BY t.ticket_id"; // Modify this query as needed

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

    // Create a new TCPDF instance with landscape orientation
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('CTMEU Traffic Violation Data');
    $pdf->SetSubject('Traffic Violation Data');
    $pdf->SetKeywords('CTMEU, traffic violation, PDF');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);


    // Remove the line above the header
$pdf->SetLineStyle(array('width' => 0)); // Set line width to 0

// Define the table layout
$tbl = '<table width="100%" cellspacing="0" cellpadding="4" border="1">';
$tbl .= '<tr bgcolor="#cccccc">';
$tbl .= '<th>No.</th>';
$tbl .= '<th>Name</th>';
$tbl .= '<th>License No.</th>';
$tbl .= '<th>Place Occurred</th>';
$tbl .= '<th>Plate</th>';
$tbl .= '<th>Vehicle</th>';
$tbl .= '<th>Date Occurred</th>';
$tbl .= '<th>Account Status</th>';
$tbl .= '</tr>';

$ticketNumber = 1; // Initialize ticket number

// Populate the table rows with data
foreach ($data as $row) {
    include 'php/database_connect.php';
    $vehicleId = $row['vehicle_type'];
    $vehicleName = fetchVehicleName($vehicleId, $conn);
    $tbl .= '<tr>';
    $tbl .= '<td>' . $ticketNumber . '</td>'; // Use the ticket number as No.
    $tbl .= '<td>' . $row['driver_name'] . '</td>';
    $tbl .= '<td>' . $row['driver_license'] . '</td>';
    $tbl .= '<td>' . $row['place_of_occurrence'] . '</td>';
    $tbl .= '<td>' . $row['plate_no'] . '</td>';
    $tbl .= '<td>' . $vehicleName . '</td>';
    $tbl .= '<td>' . $row['date_time_violation'] . '</td>';
    $tbl .= '<td>' . ($row['is_settled'] == 0 ? 'Unsettled' : 'Settled') . '</td>';
    $tbl .= '</tr>';

    $ticketNumber++; // Increment ticket number
}

$tbl .= '</table>';

// Output the table to the PDF with header
$pdf->writeHTML('
    <div style="text-align: center; margin-top: 10px;">
        <h1 style="font-size: 14px; margin: 0;">Republika ng Pilipinas</h1>
        <p style="font-size: 12px; margin: 0;">Lungsod ng Santa Rosa</p>
        <p style="font-size: 10px; margin: 0;">Lalawigan ng Laguna</p>
        <p style="font-size: 16px; font-weight: bold; margin-bottom: 10px; margin: 0;">SANGAY NG PAMAMAHALA AT PAGPAPATUPAD NG TRAPIKO</p>
        <p style="font-size: 10px; margin-bottom: 20px; margin: 0;">(CITY TRAFFIC MANAGEMENT AND ENFORCEMENT UNIT)</p>
    </div>
    ' . $tbl, true, false, false, false, '');

// Add a row for signatures at the bottom of the table
$tblSignatures = '<table width="100%" cellspacing="0" cellpadding="8">';
$tblSignatures .= '<tr>';
$tblSignatures .= '<td colspan="4">Administrator\'s Signature: ____________________________</td>';
$tblSignatures .= '<td colspan="4">Chief\'s Signature: ____________________________</td>';
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