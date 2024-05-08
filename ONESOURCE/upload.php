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

// File upload code
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Allow certain file formats
if ($imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "pdf") {
    echo "Sorry, only DOC, DOCX, and PDF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file and insert into database
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Insert file information into the database
        $employee_name = $_POST['employee_name'];
        $employee_id = $_POST['employee_id'];
        $date = $_POST['date']; // This will now contain both the date and time
        $company = $_POST['company'];
        $status = $_POST['status'];
        $description = $_POST['description'];

        $sql = "INSERT INTO file_tbl (employee_name, employee_id, date, company, status, description)
        VALUES ('$employee_name', '$employee_id', '$date', '$company', '$status', '$description')";

        if ($conn->query($sql) === TRUE) {
            echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded and information has been saved to the database.";
        } else {
            echo "Sorry, there was an error uploading your file and saving information to the database.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Display all columns from the database
$result = $conn->query("SELECT * FROM file_tbl");
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Employee Name</th><th>Employee ID</th><th>Date</th><th>Company</th><th>Status</th><th>Description</th><th>Actions</th></tr>";
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["employee_name"] . "</td><td>" . $row["employee_id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["company"] . "</td><td>" . $row["status"] . "</td><td>" . $row["description"] . "</td><td><a href='edit.php?id=" . $row["id"] . "'>Edit</a> | <a href='archive.php?id=" . $row["id"] . "'>Archive</a></td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>