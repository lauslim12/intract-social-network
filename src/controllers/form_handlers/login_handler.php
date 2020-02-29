<?php
  if(isset($_POST['login_button'])) {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];
    
    // People is able to login simply with username or email address.
    if($stmt = $db->prepare("SELECT password FROM users WHERE username = ? OR email = ? LIMIT 1")) {
      $stmt->bind_param("ss", $username, $username);
      $stmt->execute();
      $stmt->store_result();
      $num_of_cols = $stmt->num_rows();

      if($num_of_cols == 1) {
        $stmt->bind_result($col);
        $stmt->fetch();
        $hash = $col;
      }
      else {
        array_push($error_array, "Wrong username!<br>");
        $hash = 0;
      }
      $stmt->free_result();
      $stmt->close();
    }

    // If the user has closed / logged out, then logging in will set the user_closed variable to no.
    $set_user_logged_in = 'no';
    if($stmt = $db->prepare("UPDATE users SET user_closed = ? WHERE username = ? OR email = ?")) {
      $stmt->bind_param("sss", $set_user_logged_in, $username, $username);
      $stmt->execute();
      $stmt->free_result();
      $stmt->close();
      $db->close();
    }

    // BCRPYT Hash.
    if(password_verify($password, $hash)) {
      $_SESSION['username'] = $username;
      $_SESSION['logged_in'] = TRUE;
      header("location:index.php");
      exit();
    }
    else {
      array_push($error_array, "Wrong password!<br>");
    }
  }
?>