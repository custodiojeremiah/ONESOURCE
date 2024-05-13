<?php
include 'config.php'; // Ensure this file contains the necessary connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['employeeId'])) {
    $employeeId = $_POST['employeeId'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Fetch the record from the main table
        $selectQuery = $conn->prepare("SELECT * FROM employee_files WHERE id = ?");
        $selectQuery->bind_param("i", $employeeId);
        $selectQuery->execute();
        $result = $selectQuery->get_result();
        $rowData = $result->fetch_assoc();

        if ($rowData) {
            // Insert the fetched data into the archive table
            $insertQuery = $conn->prepare("INSERT INTO archive_files (file_name, employee_id, company, status, file_path, upload_timestamp) VALUES (?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("sissss", $rowData['file_name'], $rowData['employee_id'], $rowData['company'], $rowData['status'], $rowData['file_path'], $rowData['upload_timestamp']);
            $insertQuery->execute();

            // Delete the original record
            $deleteQuery = $conn->prepare("DELETE FROM employee_files WHERE id = ?");
            $deleteQuery->bind_param("i", $employeeId);
            $deleteQuery->execute();

            // Commit the transaction
            $conn->commit();
            echo "Record archived successfully.";
        } else {
            echo "No record found to archive.";
            $conn->rollback(); // Rollback the transaction
        }
    } catch (Exception $e) {
        $conn->rollback(); // Rollback the transaction on error
        echo "Error archiving record: " . $e->getMessage();
    }

    $conn->close();
} else {
    echo "No employee ID provided.";
}
?>
