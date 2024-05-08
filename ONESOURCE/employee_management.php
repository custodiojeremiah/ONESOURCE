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
	<!-- Logout button -->
    <button onclick="logout()" id="logoutButton">Logout</button>
    <!-- Form -->
    <div id="container">
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <!-- Input fields -->
            Employee Name: <input type="text" name="employee_name"><br>
            Employee ID: <input type="text" name="employee_id"><br>
            Date and Time: <input type="datetime-local" name="date"><br>
            Company:
            <select name="company">
                <option value="FSCI">FSCI</option>
                <option value="YUTAKA">YUTAKA</option>
                <option value="EMPERADOR">EMPERADOR</option>
                <option value="SHOPPEE">SHOPPEE</option>
                <option value="FAST">FAST</option>
                <option value="CTEPI">CTEPI</option>
                <!-- Add more options as needed -->
            </select><br>
            Status: <select name="status">
                <option value="ACTIVE">ACTIVE</option>
                <option value="INACTIVE">INACTIVE</option>
                <!-- Add more options as needed -->
            </select><br>
            Description: <textarea name="description"></textarea><br>
            Select file to upload: <input type="file" name="file" id="fileToUpload"><br>
            <button type="submit" id="uploadButton">Upload File</button>
        </form>

        <!-- Table to display uploaded file information -->
        <div id="fileTable"></div>
    </div>

    <script>
        function clearForm() {
            document.getElementById("uploadForm").reset();
        }
		 // Function to handle logout
        function logout() {
            // Perform logout action here, such as redirecting to a logout page
            window.location.href = "login_form.php";
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
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Update the table with the response from the server
                        fileTable.innerHTML = xhr.responseText;
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</body>



<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    color: #2E4053;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Apply background image to a specific element */
.custom-background {
    background-image: url('img/logos.png');
    background-repeat: no-repeat;
    background-size: cover; /* Adjust background size if needed */
}

#container {
    width: 65%; /* Adjust width as needed */
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    position: relative; /* Add relative positioning */
}

#addEmployeeButton {
    position: absolute; /* Position relative to the container */
    top: 0; /* Place at the top */
    right: 0; /* Place at the right */
    margin: 20px; /* Add some margin */
    background-color: darkkhaki;
    color: #333;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
}

#addEmployeeButton:hover {
    background-color: #e2b607;
}

/* Other styles remain unchanged */

        #logo {
            width: 100px;
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            color: #f1c40f;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="datetime-local"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
          
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        button {
            background-color: darkkhaki;
            color: #333;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            position: center;
        }

        button:hover {
            background-color: #e2b607;
        }

        #fileTable {
            margin-top: 20px;
        }
        

        
    </style>
</body>
</html>
