<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['years'])) {
    $id = $_POST['id'];
    $years = $_POST['years'];

    // First, get the archive timestamp
    $getTimestampQuery = "SELECT archived_timestamp FROM archive_files WHERE id = ?";
    $stmt = $conn->prepare($getTimestampQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $archiveTimestamp = $data['archived_timestamp'];
        $removalDateTime = date('Y-m-d H:i:s', strtotime("+$years years", strtotime($archiveTimestamp))); // Calculate the removal datetime

        // Update the removal_date in archive_files
        $sql = "UPDATE archive_files SET removal_date = ? WHERE id = ?";
        $updateStmt = $conn->prepare($sql);
        $updateStmt->bind_param("si", $removalDateTime, $id);
        if ($updateStmt->execute()) {
            echo "Obsolescence date set successfully based on the archive timestamp.";
        } else {
            echo "Error setting obsolescence date.";
        }
    } else {
        echo "Failed to find the archive record.";
    }

    $stmt->close();
    $conn->close();
    header("Location: display_archive_employee.php"); // Optionally redirect back to the archive page
    exit;
}
?>
