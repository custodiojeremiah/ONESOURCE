<?php
// Database configuration
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName     = 'user_db';

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if the 'file_path' column exists and add it if it doesn't
$alterTableQuery = "ALTER TABLE file_uploads ADD COLUMN file_path VARCHAR(255) NOT NULL AFTER file_name";
$db->query($alterTableQuery); // Execute the ALTER TABLE query without checking for errors to simplify this example

// File upload logic
if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
    $filename = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $employeeId = $_POST['employee_id'];
    $company = $_POST['company'];
    $status = $_POST['status'];
    $uploadDir = 'uploads/';
    $uploadPath = $uploadDir . basename($filename);

    // Check file type
    $allowedTypes = ['pdf', 'jpeg', 'jpg', 'png', 'gif'];
    if (in_array($fileExt, $allowedTypes)) {
        // Move uploaded file to specific location
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Insert file data along with additional fields into the database
            $insert = $db->query("INSERT INTO file_uploads (file_name, file_path, employee_id, company, status) VALUES ('$filename', '$uploadPath', '$employeeId', '$company', '$status')");
            if ($insert) {
                echo "File uploaded successfully.<br>";
            } else {
                echo "File upload failed, please try again. Error: " . $db->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    } else {
        echo "Sorry, only PDF, JPG, JPEG, PNG, & GIF files are allowed.<br>";
    }
}

// Fetch and display files in a table
$result = $db->query("SELECT * FROM file_uploads ORDER BY uploaded_on DESC");
echo "<h2>Uploaded Files:</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Employee ID</th><th>Company</th><th>Status</th><th>View File</th><th>Date</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['file_name'] . "</td><td><a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>View File</a></td><td>" . $row['employee_id'] . "</td><td>" . $row['company'] . "</td><td>" . $row['status'] . "</td><td>" . $row['uploaded_on'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No files uploaded yet.<br>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="file_name" id="file_name" placeholder="File Name" required>
        <input type="text" name="employee_id" id="employee_id" placeholder="Employee ID" required>
        <input type="text" name="company" id="company" placeholder="Company" required>
        <select name="status" id="status">
            <option value="ACTIVE">Active</option>
            <option value="INACTIVE">Inactive</option>
            <option value="N/A">N/A</option>
        </select>
        <label for="file">Choose File:</label>
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
