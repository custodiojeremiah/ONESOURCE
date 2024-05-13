<?php
// Include the database configuration file
include 'config2.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the POST data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $employee_id = $_POST['employee_id']; // Assuming you have a field named 'employee_id' in your form
    $date = $_POST['date'];
    $company = $_POST['company'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // Prepare and execute the SQL statement to update the record
    $stmt = $conn->prepare("UPDATE file_tbl SET employee_name=?, employee_id=?, date=?, company=?, status=?, description=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $employee_id, $date, $company, $status, $description, $id);

    if ($stmt->execute()) {
        // If the update was successful, return a success message
        $response = array(
            'status' => 'success',
            'message' => 'Record updated successfully'
        );
    } else {
        // If there was an error, return an error message
        $response = array(
            'status' => 'error',
            'message' => 'Error updating record: ' . $conn->error
        );
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
