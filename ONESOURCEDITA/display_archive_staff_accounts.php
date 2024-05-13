<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li a {
            display: block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
        }
        .sidebar ul li a:hover {
            background-color: #555;
        }
        .logout-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }
        .logout-container a {
            color: #fff;
            text-decoration: none;
        }
        .logout-container a:hover {
            color: #ccc;
        }
        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #007bff;
            color: white;
            cursor: pointer; /* Add cursor to indicate clickable columns for sorting */
        }
        tr:hover {
            background-color: #f2f2f2; /* Hover effect for rows */
        }
        .btn-sm {
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px; /* Rounded corners for buttons */
        }
        .btn-danger {
            background-color: #dc3545; /* Red color for remove button */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-white">Admin Panel</h3>
        <ul>
            <li><a href="display_staff_accounts.php">Staff Accounts</a></li>
            <li><a href="display_archive_staff_accounts.php">Archive</a></li>
        </ul>
        <div class="logout-container">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <!-- Content -->
    <div class="content">
        <h2>Archived Staff Accounts</h2>
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search">
        <?php
        include 'config.php';
        $sql = "SELECT * FROM archive_staff_accounts";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-container'>";
            echo "<table id='archivedTable' class='table'>";
            echo "<thead><tr><th>Username</th><th>Name</th><th>User Type</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['user_type']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "</div>";
        } else {
            echo "<p>No archived staff accounts found.</p>";
        }
        mysqli_close($conn);
        ?>
    </div>
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#archivedTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('th').on('click', function() {
                var table = $(this).parents('table').eq(0);
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
                this.asc = !this.asc;
                if (!this.asc) { rows = rows.reverse(); }
                for (var i = 0; i < rows.length; i++) { table.append(rows[i]); }
            });

            function comparer(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index), valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                };
            }

            function getCellValue(row, index) { return $(row).children('td').eq(index).text(); }
        });
    </script>
</body>
</html>
