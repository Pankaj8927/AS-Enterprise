<?php
// Start output buffering
ob_start();

require 'vendor/autoload.php';
include "backend/db_connection.php";

// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Simple PDF Report');
$pdf->SetSubject('PDF Report');

// Set margins
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Get the URL parameter values
$id = isset($_GET['id']) ? $_GET['id'] : 'No id provided';
$challanNo = isset($_GET['challanNo']) ? $_GET['challanNo'] : 'No challanNo provided';

// Query to get the data from the challan table
$sql = "SELECT * FROM challan WHERE challanNo = '$challanNo'";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die('Error: ' . $conn->error);
}

// Fetch the data
$data = $result->fetch_assoc();

// Fetch the company details
$sql = "SELECT * FROM companydetails";
$result1 = $conn->query($sql);
if ($row = $result1->fetch_assoc()) {
    $CompanyName = $row['CompanyName'];
    $CompanyAddress = $row['CompanyAddress'];
    $CompanyContactDetails = 'Phone Number: ' . $row['CompanyPhoneNumber'] . ', Email: ' . $row['CompanyEmailid'];
    $CompanyGSTIN = 'GSTIN: ' . $row['CompanyGSTIN'];
    $CompanyStateCode = 'State: ' . $row['CompanyStateCode'];
}

// Print the header text centered
$pdf->Cell(0, 10, 'Delivery Challan', 0, 1, 'C');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(100, 5, $CompanyName, 0, 0, "L");
$pdf->Cell(100 / 2, 5, "Challan No", "LTR", 0, "L");
$pdf->Cell(0, 5, "Date", "LTR", 1, "L");

$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 5, $CompanyAddress, 0, 0, "L");
$pdf->Cell(100 / 2, 5, $challanNo, "LBR", 0, "L");
$pdf->Cell(0, 5, $data['dateTime'], "LBR", 1, "L");

$pdf->Cell(100, 5, $CompanyContactDetails, 0, 0, "L");
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(100 / 2, 5, "Place Of Supply", "LTR", 0, "L");
$pdf->Cell(0, 5, "", "LTR", 1, "L");

$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(100, 5, $CompanyGSTIN, 0, 0, "L");
$pdf->Cell(100 / 2, 5, $data['placeOfSupply'], "LBR", 0, "L");
$pdf->Cell(0, 5, "", "LBR", 1, "L");

$pdf->Cell(100, 5, $CompanyStateCode, 0, 0, "L");
$pdf->Cell(100 / 2, 5, "", 0, 0, "L");
$pdf->Cell(0, 5, "", 0, 1, "L");
$pdf->Ln(1);
$pdf->Cell(0, 0, "", "B", 1);

// Initialize array to store goods details
$goodsDetails = [];
$totalQuantity = 0;

// Query to get all data from the challan table for the given challanNo
$sql = "SELECT * FROM challan WHERE challanNo = '$challanNo'";
$resultChallan = $conn->query($sql);

// Check for query errors
if (!$resultChallan) {
    die('Error: ' . $conn->error);
}

// Fetch all goods details and add to the array
$quantity = 1;
while ($row = $resultChallan->fetch_assoc()) {
    $goodsDetails[] = $row;
    $totalQuantity += $quantity;
}

// Generate HTML content for party details
$partyDetailsHtml = '<h3>Delivery Challan For</h3>';
$partyDetailsHtml .= '<p>Party Name: ' . htmlspecialchars($data['partiesName']) . '</p>';
$partyDetailsHtml .= '<p>Contact Number: ' . htmlspecialchars($data['partiesContactNumber']) . '</p>';
$partyDetailsHtml .= '<p>Shipping Address: ' . htmlspecialchars($data['partiesShipAddress']) . '</p>';
$partyDetailsHtml .= '<p>GSTIN: ' . htmlspecialchars($data['partiesGSTIN']) . '</p>';
$partyDetailsHtml .= '<p>State: ' . htmlspecialchars($data['partiesStateCode']) . '</p><br><hr>';

// Generate HTML content for goods details
$goodsDetailsHtml = '<h3>Goods Details</h3>';
$goodsDetailsHtml .= '<table border="1" cellpadding="4" cellspacing="0">';
$goodsDetailsHtml .= '<thead>
                        <tr>
                            <th style="width:50px;">Sl. No.</th>
                            <th style="width:220px;">Goods Name</th>
                            <th style="width:150px;">Serial/Chassis Number</th>
                            <th style="width:70px;">HSN/SAC</th>
                            <th style="width:50px;">Quantity</th>
                        </tr>
                      </thead>
                      <tbody>';

$slNo = 1; // Initialize serial number
foreach ($goodsDetails as $goods) {
    $serialChasisText = '';
    if (!empty($goods['serialNumber'])) {
        $serialChasisText = 'Serial No-' . htmlspecialchars($goods['serialNumber']);
    }
    if (!empty($goods['chasisNumber'])) {
        if (!empty($serialChasisText)) {
            $serialChasisText .= ' / ';
        }
        $serialChasisText .= 'Chasis No-' . htmlspecialchars($goods['chasisNumber']);
    }
    $goodsDetailsHtml .= '<tr>
                            <td style="width:50px;">' . $slNo++ . '</td>
                            <td style="width:220px;">' . htmlspecialchars($goods['goodsName']) . '</td>
                            <td style="width:150px;">' . $serialChasisText . '</td>
                            <td style="width:70px;">' . htmlspecialchars($goods['HSNSAC']) . '</td>
                            <td style="width:50px;">'.$quantity.'</td>
                          </tr>';
}

$goodsDetailsHtml .= '</tbody>
                      <tfoot>
                        <tr>
                            <td colspan="4">Total Quantity</td>
                            <td>' . $totalQuantity . '</td>
                        </tr>
                      </tfoot>';
$goodsDetailsHtml .= '</table>';
// Generate HTML content for description
$descriptionHtml = '<h3>Description</h3>';
$descriptionHtml .= '<p>' . htmlspecialchars($data['description']) . '</p><br><hr>';

// Generate HTML content for the signature section
$signatureHtml = '
    <div style="width:100%; display:flex; flex-direction:column; text-align:right; align-items:end; line-height:20px;">
        <p>'.$CompanyName.'</p>
        <br>
        <p>Authorised Signature</p>
    </div>';


// Add HTML content to PDF
$pdf->writeHTML($partyDetailsHtml, true, false, true, false, '');
$pdf->writeHTML($goodsDetailsHtml, true, false, true, false, '');
$pdf->writeHTML($descriptionHtml, true, false, true, false, '');
$pdf->writeHTML($signatureHtml, true, false, true, false, '');




// Close the connection
$conn->close();

// End output buffering and flush output
ob_end_clean();

// Output the PDF
$pdf->Output('simple_report.pdf', 'I');
?>
