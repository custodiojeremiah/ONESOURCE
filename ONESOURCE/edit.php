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

// Check if ID is provided in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the record from the database
    $result = $conn->query("SELECT * FROM file_tbl WHERE id=$id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Populate form fields with existing data
        $employee_name = $row['employee_name'];
        $employee_id = $row['employee_id'];
        $date = $row['date'];
        $company = $row['company'];
        $status = $row['status'];
        $description = $row['description'];
    } else {
        echo "Record not found.";
    }
} else {
    echo "ID not provided.";
}

// Update record in the database
if(isset($_POST['submit'])) {
    $employee_name = $_POST['employee_name'];
    $employee_id = $_POST['employee_id'];
    $date = $_POST['date'];
    $company = $_POST['company'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    $sql = "UPDATE file_tbl SET employee_name='$employee_name', employee_id='$employee_id', date='$date', company='$company', status='$status', description='$description' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<form method="post" action="">
    Employee Name: <input type="text" name="employee_name" value="<?php echo $employee_name; ?>"><br>
    Employee ID: <input type="text" name="employee_id" value="<?php echo $employee_id; ?>"><br>
    Date: <input type="text" name="date" value="<?php echo $date; ?>"><br>
    Company: <input type="text" name="company" value="<?php echo $company; ?>"><br>
    Status: <input type="text" name="status" value="<?php echo $status; ?>"><br>
    Description: <input type="text" name="description" value="<?php echo $description; ?>"><br>
    <input type="submit" name="submit" value="Submit">
</form>

<!-- Back button to return to add another record -->
<form action="employee_management.php">
    <input type="submit" value="Back">
</form>
