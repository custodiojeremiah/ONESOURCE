<?php
// Include your database connection file
include 'config.php';

// Check if the ID is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Sanitize the ID to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Prepare and execute the query to select the staff account from the archive table
    $select_query = "SELECT * FROM archive_staff_accounts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $select_query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $select_result = mysqli_stmt_get_result($stmt);

    // Check if the staff account exists in the archive table
    if (mysqli_num_rows($select_result) > 0) {
        $row = mysqli_fetch_assoc($select_result);

        // Prepare and execute the query to insert the staff account into the active staff accounts table
        $insert_query = "INSERT INTO staff_accounts (username, name, user_type) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, 'sss', $row['username'], $row['name'], $row['user_type']);
        if (mysqli_stmt_execute($stmt)) {
            // Prepare and execute the query to delete the staff account from the archive table
            $delete_query = "DELETE FROM archive_staff_accounts WHERE id = ?";
            $stmt = mysqli_prepare($conn, $delete_query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                // If the insertion and deletion are successful, send a success response
                echo "success";
            } else {
                // If there's an error deleting from the archive table, send an error response
                echo "error_deletion";
            }
        } else {
            // If there's an error inserting into the active staff accounts table, send an error response
            echo "error_insertion";
        }
    } else {
        // If the staff account is not found in the archive table, send an error response
        echo "not_found";
    }
} else {
    // If the ID is not set or empty, send an error response
    echo "invalid_id";
}

// Close the statement and the database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
