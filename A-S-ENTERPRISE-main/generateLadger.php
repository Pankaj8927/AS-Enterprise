<?php
// Start output buffering
ob_start();

// Include database connection
include "backend/db_connection.php";
require 'vendor/autoload.php';

// Get the table name from URL parameter
$tableName = isset($_GET['table']) ? $_GET['table'] : 'ladger'; // Default to 'sell' if not provided
$user = isset($_GET['user']) ? $conn->real_escape_string($_GET['user']) : '';

// Ensure table name is valid to prevent SQL injection
$validTables = ['sell', 'purchase', 'ladger'];
if (!in_array($tableName, $validTables)) {
    die('Invalid table name');
}

// SQL query to fetch company details
$sql = "SELECT * FROM companydetails";
$result1 = $conn->query($sql);
if ($row = $result1->fetch_assoc()) {
    $CompanyName = $row['CompanyName'];
    $CompanyAddress = $row['CompanyAddress'];
    $CompanyContactDetails = 'Phone Number: ' . $row['CompanyPhoneNumber'] . ', Email: ' . $row['CompanyEmailid'];
    $CompanyGSTIN = $row['CompanyGSTIN'];
    $CompanyStateCode = $row['CompanyStateCode'];
}

// Fetch parties' details
$partiesDetails = [];
if ($user != '') {
    // Fetch partiesName and phoneNumber from ladger table
    $sql = "SELECT partiesName, phoneNumber FROM `ladger` WHERE partiesName = '$user'";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $partiesName = $row['partiesName'];
        $phoneNumber = $row['phoneNumber'];

        // Fetch detailed information from parties table
        $sqlParties = "SELECT * FROM `parties` WHERE partiesName = '$partiesName' AND phoneNumber = '$phoneNumber'";
        $resultParties = $conn->query($sqlParties);
        if ($rowParties = $resultParties->fetch_assoc()) {
            $partiesDetails = [
                'Party Name' => $rowParties['partiesName'],
                'Phone Number' => $rowParties['phoneNumber'],
                'Address' => $rowParties['billingAddress'] . ', ' . $rowParties['shippingAddress'], // Combine addresses
                'GSTIN' => $rowParties['gstin']
            ];
        }
    }
}

// Create a custom TCPDF class
class MYPDF extends TCPDF {
    private $CompanyName;
    private $CompanyAddress;
    private $CompanyContactDetails;
    private $CompanyGSTIN;
    private $CompanyStateCode;
    private $tableName;
    private $partiesDetails;

    public function __construct($tableName, $CompanyName, $CompanyAddress, $CompanyContactDetails, $CompanyGSTIN, $CompanyStateCode, $partiesDetails, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
        $this->CompanyName = $CompanyName;
        $this->CompanyAddress = $CompanyAddress;
        $this->CompanyContactDetails = $CompanyContactDetails;
        $this->CompanyGSTIN = $CompanyGSTIN;
        $this->CompanyStateCode = $CompanyStateCode;
        $this->tableName = $tableName;
        $this->partiesDetails = $partiesDetails;
    }

    public function Header() {
        // Determine the title based on tableName value
        $title = ucfirst($this->tableName) . ' Report';

        // Check if it's the first page
        if ($this->getPage() == 1) {
            // Set font
            $this->SetFont('dejavusans', 'B', 12);
            $this->Cell(0, 10, $this->CompanyName, 0, 1, 'L');
            $this->SetFont('dejavusans', '', 10);
            $this->Cell(0, 5, 'Company Address: ' . $this->CompanyAddress, 0, 1, 'L');
            $this->Cell(0, 5, $this->CompanyContactDetails, 0, 1, 'L');
            $this->Cell(0, 5, 'GSTIN: ' . $this->CompanyGSTIN, 0, 1, 'L');
            $this->Cell(0, 5, 'State Code: ' . $this->CompanyStateCode, 0, 1, 'L');

            // Title
            $this->SetFont('dejavusans', 'B', 12);
            $this->Cell(0, 10, $title, 'B', 1, 'C');

            // Add parties details
            $this->SetFont('dejavusans', 'B', 8);
            if (!empty($this->partiesDetails)) {
 // Add some space before the parties details
                foreach ($this->partiesDetails as $label => $value) {
                    $this->Cell(0, 5, $value, 0, 1, 'C');
                }
                 // Add some space after the parties details
            }

            // Line break
            $this->Ln(10);
        }
    }

