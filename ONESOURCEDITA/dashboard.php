	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Dashboard</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>

	<div class="navbar">
		<ul>
			<li id="home" class="active">Home</li>
			<li id="employee-management">Employee Management</li>
			<li id="file-upload-trigger">File Upload</li>
		</ul>
	</div>

	<div class="content">
		<h1>Welcome to the Dashboard</h1>
		<p>This is the content area where you can view different sections.</p>

		<div id="home-section">
			<h2>Home</h2>
			<img src="https://via.placeholder.com/400" alt="Placeholder image">
		</div>

		<div id="file-upload-section">
			<h2>File Upload</h2>
			<input type="file" id="file-upload" accept=".pdf,.jpg,.jpeg,.png">
			<button class="file-upload-btn" id="file-upload-btn">Upload File</button>
		</div>

		<div id="employee-management-section">
			<h2>Employee Management</h2>
			<button id="add-employee-btn">Add Employee</button>
			<div id="add-employee-form">
				<h3>Add New Employee</h3>
				<form id="employee-form" method="post" action="add_employee.php" enctype="multipart/form-data">
					<label for="employee-id">Employee ID:</label>
					<input type="text" id="employee-id" name="employee_id" required><br><br>
					<label for="employee-name">Employee Name:</label>
					<input type="text" id="employee-name" name="employee_name" required><br><br>
					<label for="file-description">File Description:</label>
					<input type="text" id="file-description" name="file_description"><br><br>
					<label for="fileToUpload">Upload File:</label>
					<input type="file" id="fileToUpload" name="fileToUpload" accept=".pdf,.jpg,.jpeg,.png"><br><br>
					<button type="submit">Add Employee</button>
				</form>
			</div>
			<table id="employee-table">
				<thead>
					<tr>
						<th>Employee ID</th>
						<th>Employee Name</th>
						<th>File Description</th>
						<th>Uploaded File</th>
						<th>Timeframe</th> <!-- Displayed but not entered by user -->
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- PHP code will be added here to populate the table -->
				</tbody>
			</table>
		</div>
	</div>

	<script>
		// JavaScript code to fetch employee data and update the table
		function updateEmployeeTable() {
			// Fetch updated data from the server and update the table
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					// Update table with new data
					document.getElementById('employee-table').getElementsByTagName('tbody')[0].innerHTML = this.responseText;
				}
			};
			xhttp.open("GET", "get_employees.php", true);
			xhttp.send();
		}

		// Call the updateEmployeeTable function initially to populate the table
		updateEmployeeTable();

		// Add event listeners for navigation
		document.getElementById('home').addEventListener('click', function() {
			showSection('home-section');
		});

		document.getElementById('employee-management').addEventListener('click', function() {
			showSection('employee-management-section');
			// Update employee table when navigating to Employee Management section
			updateEmployeeTable();
		});

		document.getElementById('file-upload-trigger').addEventListener('click', function() {
			showSection('file-upload-section');
		});

		// Function to show a specific section and hide others
		function showSection(sectionId) {
			var sections = document.querySelectorAll('.content > div');
			sections.forEach(function(section) {
				if (section.id === sectionId) {
					section.style.display = 'block';
				} else {
					section.style.display = 'none';
				}
			});
		}
	</script>

	</body>
	</html>
