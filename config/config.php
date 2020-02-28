<?php
  // Turns on output buffer and session.
  ob_start();
  session_start();

  $timezone = date_default_timezone_set("Asia/Jakarta");

  // Connect to PHP Database.
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "intract";
  $db = new mysqli($host, $username, $password, $dbname);

  // Error handling and setting the database.
  if($db->connect_error) {
    die('Error connecting to the database!');
  }
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $db->set_charset('utf8mb4');
?>