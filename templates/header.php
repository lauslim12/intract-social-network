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
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Intract &mdash; Your personalized social network</title>
    
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
    <nav class="navbar navbar-expand-lg navigation u-margin-bottom-medium">
      <div class="navigation__logo">
        <a class="navigation__logo--link" href="index.php">Intract!</a>
      </div>

      <div class="navigation__center">
        <form action="search.php" method="GET" class="search_form">
          <input class="search__results--button" type="text" onkeyup="get_live_search_users(this.value, '<?php echo $user_logged_in; ?>')" name="q" placeholder="Search users..." autocomplete="off" id="search_text_input">
          
          <div class="search__button-holder">
            <img src="assets/images/icons/search.png" alt="Search" />
          </div>

          <!-- Style later. -->
          <div class="search__results">
          
          </div>

          <div class="search__results--footer-empty">
          
          </div>

        </form>
      </div>

      <ul class="navigation__items">
        <p class="navigation__items--item">Hello, <?php echo $user['first_name'] ?>!</p>
        <li class="navigation__items--item">Profile</li>
        <li class="navigation__items--item">Messages</li>
        <li class="navigation__items--item">Settings</li>
        <li class="navigation__items--item"><a href="src/controllers/handlers/logout.php">Logout</a></li>
      </ul>
      
    </nav>