<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "file_uploads";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch and display archived records
function displayArchivedRecords($conn) {
    $archive_result = $conn->query("SELECT * FROM archive_tbl");
    if ($archive_result->num_rows > 0) {
        echo "<h2>Archived Records</h2>";
        echo "<table border='1' style='width: 100%;'>";
        echo "<tr><th>Employee Name</th><th>Employee ID</th><th>Date</th><th>Company</th><th>Status</th><th>Description</th></tr>";
        while($row = $archive_result->fetch_assoc()) {
            echo "<tr><td>".$row["employee_name"]."</td><td>".$row["employee_id"]."</td><td>".$row["date"]."</td><td>".$row["company"]."</td><td>".$row["status"]."</td><td>".$row["description"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No archived records found.";
    }
}

// Check if ID is provided in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the record from the database
    $result = $conn->query("SELECT * FROM file_tbl WHERE id=$id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Move the record to an archive table or perform any archiving action
        // For example, you can insert it into an archive table
        $archive_sql = "INSERT INTO archive_tbl (employee_name, employee_id, date, company, status, description)
                        VALUES ('" . $row['employee_name'] . "', '" . $row['employee_id'] . "', '" . $row['date'] . "', '" . $row['company'] . "', '" . $row['status'] . "', '" . $row['description'] . "')";

        if ($conn->query($archive_sql) === TRUE) {
            // Record successfully archived, now delete it from the main table
            $delete_sql = "DELETE FROM file_tbl WHERE id=$id";

            if ($conn->query($delete_sql) === TRUE) {
                echo "Record archived successfully.";
                // Display archived records
                displayArchivedRecords($conn);
                // Add a back button
                echo "<div style='position: fixed; top: 10px; right: 10px;'><a href='employee_management.php' style='color: black; text-decoration: none;'>Back to Add New Record</a></div>";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        } else {
            echo "Error archiving record: " . $conn->error;
        }
    } else {
        echo "Record not found.";
    }
} else {
    echo "ID not provided.";
}

$conn->close();
?>
