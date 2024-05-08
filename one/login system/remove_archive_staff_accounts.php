<?php
// Include your database connection file
include 'config.php';

// Check if the ID is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Sanitize the ID to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to delete the item from the archive table
    $sql = "DELETE FROM archive_staff_accounts WHERE id = '$id'";

    // Attempt to execute the query
    if (mysqli_query($conn, $sql)) {
        // If the query is successful, send a success response
        echo "success";
    } else {
        // If there's an error with the query, send an error response
        echo "error";
    }
} else {
    // If the ID is not set or empty, send an error response
    echo "error";
}

// Close the database connection
mysqli_close($conn);
?>
