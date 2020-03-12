<?php 
  include 'templates/header.php';
  include 'src/classes/User.php';

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
        <div class="search-detail detail">
          <div class="description">
            <h2>PROFILE</h2>
            <img src="<?php echo $user_search['profile_pic']; ?>" alt="" style="float:left; margin-right: 3rem; max-width: 15rem; max-height: 15rem;">
            <p class="paragraph">
              <?php echo $user_search['first_name'] . " " . $user_search['last_name'] . "<br>"; ?>
              <?php echo "Posts: " . $user_search['num_posts'] . "<br>"; ?>
              <?php echo "Likes: " . $user_search['num_likes'] . "<br>"; ?>
            </p>

            <a href="index.php">Return to Home</a><br><br><br><br>

            <?php
              if($user_search['username'] == $user_logged_in) {
                echo "
                <form action='src/controllers/handlers/change_profile_picture.php' method='POST' enctype='multipart/form-data'>
                  Change your profile picture here:<br>
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