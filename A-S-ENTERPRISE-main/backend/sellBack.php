<?php
// Include the database connection
include 'db_connection.php'; // Adjust this according to your database connection script

// Require FPDF library
require_once('../fpdf186/fpdf.php'); // Adjust the path to FPDF library
// require '../vendor/autoload.php';
// Function to convert amount to words (simple implementation for demonstration)
function convertNumberToWords($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'forty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

class PDF extends FPDF
{
    // Properties to store header values
    private $formattedString;
    private $delNoDate;
    private $paymentMethod2;
    private $refNoDate;
    private $othRef;
    private $buyer_name;
    private $buyer_shipAddress;
    private $buyOdrNo;
    private $dated;
    private $contact_number;
    private $gstin;
    private $stateCode;
    private $disDocNo;
    private $delNoteDate;
    private $hyp;
    private $des;
    private $terOfDel;
    private $buyer_billAddress;

    // Constructor to initialize header values
    function __construct($headerValues)
    {
        parent::__construct();
        $this->formattedString = $headerValues['formattedString'];
        $this->delNoDate = $headerValues['delNoDate'];
        $this->paymentMethod2 = $headerValues['paymentMethod2'];
        $this->refNoDate = $headerValues['refNoDate'];
        $this->othRef = $headerValues['othRef'];
        $this->buyer_name = $headerValues['buyer_name'];
        $this->buyer_shipAddress = $headerValues['buyer_shipAddress'];
        $this->buyOdrNo = $headerValues['buyOdrNo'];
        $this->dated = $headerValues['dated'];
        $this->contact_number = $headerValues['contact_number'];
        $this->gstin = $headerValues['gstin'];
        $this->state = $headerValues['state'];
        $this->disDocNo = $headerValues['disDocNo'];
        $this->delNoteDate = $headerValues['delNoteDate'];
        $this->hyp = $headerValues['hyp'];
        $this->des = $headerValues['des'];
        $this->terOfDel = $headerValues['terOfDel'];
        $this->buyer_billAddress = $headerValues['buyer_billAddress'];
    }

    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(190, 5, 'TAX INVOICE', 0, 1, 'C');
        $this->Ln(2);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 5, 'A S ENTERPRISE', "LTR", 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 5, "Invoice No:", "LTR", 0, 'L');
        $this->Cell(45, 5, "Date: ", "LTR", 1, 'L');

        // Seller Details
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 5, "SAHEB BAZAR, NEAR JANGIPUR BUS", "L", 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(45, 5, $this->formattedString, "LR", 0, 'L');
        $this->Cell(45, 5, date("d-M-Y"), "LR", 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 5, "STAND,JANGIPUR", "L", 0, 'L');
        $this->Cell(45, 5, "Delivery No. & Date", "LTR", 0, 'L');
        $this->Cell(45, 5, "Mode/Terms fo Payment", "LTR", 1, 'L');
        $this->Cell(100, 5, "GSTIN/UIN: 19ETWPR8283K", "L", 0, 'L');
        $this->Cell(45, 5, $this->delNoDate, "LBR", 0, 'L');
        $this->Cell(45, 5, $this->paymentMethod2, "LBR", 1, 'L');
        $this->Cell(100, 5, "STATE NAME: WEST BENGAL, CODE: 19", "L", 0, 'L');
        $this->Cell(45, 5, "Reference No & Date", "LTR", 0, 'L');
        $this->Cell(45, 5, "Other References", "LTR", 1, 'L');

        // Shipment Details
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 5, "Consignee (Ship To)", "LT", 0, 'L');
        $this->Cell(45, 5, $this->refNoDate, "LBR", 0, 'L');
        $this->Cell(45, 5, $this->othRef, "LBR", 1, 'L');
        $this->Cell(100, 5, $this->buyer_name, "L", 0, 'L');
        $this->Cell(45, 5, "Buyer's Order No.", "LTR", 0, 'L');
        $this->Cell(45, 5, "Dated", "LTR", 1, 'L');
        $this->Cell(100, 5, $this->buyer_shipAddress, "L", 0, 'L');
        $this->Cell(45, 5, $this->buyOdrNo, "LBR", 0, 'L');
        $this->Cell(45, 5, $this->dated, "LBR", 1, 'L');
        $this->Cell(100, 5, $this->contact_number, "L", 0, 'L');
        $this->Cell(45, 5, "Dispatch Doc No.", "LTR", 0, 'L');
        $this->Cell(45, 5, "Delivery Note Date", "LTR", 1, 'L');
        $this->Cell(100, 5, "GSTIN/UIN : ".$this->gstin."", "L", 0, 'L');
        $this->Cell(45, 5, $this->disDocNo, "LBR", 0, 'L');
        $this->Cell(45, 5, $this->delNoteDate, "LBR", 1, 'L');
        $this->Cell(100, 5, $this->stateCode, "L", 0, 'L');
        $this->Cell(45, 5, "HYPOTHICATION", "LTR", 0, 'L');
        $this->Cell(45, 5, "Destination", "LTR", 1, 'L');
        $this->Cell(100, 10, "", "L", 0, 'L');
        $this->Cell(45, 10, $this->hyp, "LBR", 0, 'L');
        $this->Cell(45, 10, $this->des, "LBR", 1, 'L');
        $this->Cell(100, 5, "Buyer (Bill To)", "LT", 0, 'L');
        $this->Cell(45, 5, "Terms Of Delivery", "LT", 0, 'L');
        $this->Cell(45, 5, "", "TR", 1, 'L');
        $this->Cell(100, 5, $this->buyer_name, "L", 0, 'L');
        $this->Cell(45, 5, $this->terOfDel, "L", 0, 'L');
        $this->Cell(45, 5, "", "R", 1, 'L');
        $this->Cell(100, 5, $this->buyer_billAddress, "L", 0, 'L');
        $this->Cell(45, 5, "", "L", 0, 'L');
        $this->Cell(45, 5, "", "R", 1, 'L');
        $this->Cell(100, 5, $this->contact_number, "L", 0, 'L');
        $this->Cell(45, 5, "", "L", 0, 'L');
        $this->Cell(45, 5, "", "R", 1, 'L');
        $this->Cell(100, 5, "GSTIN/UIN : ".$this->gstin."", "L", 0, 'L');
        $this->Cell(45, 5, "", "L", 0, 'L');
        $this->Cell(45, 5, "", "R", 1, 'L');
        $this->Cell(100, 5, $this->stateCode, "L", 0, 'L');
        $this->Cell(45, 5, "", "LB", 0, 'L');
        $this->Cell(45, 5, "", "BR", 1, 'L');
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
    function nblines($w, $txt)
    {
        // Width of the MultiCell
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
    
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    $categorys = isset($data['sell_submit']) ? $data['sell_submit'] : []; // This will be an array of objects
    // $categorys = isset($data['sell_submit']) ? $data['sell_submit'] : []; // This will be an array of objects

    $success = true;
    $errors = [];
    $category ='';
    $goods_name = '';
    $quantity = '';
    $amount = '';
    $gst = '';
    $brand = '';
    $description = '';
    // Get the additional form data
    $discount = isset($data['discount']) ? $data['discount'] : 0;
    $buyer_name = isset($data['buyer_name']) ? $data['buyer_name'] : 'N/A';
    // $description = isset($data['description']) ? $data['description'] : 'N/A';
    $buyer_billAddress = isset($data['buyer_billAddress']) ? $data['buyer_billAddress'] : 'N/A';
    $buyer_shipAddress = isset($data['buyer_shipAddress']) ? $data['buyer_shipAddress'] : 'N/A';
    $contact_number = isset($data['contact_number']) ? $data['contact_number'] : 'N/A';
    $state = isset($data['state']) ? $data['state'] : 'N/A';
    $gstin = isset($data['gstin']) ? $data['gstin'] : 'N/A';
    $invoice_maker = isset($data['invoice_maker']) ? $data['invoice_maker'] : 'N/A';

    $delNoDate = isset($data['delNoDate']) ? $data['delNoDate'] : '';
    $paymentMethod2 = isset($data['paymentMethod2']) ? $data['paymentMethod2'] : '';
    $refNoDate = isset($data['refNoDate']) ? $data['refNoDate'] : '';
    $othRef = isset($data['othRef']) ? $data['othRef'] : '';
    $buyOdrNo = isset($data['buyOdrNo']) ? $data['buyOdrNo'] : '';
    $dated = isset($data['dated']) ? $data['dated'] : '';
    $disDocNo = isset($data['disDocNo']) ? $data['disDocNo'] : '';
    $delNoteDate = isset($data['delNoteDate']) ? $data['delNoteDate'] : '';
    $hyp = isset($data['hyp']) ? $data['hyp'] : '';
    $des = isset($data['des']) ? $data['des'] : '';
    $terOfDel = isset($data['terOfDel']) ? $data['terOfDel'] : '';
    $extChaName = isset($data['extChaName']) ? $data['extChaName'] : '';
    $receivedinput = isset($data['receivedinput']) ? $data['receivedinput'] : 0;
    $chaAmount = isset($data['chaAmount']) ? $data['chaAmount'] : '';

    // Get current date and time for invoice
    $date_time = date("Ymd-His");
    $current_date_time = date('Y.m.d-H:i:s');
    $hsn_sac_number='';
    //insert the items to sell database
    foreach ($categorys as $item) {
        // Extract the values from each item
        $category = $conn->real_escape_string($item['category']);
        $goods_name = $conn->real_escape_string($item['name']);
        $description = $item['description'];
        $quantity = intval($item['quantity']);
        $perUnitAmount = floatval($item['amount_per_unit']); 
        $amount = floatval($perUnitAmount * $quantity);       
        $gst = floatval($item['gst']);  
        $id = $item['id'];  
        
        // SQL query to update quantity in goods table
        $sql_update = "UPDATE goods SET quantity = quantity - $quantity WHERE id = '$id'";

        // Execute the SQL query to update goods table
        if (!$conn->query($sql_update)) {
            $success = false;
            $errors[] = "Error updating quantity for category $category: " . $conn->error;
        }
        // Query to check the type of the party
        $sql_check_type = "SELECT type FROM parties WHERE partiesName = '$buyer_name' AND phoneNumber = '$contact_number'";
        $result = $conn->query($sql_check_type);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $party_type = $row['type'];

            // Conditionally update totalAmount or clearAmount based on party type
            if($receivedinput > 0){
                $partiesClearAmount = $amount - $receivedinput;

                if ($party_type === 'sale') {
                    $sql_update_parties = "UPDATE parties SET totalAmount = totalAmount + $amount, clearAmount = clearAmount + $partiesClearAmount WHERE partiesName = '$buyer_name' AND phoneNumber = '$contact_number'";
                } elseif ($party_type === 'purchase') {
                    $sql_update_parties = "UPDATE parties SET clearAmount = clearAmount + $partiesClearAmount WHERE partiesName = '$buyer_name' AND phoneNumber = '$contact_number'";
                }
            }
            // if ($party_type === 'sale') {
            //     $sql_update_parties = "UPDATE parties SET totalAmount = totalAmount + $amount WHERE partiesName = '$buyer_name' AND phoneNumber = '$contact_number'";
            // } elseif ($party_type === 'purchase') {
            //     $sql_update_parties = "UPDATE parties SET clearAmount = clearAmount + $amount WHERE partiesName = '$buyer_name' AND phoneNumber = '$contact_number'";
            // }

            // Execute the SQL query to update the parties table
            if (!$conn->query($sql_update_parties)) {
                $success = false;
                $errors[] = "Error updating amount for party $buyer_name: " . $conn->error;
            }
        } else {
            $success = false;
            $errors[] = "Party not found for $buyer_name with contact number $contact_number";
        }

        // SQL query to insert data
        $sql = "INSERT INTO sell (category, goodsName, description, brand, method, goodsAmount, goodsQuantity, discount, buyerName, buyerBillAdd, buyerShipAdd, contactNumber, stateNameCode, gstin, invoiceMakerName, dateTime, invoiceFiles) 
                VALUES ('$category', '$goods_name','$description','$brand','$paymentMethod2', '$amount', '$quantity', '$discount', '$buyer_name', '$buyer_billAddress', '$buyer_shipAddress', '$contact_number', '$state', '$gstin', '$invoice_maker', '$current_date_time', '')";
            
        // Execute the SQL query
        if (!$conn->query($sql)) {
            $success = false;
            $errors[] = "Error inserting category $category: " . $conn->error;
        }
        
    }

    // Attempt to insert data into the database
    if ($success) {
        // Get the last inserted ID
        $last_id = $conn->insert_id;
        // Query to get the last invoice number
        $numbersql = "SELECT MAX(invoiceNumber) AS last_invoice_number FROM sell";
        $numbersqlresult = mysqli_query($conn, $numbersql);
        $lastInvoiceNumber = $numbersqlresult ? mysqli_fetch_assoc($numbersqlresult)['last_invoice_number'] : "Error: " . mysqli_error($conn);
        mysqli_free_result($numbersqlresult);
        // Generate file name for PDF in a different folder
        $pdf_folder = "../invoices/"; // Adjust path to your desired location
        $pdf_file = "invoice_" . $date_time . ".pdf";
        // Create PDF document using FPDF
        // Initialize header values
        // Get the last two digits of the current year
        $currentYearShort = date("y"); // Get the current year's last two digits
        $nextYearShort = date("y", strtotime("+1 year")); // Get next year's last two digits
        
        $currentPlusNextYearShort = $currentYearShort . "-" . $nextYearShort;

        // Format the string as needed
        $formattedString = "ASE/{$currentPlusNextYearShort}/{$lastInvoiceNumber}";
        $headerValues = [
            'formattedString' => $formattedString,
            'delNoDate' => $delNoDate,
            'paymentMethod2' => $paymentMethod2,
            'refNoDate' => $refNoDate,
            'othRef' => $othRef,
            'buyer_name' => $buyer_name,
            'buyer_shipAddress' => $buyer_shipAddress,
            'buyOdrNo' => $buyOdrNo,
            'dated' => $dated,
            'contact_number' => $contact_number,
            'gstin' => $gstin,
            'state' => $state,
            'disDocNo' => $disDocNo,
            'delNoteDate' => $delNoteDate,
            'hyp' => $hyp,
            'des' => $des,
            'terOfDel' => $terOfDel,
            'buyer_billAddress' => $buyer_billAddress
        ];
        $pdf = new PDF($headerValues);
        $pdf->AddPage();
        

        // Calculate height for goods details section
        $header_height = 60; // Height of header section
        $footer_height = 60; // Height of footer section
        $remaining_height = (($pdf->GetPageHeight() - $pdf->GetY()) - $footer_height);
        // Itemized List with Tax Details
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 7, "Sr", 1);
        $pdf->Cell(70, 7, "Description of Goods", 1);
        $pdf->Cell(30, 7, "HSN/SAC", 1); // Added HSN/SAC column
        $pdf->Cell(10, 7, "Qty", 1);
        $pdf->Cell(20, 7, "Rate", 1);
        $pdf->Cell(20, 7, "Disc %", 1);
        $pdf->Cell(30, 7, "Amount", 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $srCounter = 1;
        $total_amount_before_tax = 0;
        $total_quantity = 0;
        $discount = (float) preg_replace('/[^0-9.]/', '', $discount); // Convert to float after removing non-numeric characters

        foreach ($categorys as $item) {
            $category = $item['category'];
            $goods_name = $item['name'];
            $description = $item['description'];
            $quantity = $item['quantity'];
            $amount_per_unit = $item['amount_per_unit'];
            $hsn_sac_number = $item['HSN/SAC'];
            $total_amount = $amount_per_unit * $quantity;
            $total_amount_before_tax += $total_amount;
            $total_quantity += $quantity;

            $text = "".$goods_name."\n".$description."";
            $lines = $pdf->nblines(70, $text);
            $rowHeight = 7 * $lines;

            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $maxY = $y;  // Track the maximum Y position
            // Serial Counter
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(10, 7, $srCounter, 'LR', 'C');
            $maxY = max($maxY, $pdf->GetY());
        
            $x += 10;
            $pdf->SetXY($x, $y);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->MultiCell(70, 7, $goods_name, 'LR', 'L');
            $maxY = max($maxY, $pdf->GetY());
            $pdf->SetFont('Arial', '', 10);
        
            // HSN/SAC Number
            $x += 70;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(30, 7, $hsn_sac_number, 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
        
            // Quantity
            $x += 30;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(10, 7, $quantity, 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
        
            // Amount per Unit
            $x += 10;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(20, 7, number_format($amount_per_unit, 2), 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
        
            // Discount Cell
            $x += 20;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(20, 7, '', 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
        
            // Total Amount
            $x += 20;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(30, 7, number_format($total_amount, 2), 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
                // Move Y position down by 7 units for the next row
            $pdf->SetY($maxY + 0);

            // Second Row (Serial Number, Description, Empty Columns)
            // Reset X position and update Y position
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            // Serial Number (same as first row)
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(10, $rowHeight, '', 'LR', 'C');
            $maxY = max($maxY, $pdf->GetY());

            // Description (should start in the Goods Name column)
            $x += 10;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(70, 7, $description, 'LR', 'L');
            $maxY = max($maxY, $pdf->GetY());

            // Empty Cells for HSN/SAC, Quantity, Amount per Unit, Discount, Total Amount
            $x += 70;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(30, $rowHeight, '', 'LR', 'R'); // HSN/SAC
            $x += 30;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(10, $rowHeight, '', 'LR', 'R'); // Quantity
            $x += 10;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(20, $rowHeight, '', 'LR', 'R'); // Amount per Unit
            $x += 20;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(20, $rowHeight, '', 'LR', 'R'); // Discount
            $x += 20;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(30, $rowHeight, '', 'LR', 'R'); // Total Amount
            $maxY = max($maxY, $pdf->GetY());
            // Move Y position down by 14 units for the next row
            $pdf->SetY($maxY);
        
            // Update y for the next row and reset x to start position
            $srCounter++;
            // Calculate the remaining height considering the footer and additional content
            $remaining_height = $pdf->GetPageHeight() - $pdf->GetY() - $footer_height;
        
            // Check if there is enough space for the next row (assuming minimum required space is 60)
            if ($remaining_height < 55) {
                // Determine the number of blank rows needed
                $row_height = 7; // Height of each row
                $num_blank_rows = ceil(($remaining_height + $footer_height - 40) / $row_height); // Adjust 20 if needed for padding
                
                // Insert blank cells to take up the remaining height
                for ($i = 0; $i < $num_blank_rows; $i++) {
                    $pdf->Cell(10, $row_height, '', 'LR', 0, 'R');
                    $pdf->Cell(70, $row_height, '', 'LR', 0, 'R');
                    $pdf->Cell(30, $row_height, '', 'LR', 0, 'R');
                    $pdf->Cell(10, $row_height, '', 'LR', 0, 'R');
                    $pdf->Cell(20, $row_height, '', 'LR', 0, 'R');
                    $pdf->Cell(20, $row_height, '', 'LR', 0, 'R');
                    $pdf->Cell(30, $row_height, '', 'LR', 1, 'R');
                }

                // Add a multicell with text indicating continuation on the next page
                $pdf->SetFont('Arial', 'I', 10);
                $pdf->MultiCell(0, 7, "Continued on Next Page", "LTRB", 'R');
                $pdf->Ln(); // Add a line break before the new page content

                
                $pdf->AddPage(); // Add a new page if there is not enough space
                        // Itemized List with Tax Details
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(10, 7, "Sr", 1);
                $pdf->Cell(70, 7, "Description of Goods", 1);
                $pdf->Cell(30, 7, "HSN/SAC", 1); // Added HSN/SAC column
                $pdf->Cell(10, 7, "Qty", 1);
                $pdf->Cell(20, 7, "Rate", 1);
                $pdf->Cell(20, 7, "Disc %", 1);
                $pdf->Cell(30, 7, "Amount", 1);
                $pdf->Ln();
            }
        }
        

        // Step 1: Calculate the discount amount
        $discount_amount = $total_amount_before_tax * ($discount / 100);

        // Step 2: Calculate the total amount after discount
        $total_amount_after_discount = $total_amount_before_tax - $discount_amount;

        // Calculate CGST and SGST (assuming both are 9% each)
        $gst = (float)$gst / 100;
        $cgstp = $gst / 2;
        $sgstp = $gst / 2;

        $cgst = round($total_amount_after_discount * $cgstp, 2);
        $sgst = round($total_amount_after_discount * $sgstp, 2);

        // Calculate total amount after tax
        $total_amount_after_tax = $total_amount_before_tax + $cgst + $sgst;
        $final_amount = $total_amount_after_discount + $cgst + $sgst + $chaAmount;

        $rounded_off_value = round($final_amount, 0) - $final_amount;
        $final_amount_rounded = round($final_amount, 0);

        // Insert blank cells to take up the remaining height
        $current_y = $pdf->GetY();
        while ($current_y < $pdf->GetPageHeight() - $footer_height - 65) { // Adjust 50 if needed
            $pdf->Cell(10, 7, '', 'LR', 0, 'R');
            $pdf->Cell(70, 7, '', 'LR', 0, 'R');
            $pdf->Cell(30, 7, '', 'LR', 0, 'R');
            $pdf->Cell(10, 7, '', 'LR', 0, 'R');
            $pdf->Cell(20, 7, '', 'LR', 0, 'R');
            $pdf->Cell(20, 7, '', 'LR', 0, 'R');
            $pdf->Cell(30, 7, '', 'LR', 1, 'R');
            $current_y = $pdf->GetY();
        }

        // Add the CGST, SGST, rounded off value, and final amount to the PDF
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 7, '', 'LR', 0, 'R');
        $pdf->Cell(70, 7, '', 'LR', 0, 'R');
        $pdf->Cell(30, 7, '', 'LR', 0, 'R');
        $pdf->Cell(10, 7, '', 'LR', 0, 'R');
        $pdf->Cell(20, 7, '', 'LR', 0, 'R');
        $pdf->Cell(20, 7, '', 'LR', 0, 'R');
        $pdf->Cell(30, 7, number_format($total_amount_before_tax, 2), 'TR', 1, 'R');

        $pdf->Cell(10, 5, '', 'L', 0, 'R');
        $pdf->Cell(70, 5, 'CGST', 'LR', 0, 'R');
        $pdf->Cell(30, 5, '', 'LR', 0, 'R');
        $pdf->Cell(10, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(30, 5, number_format($cgst, 2), 'R', 1, 'R');

        $pdf->Cell(10, 5, '', 'L', 0, 'R');
        $pdf->Cell(70, 5, 'SGST', 'LR', 0, 'R');
        $pdf->Cell(30, 5, '', 'LR', 0, 'R');
        $pdf->Cell(10, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(30, 5, number_format($sgst, 2), 'R', 1, 'R');

        $pdf->Cell(10, 5, '', 'L', 0, 'R');
        $pdf->Cell(70, 5, $extChaName, 'LR', 0, 'R');
        $pdf->Cell(30, 5, '', 'LR', 0, 'R');
        $pdf->Cell(10, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(30, 5, number_format($chaAmount, 2), 'R', 1, 'R');

        $pdf->Cell(10, 5, '', 'L', 0, 'R');
        $pdf->Cell(70, 5, 'Rounded Off', 'LR', 0, 'R');
        $pdf->Cell(30, 5, '', 'LR', 0, 'R');
        $pdf->Cell(10, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(20, 5, '', 'LR', 0, 'R');
        $pdf->Cell(30, 5, number_format($rounded_off_value, 2), 'R', 1, 'R');

        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(70, 5, 'Total', 1, 0, 'R');
        $pdf->Cell(30, 5, '', 1, 0, 'R'); // Replace $hsn_sac_number with actual data
        $pdf->Cell(10, 5, $total_quantity, 1, 0, 'R');
        $pdf->Cell(20, 5, '', 1, 0, 'R');
        $pdf->Cell(20, 5, $discount, 1, 0, 'R');
        $pdf->Cell(30, 5, ''. number_format($final_amount_rounded, 2).'', 1, 1, 'R');

        // Amount in Words
        $pdf->SetY(-90);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, "Amount Chargeable (in Words)" , "LR", 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(0, 7, "INR ". ucwords(convertNumberToWords($final_amount_rounded)) . " only", 'LR', 'L');
        // Determine cell width based on page width and number of columns
        $cell_width = ($pdf->GetPageWidth() - 20) / 5; // Subtracting 20 for margins and dividing by 5 columns

        // Total Calculations
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($cell_width+30, 4, "HSN/SAC", "LTR", 0, 'C');
        $pdf->Cell($cell_width-15, 4, "Taxable", "LTR", 0, 'C');
        $pdf->Cell($cell_width, 4, "Central Tax", 1, 0, 'C');
        $pdf->Cell($cell_width, 4, "State Tax", 1, 0, 'C');
        $pdf->Cell($cell_width-15, 4, "Total", "LTR", 1, 'C');

        // $cell_width = ($pdf->GetPageWidth() - 20) / 7;
        $cell_shalf_width = ($cell_width) / 2;

        $pdf->Cell($cell_width+30, 4, "", "LBR", 0, 'C');
        $pdf->Cell($cell_width-15, 4, "Value", "LBR", 0, 'C');
        $pdf->Cell($cell_shalf_width-5, 4, "Rate", 1, 0, 'C');
        $pdf->Cell($cell_shalf_width+5, 4, "Amount", 1, 0, 'C');
        $pdf->Cell($cell_shalf_width-5, 4, "Rate", 1, 0, 'C');
        $pdf->Cell($cell_shalf_width+5, 4, "Amount", 1, 0, 'C');
        $pdf->Cell($cell_width-15, 4, "Tax Amount", "LBR", 1, 'C');

        $pdf->Cell($cell_width+30, 4, $hsn_sac_number, 1, 0, 'L');
        $pdf->Cell($cell_width-15, 4, $total_amount_before_tax, 1, 0, 'C');
        $pdf->Cell($cell_shalf_width-5, 4, $cgstp, 1, 0, 'C');
        $pdf->Cell($cell_shalf_width+5, 4, $cgst, 1, 0, 'C');
        $pdf->Cell($cell_shalf_width-5, 4, $sgstp, 1, 0, 'C');
        $pdf->Cell($cell_shalf_width+5, 4, $sgst, 1, 0, 'C');
        $pdf->Cell($cell_width-15, 4, number_format($cgst + $sgst, 2), 1, 1, 'R');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($cell_width+30, 4, "Total", 1, 0, 'R');
        $pdf->Cell($cell_width-15, 4, $total_amount_before_tax, 1, 0, 'C');
        $pdf->Cell($cell_shalf_width-5, 4, "", 1, 0, 'C');
        $pdf->Cell($cell_shalf_width+5, 4, $cgst, 1, 0, 'C');
        $pdf->Cell($cell_shalf_width-5, 4, "", 1, 0, 'C');
        $pdf->Cell($cell_shalf_width+5, 4, $sgst, 1, 0, 'C');
        $pdf->Cell($cell_width-15, 4, number_format($cgst + $sgst, 2), 1, 1, 'R');

        // $pdf->Ln(3);

        // Amount in Words
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(0, 5, "Tax Amount (in Words): INR " . ucwords(convertNumberToWords(($cgst + $sgst))) . " only", 'LR', 'L');

        // Footer Section
        // Calculate width for the left section (Terms and Conditions)
        $left_section_width = $pdf->GetPageWidth() / 2; // Half of page width

        // Description & Comapny Details (Bottom )
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($left_section_width, 3, "", "L",0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($left_section_width - 20, 3, "Company's Bank Details:", "R",1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($left_section_width, 3, "", "L",0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($left_section_width - 20, 3, "Bank Name: Punjab National Bank (C/C)", "R",1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($left_section_width, 3, "", "L",0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($left_section_width - 20, 3, "Account Number: 1377208700000805", "R",1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($left_section_width, 3, "", "L",0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($left_section_width - 20, 3, "Branch & IFS Code: UMARPUR & PUNB0137720", "R",1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($left_section_width, 3, "Declaration", "L",0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($left_section_width - 20, 3, "for A S ENTERPRISE.", "LTR",1, 'R');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($left_section_width, 3, "We declare that this invoice shows the actual price of the", "L",0, 'L');
        $pdf->Cell($left_section_width - 20, 3, "", "LR",1, 'L');
        $pdf->Cell($left_section_width, 3, "goods described and that all particulars are true and", "L",0, 'L');
        $pdf->Cell($left_section_width - 20, 3, "", "LR",1, 'L');
        $pdf->Cell($left_section_width, 3, "correct.", "LB",0, 'L');
        $pdf->Cell($left_section_width - 20, 3, "Authorised Signatory", "LBR",1, 'R');


        $pdf->ln(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 2, "This is a Computer Generated Invoice.", 0, 0, 'C');

        // Save PDF to file
        // Concatenate folder path and file name
        $pdf_path = $pdf_folder . $pdf_file;

        // Output the PDF to the specified path
        $pdf->Output($pdf_path, 'F');
        $invoiceNumber = $lastInvoiceNumber + 1;
        // Update the invoice file name in the database
        $update_sql = "UPDATE sell SET invoiceNumber = $invoiceNumber, invoiceFiles = '$pdf_file' WHERE id = '$last_id'";

        if ($conn->query($update_sql) === TRUE) {
            // Output success message and prompt to open the PDF
            echo '<script>
                    var pdf_path = "'.$pdf_folder.'' . $pdf_file . '"; // Adjust relative path for window.open
                    if (confirm("Goods Sold Successfully. Print out the Tax Invoice: " + pdf_path)) {
                        window.location.href = pdf_path;
                    }
                </script>';
        } else {
            // Error handling if updating database fails
            echo '<script>
                    alert("Error updating invoice file name: ' . $conn->error . '");
                    window.location.href = "../sell.php";
                </script>';
        }
        echo json_encode(['status' => 'success']);
    } else {
        // Error handling if SQL query fails
        echo json_encode(['status' => 'error', 'message' => 'No categorys received']);
        echo '<script>
                alert("Error inserting data: ' . $conn->error . '");
                window.location.href = "../sell.php";
            </script>';
    }

}
// Close connection
$conn->close();
?>