<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Archiving System</title>
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
        <h3 class="text-center text-white">File Archiving System</h3>
        <ul>
            <li><a href="employee_management.php">Add Files</a></li>
            <li><a href="display_employee.php">File Records</a></li>
            <li><a href="display_archive_employee.php">Archived Files</a></li>
        </ul>
        <div class="logout-container">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div id="container" class="content">
        <h2>Add Employee/File</h2>

        <!-- Form -->
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
    File Name: <input type="text" name="file_name" class="form-control"><br>
    Employee ID: <input type="text" name="employee_id" class="form-control"><br>
    Company: <input type="text" name="company" class="form-control"><br>
    Status:
    <select name="status" class="form-control">
        <option value="ACTIVE">ACTIVE</option>
        <option value="INACTIVE">INACTIVE</option>
        <option value="N/A">N/A</option>
    </select><br>
    Select files to upload: <input type="file" name="files[]" id="filesToUpload" class="form-control" multiple><br>
    <button type="submit" id="uploadButton" class="btn btn-primary">Upload Files</button>
</form>

    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.getElementById("uploadForm");
            form.addEventListener("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "upload.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Redirect to display_employee.php after successful submission
                        window.location.href = "display_employee.php";
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>
