<?php
// Include your database connection file
include 'config.php';

session_start();

if(isset($_POST['submit'])){

    // Retrieve form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // Hash the password for security

    // Prepare SQL statement to select user from the database
    $sql = "SELECT * FROM staff_accounts WHERE email = '$email' AND password = '$password'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if a matching user is found
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);

        // Check user type and set session accordingly
        if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            header('location: display_staff_accounts.php');
            exit;
        } elseif($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location: display_employee.php'); // Redirect to index.php for users
            exit;
        }
    } else {
        $error = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Font Awesome library -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
   <style>
      .password-container {
         position: relative;
      }
      .show-password {
         position: absolute;
         top: 50%;
         right: 10px;
         transform: translateY(-50%);
         cursor: pointer;
      }
   </style>
</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>ONE SOURCE FILE ARCHIVING SYSTEM</h3>
      <?php
      if(isset($error)){
         echo '<span class="error-msg">'.$error.'</span>';
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <div class="password-container">
         <input type="password" name="password" required placeholder="Enter your Password">
         <span class="show-password" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
         </span>
      </div>
      <input type="submit" name="submit" value="Login Now" class="form-btn">
   </form>

</div>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
function togglePassword() {
   var x = document.getElementsByName("password")[0];
   if (x.type === "password") {
      x.type = "text";
   } else {
      x.type = "password";
   }
}
</script>

</body>
</html>
