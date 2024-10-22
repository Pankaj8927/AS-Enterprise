<?php
include 'db_connection.php'; // Include your database connection script

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    $sql = "SELECT name FROM goods WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();

    $goods = [];
    while ($row = $result->fetch_assoc()) {
        $goods[] = $row;
    }

    echo json_encode($goods);
}

if (isset($_POST['input'])) {
    $input = htmlspecialchars($_POST['input']); // Sanitize input

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM goods WHERE name = ?");
    $stmt->bind_param("s", $input); // 's' specifies the type (string)

    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'id' => htmlspecialchars($row['id']),
                'category' => htmlspecialchars($row['category']),
                'name' => htmlspecialchars($row['name']),
                'description' => htmlspecialchars($row['description']),
                'amount_per_unit' => htmlspecialchars($row['amount']),
                'quantity' => htmlspecialchars($row['quantity']),
                'HSN/SAC' => htmlspecialchars($row['HSN/SAC']),
                'gst' => htmlspecialchars($row['gst']),
                'brand' => htmlspecialchars($row['brand']),
                'amount' => htmlspecialchars($row['amount']) * htmlspecialchars($row['quantity'])
            );
        }
    }

    // Return the data as JSON
    echo json_encode($data);
    

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
