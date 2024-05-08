<?php
// Include your database connection file
include 'config.php';

// Check if the POST data is received properly
if(isset($_POST['id']) && isset($_POST['newName'])) {
    // Sanitize the input data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $newName = mysqli_real_escape_string($conn, $_POST['newName']);

    // Update the staff account in the database
    $sql = "UPDATE staff_accounts SET name='$newName' WHERE id='$id'";
    if(mysqli_query($conn, $sql)) {
        // If update is successful, return a success message
        echo "Staff account updated successfully.";
    } else {
        // If update fails, return an error message
        echo "Error updating staff account: " . mysqli_error($conn);
    }
} else {
    // If POST data is not received properly, return an error message
    echo "Error: Incomplete POST data.";
}

// Close the database connection
mysqli_close($conn);
?>
