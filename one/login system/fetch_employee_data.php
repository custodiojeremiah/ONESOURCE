<?php
// Include the database connection file
include 'config.php';

// Connect to the database
$conn = connectToDatabase();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employee data from the database
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

// Display employee data in table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Name"] . "</td>";
        echo "<td>" . $row["Employee_ID"] . "</td>";
        echo "<td>" . $row["Date"] . "</td>";
        echo "<td>" . $row["Status"] . "</td>";
        echo "<td>" . $row["Company"] . "</td>";
        echo "<td><a href='" . $row["PDF"] . "' target='_blank'>View PDF</a></td>";
        echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a> | <a href='archive.php?id=" . $row["id"] . "'>Archive</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No employees found</td></tr>";
}

// Close the database connection
$conn->close();
?>
