<?php
// Include your database connection file
// For example, if your database connection code is in a file named "db_connection.php", you would include it here.
// include 'db_connection.php';

// Example code to connect to the database (replace with your actual database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch employee data
$sql = "SELECT * FROM employees";

$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['employee_id']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "<td>".$row['company']."</td>";
        echo "<td>".$row['role']."</td>";
        echo "<td>".$row['status']."</td>";
        echo "<td>".$row['uploaded_file']."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No employees found</td></tr>";
}

$conn->close();
?>
