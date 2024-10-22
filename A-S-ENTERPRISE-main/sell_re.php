<?php
include 'backend/db_connection.php';

// Get the JSON data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);

// Check if required fields are present
if (isset($data['sell_return']) && !empty($data['sell_return'])) {
    $challanSubmit = $data['sell_return'];
    $discount = $data['discount'];
    $buyerName = $data['buyer_name'];
    $buyerBillAddress = $data['buyer_billAddress'];
    $buyerShipAddress = $data['buyer_shipAddress'];
    $contactNumber = $data['contact_number'];
    $state = $data['state'];
    $gstin = $data['gstin'];
    $dated = $data['dated'];
    $description = $data['description'];
    $ReturnNo = $data['ReturnNo'];
    $pos = $data['pos'];
    $ReturnAmount = floatval($data['ReturnAmount']);
    $totalAmount = floatval($data['totalAmount']);

    // Attempt to parse the date in different formats
    $dateFormats = ['d-m-Y', 'd.m.Y', 'Y-m-d'];
    $dateTime = false;

    foreach ($dateFormats as $format) {
        $dateTime = DateTime::createFromFormat($format, $dated);
        if ($dateTime) {
            break;
        }
    }

    if ($dateTime) {
        // Add the current time to the date
        $currentTime = new DateTime();
        $dateTime->setTime($currentTime->format('H'), $currentTime->format('i'), $currentTime->format('s'));

        // Format the datetime as d.m.Y-H:i:s
        $dated = $dateTime->format('Y.m.d-H:i:s');
    } else {
        $response[] = "Invalid date format provided.";
        echo json_encode(['status' => 'error', 'message' => $response]);
        exit;
    }


    $response = [];
    foreach ($challanSubmit as $item) {
        $goodsName = mysqli_real_escape_string($conn, $item['name']);
        $serialNumber = mysqli_real_escape_string($conn, $item['serialNumber']);
        $chasisNumber = mysqli_real_escape_string($conn, $item['chasisNumber']);
        $gst = mysqli_real_escape_string($conn, $item['gst']);
        $HSNSAC = mysqli_real_escape_string($conn, $item['HSN/SAC']);
        $quantity = mysqli_real_escape_string($conn, $item['quantity']);

        // Insert record into sellreturn
        $sqlInsert = "INSERT INTO sellreturn (`dateTime`, `sellReturnNo`, `goodsName`, `serialNumber`, `chasisNumber`, `description`, `gst`, `HSNSAC`, `quantity`, `returnAmount`, `totalAmount`, `partiesName`, `partiesContactNumber`, `partiesBillAddress`, `partiesShipAddress`, `partiesStateCode`, `partiesGSTIN`, `placeOfSupply`) 
        VALUES ('$dated', '$ReturnNo', '$goodsName', '$serialNumber', '$chasisNumber', '$description', '$gst', '$HSNSAC', '$quantity', '$ReturnAmount', '$totalAmount', '$buyerName', '$contactNumber', '$buyerBillAddress', '$buyerShipAddress', '$state', '$gstin', '$pos')";

        if ($conn->query($sqlInsert) === TRUE) {
            $response[] = "Record inserted successfully for $goodsName";
        } else {
            $response[] = "Error inserting record for $goodsName: " . $conn->error;
        }

        // Construct the SQL query to update the specific item quantity
        // This query ensures only the exact matching row is updated
        if ($serialNumber) {
            $sqlUpdate = "UPDATE goods SET quantity = quantity + '$quantity' WHERE name = '$goodsName' AND serialNumber = '$serialNumber'";
        }
        elseif ($chasisNumber) {
            $sqlUpdate = "UPDATE goods SET quantity = quantity + '$quantity' WHERE name = '$goodsName' AND chasisNumber = '$chasisNumber'";
        }
        else{
            $response[] = "No Serial or Chasis Number to update $goodsName";
        }

        // Check if partiesName and phoneNumber are provided to insert into ledger
        if (!empty($buyerName) && !empty($contactNumber)) {
            $clearAmount = $totalAmount; // or any other logic for determining clearAmount
        
            // Corrected table name and query with the right columns
            $sqlLedgerInsert = "INSERT INTO ladger (`dateTime`, `partiesName`, `phoneNumber`, `clearAmount`, `debit`) 
            VALUES ('$dated', '$buyerName', '$contactNumber', '$ReturnAmount', '$ReturnAmount')";
        
            if ($conn->query($sqlLedgerInsert) === TRUE) {
                $response[] = "Record inserted successfully into ladger for $buyerName";
            } else {
                $response[] = "Error inserting record into ladger for $buyerName: " . $conn->error;
            }
        }        

        // Execute the SQL query to update the existing item quantity
        if ($conn->query($sqlUpdate) === TRUE) {
            $response[] = "Quantity updated successfully for $goodsName";
        } else {
            $response[] = "Error updating quantity for $goodsName: " . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
    echo json_encode(['status' => 'success', 'message' => $response]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No categories to send']);
}
?>
