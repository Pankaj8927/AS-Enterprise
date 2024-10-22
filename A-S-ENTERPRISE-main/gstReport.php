<?php
// Start output buffering
ob_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include "backend/db_connection.php";
require 'vendor/autoload.php';

$tableName = isset($_GET['table']) ? $_GET['table'] : 'sell'; // Default to 'sell' if not provided

// Ensure table name is valid to prevent SQL injection
$validTables = ['sell', 'purchase'];
if (!in_array($tableName, $validTables)) {
    die('Invalid table name');
}
// Fetch company details
$sql = "SELECT * FROM companydetails";
$result1 = $conn->query($sql);
if ($row = $result1->fetch_assoc()) {
    $CompanyName = $row['CompanyName'];
    $CompanyAddress = $row['CompanyAddress'];
    $CompanyContactDetails = 'Phone Number: ' . $row['CompanyPhoneNumber'] . ', Email Id: ' . $row['CompanyEmailid'];
    $CompanyGSTIN = $row['CompanyGSTIN'];
    $CompanyStateCode = $row['CompanyStateCode'];
}

// Create a custom TCPDF class
class MYPDF extends TCPDF {
    private $CompanyName;
    private $CompanyAddress;
    private $CompanyContactDetails;
    private $CompanyGSTIN;
    private $CompanyStateCode;

    public function __construct($tableName, $CompanyName, $CompanyAddress, $CompanyContactDetails, $CompanyGSTIN, $CompanyStateCode) {
        parent::__construct();
        $this->CompanyName = $CompanyName;
        $this->CompanyAddress = $CompanyAddress;
        $this->CompanyContactDetails = $CompanyContactDetails;
        $this->CompanyGSTIN = $CompanyGSTIN;
        $this->CompanyStateCode = $CompanyStateCode;
        $this->tableName = $tableName;

    }

