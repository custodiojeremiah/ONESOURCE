<?php
// Include your database connection file
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Adjust styles as needed */
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
            background-color: #343a40; /* Dark color for sidebar */
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
            color: #fff; /* White color for sidebar links */
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            background-color: #555; /* Darker color on hover */
        }

        /* Table styles */
        .table-container {
            background-color: #fff; /* White background for table container */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow for container */
        }

        .table-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-white">Admin Panel</h3>
        <ul>
            <li><a href="admin_page1.php">Dashboard</a></li>
            <li><a href="display_staff_accounts.php">Staff Accounts</a></li>
            <li><a href="display_archive_staff_accounts.php">Archive</a></li>
        </ul>
        <!-- Logout button -->
        <div class="logout-container">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <!-- Content -->
    <div class="content">
  <h2>Archived Staff Accounts</h2>

<?php
// Fetch archived staff accounts from the database
$sql = "SELECT * FROM archive_staff_accounts"; // Query to retrieve data from the archive table
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-container'>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col'>ID</th>";
    echo "<th scope='col'>Username</th>";
    echo "<th scope='col'>Name</th>";
    echo "<th scope='col'>User Type</th>";
    echo "<th scope='col'>Actions</th>"; // Added actions column header
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop through archived staff accounts and display in table rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['user_type'] . "</td>";
        echo "<td>";
        echo "<button class='btn btn-success btn-sm retrieve-btn' data-id='" . $row['id'] . "'>Retrieve</button>";
        echo "<button class='btn btn-danger btn-sm remove-btn' data-id='" . $row['id'] . "'>Remove</button>";
        echo "</td>"; // Buttons for actions
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    // If no archived staff accounts found, display a message
    echo "<p>No archived staff accounts found.</p>";
}

// Close the database connection
mysqli_close($conn);
?>


 <!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Remove item from archive when remove button is clicked
        $('.remove-btn').click(function() {
            var id = $(this).data('id');

            // Confirm before removing the item
            if (confirm("Are you sure you want to remove this item from the archive?")) {
                $.ajax({
                    url: 'remove_archive_staff_accounts.php', // PHP file to handle removal
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response === "success") {
                            // Reload the page after successful removal
                            location.reload();
                        } else {
                            alert("Error: Unable to remove item from the archive.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error if needed
                    }
                });
            }
        });

        // Retrieve item from archive when retrieve button is clicked
        $('.retrieve-btn').click(function() {
            var id = $(this).data('id');

            // Confirm before retrieving the item
            if (confirm("Are you sure you want to retrieve this item from the archive?")) {
                $.ajax({
                    url: 'retrieve_from_archive.php', // PHP file to handle retrieval
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response === "success") {
                            // Reload the page after successful retrieval
                            location.reload();
                        } else {
                            alert("Error: Unable to retrieve item from the archive.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error if needed
                    }
                });
            }
        });
    });
</script>

</body>

</html>
