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
        <li><a href="employee_management.php">Employee Management</a></li>
    </ul>
    <!-- Logout button -->
    <div class="logout-container">
        <a href="logout.php">Logout</a>
    </div>
</div>

    <!-- Page Content -->
    <div class="content">
        <h2>Welcome to Admin Page</h2>
        <hr>
        <!-- Dashboard Content -->
        <div id="dashboard">
            <h3>Dashboard</h3>
            <p>This is the dashboard content.</p>
        </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
