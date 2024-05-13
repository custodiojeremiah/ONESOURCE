<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="custom-background">
    <!-- Add New Employee button -->
    <button onclick="clearForm()" id="addEmployeeButton">Add New Employee</button>

    <!-- Form -->
    <div id="container">
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <!-- Input fields -->
            <label for="employee_name">Employee Name:</label>
            <input type="text" name="employee_name" id="employee_name" required><br>
            <label for="employee_id">Employee ID:</label>
            <input type="text" name="employee_id" id="employee_id" required><br>
            <label for="date">Date and Time:</label>
            <input type="datetime-local" name="date" id="date" required><br>
            <label for="company">Company:</label>
            <select name="company" id="company" required>
                <option value="FSCI">FSCI</option>
                <option value="YUTAKA">YUTAKA</option>
                <option value="EMPERADOR">EMPERADOR</option>
                <option value="SHOPPEE">SHOPPEE</option>
                <option value="FAST">FAST</option>
                <option value="CTEPI">CTEPI</option>
                <!-- Add more options as needed -->
            </select><br>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="ACTIVE">ACTIVE</option>
                <option value="INACTIVE">INACTIVE</option>
                <!-- Add more options as needed -->
            </select><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea><br>
            <label for="fileToUpload">Select file to upload:</label>
            <input type="file" name="file" id="fileToUpload" required><br>
            <button type="submit" id="uploadButton">Upload File</button>
        </form>

        <!-- Table to display uploaded file information -->
        <div id="fileTable"></div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("uploadForm").reset();
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get reference to the form and table elements
            var form = document.getElementById("uploadForm");
            var fileTable = document.getElementById("fileTable");

            // Add event listener to the form submission
            form.addEventListener("submit", function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Create a FormData object and append form data
                var formData = new FormData(form);

                // Send form data using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "upload.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Update the table with the response from the server
                            fileTable.innerHTML = xhr.responseText;
                            clearForm(); // Clear the form after successful upload
                        } else {
                            // Display error message to the user
                            alert('Error: Unable to upload file.');
                        }
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>
