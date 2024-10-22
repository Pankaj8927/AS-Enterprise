<?php
include 'db_connection.php';

// Check if 'id', 'dueAmount', and 'method' are passed in POST request
if (isset($_POST['id']) && isset($_POST['dueAmount']) && isset($_POST['method'])) {
    $partyId = intval($_POST['id']); // Ensure the ID is an integer
    $dueAmount = floatval($_POST['dueAmount']); // Ensure the amount is a float
    $paymentMethod = intval($_POST['method']); // Ensure the payment method is an integer

    // SQL query to update the clear amount and payment method
    $sql = "UPDATE parties 
            SET clearAmount = clearAmount + $dueAmount, paymentMethod = $paymentMethod 
            WHERE id = $partyId";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
