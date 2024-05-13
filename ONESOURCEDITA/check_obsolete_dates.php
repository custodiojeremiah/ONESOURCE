<?php
include 'config.php'; // Database connection

$currentDate = date('Y-m-d');
$alertDate = date('Y-m-d', strtotime('+30 days')); // Change '+30 days' to adjust alert time

$sql = "SELECT id, file_name, removal_date FROM archive_file WHERE removal_date BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $currentDate, $alertDate);
$stmt->execute();
$result = $stmt->get_result();

$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}
echo json_encode($files);

$stmt->close();
$conn->close();
?>
