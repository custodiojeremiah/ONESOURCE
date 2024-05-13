<?php
include 'config.php'; // Database connection setup file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $newName = isset($_POST['newName']) ? trim($_POST['newName']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : ''; // Retrieve the email from POST data
    $userType = isset($_POST['user_type']) ? trim($_POST['user_type']) : '';

    // Prepare an SQL statement to update the staff data including email
    $sql = "UPDATE staff_accounts SET name = ?, username = ?, email = ?, user_type = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $newName, $username, $email, $userType, $id); // Bind the email parameter

        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
