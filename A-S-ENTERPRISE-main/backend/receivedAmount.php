<?php
    include 'db_connection.php';
    header('Content-Type: application/json'); // Set the response type to JSON

    // Check if 'id' is passed in POST request
    if (isset($_POST['id'])) {
        $partyId = intval($_POST['id']); // Ensure the ID is an integer

        // SQL query to fetch totalAmount and clearAmount for the selected party
        $sql = "SELECT totalAmount, clearAmount FROM parties WHERE id = $partyId";
        
        // Execute the query
        $result = $conn->query($sql);
        
        // Check if the query returned a result
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalAmount = round($row['totalAmount'], 2);
            $clearAmount = round($row['clearAmount'], 2);
            $dueAmount = round($totalAmount - $clearAmount, 2);

            // Output the results as JSON
            echo json_encode(array(
                'totalAmount' => $totalAmount,
                'clearAmount' => $clearAmount,
                'dueAmount' => $dueAmount
            ));
        } else {
            echo json_encode(array('error' => 'No details found for the selected party.'));
        }
    } else {
        echo json_encode(array('error' => 'No party selected.'));
    }

    // Close the database connection
    $conn->close();
?>
