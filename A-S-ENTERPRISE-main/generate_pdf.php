<?php

// Include database connection
include "backend/db_connection.php";
require 'vendor/autoload.php';
// Get the table name from URL parameter
$tableName = isset($_GET['table']) ? $_GET['table'] : 'sell'; // Default to 'sell' if not provided

// Ensure table name is valid to prevent SQL injection
$validTables = ['sell', 'purchase'];
if (!in_array($tableName, $validTables)) {
    die('Invalid table name');
}
// SQL query
$sql = "SELECT * FROM companydetails";
// Execute query
$result1 = $conn->query($sql);
if ($row = $result1->fetch_assoc()) {
    $CompanyName = $row['CompanyName'];
    $CompanyAddress = $row['CompanyAddress'];
    $CompanyContactDetails = 'Phone Number:'.$row['CompanyPhoneNumber'] . ', Email Id:' . $row['CompanyEmailid'];
    $CompanyGSTIN = $row['CompanyGSTIN'];
    $CompanyStateCode = $row['CompanyStateCode'];
}

// Create a custom TCPDF class
class MYPDF extends TCPDF {
    // Declare properties to hold company details
    private $CompanyName;
    private $CompanyAddress;
    private $CompanyContactDetails;
    private $CompanyGSTIN;
    private $CompanyStateCode;
    private $tableName;

    // Constructor to initialize the properties
    public function __construct($tableName, $CompanyName, $CompanyAddress, $CompanyContactDetails, $CompanyGSTIN, $CompanyStateCode, $orientation, $unit, $format, $unicode, $encoding, $diskcache) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
        $this->CompanyName = $CompanyName;
        $this->CompanyAddress = $CompanyAddress;
        $this->CompanyContactDetails = $CompanyContactDetails;
        $this->CompanyGSTIN = $CompanyGSTIN;
        $this->CompanyStateCode = $CompanyStateCode;
        $this->tableName = $tableName;
    }


    public function Header() {
            // Determine the title based on tableName value
    switch ($this->tableName) {
        case 'sell':
            $title = 'Sell Report';
            break;
        case 'purchase':
            $title = 'Purchase Report';
            break;
        default:
            $title = $this->tableName . ' Report';
            break;
    }
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
    
            // Line break
            $this->Ln(10);
        }
    }
    
    

    // Page footer
    public function Footer() {
        // Set font
        $this->SetFont('dejavusans', 'I', 8);

        // Go to 1.5 cm from bottom
        $this->SetY(-15);

        // Page number
        $this->Cell(0, 5, "Page " . $this->getAliasNumPage() . "/" . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Create new PDF document
$pdf = new MYPDF($tableName,$CompanyName, $CompanyAddress, $CompanyContactDetails, $CompanyGSTIN, $CompanyStateCode, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('A S ENTERPRISE');
$pdf->SetTitle(''.$tableName.'_Report_'.date('Y.m.d').'');
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
    $pdf->Ln(35); // Adjust the space as needed
}


// SQL query
$sql = "SELECT * FROM parties";

// Execute query
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
            <tbody>';

// Generate table rows from database
$finalTotalAmount = 0;
if ($result1->num_rows > 0) {
    while($row = $result1->fetch_assoc()) {
        $balanceAmount = $row['totalAmount'] - $row['clearAmount'];
        $html .='<tr>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Date</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Party Name</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Phone No.</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Party GSTIN No.</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Total Amount</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Payment Type</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Received Payment</th>';
        $html .='    <th style="border: 1px solid #006769; text-align: center; background-color: #006769; color: white;">Balance Amount</th>';
        $html .='</tr>';

        $html .= '<tr>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row["id"] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row["partiesName"] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row["phoneNumber"] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row["gstin"] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row['totalAmount'] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row["paymentMethod"] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $row["clearAmount"] . '</td>';
            $html .= '<td style="border: 1px solid #ddd; background-color: #89BDBC; color: black; text-align: center;">' . $balanceAmount . '</td>';
        $html .= '</tr>';

        // Fetch nested data for this party
        $nested_sql = "SELECT * FROM $tableName WHERE buyerName = '" . $row["partiesName"] . "'";
        $nested_result = $conn->query($nested_sql);

        // Add nested table
        $html .= '<tr><td colspan="9" style="padding:0;">';
        $html .= '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
        $html .= '<thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">Date</th>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">Goods Name</th>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">HSN/SAC</th>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">Quantity</th>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">Price</th>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">GST</th>
                        <th style="border: 1px solid #ddd; padding: 6px; background-color: #56AC5C; color: white;">Gross Amount</th>
                    </tr>
                  </thead>
                  <tbody>';

        if ($nested_result->num_rows > 0) {
            while ($nested_row = $nested_result->fetch_assoc()) {
                $nested_sql_goods = "SELECT * FROM goods WHERE name = '" . $nested_row["goodsName"] . "' AND amount = " . $nested_row["goodsAmount"];
                // Execute the query
                $result = $conn->query($nested_sql_goods);

                if ($result) {
                    // Fetch data using a while loop
                    while ($row = $result->fetch_assoc()) {
                        // Process each row
                        $goodsHSNSAC=$row["HSN/SAC"];
                        $goodsGST=$row["gst"];
                        // Add more fields as needed
                    }
                }
                $amount = ($nested_row["goodsAmount"] * $nested_row["goodsQuantity"]);
                $grossAmount = ($amount + ($amount * ($goodsGST / 100))) ;

                $html .= '<tr>';
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' . $nested_row["dateTime"] . '</td>';
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' . $nested_row["goodsName"] . '</td>';
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' . $goodsHSNSAC . '</td>'; // Assuming goodsHSN exists
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' . $nested_row["goodsQuantity"] . '</td>';
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' . $nested_row["goodsAmount"] . '</td>';
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' . $goodsGST . '</td>'; // Assuming goodsGST exists
                $html .= '<td style="border: 1px solid #000; padding: 6px;">' .$grossAmount . '</td>';
                $html .= '</tr>';
                $finalTotalAmount +=$grossAmount;
            }
        } else {
            $html .= '<tr><td colspan="7" style="border: 1px solid #ddd; padding: 6px; text-align: center;">No details found</td></tr>';
        }

        $html .= '</tbody></table></td></tr><br><br>';

        // Ensure page breaks for long content
        if ($pdf->getY() > 250) {
            $pdf->AddPage();
        }
    }
} else {
    $html .= '<tr><td colspan="9" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No results found</td></tr>';
}

$html .= '
            </tbody>
        </table>
    </div>';
    // SQL query to select the total amount for the current month
    // $sql = "SELECT SUM(totalAmount) AS total_amount FROM $tableName ";
    // $result = $conn->query($sql);
    // // Fetch the result
    // $row = $result->fetch_assoc();
    $totalSaleAmount = floatval(round($finalTotalAmount, 2));
    $html .= '<h1 style="font-size:20px; font-style:bold;text-align: right;">Total '.$tableName.': ₹' . (($totalSaleAmount === 0) ? 0.0 : $totalSaleAmount) . '</h1>';
    $html.='
    </body>
    </html>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    ob_end_clean(); // Clear the output buffer
    $pdf->Output(''.$tableName.'_Report_'.date('Y.m.d').'.pdf', 'I'); // 'I' for inline display in browser, 'D' for download
?>
