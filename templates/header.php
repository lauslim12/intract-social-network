<?php
  require 'config/config.php';

  if(isset($_SESSION['username'], $_SESSION['logged_in'])) {
    $user_logged_in = $_SESSION['username'];
    $authentication = $_SESSION['logged_in'];
  }
  else {
    header("location: landing.php");
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Intract</title>
  </head>
  <body>