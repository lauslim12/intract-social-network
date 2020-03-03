<?php
  require 'config/config.php';

  if(isset($_SESSION['username'], $_SESSION['logged_in'])) {
    $user_logged_in = $_SESSION['username'];
    $authentication = $_SESSION['logged_in'];
    
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    if($stmt = $db->prepare($sql)) {
      $stmt->bind_param("s", $user_logged_in);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_array();
      $stmt->free_result();
      $stmt->close();
    }
  }
  else {
    header("location: landing.php");
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Intract</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
          crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
        crossorigin="anonymous"></script>

  </head>
  <body>
    <nav class="navbar navbar-expand-lg navigation">
      <div class="navigation__logo">
        <a class="navigation__logo--link" href="index.php">Intract!</a>
      </div>

      <ul class="navbar-nav ml-auto">
        <li ckass="nav-item"><?php echo $user['first_name'] ?></li>
        <li class="nav-item">Profile</li>
        <li class="nav-item">Messages</li>
        <li class="nav-item">Settings</li>
      </ul>
      
    </nav>