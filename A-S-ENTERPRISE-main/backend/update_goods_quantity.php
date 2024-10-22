<?php
include 'db_connection.php'; // Include your database connection script

// Initialize response array
$response = array('success' => false, 'message' => '');

// Check if POST data is set
if (isset($_POST['id']) && isset($_POST['quantity'])) {
    // Retrieve and sanitize inputs
    $id = intval($_POST['id']); // Ensure id is an integer
    $quantity = intval($_POST['quantity']); // Ensure quantity is an integer

    // Check for valid inputs
    if ($id <= 0 || $quantity < 0) {
        $response['message'] = 'Invalid input values';
    } else {
        // Construct SQL query
        $sql_update = "UPDATE goods SET quantity = quantity - $quantity WHERE id = $id";

        // Execute the SQL query
        if ($conn->query($sql_update) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Quantity updated successfully';
        } else {
            $response['message'] = "Error updating quantity: " . $conn->error;
        }
    }
} else {
    $response['message'] = 'Required data not provided';
}

// Return the response as JSON
echo json_encode($response);

// Close the connection
$conn->close();
?>
