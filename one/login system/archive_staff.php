<?php
// Include your database connection file
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve staff ID from form submission
    $staffId = $_POST['id'];

    // Retrieve staff information from the database
    $sqlSelect = "SELECT * FROM staff_accounts WHERE id = '$staffId'";
    $resultSelect = mysqli_query($conn, $sqlSelect);

    if (mysqli_num_rows($resultSelect) > 0) {
        // Fetch the staff member details
        $row = mysqli_fetch_assoc($resultSelect);
        $staffUsername = $row['username'];
        $staffName = $row['name'];
        $userType = $row['user_type'];

        // Insert the staff member into the archive table
        $sqlInsertArchive = "INSERT INTO archive_staff_accounts (username, name, user_type) VALUES ('$staffUsername', '$staffName', '$userType')";
        if (mysqli_query($conn, $sqlInsertArchive)) {
            // Archive staff member successfully
            // Now, delete the staff member from the original table
            $sqlDeleteOriginal = "DELETE FROM staff_accounts WHERE id = '$staffId'";
            if (mysqli_query($conn, $sqlDeleteOriginal)) {
                // Staff member deleted successfully
                echo "Staff member archived successfully.";
            } else {
                // Error deleting staff member from original table
                echo "Error deleting staff member: " . mysqli_error($conn);
            }
        } else {
            // Error archiving staff member
            echo "Error archiving staff member: " . mysqli_error($conn);
        }
    } else {
        // Staff member not found
        echo "Staff member not found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
