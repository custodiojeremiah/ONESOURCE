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

        /* Styles for the logout button */
        .logout-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .logout-container a {
            color: #fff; /* White color for logout link */
            text-decoration: none;
        }

        .logout-container a:hover {
            color: #ccc; /* Light gray color on hover */
        }

        /* Table styles */
        .table-container {
            background-color: #fff; /* White background for table container */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow for container */
        }

        .table-container h3 {
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

  <div id="staffAccounts" class="content">
    <h2>Staff Accounts</h2>
    <button class="btn btn-success" id="addStaffBtn">Add Staff</button>

    <?php
    // Include your database connection file
    include 'config.php';

    // Fetch staff accounts from the database
    $sql = "SELECT id, username, name, user_type FROM staff_accounts"; // Modify the table name here if needed
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>ID</th>";
        echo "<th scope='col'>Username</th>";
        echo "<th scope='col'>Name</th>";
        echo "<th scope='col'>User Type</th>";
        echo "<th scope='col'>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Loop through staff accounts and display in table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['user_type'] . "</td>";
            echo "<td>";
            echo "<button class='btn btn-info btn-sm edit-btn' data-toggle='modal' data-target='#editModal' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-username='" . $row['username'] . "' data-user-type='" . $row['user_type'] . "'>Edit</button>";
            echo "<form class='archive-form' method='POST' action='archive_staff.php'>"; // Added class 'archive-form'
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<button type='submit' class='btn btn-warning btn-sm archive-btn'>Archive</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        // If no staff accounts found, display a message
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
                            <input type="text" class="form-control" id="editName" name="name" required>
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
<button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form for adding staff here -->
                <form method="POST" action="create_staff_accounts.php">
                    <!-- Form fields for adding staff -->
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
                    <!-- Other form fields for adding staff -->
                    <button type="submit" class="btn btn-primary">Add Staff</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Archiving process was successful.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // Your existing JavaScript code

        // Show the modal when addStaffBtn is clicked
        $('#addStaffBtn').click(function() {
            $('#addStaffModal').modal('show');
        });

        // Submit the archive form asynchronously
        $('.archive-form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var form = $(this);
            var formData = form.serialize(); // Serialize form data

            // Submit the form asynchronously
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                success: function(response) {
                    // Show the success modal
                    $('#successModal').modal('show');
                    // Optionally, reload the page after a delay
                    setTimeout(function() {
                        location.reload();
                    }, 2000); // 2000 milliseconds = 2 seconds
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error if needed
                }
            });
        });
    });
	
function saveChanges() {
        // Get form data
        var id = $('#editId').val();
        var name = $('#editName').val();
        var username = $('#editUsername').val();
        var userType = $('#editUserType').val();

        // Construct data object
        var formData = {
            id: id,
            name: name,
            username: username,
            user_type: userType
        };

        // Submit form data asynchronously
        $.ajax({
            type: 'POST',
            url: 'edit_staff.php',
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response); // Log response for debugging
                // Close the modal
                $('#editModal').modal('hide');
                // Optionally, reload the page or update the table with new data
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText); // Log error for debugging
                // Optionally, display an error message to the user
            }
        });
    }
</script>


</body>

</html>