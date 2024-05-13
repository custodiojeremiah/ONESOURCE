<?php
// Include your database connection file
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Set the default password to "onesource"
    $password = md5('onesource');
    $user_type = $_POST['user_type'];

    // Check for duplicate username, name, and email
    $duplicateCheckQuery = "SELECT * FROM staff_accounts WHERE username = '$username' OR name = '$name' OR email = '$email'";
    $duplicateCheckResult = mysqli_query($conn, $duplicateCheckQuery);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        // If duplicate records are found, display an error message
        echo "Error: Username, name, or email already exists.";
    } else {
        // Prepare SQL statement to insert data into the database
        $sql = "INSERT INTO staff_accounts (name, username, email, password, user_type) VALUES (?, ?, ?, ?, ?)";
        
        // Prepare the SQL statement
        $stmt = mysqli_prepare($conn, $sql);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssss", $name, $username, $email, $password, $user_type);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If insertion is successful, redirect back to admin_page1.php
            header("Location: display_staff_accounts.php");
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
}
?>
