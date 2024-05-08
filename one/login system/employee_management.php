
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .button {
            display: inline-block;
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none;
            padding: 5px 10px; /* Padding inside the button */
            margin: 5px 0; /* Space above and below the button */
            text-align: center;
            text-decoration: none; /* Removes underline from the link */
            font-size: 12px;
            cursor: pointer;
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }
        .button:hover {
            background-color: #45a049; /* Slightly darker green on hover */
        }
    </style>
<body>
    <div class="content">
        <p>You are successfully logged in!</p>
        <a href="logout.php" class="button">Log Out</a> <!-- Styled Logout Button -->
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Management</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<button id="addEmployeeBtn">ADD EMPLOYEE</button>
<div id="employeeForm" style="display: none;">
  <form id="employeeManagementForm" action="upload.php" method="post" enctype="multipart/form-data">
  <label for="name">Name*</label>
<input type="text" id="name" name="name" required pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
    <label for="employeeId">Employee ID*</label>
    <input type="text" id="employeeId" name="employeeId" pattern="\d{2,3}-\d{4}|\d{2,3}-\d{6}" placeholder="XX-XXXX or XXX-XXXX" required title="Employee ID format: XX-XXXX or XXX-XXXX">
    <label for="date">Date*</label>
    <input type="date" id="date" name="date" required>
    <label for="company">Company*</label>
<select id="company" name="company" required onchange="updateRoleDropdown()">
    <option value="">Select a company</option>
    <option value="FIRST SUMIDEN">FIRST SUMIDEN</option>
    <option value="PORTION FILLER">PORTION FILLER</option>
    <option value="NEWLYWEDS">NEWLYWEDS</option>
    <option value="LAGUNA CAR PARTS">LAGUNA CAR PARTS</option>
    <option value="Shopee">Shopee</option>
</select>

<label for="role">Role*</label>
<select id="role" name="role" required disabled>
    <option value="">Select a role</option>
    <option value="rider">Rider</option>
    <option value="sorter">Sorter</option>
</select>

<script>
function updateRoleDropdown() {
    var companyDropdown = document.getElementById('company');
    var roleDropdown = document.getElementById('role');
    // Check if the selected company is 'Shopee'
    if (companyDropdown.value === 'Shopee') {
        roleDropdown.disabled = false; // Enable the role dropdown
    } else {
        roleDropdown.disabled = true; // Disable the role dropdown
        roleDropdown.value = ''; // Reset the role selection
    }
}
</script>

<label for="status">Status</label>
<select id="status" name="status" required>
    <option value="">Select status</option>
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
</select>

</head>
<body>
        <label class="custom-file-upload">
        Choose File
        </label>
        <style>
    .submit-button {
        background-color: #4CAF50; /* Green background */
        color: white; /* White text color */
        border: none; /* No border */
        padding: 1px 5px; /* Smaller padding for a smaller button */
        cursor: pointer;
        border-radius: 50px; /* Rounded corners */
        font-size: 15px; /* Smaller font size */
    }

    .submit-button:hover {
        background-color: #45a049; /* Darker green on hover */
    }
</style>
        <button type="submit" class="submit-button">Submit</button>
    </form>
</body>
<form method="post" enctype="multipart/form-data">
    <!-- Input and other form elements here -->
</form>

<input type="file" id="file" name="file[]" multiple accept="image/*,application/pdf">
<input type="file" id="file" name="file[]" multiple accept="image/*,application/pdf">
<input type="file" id="file" name="file[]" multiple accept="image/*,application/pdf">
<input type="file" id="file" name="file[]" multiple accept="image/*,application/pdf">
<script>
    const fileInput = document.getElementById('file');
    const label = document.querySelector('.custom-file-upload');

    fileInput.onchange = () => {
        let fileList = Array.from(fileInput.files).map(file => file.name).join(', ');
        label.textContent = fileList ? fileList : 'Choose File';
    };
</script>

</div>
<div id="searchContainer">
  <input type="text" id="searchEmployee" placeholder="Search Employee">
  <span id="searchIcon">&#128269;</span> <!-- Search icon -->
</div>
<table id="employeeTable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Employee ID</th>
      <th>Date</th>
      <th>Status</th>
      <th>Company</th>
      <th>PDF</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <!-- Employee rows will be dynamically inserted here -->
  </tbody>
</table>
<script src="script.js"></script>

</body>
</html>