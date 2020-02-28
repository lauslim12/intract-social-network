<?php
  require 'config/config.php';
  require 'src/controllers/form_handlers/register_handler.php';
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Welcome to Intract!</title>
  </head>

  <body>
    <!-- Action left empty to prevent XSS. -->
    <form action='' method="POST">
      <input type="text" name="fname" placeholder="First Name" value="<?php
        if(isset($_SESSION['fname'])) {
          echo $_SESSION['fname'];
        }
      ?>" required /><br>
      <?php if(in_array("Your first name has to be between 2 to 25 characters!<br>", $error_array)) echo "Your first name has to be between 2 to 25 characters!<br>"; ?>

      <input type="text" name="lname" placeholder="Last Name" value="<?php
        if(isset($_SESSION['lname'])) {
          echo $_SESSION['lname'];
        }
      ?>" required /><br>
      <?php if(in_array("Your last name has to be between 2 to 25 characters!<br>", $error_array)) echo "Your last name has to be between 2 to 25 characters!<br>"; ?>

      <input type="text" name="username" placeholder="Username" required /><br>

      <input type="email" name="email" placeholder="Email" value="<?php
        if(isset($_SESSION['email'])) {
          echo $_SESSION['email'];
        }
      ?>" required /><br>

      <input type="email" name="email2" placeholder="Confirm Email" required /><br>
      <?php 
        if(in_array("Emails do not match!<br>", $error_array)) {
          echo "Emails do not match!<br>";
        }
        else if(in_array("Invalid email format!<br>", $error_array)) {
          echo "Invalid email format!<br>";
        }
        else if(in_array("Email already in use!<br>", $error_array)) {
          echo "Email already in use!<br>"; 
        }
      ?>
      
      <input type="password" name="password" placeholder="Password" required /><br>
      
      <input type="password" name="password2" placeholder="Confirm Password" required /><br>
      <?php if(in_array("Your password do not match!<br>", $error_array)) echo "Your password do not match!<br>"; ?>
      
      <input type="date" name="birthdate" required /><br>
      
      <input type="radio" name="gender" value="M">Male
      
      <input type="radio" name="gender" value="F">Female<br>
      
      <input type="submit" name="register_button" value="Submit">
      <?php if(in_array("<span>You're registered! Please login!</span><br>", $error_array)) echo "<span>You're registered! Please login!</span><br>"; ?>

    </form>  
  </body>
</html>