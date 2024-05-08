<?php
// Include your database connection file
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // Hash the password for security
    $user_type = $_POST['user_type'];

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO staff_accounts (name, email, password, user_type) VALUES (?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $user_type);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // If insertion is successful, redirect back to admin_page1.php
        header("Location: admin_page1.php");
        exit();
    } else {
        // If insertion fails, display an error message
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
