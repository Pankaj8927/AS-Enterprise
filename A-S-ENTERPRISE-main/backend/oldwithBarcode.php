<?php
// Include the database connection
include 'db_connection.php'; // Adjust this according to your database connection script

// Require FPDF library
require_once('../fpdf186/fpdf.php'); // Adjust the path to FPDF library
require '../vendor/autoload.php';
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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barcodes = isset($_POST['sell_submit']) ? $_POST['sell_submit'] : []; // This will be an array of objects

    $success = true;
    $errors = [];
    $barcode ='';
    $goods_name = '';
    $quantity = '';
    $amount = '';
    $gst = '';
    $brand = '';
    $description = '';
    // Get the additional form data
    $discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
    $buyer_name = isset($_POST['buyer_name']) ? $_POST['buyer_name'] : 'N/A';
    $buyer_address = isset($_POST['buyer_address']) ? $_POST['buyer_address'] : 'N/A';
    $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : 'N/A';
    $state = isset($_POST['state']) ? $_POST['state'] : 'N/A';
    $invoice_maker = isset($_POST['invoice_maker']) ? $_POST['invoice_maker'] : 'N/A';
    // Get current date and time for invoice
    $date_time = date("Ymd-His");
    $hsn_sac_number='';
    //insert the items to sell database
    foreach ($barcodes as $item) {
        // Extract the values from each item
        $barcode = $conn->real_escape_string($item['barcode']);
        $goods_name = $conn->real_escape_string($item['name']);
        $quantity = intval($item['quantity']);
        $amount = floatval($item['amount_per_unit']);        
        $gst = floatval($item['gst']);        

        // SQL query to insert data
        $sql = "INSERT INTO sell (barcodeNumber, goodsName, description, brand, goodsAmount, goodsQuantity, discount, buyerName, buyerAdd, contactNumber, stateNameCode, invoiceMakerName, dateTime, invoiceFiles) 
                VALUES ('$barcode', '$goods_name','$description','$brand', '$amount', '$quantity', '$discount', '$buyer_name', '$buyer_address', '$contact_number', '$state', '$invoice_maker', '$date_time', '')";
            
        // Execute the SQL query
        if (!$conn->query($sql)) {
            $success = false;
            $errors[] = "Error inserting barcode $barcode: " . $conn->error;
        }
    }

    // Attempt to insert data into the database
    if ($success) {
        // Get the last inserted ID
        $last_id = $conn->insert_id;
        // Generate file name for PDF in a different folder
        $pdf_folder = "../invoices/"; // Adjust path to your desired location
        $pdf_file = "invoice_" . $date_time . ".pdf";
        // Create PDF document using FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Query to get the last invoice number
        $numbersql = "SELECT MAX(invoiceNumber) AS last_invoice_number FROM sell";
        $numbersqlresult = mysqli_query($conn, $numbersql);
        $lastInvoiceNumber = $numbersqlresult ? mysqli_fetch_assoc($numbersqlresult)['last_invoice_number'] : "Error: " . mysqli_error($conn);
        mysqli_free_result($numbersqlresult);

        // Get the last two digits of the current year
        $currentYearShort = date("y"); // Get the current year's last two digits
        $nextYearShort = date("y", strtotime("+1 year")); // Get next year's last two digits
        
        $currentPlusNextYearShort = $currentYearShort . "-" . $nextYearShort;

        // Format the string as needed
        $formattedString = "ASE/{$currentPlusNextYearShort}/{$lastInvoiceNumber}";
        
        // Header Section
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 5, 'TAX INVOICE', 0, 1, 'C');
        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 5, 'A S ENTERPRISE', "LTR", 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(45, 5, "Invoice No:", "LTR", 0, 'L');
        $pdf->Cell(45, 5, "Date: ", "LTR", 1, 'L');
        // $pdf->Ln(1);

        // Seller Details
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 5, "SAHEB BAZAR, NEAR JANGIPUR BUS", "L", 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 5, $formattedString, "LR", 0, 'L');
        $pdf->Cell(45, 5, date("d-M-Y"), "LR", 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 5, "STAND,JANGIPUR", "L", 0, 'L');
        $pdf->Cell(45, 5, "Delivery No. & Date", "LTR", 0, 'L');
        $pdf->Cell(45, 5, "Mode/Terms fo Payment", "LTR", 1, 'L');
        $pdf->Cell(100, 5, "GSTIN/UIN: 19ETWPR8283K", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 1, 'L');
        $pdf->Cell(100, 5, "STATE NAME: WEST BENGAL, CODE: 19", "L", 0, 'L');
        $pdf->Cell(45, 5, "Reference No & Date", "LTR", 0, 'L');
        $pdf->Cell(45, 5, "Other References", "LTR", 1, 'L');
        // $pdf->Ln(1);

        // Shiipment Details
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(100, 5, "Consignee (Ship To)", "LT", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 1, 'L');
        $pdf->Cell(100, 5, $buyer_name, "L", 0, 'L');
        $pdf->Cell(45, 5, "Buyer's Order No.", "LTR", 0, 'L');
        $pdf->Cell(45, 5, "Dated", "LTR", 1, 'L');
        $pdf->Cell(100, 5, $buyer_address, "L", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 1, 'L');
        $pdf->Cell(100, 5, $contact_number, "L", 0, 'L');
        $pdf->Cell(45, 5, "Dispatch Doc No.", "LTR", 0, 'L');
        $pdf->Cell(45, 5, "Delivery Note Date", "LTR", 1, 'L');
        $pdf->Cell(100, 5, "GSTIN/UIN :", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 0, 'L');
        $pdf->Cell(45, 5, "", "LBR", 1, 'L');
        $pdf->Cell(100, 5, $state, "L", 0, 'L');
        $pdf->Cell(45, 5, "HYPOTHICATION", "LTR", 0, 'L');
        $pdf->Cell(45, 5, "Destination", "LTR", 1, 'L');
        // $pdf->Ln(1);
        // Buyer Details
        $pdf->Cell(100, 10, "", "L", 0, 'L');
        $pdf->Cell(45, 10, "", "LBR", 0, 'L');
        $pdf->Cell(45, 10, "", "LBR", 1, 'L');
        $pdf->Cell(100, 5, "Buyer (Bill To)", "LT", 0, 'L');
        $pdf->Cell(45, 5, "Terms Of Delivery", "LT", 0, 'L');
        $pdf->Cell(45, 5, "", "TR", 1, 'L');
        $pdf->Cell(100, 5, $buyer_name, "L", 0, 'L');
        $pdf->Cell(45, 5, "", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "R", 1, 'L');
        $pdf->Cell(100, 5, $buyer_address, "L", 0, 'L');
        $pdf->Cell(45, 5, "", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "R", 1, 'L');
        $pdf->Cell(100, 5, $contact_number, "L", 0, 'L');
        $pdf->Cell(45, 5, "", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "R", 1, 'L');
        $pdf->Cell(100, 5, "GSTIN/UIN :", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "L", 0, 'L');
        $pdf->Cell(45, 5, "", "R", 1, 'L');
        $pdf->Cell(100, 5, $state, "L", 0, 'L');
        $pdf->Cell(45, 5, "", "LB", 0, 'L');
        $pdf->Cell(45, 5, "", "BR", 1, 'L');

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

        foreach ($barcodes as $item) {
            $barcode = $item['barcode'];
            $goods_name = $item['name'];
            $description = $item['description'];
            $quantity = $item['quantity'];
            $amount_per_unit = $item['amount_per_unit'];
            $hsn_sac_number = $item['HSN/SAC'];
            $total_amount = $amount_per_unit * $quantity;
            $total_amount_before_tax += $total_amount;
            $total_quantity += $quantity;
        
            // Set initial x and y positions
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $maxY = $y;  // Track the maximum Y position
        
            // Serial Counter
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(10, 7, $srCounter, 'LR', 'C');
            $maxY = max($maxY, $pdf->GetY());
        
            // Goods Name and Barcode
            // Generate the barcode as a PNG image
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            $barcodeData = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);
            $barcodeFile = '../barcodeFile/barcode_' . $barcode . '.png';  // Use barcode value in file name
            file_put_contents($barcodeFile, $barcodeData);
        
            $x += 10;
            $xpos = $x;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(70, 7, "".$goods_name."\n".$description."", 'LR', 'L');
            $maxY = max($maxY, $pdf->GetY());
            $pdf->SetXY($xpos-10, $maxY);
            $pdf->Cell(10, 7, "", 'LR', 0);
            $pdf->Cell(70, 7, "", 'LR', 0);
            $pdf->Image($barcodeFile, $xpos+5, $pdf->GetY(), 60, 5);
            $pdf->Cell(30, 7, "", 'LR', 0);
            $pdf->Cell(10, 7, "", 'LR', 0);
            $pdf->Cell(20, 7, "", 'LR', 0);
            $pdf->Cell(20, 7, "", 'LR', 0);
            $pdf->Cell(30, 7, "", 'LR', 0);
            $maxY = max($maxY, $pdf->GetY() + 5);
        
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
        
            // Empty Cell
            $x += 20;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(20, 7, '', 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
        
            // Total Amount
            $x += 20;
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(30, 7, number_format($total_amount, 2), 'LR', 'R');
            $maxY = max($maxY, $pdf->GetY());
        
            // Move Y position down by 14 units for the next row
            $pdf->SetY($maxY);
        
            // Update y for the next row and reset x to start position
            $srCounter++;
            // Calculate the remaining height considering the footer and additional content
            $remaining_height = $pdf->GetPageHeight() - $pdf->GetY() - $footer_height;
        
            // Check if there is enough space for the next row (assuming minimum required space is 60)
            if ($remaining_height < 10) {
                $pdf->AddPage(); // Add a new page if there is not enough space
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
        $final_amount = $total_amount_after_discount + $cgst + $sgst;

        $rounded_off_value = round($final_amount, 0) - $final_amount;
        $final_amount_rounded = round($final_amount, 0);

        // Insert blank cells to take up the remaining height
        $current_y = $pdf->GetY();
        while ($current_y < $pdf->GetPageHeight() - $remaining_height - 20) {
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
        echo json_encode(['status' => 'error', 'message' => 'No barcodes received']);
        echo '<script>
                alert("Error inserting data: ' . $conn->error . '");
                window.location.href = "../sell.php";
            </script>';
    }

}
// Close connection
$conn->close();
?>