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
    </style>
</head>
<body>

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


<div id="staffAccounts" class="content">
    <h2>Staff Accounts</h2>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search">


    <button class="btn btn-success" id="addStaffBtn">Add Staff</button>

    <!-- PHP to fetch and display staff accounts from the database -->
    <?php
    include 'config.php'; // Ensure your DB connection settings are correct

    // Prepare and execute a query to fetch all staff accounts
    $query = "SELECT id, username, name, user_type FROM staff_accounts ORDER BY id ASC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered mt-3'>";
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Username</th>";
        echo "<th>Name</th>";
        echo "<th>User Type</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Loop through each row and create a table row for each
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['user_type']) . "</td>";
            echo "<td>";
            // Edit button triggers the edit modal and fills in the form with data
            echo "<button class='btn btn-info edit-btn' data-id='" . $row['id'] . "' data-username='" . $row['username'] . "' data-name='" . $row['name'] . "' data-user-type='" . $row['user_type'] . "' data-toggle='modal' data-target='#editModal'>Edit</button> ";
            // Delete button could potentially trigger a delete action
            echo "<button class='btn btn-warning archive-btn' data-id='" . $row['id'] . "'>Archive</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No staff accounts found.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>


    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="edit_staff.php">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="newName" required>
                        </div>
                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserType">User Type</label>
                            <select class="form-control" id="editUserType" name="user_type" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                    <button type="button" the "close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addStaffForm" method="POST" action="create_staff_accounts.php">
                        <div class="form-group">
                            <label for="staffName">Staff Name</label>
                            <input type="text" class="form-control" id="staffName" name="name" placeholder="Enter staff name" required>
                        </div>
                        <div class="form-group">
                            <label for="staffUsername">Username</label>
                            <input type="text" class="form-control" id="staffUsername" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                            <label for="staffEmail">Staff Email</label>
                            <input type="email" class="form-control" id="staffEmail" name="email" placeholder="Enter staff email" required>
                        </div>
                        <div class="form-group">
                            <label for="staffPassword">Staff Password</label>
                            <input type="password" class="form-control" id="staffPassword" name="password" placeholder="Enter staff password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm staff password" required>
                        </div>
                        <div class="form-group">
                            <label for="userType">User Type</label>
                            <select class="form-control" id="userType" name="user_type" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Show the Add Staff modal
    $('#addStaffBtn').click(function() {
        $('#addStaffModal').modal('show');
    });

    // Populate the Edit Staff modal fields and show it
 function populateEditModal(id, name, username, email, userType) {
    $('#editId').val(id);
    $('#editName').val(name);
    $('#editUsername').val(username);
    $('#editEmail').val(email); // Make sure this is correct
    $('#editUserType').val(userType);
    $('#editModal').modal('show');
}


    // Attach click event to Edit button dynamically
    $(document).on('click', '.edit-btn', function() {
        var $button = $(this);
        populateEditModal($button.data('id'), $button.data('name'), $button.data('username'), $button.data('email'), $button.data('user-type'));
    });

    // Submit the Edit Staff form
    $('#editForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'edit_staff.php',
            data: formData,
            success: function(response) {
                alert('Update Successful: ' + response);
                $('#editModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Update Failed: ' + xhr.responseText);
            }
        });
    });

    // Submit the Add Staff form
    $('#addStaffForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var staffName = $('#staffName').val();
        var staffUsername = $('#staffUsername').val();
        var staffEmail = $('#staffEmail').val();

        // Check for duplicate username, name, and email
        if (checkDuplicate(staffName, staffUsername, staffEmail)) {
            alert('Staff with the same name, username, or email already exists.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                $('#addStaffModal').modal('hide');
                alert('New staff added successfully');
                location.reload();
            },
            error: function(xhr) {
                alert('Error adding new staff: ' + xhr.responseText);
            }
        });
    });

    // Attach click event to Archive button dynamically
    $(document).on('click', '.archive-btn', function() {
        var staffId = $(this).data('id');
        if (confirm("Are you sure you want to archive this staff member?")) {
            $.ajax({
                type: 'POST',
                url: 'archive_staff.php',
                data: { id: staffId },
                success: function(response) {
                    alert('Staff archived successfully');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error archiving staff: ' + xhr.responseText);
                }
            });
        }
    });
	            function sortTable(n) {
                var table = document.getElementById("fileRecordsTable");
                var rows = table.getElementsByTagName("tr");
                var switching = true;
                var dir = "asc";
                var switchcount = 0;
                while (switching) {
                    switching = false;
                    for (var i = 1; i < (rows.length - 1); i++) {
                        var shouldSwitch = false;
                        var x = rows[i].getElementsByTagName("TD")[n];
                        var y = rows[i + 1].getElementsByTagName("TD")[n];
                        if ((dir == "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) ||
                            (dir == "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    } else if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }

    // Function to check for duplicate username, name, and email
    function checkDuplicate(name, username, email) {
        var rows = $('#staffAccounts').find('tr');
        var duplicate = false;
        rows.each(function() {
            var existingName = $(this).find('td:eq(2)').text();
            var existingUsername = $(this).find('td:eq(1)').text();
            var existingEmail = $(this).find('td:eq(3)').text();
            if (existingName === name || existingUsername === username || existingEmail === email) {
                duplicate = true;
                return false; // Exit the loop
            }
        });
        return duplicate;
    }
});
$(document).ready(function() {
    // Search function
    $('#searchInput').on('input', function() {
        var query = $(this).val().toLowerCase();
        $('#staffAccounts tbody tr').each(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
        });
    });
});
</script>


</body>
</html>
