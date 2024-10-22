<?php
// Include the database connection file
include "db_connection.php";

// Get the ID and table name from the URL parameters (sanitize if necessary)
$id = $_GET['id'];
$table = $_GET['table'];

// Ensure the table name is a valid value (use a whitelist or predefined set of table names)
$allowed_tables = ['goods', 'sell']; // Add other table names if needed

if (in_array($table, $allowed_tables)) {
    // Sanitize the ID if necessary
    $id = intval($id); // Convert to integer to prevent SQL injection (basic sanitization)

    // Construct the SQL delete query
    $sql = "DELETE FROM $table WHERE id = $id";

    // Execute the delete query
    if (mysqli_query($conn, $sql)) {
        // Check if any row was affected
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>
                alert('Record deleted successfully.');
                window.location.href = '../index.php'; // Redirect to the main page after deletion
                </script>";
        } else {
            echo "<script>
                alert('No records deleted.');
                window.location.href = '../index.php'; // Redirect to the main page if no records were deleted
                </script>";
        }
    } else {
        echo "<script>
            alert('Error deleting record: " . mysqli_error($conn) . "');
            window.location.href = '../index.php'; // Redirect to the main page after error
            </script>";
    }
} else {
    echo "<script>
        alert('Invalid table name.');
        window.location.href = '../index.php'; // Redirect to the main page after error
        </script>";
}

// Close the database connection
mysqli_close($conn);
?>
