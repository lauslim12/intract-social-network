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