    public function Header() {
        switch ($this->tableName) {
            case 'sell':
                $title = 'Sell';
                $nameReport = 'GSTR 1';
                break;
            case 'purchase':
                $title = 'Purchase';
                $nameReport = 'GSTR 2';
                break;
            default:
                $title = $this->tableName . ' Report';
                break;
        }
        if ($this->getPage() == 1) {
            $this->SetFont('dejavusans', 'B', 12);
            $this->Cell(0, 10, $this->CompanyName, 0, 1, 'L');
            $this->SetFont('dejavusans', '', 10);
            $this->Cell(0, 5, 'Company Address: ' . $this->CompanyAddress, 0, 1, 'L');
            $this->Cell(0, 5, $this->CompanyContactDetails, 0, 1, 'L');
            $this->Cell(0, 5, 'GSTIN: ' . $this->CompanyGSTIN, 0, 1, 'L');
            $this->Cell(0, 5, 'State Code: ' . $this->CompanyStateCode, 0, 1, 'L');

            $this->SetFont('dejavusans', 'B', 12);
            $this->Cell(0, 10, ''.$nameReport.' Report', 0, 1, 'C');

            $this->SetFont('dejavusans', '', 10);
            $this->Cell(($this->GetPageWidth() / 2),7,'1. GSTIN',1,0,'L');
            $this->Cell(0,7, $this->CompanyGSTIN,1,1,'L');
            $this->Cell(($this->GetPageWidth() / 2),7,'2.a Legal name of the registered person',1,0,'L');
            $this->Cell(0,7, $this->CompanyName,1,1,'L');
            $this->Cell(($this->GetPageWidth() / 2),7,'2.b Trade name, if any',1,0,'L');
            $this->Cell(0,7,'',1,1,'L');
            $this->Cell(($this->GetPageWidth() / 2),7,'3.a Aggregate Turnover in the preceeding Financial Year.',1,0,'L');
            $this->Cell(0,7,'',1,1,'L');
            $this->Cell(($this->GetPageWidth() / 2),7,'3.b Aggregate Turnover, April to June 2017',1,0,'L');
            $this->Cell(0,7,'',1,1,'L');
            $this->Cell(0,7,'','B',1,'L');
            $this->ln(2);
            $this->SetFont('', 'B', 10);
            $this->Cell(0,7, $title,'',1,'C');

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
$pdf = new MYPDF($tableName,$CompanyName, $CompanyAddress, $CompanyContactDetails, $CompanyGSTIN, $CompanyStateCode);

switch ($tableName) {
    case 'sell':
        $title = 'Sell';
        $nameReport = 'GSTR 1';
        break;
    case 'purchase':
        $title = 'Purchase';
        $nameReport = 'GSTR 2';
        break;
    default:
        $title = $this->tableName . ' Report';
        break;
}
// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('A S ENTERPRISE');
$pdf->SetTitle(''.$nameReport.'_Report_' . date('Y.m.d'));
$pdf->SetSubject(''.$nameReport.' Report');
$pdf->SetKeywords('TCPDF, PDF, '.$nameReport.', Report');

// Set margins
$pdf->SetMargins(2, 10, 2);
$pdf->SetHeaderMargin(3);
$pdf->SetFooterMargin(0);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// Set font
$pdf->SetFont('dejavusans', '', 6);

// Add a page
$pdf->AddPage();
$width = $pdf->GetPageWidth() / 12 - 2;
$pdf->SetY(100);

$pdf->Cell($width,7*2,'GSTIN/',1,0,'C');
$pdf->Cell($width*4,7,'Invoice details',1,0,'C');
$pdf->Cell($width,7*2,'Rate',1,0,'C');
$pdf->Cell($width,7*2,'Cess',1,0,'C');
$pdf->Cell($width,7*2,'Taxable',1,0,'C');
$pdf->Cell($width*4,7,'Amount',1,0,'C');
$pdf->Cell(0,7*2,'Place of',1,1,'C');

$pdf->SetY(107);

$pdf->Cell($width,7,'UIN',0,0,'C');
$pdf->Cell($width,7,'Name',1,0,'C');
$pdf->Cell($width,7,'Inv No.',1,0,'C');
$pdf->Cell($width,7,'Date',1,0,'C');
$pdf->Cell($width,7,'Value',1,0,'C');
$pdf->Cell($width,7,'',0,0,'C');
$pdf->Cell($width,7,'Rate',0,0,'C');
$pdf->Cell($width,7,'value',0,0,'C');
$pdf->Cell($width,7,'ITC',1,0,'C');
$pdf->Cell($width,7,'CGST',1,0,'C');
$pdf->Cell($width,7,'SGST',1,0,'C');
$pdf->Cell($width,7,'Cess',1,0,'C');
$pdf->Cell(0,7,'Supply',0,1,'C');

// Table Data
$sql = "SELECT * FROM $tableName";
$result = $conn->query($sql);
$pdf->SetY(114);
$defaultHeight = 5; // Set default height for MultiCells
$footerHeight = 20;

while ($row = $result->fetch_assoc()) {
    // Replace with your actual field names
    $buyerName= $row['buyerName'];
    $gstin = $row['gstin'];
    $dateTime = $row['dateTime'];
    $dateObject = DateTime::createFromFormat('Y.m.d-H:i:s', $dateTime);
    if ($dateObject) {
        $formattedDate = $dateObject->format('Y.m.d'); // Format date as YYYY.MM.DD
    } else {
        $formattedDate = 'Invalid Date';
    }
    $stateNameCode = $row['stateNameCode'];
    preg_match('/(\d+)$/', $stateNameCode, $matches);
    if (!empty($matches)) {
        $lastNumbers = $matches[1]; // The matched numbers at the end
        $compressedStateCode = 'c-' . $lastNumbers;
    } else {
        $compressedStateCode = 'c-unknown';
    }
    $InvoiceNumber = $row['invoiceNumber'];
    $goodsAmount = isset($row['goodsAmount']) ? floatval($row['goodsAmount']) : 0.0;
    $goodsQuantity = isset($row['goodsQuantity']) ? intval($row['goodsQuantity']) : 0;
    $GST = isset($row['GST']) ? floatval($row['GST']) : 0.0;
    $Cess = isset($row['cess']) ? floatval($row['cess']) : 0.0;
    $ITC = isset($row['itc']) ? floatval($row['itc']) : 0.0;
    $value = $goodsAmount * $goodsQuantity;
    $tax= ($value * ($GST / 100));
    $taxValue = ($value * ($GST / 100));
    $taxPlusValue = $value + $taxValue;

    // Store heights
    $heights = [];
    // $width = 20; // assuming the cell width is 20, adjust accordingly

    // Calculate the heights of each MultiCell based on the content
    $heights[] = $pdf->getStringHeight($width, $gstin);
    $heights[] = $pdf->getStringHeight($width, $buyerName);
    $heights[] = $pdf->getStringHeight($width, $InvoiceNumber);
    $heights[] = $pdf->getStringHeight($width, $formattedDate);
    $heights[] = $pdf->getStringHeight($width, round($taxPlusValue, 1));
    $heights[] = $pdf->getStringHeight($width, $GST);
    $heights[] = $pdf->getStringHeight($width, $Cess);
    $heights[] = $pdf->getStringHeight($width, round($value, 1));
    $heights[] = $pdf->getStringHeight($width, $ITC);
    $heights[] = $pdf->getStringHeight($width, round($taxValue / 2, 1));
    $heights[] = $pdf->getStringHeight($width, $compressedStateCode);

    // Find the maximum height based on content or default height
    $maxHeight = max($defaultHeight, max($heights));

    // Calculate the available space on the page considering the footer
    $availableHeight = $pdf->getPageHeight() - $pdf->getBreakMargin() - $footerHeight;

    // Ensure the remaining space on the page can accommodate the row height
    if ($pdf->GetY() + $maxHeight > $availableHeight) {
        $pdf->AddPage(); // Add a new page if there's not enough space
    }

    // Use MultiCell for wrapping and adjust Y position
    $startX = $pdf->GetX();
    $startY = $pdf->GetY();

    $pdf->MultiCell($width, $maxHeight, $gstin, 1, 'C', false, 0, $startX, $startY);
    $pdf->MultiCell($width, $maxHeight, $buyerName, 1, 'C', false, 0, $startX + $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $InvoiceNumber, 1, 'C', false, 0, $startX + 2 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $formattedDate, 1, 'C', false, 0, $startX + 3 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($taxPlusValue, 1), 1, 'C', false, 0, $startX + 4 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $GST, 1, 'C', false, 0, $startX + 5 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $Cess, 1, 'C', false, 0, $startX + 6 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($value, 1), 1, 'C', false, 0, $startX + 7 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $ITC, 1, 'C', false, 0, $startX + 8 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($taxValue / 2, 1), 1, 'C', false, 0, $startX + 9 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($taxValue / 2, 1), 1, 'C', false, 0, $startX + 10 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $Cess, 1, 'C', false, 0, $startX + 11 * $width, $startY);
    $pdf->MultiCell(0, $maxHeight, $compressedStateCode, 1, 'C', false, 0, $startX + 12 * $width, $startY);

    // Move to the next row
    $pdf->Ln($maxHeight);

    // Update totals
    $TtaxPlusValue += $taxPlusValue;
    $Tvalue += $value;
    $TITC += $ITC;
    $TtaxValue += $taxValue / 2;
    $TCess += $Cess;
}

// $pdf->SetY($nextYAxis);

$pdf->Cell($width*4,7,'Total',1,0,'L');
$pdf->Cell($width,7,round($TtaxPlusValue, 1),1,0,'C');
$pdf->Cell($width,7,'',1,0,'C');
$pdf->Cell($width,7,$TCess,1,0,'C');
$pdf->Cell($width,7,round($Tvalue, 1),1,0,'C');
$pdf->Cell($width,7,$TITC,1,0,'C');
$pdf->Cell($width,7,round($TtaxValue, 1),1,0,'C');
$pdf->Cell($width,7,round($TtaxValue, 1),1,0,'C');
$pdf->Cell($width,7,round($TCess, 1),1,0,'C');
$pdf->Cell(0,7,'',1,1,'C');

// $nextYAxis+=14;

// $pdf->SetY($nextYAxis);
$pdf->SetFont('', 'B', 10);
$pdf->Cell(0,7,''.$pdf->$title.' Return','B',1,'C');

$pdf->SetFont('', '', 6);

$width = $pdf->GetPageWidth() / 14 - 2;

$pdf->Cell($width,7*2,'GSTIN/',1,0,'C');
$pdf->Cell($width*6,7,'Invoice details',1,0,'C');
$pdf->Cell($width,7*2,'Rate',1,0,'C');
$pdf->Cell($width,7*2,'Cess',1,0,'C');
$pdf->Cell($width,7*2,'Taxable',1,0,'C');
$pdf->Cell($width*4,7,'Amount',1,0,'C');
$pdf->Cell(0,7*2,'Place of',1,0,'C');
$pdf->Cell($width,7,'',0,1,'C');

// $pdf->SetY($nextYAxis+14);

$pdf->Cell($width,7,'UIN',0,0,'C');
$pdf->Cell($width,7,'Name',1,0,'C');
$pdf->Cell($width,7,'R No.',1,0,'C');
$pdf->Cell($width,7,'R Date',1,0,'C');
$pdf->Cell($width,7,'Inv No.',1,0,'C');
$pdf->Cell($width,7,'Date',1,0,'C');
$pdf->Cell($width,7,'Value',1,0,'C');
$pdf->Cell($width,7,'',0,0,'C');
$pdf->Cell($width,7,'Rate',0,0,'C');
$pdf->Cell($width,7,'value',0,0,'C');
$pdf->Cell($width,7,'ITC',1,0,'C');
$pdf->Cell($width,7,'CGST',1,0,'C');
$pdf->Cell($width,7,'SGST',1,0,'C');
$pdf->Cell($width,7,'Cess',1,0,'C');
$pdf->Cell(0,7,'Supply',0,1,'C');


// Fetch sell return data
$returnSql = "SELECT * FROM {$tableName}return";
$returnResult = $conn->query($returnSql);
while ($returnRow = $returnResult->fetch_assoc()) {
    // Data retrieval and calculations
    $buyerName = $returnRow['partiesName'];
    $gstin = $returnRow['partiesGSTIN'];
    $dateTime = $returnRow['dateTime'];
    $dateObject = DateTime::createFromFormat('Y.m.d-H:i:s', $dateTime);
    $formattedDate = $dateObject ? $dateObject->format('Y.m.d') : 'Invalid Date';

    $stateNameCode = $returnRow['placeOfSupply'];
    preg_match('/(\d+)$/', $stateNameCode, $matches);
    $compressedStateCode = !empty($matches) ? 'c-' . $matches[1] : 'c-unknown';

    $returnNumberFormat = $tableName . 'ReturnNo';
    $returnNumber = $returnRow[$returnNumberFormat];
    $goodsAmount = isset($returnRow['totalAmount']) ? floatval($returnRow['totalAmount']) : 0.0;
    $goodsQuantity = isset($returnRow['quantity']) ? intval($returnRow['quantity']) : 0;
    $GST = isset($returnRow['gst']) ? floatval($returnRow['gst']) : 0.0;
    $Cess = isset($returnRow['cess']) ? floatval($returnRow['cess']) : 0.0;
    $ITC = isset($returnRow['itc']) ? floatval($returnRow['itc']) : 0.0;

    $value = $goodsAmount * $goodsQuantity;
    $taxValue = $value * ($GST / 100);
    $taxPlusValue = $value + $taxValue;

    // Calculate heights of each MultiCell based on content
    $heights = [];
    // $width = 20; // Adjust as needed

    $heights[] = $pdf->getStringHeight($width, $gstin);
    $heights[] = $pdf->getStringHeight($width, $buyerName);
    $heights[] = $pdf->getStringHeight($width, $returnNumber);
    $heights[] = $pdf->getStringHeight($width, $formattedDate);
    $heights[] = $pdf->getStringHeight($width, $invoiceNumber);
    $heights[] = $pdf->getStringHeight($width, round($returnRow['totalAmount'], 1));
    $heights[] = $pdf->getStringHeight($width, $returnRow['gst']);
    $heights[] = $pdf->getStringHeight($width, $Cess);
    $heights[] = $pdf->getStringHeight($width, round($goodsAmount, 1));
    $heights[] = $pdf->getStringHeight($width, $ITC);
    $heights[] = $pdf->getStringHeight($width, round($taxValue / 2, 1));
    $heights[] = $pdf->getStringHeight($width, $compressedStateCode);

    $maxHeight = max($defaultHeight, max($heights));

    // Calculate available height
    $availableHeight = $pdf->getPageHeight() - $pdf->getBreakMargin() - $footerHeight;

    // Ensure remaining space on the page can accommodate the row height
    if ($pdf->GetY() + $maxHeight > $availableHeight) {
        $pdf->AddPage(); // Add a new page if there's not enough space
    }

    // Start drawing cells
    $startX = $pdf->GetX();
    $startY = $pdf->GetY();

    $pdf->MultiCell($width, $maxHeight, $gstin, 1, 'C', false, 0, $startX, $startY);
    $pdf->MultiCell($width, $maxHeight, $buyerName, 1, 'C', false, 0, $startX + $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $returnNumber, 1, 'C', false, 0, $startX + 2 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $formattedDate, 1, 'C', false, 0, $startX + 3 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $returnRow['invoiceNumber'], 1, 'C', false, 0, $startX + 4 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $formattedDate, 1, 'C', false, 0, $startX + 5 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($returnRow['totalAmount'], 1), 1, 'C', false, 0, $startX + 6 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $returnRow['gst'], 1, 'C', false, 0, $startX + 7 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $Cess, 1, 'C', false, 0, $startX + 8 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($goodsAmount, 1), 1, 'C', false, 0, $startX + 9 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $ITC, 1, 'C', false, 0, $startX + 10 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($taxValue / 2, 1), 1, 'C', false, 0, $startX + 11 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, round($taxValue / 2, 1), 1, 'C', false, 0, $startX + 12 * $width, $startY);
    $pdf->MultiCell($width, $maxHeight, $Cess, 1, 'C', false, 0, $startX + 13 * $width, $startY);
    $pdf->MultiCell(0, $maxHeight, $compressedStateCode, 1, 'C', false, 1, $startX + 14 * $width, $startY);

    // Accumulate totals
    $totalAmountTotal += $returnRow['totalAmount'];
    $goodsAmountTotal += $goodsAmount;
    $cgstTotal += $taxValue / 2;
    $sgstTotal += $taxValue / 2;
    $cessTotal += $Cess;
    $finalTotal += $taxPlusValue;
}

$pdf->Cell($width*6,7,'Total',1,0,'C');
$pdf->Cell($width,7,round($totalAmountTotal,1),1,0,'C');
$pdf->Cell($width,7,'',1,0,'C');
$pdf->Cell($width,7,'0.0',1,0,'C');
$pdf->Cell($width,7,round($goodsAmountTotal,1),1,0,'C');
$pdf->Cell($width,7,'0.0',1,0,'C');
$pdf->Cell($width,7,round($cgstTotal,1),1,0,'C');
$pdf->Cell($width,7,round($sgstTotal,1),1,0,'C');
$pdf->Cell($width,7,$cessTotal,1,0,'C');
$pdf->Cell(0,7,'',1,1,'C');






// End output buffering and clean up
ob_end_clean();

// Output PDF document (force download)
$pdf->Output(''.$nameReport.'_Report_' . date('Y.m.d') . '.pdf', 'I');

// Restore error reporting
error_reporting(E_ALL);
?>
