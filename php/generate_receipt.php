<?php
// generate_receipt.php
include 'database_connect.php';

// Function to fetch vehicle_name based on vehicle_type
function fetchVehicleName($vehicleType, $conn) {
    // Perform a database query to fetch vehicle_name based on vehicle_type
    $query = "SELECT vehicle_name FROM vehicletype WHERE vehicle_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $vehicleType);
    $stmt->execute();
    $stmt->bind_result($vehicleName);

    // Check if the query was successful and if a row was returned
    if ($stmt->fetch()) {
        return $vehicleName;
    } else {
        // Return a default value or handle the error as needed
        return "Vehicle not found"; // Replace with your desired default value or error message
    }
}

// Function to fetch violations for a specific ticket
function fetchViolationsForTicket($ticketId, $conn) {
    // Perform a database query to fetch violations based on ticket_id
    $query = "SELECT v.violation_name, v.violation_fine FROM violations v
              JOIN violation_lists vl ON v.violationlist_id = vl.violationlist_id
              JOIN violation_tickets vt ON vl.ticket_id_violations = vt.ticket_id
              WHERE vt.ticket_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ticketId);
    $stmt->execute();
    $stmt->bind_result($violationName, $fineAmount);

    $violations = [];

    // Fetch all violations related to the ticket
    while ($stmt->fetch()) {
        $violations[] = [
            'violation_name' => $violationName,
            'violation_fine' => $fineAmount
        ];
    }

    return $violations;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Process $requestData['ticketDetails'] and generate the receipt
    $ticketDetails = $requestData['ticketDetails'];
    $vehicleName = fetchVehicleName($ticketDetails['vehicle_type'], $conn); // Fetch vehicle_name
    $receipt = generateReceipt($ticketDetails, $vehicleName);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'receipt' => $receipt]);
    exit();
}

// Handle other HTTP methods
http_response_code(405); // Method Not Allowed
exit();


// Function to generate a receipt based on the provided design
function generateReceipt($ticketDetails, $vehicleName) {
    // Start building the receipt HTML
    $receipt = '<div class="main" id="ticket-receipt">';
    $receipt .= '<div class="heading">';
    $receipt .= '<p class="introduction">Dear ' . $ticketDetails['driver_name'] . ',<br /><br />This email serves as a notification that you have been issued a traffic violation on ' . date('Y-m-d H:i:s') . '.</p>';
    $receipt .= '</div>';
    $receipt .= '<div class="summer-sale-up-to-wrapper"><p class="summer-sale-up-to">Traffic Citation Ticket</p></div>';
    $receipt .= '<div class="paragraph-text"><p class="date-and-time">' . date('Y-m-d H:i:s') . '</p></div>';

    
    // Table section
    $receipt .= '<div class="table">';
    foreach ($ticketDetails['violations'] as $violation) {
        $receipt .= '<div class="table-row">';
        $receipt .= '<div class="something-that-is">' . $violation['violation_name'] . '</div>';
        $receipt .= '<div class="element">' . $violation['violation_fine'] . ' PHP</div>';
        $receipt .= '</div>';
    }
    $receipt .= '<div class="div">';
    $receipt .= '<div class="text-wrapper">Total</div>';
    $receipt .= '<div class="element-2">PHP</div>'; //' . $ticketDetails['total_fine'] . ' 
    $receipt .= '</div>';
    $receipt .= '</div>';

    // Other sections
    $receipt .= '<div class="ticket-details">';
    $receipt .= '<div class="hi-george-we-ve-det-wrapper"><p class="hi-george-we-ve-det">The details of the traffic citation are:</p></div>';
    $receipt .= '<div class="horizontal-rule"><div class="line-color"><div class="color"></div></div></div>';

    // Input fields section
    $inputFields = [
        'Driver’s Name' => $ticketDetails['driver_name'],
        'License Number' => $ticketDetails['driver_license'],
        'Type of Vehicle' => $vehicleName
        //'Plate Number' => $ticketDetails['plate_number']
        //'Traffic Enforcer’s Name' => $ticketDetails['traffic_enforcer_name']
    ];

    foreach ($inputFields as $label => $value) {
        $receipt .= '<div class="input-fields-edit">';
        $receipt .= '<div class="text-wrapper-2">' . $label . '</div>';
        $receipt .= '<div class="frame"><div class="text-wrapper-3">' . $value . '</div></div>';
        $receipt .= '</div>';
    }
    $receipt .= '</div>';
    // Additional sections
    $receipt .= '<div class="paragraph-text">';
    $receipt .= '<p class="steps-and-reminders">';
    $receipt .= '<span class="span">To pay your fine, please follow these steps:<br /></span>';
    $receipt .= '<span class="text-wrapper-4">1. Gather the following:<br />    *A copy of your traffic violation notice (This email can also serve as a copy)<br />    *Valid photo ID<br />    *Payment (Cash, Gcash, and Maya)<br />2. Visit City Treasury Office: <br />3. Present your documents and payment to the treasury.<br />4. Receive an official receipt of payment.<br /><br /></span>';
    $receipt .= '<span class="span">Important notes:<br /></span>';
    $receipt .= '<span class="text-wrapper-4">If you choose to contest your citation, you may contact us.<br />Sincerely,<br />City Traffic Management Enforcement Unit</span>';
    $receipt .= '</p></div>';
    $receipt .= '<div class="line-color-wrapper"><div class="line-color"><div class="color-2"></div></div></div>';
    $receipt .= '<img class="contact-svg" src="images/contact-svg.png" />';
    $receipt .= '<div class="inquiry-wrapper">';
    $receipt .= '<p class="inquiry">';
    $receipt .= '<span class="text-wrapper-5">For any inquiries, please contact the </span>';
    $receipt .= '<span class="text-wrapper-6">City Traffic Management Enforcement Unit</span>';
    $receipt .= '<span class="text-wrapper-5"> at 09487448484.</span>';
    $receipt .= '</p></div>';
    $receipt .= '</div>';

    return $receipt;
}

?>
