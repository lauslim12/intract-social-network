<?php 
  include 'templates/header.php';
  include 'src/classes/User.php';

  if(isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' ");
    $user = mysqli_fetch_array($user_details_query);
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="shortcut icon" type="image/png" href="assets/images/icons/favicon.png">

  <title>Intract x Bordeaux &mdash; Your Reviews</title>
</head>

<body>
  <div class="container">
    <header class="header">
      <img src="assets/images/icons/logo.png" alt="Trillo logo" class="logo">

      <form action="search.php" class="search" name="search_form">
        <input type="text" class="search__input" name="q" autocomplete="off" placeholder="Search other reviewers..">
        <button class="search__button">
          <svg class="search__icon">
            <use xlink:href="assets/images/svg/sprite.svg#icon-magnifying-glass"></use>
          </svg>
        </button>
      </form>

      <nav class="user-nav">
        <div class="user-nav__icon-box">
          <svg class="user-nav__icon">
            <use xlink:href="assets/images/svg/sprite.svg#icon-bookmark"></use>
          </svg>
          <span class="user-nav__notification">5</span>
        </div>

        <div class="user-nav__icon-box">
          <svg class="user-nav__icon">
            <use xlink:href="assets/images/svg/sprite.svg#icon-chat"></use>
          </svg>
          <span class="user-nav__notification">10</span>
        </div>

        <div class="user-nav__user">
          <img src="<?php echo $user['profile_pic']; ?>" alt="User photo" class="user-nav__user-photo">
          <span class="user-nav__user-name"><?php echo $user_logged_in; ?></span>
        </div>
      </nav>
    </header>

    <div class="content">
      <nav class="sidebar">
        <ul class="side-nav">
          <li class="side-nav__item side-nav__item">
            <a href="index.php" class="side-nav__link">
              <svg class="side-nav__icon">
                <use xlink:href="assets/images/svg/sprite.svg#icon-home"></use>
              </svg>
              <span>Hotel</span>
            </a>
          </li>

          <li class="side-nav__item side-nav__item--active">
            <a href="#" class="side-nav__link">
              <svg class="side-nav__icon">
                <use xlink:href="assets/images/svg/sprite.svg#icon-aircraft-take-off"></use>
              </svg>
              <span>Profile</span>
            </a>
          </li>
        </ul>

        <div class="legal">
          &copy; 2020 by Intract and Bordeaux. All Rights Reserved.
        </div>
      </nav>

      <main class="hotel-view">
        <div class="search-detail detail">
          <div class="description">
            <h2>PROFILE</h2>
            <img src="<?php echo $user['profile_pic']; ?>" alt="" style="float:left; margin-right: 3rem;">
            <p class="paragraph">
              <?php echo $user['first_name'] . " " . $user['last_name'] . "<br>"; ?>
              <?php echo "Posts: " . $user['num_posts'] . "<br>"; ?>
              <?php echo "Likes: " . $user['num_likes'] . "<br>"; ?>
            </p>

            <a href="index.php">Return to Home</a><br><br><br><br>

            <?php
              if($user['username'] == $user_logged_in) {
                echo "
                <form action='src/controllers/handlers/change_profile_picture.php' method='POST' enctype='multipart/form-data'>
                  Select image to upload:<br>
                  <input type='hidden' name='username' value=$user_logged_in readonly/>
                  <input type='file' name='fileToUpload' id='fileToUpload'><br>
                  <input type='submit' value='Upload Image' name='submit'>
              </form>
                ";
              }

            ?>



          </div>
        </div>
      </main>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="assets/js/search.js"></script>

</body>

</html>