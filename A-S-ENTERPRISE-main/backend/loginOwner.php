<?php
// Start session
session_start();

// Include database connection
require_once 'db_connection.php';

// Function to sanitize input data
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}
// Check if logout action is requested
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Update user status to inactive in the database
    $updateQuery = "UPDATE users SET status = 'inactive' WHERE id = '1'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Perform logout by destroying the session
        session_unset();
        session_destroy();
        header("Location: ../index.php"); // Redirect to login page after logout
        exit();
    } else {
        echo "Failed to update user status. Please try again.";
    }
}
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize username and password
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Query to fetch user from database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check if user exists
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if ($username === $user['username'] && $password === $user['password']) {
                // Check if user status is inactive
                if ($user['status'] === 'inactive') {
                    // Update user status to 'active' in the database
                    $update_query = "UPDATE users SET status = 'active' WHERE username = '$username'";
                    $update_result = mysqli_query($conn, $update_query);
                    
                    if (!$update_result) {
                        echo "Failed to update account status.";
                    }
                    header("Location: ../index.php");
                } else {
                    echo '<script>';
                    echo 'confirm("User Already Logged In. Do you want to continue?") ? ';
                    echo '  window.location.href = "../index.php" : ';
                    echo '  window.location.href = "../index.php";';
                    echo '</script>';
                    
                }
            } else {
                // Invalid password
                echo '<script>';
                echo 'confirm("Invalid Password ! Try Again....") ? ';
                echo '  window.location.href = "../index.php" : ';
                echo '  window.location.href = "../index.php";';
                echo '</script>';
            }
        } else {
            // User does not exist
            echo '<script>';
            echo 'confirm("Invalid username ! Try Again....") ? ';
            echo '  window.location.href = "../index.php" : ';
            echo '  window.location.href = "../index.php";';
            echo '</script>';
        }
    } else {
        // Error in query execution
        echo '<script>';
        echo 'confirm("Database error: ' . mysqli_error($conn).'") ? ';
        echo '  window.location.href = "../index.php" : ';
        echo '  window.location.href = "../index.php";';
        echo '</script>';
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);
}
?>
