<?php
  require 'config/config.php';
  require 'src/controllers/form_handlers/register_handler.php';
  require 'src/controllers/form_handlers/login_handler.php';
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Welcome to Intract!</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="assets/js/landing.js"></script>
  </head>

  <body class="landing-body">

    <?php
      if(isset($_POST['register_button'])) {
        echo '
          <script>
            $(document).ready(function() {
              $(".form-view__login").hide();
              $(".form-view__register").show();
            });
          </script>
        ';
      }
    ?>

    <main class="form-view">
      
      <div class="form-view__header">
        <h2>Intract</h2>
        <p>Sign up or login here!</p>
      </div>

      <!-- Action left empty to prevent XSS. -->
      <div class="form-view__login u-margin-bottom-small">
        <form action='' method="POST">
          <input type="text" name="login_username" placeholder="Username or Email Address" /><br>
          <?php
            if(in_array("Wrong username!<br>", $error_array)) {
              echo "Wrong username!<br>";
            }
          ?>
          <input type="password" name="login_password" placeholder="Password" /><br>
          <?php 
            if(in_array("Wrong password!<br>", $error_array)) {
              echo "Wrong password!<br>";
            }
          ?>
          <input type="submit" name="login_button" value="Submit">
          <br>
          <a href="#" id="register">Do not have an account yet? Sign up by clicking me!</a>
        </form>
      </div>

      <div class="form-view__register u-margin-bottom-small">
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
          <?php if(in_array("Username is already in use!", $error_array)) echo "Username is already in use!<br>"; ?>

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

          <select name="gender" required> 
            <option value="M">Male</option>
            <option value="F">Female</option>
          </select><br>
          
          <input type="submit" name="register_button" value="Submit">
          <?php if(in_array("<span>You're registered! Please login!</span><br>", $error_array)) echo "<span>You're registered! Please login!</span><br>"; ?>
          <br>
          <a href="#" id="login">Already have an account? Click me to login!</a>
        </form> 
      </div>
  
    </main>
  
  </body>
</html>