    public function Footer() {
        $this->SetFont('dejavusans', 'I', 8);
        $this->SetY(-15);
        $this->Cell(0, 5, "Page " . $this->getAliasNumPage() . "/" . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Create new PDF document
$pdf = new MYPDF($tableName, $CompanyName, $CompanyAddress, $CompanyContactDetails, $CompanyGSTIN, $CompanyStateCode, $partiesDetails, PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('A S ENTERPRISE');
$pdf->SetTitle($tableName . '_Report_' . date('Y.m.d'));
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(2, 10, 2);
$pdf->SetHeaderMargin(3);
$pdf->SetFooterMargin(0);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('dejavusans', '', 8);

// Add a page
$pdf->AddPage();

// Add a small space before the table on the first page
if ($pdf->getPage() == 1) {
    $pdf->Ln(50); // Adjust the space as needed
}

// Initialize total counters
$totalDebit = 0;
$totalCredit = 0;

// SQL query to fetch data from the ladger table with specific columns
$sql= '';
if ($user == '') {
    $sql = "SELECT * FROM `ladger`";
}
else {
    $sql = "SELECT * FROM `ladger` WHERE partiesName = '$user'";
}

$result1 = $conn->query($sql);

// Initialize HTML content
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Sample PDF</title>
</head>
<body>
    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;width: 80px;">ID</th>
                    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;width: 80px;">Date</th>
                    <!--<th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Party Name</th>-->
                    <!--<th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Phone No.</th>-->
                    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;width:270px;">Payment Method</th>
                    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Debit</th>
                    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Credit</th>
                    <!--<th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Balance</th>-->
                </tr>
            </thead>
            <tbody>';

// Generate table rows from database
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        // Parse and format the dateTime
        $dateTime = DateTime::createFromFormat('Y.m.d-H:i:s', $row["dateTime"]);
        if ($dateTime === false) {
            $formattedDateTime = 'Invalid Date';
        } else {
            $formattedDateTime = $dateTime->format('Y.m.d');
        }


        // Calculate balance
        $debit = floatval($row["debit"]);
        $credit = floatval($row["credit"]);
        $balance = $credit + $debit;
        $formattedBalance = ($balance > 0 ? '+' : '') . number_format($balance, 2);

        // Accumulate totals
        $totalDebit += $debit;
        $totalCredit += $credit;

        $html .= '<tr>';
        $html .= '<td style="border: 1px solid #ddd; text-align: center; width:80px;">' . htmlspecialchars($row["id"]) . '</td>';
        $html .= '<td style="border: 1px solid #ddd; text-align: center; width:80px;">' . $formattedDateTime . '</td>';
        // $html .= '<td style="border: 1px solid #ddd; text-align: center;">' . htmlspecialchars($row["partiesName"]) . '</td>';
        // $html .= '<td style="border: 1px solid #ddd; text-align: center;">' . htmlspecialchars($row["phoneNumber"]) . '</td>';
        $html .= '<td style="border: 1px solid #ddd; text-align: left;width:270px;">' . htmlspecialchars($row["paymentMethod"]) . '<br>' . htmlspecialchars($row["paymentReference"]) . '</td>';
        $html .= '<td style="border: 1px solid #ddd; text-align: center;">' . number_format($debit, 2) . '</td>';
        $html .= '<td style="border: 1px solid #ddd; text-align: center;">' . number_format($credit, 2) . '</td>';
        // $html .= '<td style="border: 1px solid #ddd; text-align: center;">' . $formattedBalance . '</td>';
        $html .= '</tr>';

        // Ensure page breaks for long content
        if ($pdf->getY() > 250) {
            $pdf->AddPage();
        }
    }
} else {
    $html .= '<tr><td colspan="5" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No records found.</td></tr>';
}

// Calculate and format the total balance
$totalBalance = $totalCredit + $totalDebit;
$totalBalance2 = $totalCredit - $totalDebit;
$formattedTotalBalance = ($totalBalance > 0 ? '+' : '') . number_format($totalBalance, 2);

// Add a summary row for totals
$html .= '
            <tr>
                <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: left; font-weight: bold;">Total:</td>
                <td style="border: 1px solid #ddd; text-align: center; font-weight: bold;">' . number_format($totalDebit, 2) . '</td>
                <td style="border: 1px solid #ddd; text-align: center; font-weight: bold;">' . number_format($totalCredit, 2) . '</td>
                <!--<td style="border: 1px solid #ddd; text-align: center; font-weight: bold;">' . $formattedTotalBalance . '</td>-->
            </tr>';

$html .= '
            </tbody>
        </table>';
        $html .= '
    <p style="text-align: right; font-weight: bold; font-size: 16px;">Closing Balance: ' .$totalBalance2. '</p>
    </div>
</body>
</html>';

// Output HTML content as PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Clean (erase) the output buffer
ob_end_clean();

// Close and output PDF document
$pdf->Output($tableName . '_Report_'.$user.'_' . date('Y_m_d') . '.pdf', 'I');

// Close database connection
$conn->close();
?>
