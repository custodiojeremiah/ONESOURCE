<?php
// Include your database connection file
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $user_type = $_POST['user_type'];

    // Prepare SQL statement to update data in the database
    $sql = "UPDATE staff_accounts SET name = ?, username = ?, user_type = ? WHERE id = ?";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssi", $name, $username, $user_type, $id);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // If update is successful, redirect back to admin_page1.php
        header("Location: admin_page1.php");
        exit();
    } else {
        // If update fails, display an error message
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
