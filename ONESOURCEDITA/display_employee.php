<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Records</title>
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
        .table-responsive { overflow-x: auto; }
        #fileRecordsTable th.hovered {
            background-color: #555;
            color: #fff;
            cursor: pointer;
        }
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

    <div class="container content">
        <h2>File Records</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary" id="addEmployeeButton" data-toggle="modal" data-target="#addEmployeeModal">Add File</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="fileRecordsTable">
                <thead class="thead-dark">
                    <tr>
                        <th style="min-width: 50px;">File Name</th>
                        <th style="min-width: 50px;">Employee ID</th>
                        <th style="min-width: 50px;">Company</th>
                        <th style="min-width: 80px;">Status</th>
                        <th style="min-width: 80px;">File</th>
                        <th style="min-width: 80px;">Actions</th>
                        <th style="min-width: 100px;">Timestamp</th>
                    </tr>
                </thead>
                <tbody id="fileRecordsBody">
                    <?php
                    include 'config.php';
                    $query = "SELECT id, file_name, employee_id, company, status, file_path, upload_timestamp FROM employee_files";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['company']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td><a href='uploads/" . htmlspecialchars($row['file_path']) . "' target='_blank'>View File</a></td>";
                            echo "<td><button class='btn btn-info btn-sm btn-edit' data-id='" . $row['id'] . "' data-file-name='" . htmlspecialchars($row['file_name']) . "'>Edit</button> <button class='btn btn-danger btn-sm btn-archive' data-id='" . $row['id'] . "'>Archive</button></td>";
                            echo "<td>" . htmlspecialchars($row['upload_timestamp']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add File Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        File Name: <input type="text" name="file_name" id="file_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        Employee ID: <input type="text" name="employee_id" id="employee_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        Company: <input type="text" name="company" id="company" class="form-control" required>
                    </div>
                    <div class="form-group">
                        Status:
                        <select name="status" id="status" class="form-control" required>
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div class="form-group">
                        Select files to upload: <input type="file" name="files[]" id="filesToUpload" class="form-control" multiple required><br>
                    </div>
                    <button type="submit" id="uploadButton" class="btn btn-primary">Upload Files</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit File Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label>File Name:</label>
                            <p id="editFileName"></p>
                        </div>
                        <div class="form-group">
                            <label for="editEmployeeId">Employee ID</label>
                            <input type="text" class="form-control" id="editEmployeeId" name="employeeId" required>
                        </div>
                        <div class="form-group">
                            <label for="editCompany">Company</label>
                            <input type="text" class="form-control" id="editCompany" name="company" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                $('#fileRecordsBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });

            $("#fileRecordsTable th").click(function() {
                var index = $(this).index();
                sortTable(index);
            }).hover(function() {
                $(this).addClass("hovered");
            }, function() {
                $(this).removeClass("hovered");
            });

            $('#uploadForm').submit(function(event) {
                event.preventDefault();
                if (checkDuplicate($('#employee_id').val())) {
                    alert('Employee with the same ID already exists.');
                    return;
                }
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('New file added successfully');
                        $('#addEmployeeModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error adding new file: ' + xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var fileName = $(this).data('file-name');
                $('#editId').val(id);
                $('#editFileName').text(fileName);
                $('#editEmployeeId').val($(this).closest('tr').find('td:eq(1)').text());
                $('#editCompany').val($(this).closest('tr').find('td:eq(2)').text());
                $('#editStatus').val($(this).closest('tr').find('td:eq(3)').text());
                $('#editModal').modal('show');
            });

            $(document).on('submit', '#editForm', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'edit_employee.php',
                    data: formData,
                    success: function(response) {
                        alert('Record updated successfully.');
                        $('#editModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.btn-archive', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to archive this record?')) {
                    $.ajax({
                        type: 'POST',
                        url: 'archive_employee.php',
                        data: { employeeId: id },
                        success: function(response) {
                            alert('Record archived successfully.');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseText);
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

            function checkDuplicate(employeeId) {
                var duplicate = false;
                $('#fileRecordsBody tr').each(function() {
                    if ($(this).find('td:eq(2)').text() === employeeId) {
                        duplicate = true;
                        return false; // break the loop
                    }
                });
                return duplicate;
            }
        });
    </script>
</body>
</html>
