<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['files'])) {
    $file_name = $_POST['file_name'];
    $employee_id = $_POST['employee_id'];
    $company = $_POST['company'];
    $status = $_POST['status'];
    $target_dir = "uploads/";

    foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
        $original_file_name = $_FILES["files"]["name"][$key];
        $target_file = $target_dir . basename($original_file_name);
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            $sql = "INSERT INTO employee_files (file_name, employee_id, company, status, file_path) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $original_file_name, $employee_id, $company, $status, $target_file);
            $stmt->execute();
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }
} else {
    echo "No files to upload.";
}
?>
