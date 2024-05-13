<?php
// Assuming you have a connection setup similar to this
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging output
    error_log(print_r($_POST, true));

    $id = $_POST['id'];
    $employeeId = $_POST['employeeId'];
    $company = $_POST['company'];
    $status = $_POST['status'];

    // Update query without the file name
    $query = "UPDATE employee_files SET employee_id=?, company=?, status=? WHERE id=?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssi", $employeeId, $company, $status, $id);
        $stmt->execute();
        if ($stmt->affected_rows) {
            echo "Record updated successfully.";
        } else {
            echo "No record updated. Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
    $conn->close();
}
?>
