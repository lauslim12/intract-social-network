<?php 
  include 'templates/header.php';
  include 'src/classes/User.php';
  include 'src/controllers/handlers/change_profile_picture.php';

  if(isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' ");
    $user_search = mysqli_fetch_array($user_details_query);
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
    <?php
      include 'templates/navigation.php';
    ?>

    <div class="content">
      <?php
        include 'templates/sidebar.php';
      ?>

      <main class="hotel-view">
        <div class="profile-detail detail">
          <div class="description">

            <div class="profile">
              <div class="profile__profile-picture">
                <img src="<?php echo $user_search['profile_pic']; ?>" alt="">
              </div>

              <div class="profile__content">
                <?php echo "<p class='paragraph--bold'>" . $user_search['first_name'] . " " . $user_search['last_name'] . "</p>"; ?>
                <?php echo "<p class='paragraph'>" . $user_search['birthday'] .  "</p>"; ?>
                  
                <div class="profile__text-gallery">
                  <?php echo "<p class='profile__text-gallery__text-par'>Posts " . $user_search['num_posts'] . "</p>"; ?>
                  <?php echo "<p class='profile__text-gallery__text-par'>Likes " . $user_search['num_likes'] . "</p>"; ?>
                  <p class='profile__text-gallery__text-par'>Friends 0</p>
                  <p class='profile__text-gallery__text-par'>Reputation 0</p>
                </div>
                <a href="index.php">Return to Home</a>
              </div>

            </div>


            <?php
              if($user_search['username'] == $user_logged_in) {
                echo "
                <div class='profile__change-picture'>
                  <form action='' method='POST' enctype='multipart/form-data'>
                    <p class='paragraph'>Change your profile picture here:</p>
                    <input type='hidden' name='username' value=$user_logged_in readonly/>
                    <input type='file' name='fileToUpload' id='fileToUpload'>
                    <input type='submit' value='Upload Image' name='submit' class='btn-inline'>
                    $error_message
                  </form>
                </div>
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