<?php
// Include database connection
include 'db_connect.php';

// Fetch employees from the database
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Loop through each row and display the data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["employee_id"] . "</td>";
        echo "<td>" . $row["employee_name"] . "</td>";
        echo "<td>" . $row["file_description"] . "</td>";
        echo "<td><a href='" . $row["file_path"] . "' target='_blank'>View File</a></td>";
        echo "<td>Timeframe</td>"; // This will be calculated on the client side using JavaScript
        echo "<td>Actions</td>"; // Add buttons for actions like edit and delete
        echo "</tr>";
    }
} else {
    // If no employees found
    echo "<tr><td colspan='6'>No employees found</td></tr>";
}

// Close database connection
mysqli_close($conn);
?>
