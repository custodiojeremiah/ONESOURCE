<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
</head>
<body>
    <h1>Employee Management System</h1>

    <!-- Form to add new employee -->
    <h2>Add New Employee</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data"> <!-- Changed action to upload.php -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="employee_id">Employee ID (Format: xx-xxxx or xxx-xxxx):</label>
        <input type="text" id="employee_id" name="employee_id" pattern="[0-9]{2,3}-[0-9]{4}" title="Please enter in the format xx-xxxx or xxx-xxxx" required><br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="company">Company:</label>
        <select id="company" name="company" required>
            <option value="">Select Company</option>
            <option value="ABC Company">ABC Company</option>
            <option value="XYZ Corp">XYZ Corp</option>
            <option value="DEF Ltd">DEF Ltd</option>
            <!-- Add more companies as needed -->
        </select><br><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="">Select Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="On Leave">On Leave</option>
            <!-- Add more status options as needed -->
        </select><br><br>

        <label for="uploaded_files">Uploaded Files:</label>
        <input type="file" id="uploaded_files" name="uploaded_files[]" multiple><br><br>

        <input type="submit" value="Add Employee">
    </form>

    <hr>

    <!-- Display table of employees -->
    <h2>Employee List</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Employee ID</th>
            <th>Date</th>
            <th>Company</th>
            <th>Role</th>
            <th>Status</th>
            <th>Uploaded Files</th>
        </tr>
        <!-- PHP code to fetch and display employee data -->
        <?php
            include 'fetch_data.php';
        ?>
    </table>
</body>
</html>
