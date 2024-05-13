<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Files</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .sidebar { height: 100%; width: 250px; position: fixed; top: 0; left: 0; background-color: #343a40; padding-top: 20px; }
        .content { margin-left: 250px; padding: 20px; }
        .sidebar ul { list-style-type: none; padding: 0; }
        .sidebar ul li a { display: block; padding: 10px 20px; color: #fff; text-decoration: none; }
        .sidebar ul li a:hover { background-color: #555; }
        .logout-container { position: absolute; bottom: 20px; width: 100%; text-align: center; }
        .logout-container a { color: #fff; text-decoration: none; }
        .logout-container a:hover { color: #ccc; }
        table { width: 100%; background-color: #fff; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ccc; }
        th { background-color: #007bff; color: white; }
        .btn-sm { padding: 5px 10px; color: #fff; border-radius: 5px; }
        .btn-warning, .btn-info { background-color: #ffc107; }
        .btn-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-center text-white">File Archiving System</h3>
        <ul>
            <li><a href="display_employee.php">File Records</a></li>
            <li><a href="display_archive_employee.php">Archived Files</a></li>
        </ul>
        <div class="logout-container">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="content">
        <h2>Archived Files</h2>
        <?php
        include 'config.php';
        $query = "SELECT * FROM archive_files";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>File Name</th><th>Employee ID</th><th>Company</th><th>Status</th><th>File Path</th><th>Timestamp</th><th>Set Obsolete</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['company']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['file_path']) . "</td>";
                echo "<td>" . htmlspecialchars($row['upload_timestamp']) . "</td>";
                echo "<td>";
                if (empty($row['removal_date'])) {
                    echo "<form action='set_obsolete.php' method='post'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <select name='years' class='form-control'>
                                <option value='2'>2 Years</option>
                                <option value='3'>3 Years</option>
                                <option value='4'>4 Years</option>
                                <option value='5'>5 Years</option>
                            </select>
                            <button type='submit' class='btn btn-warning btn-sm'>Set Obsolete</button>
                          </form>";
                } else {
                    echo "Set for removal on " . date("Y-m-d", strtotime($row['removal_date']));
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No archived records found.</p>";
        }
        $conn->close();
        ?>
    </div>

    <!-- Modal for Nearing Obsolescence Alerts -->
    <div class="modal fade" id="obsoleteNotificationModal" tabindex="-1" role="dialog" aria-labelledby="obsoleteNotificationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="obsoleteNotificationLabel">Nearing Obsolescence</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="nearingObsoleteAlerts">
                    <!-- Alerts will be loaded here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>		
$(document).ready(function() {
    // Function to fetch nearing obsolescence alerts
    function fetchNearingObsolescenceAlerts() {
        $.ajax({
            url: 'check_obsolete_dates.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    let alertsHtml = data.map(item => `<p>${item.file_name} is nearing its obsolescence date on ${item.removal_date}.</p>`).join('');
                    $('#nearingObsoleteAlerts').html(alertsHtml);
                    $('#obsoleteNotificationModal').modal('show');
                }
            },
            error: function() {
                console.log('Error retrieving obsolescence data.');
            }
        });
    }

    // Call fetchNearingObsolescenceAlerts function on page load
    fetchNearingObsolescenceAlerts();  

    // Search function
    $('#searchInput').on('input', function() {
        var query = $(this).val().toLowerCase();
        $('table tbody tr').each(function() {
            var file_name = $(this).find('td:eq(0)').text().toLowerCase();
            var employee_id = $(this).find('td:eq(1)').text().toLowerCase();
            var company = $(this).find('td:eq(2)').text().toLowerCase();
            var status = $(this).find('td:eq(3)').text().toLowerCase();
            if (file_name.indexOf(query) > -1 || employee_id.indexOf(query) > -1 || company.indexOf(query) > -1 || status.indexOf(query) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
</body>
</html>
