<?php
  // Error Array
  $error_array = [];

  /*  Registration form handling.
  *   Strip any HTML tags that might be in the way.
  *   Replace any spaces with no space.
  *   Capitalize some of the variables's first character.
  *   Email comparision, password comparision, and hashing.
  *   Closing the database object connection at the final line (not needed anymore).
  */

  if(isset($_POST['register_button'])) {
    $fname = strip_tags($_POST['fname']);
    $fname = str_replace(' ', '', $fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['fname'] = $fname;

    $lname = strip_tags($_POST['lname']);
    $lname = str_replace(' ', '', $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['lname'] = $lname;

    $username = strip_tags($_POST['username']);
    $username = str_replace(' ', '', $username);
    $username = strtolower($username);

    $email = strip_tags($_POST['email']);
    $email = str_replace(' ', '', $email);
    $email = strtolower($email);
    $_SESSION['email'] = $email;

    $email2 = strip_tags($_POST['email2']);
    $email2 = str_replace(' ', '', $email2);
    $email2 = strtolower($email2);

    $password = strip_tags($_POST['password']);
    $password = str_replace(' ', '', $password);

    $password2 = strip_tags($_POST['password2']);
    $password2 = str_replace(' ', '', $password);

    $signup_date = date("Y-m-d");

    $birthday = date('Y-m-d', strtotime($_POST['birthdate']));

    $gender = $_POST['gender'];

    // Compare username from usernames at the database.
    if($username_checker = $db->prepare("SELECT username FROM users WHERE username = ?")) {
      $username_checker->bind_param("s", $username);
      $username_checker->execute();
      $username_checker->store_result();
      $num_rows = $username_checker->num_rows();

      if($num_rows > 0) {
        array_push($error_array, "Username is already in use!");
      }

      $username_checker->free_result();
      $username_checker->close();
      $db->close();
    }
    else {
      array_push($error_array, "Something is happening. Please retry!");
    }

    // Compare email from the emails at the database.
    if($email == $email2) {
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if($email_checker = $db->prepare("SELECT email FROM users WHERE email = ?")) {
          $email_checker->bind_param("s", $email);
          $email_checker->execute();
          $email_checker->store_result();
          $num_rows = $email_checker->num_rows();
        }
        else {
          array_push($error_array, "Something is happening. Please retry logging in!<br>");
        }

        if($num_rows > 0) {
          array_push($error_array, "Email already in use!<br>");
        }

        // Always close the statement to prevent memory leaks.
        $email_checker->free_result();
        $email_checker->close();
      }
      else {
        array_push($error_array, "Invalid email format!<br>");
      }
    } 
    else {
      array_push($error_array, "Emails do not match!<br>");
    }
    
    if(strlen($fname) > 25 || strlen($fname) < 2) {
      array_push($error_array, "Your first name has to be between 2 to 25 characters!<br>");
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
      array_push($error_array, "Your last name has to be between 2 to 25 characters!<br>");
    }

    if($password != $password2) {
      array_push($error_array, "Your password do not match!<br>");
    }

    /*  Next up, inserting into the database.
    *   This is to secure the password with PHP's native BCRYPT Algorithm.
    *   It is not recommended to make your own salt. The course's module is outdated. Don't follow it.
    *   BCRYPT Algorithm will automatically create its salt.
    *   Don't change this unless you have a degree in cryptography.
    *   Plus, if the error array is empty, then insert the data into the database.
    */
    if(empty($error_array)) {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $initial_number = 0;
      $initial_user_closed = 'no';
      $initial_user_friends = ',';
      
      // Gives user a random profile picture.
      $rand = rand(1, 2);
      
      if($rand == 1) {
        $profile_picture = "assets/images/profile_pics/defaults/head_emerald.png";
      }
      else if($rand == 2) {
        $profile_picture = "assets/images/profile_pics/defaults/head_alizarin.png";
      }

      if($stmt = $db->prepare("INSERT INTO users (first_name, last_name, username, email, password, birthday, 
                              gender, signup_date, profile_pic, num_posts, num_likes, user_closed, friend_array)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
        $stmt->bind_param("sssssssssiiss", 
                        $fname, $lname, $username, $email, $password, $birthday, $gender, $signup_date,
                        $profile_picture, $initial_number, $initial_number, $initial_user_closed, $initial_user_friends);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
        
        array_push($error_array, "<span>You're registered! Please login!</span><br>");

        // Clear session. Set the Session array to null, the destroy.
        $_SESSION = [];
        session_destroy();
      }
      else {
        echo "An error occured. Please retry submitting the form again!";
      }
    }

    $db->close();
  }
?>