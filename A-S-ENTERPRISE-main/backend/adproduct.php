<?php
include "db_connection.php";

if (isset($_POST['submit'])) {
    // Sanitize and escape input data
    $barcode = mysqli_real_escape_string($conn, $_POST['barcode']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $hsn_sac = mysqli_real_escape_string($conn, $_POST['hsn_sac']);
    $gst = mysqli_real_escape_string($conn, $_POST['gst']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);

    // SQL query
    $sql = "INSERT INTO goods (barcode, name, description, amount, quantity, `HSN/SAC`, gst, brand) 
            VALUES ('$barcode', '$name', '$description', '$amount', '$quantity', '$hsn_sac', '$gst', '$brand')";

    // Execute query and handle result
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            if (confirm('Product added successfully. Do you want to add another product?')) {
                window.location.href = '../add.php';
            } else {
                window.location.href = '../index.php';
            }
            </script>";
    } else {
        echo "<script>alert('Failed: " . mysqli_error($conn) . "');</script>";
    }

    // Close connection
    mysqli_close($conn);
}
?>
