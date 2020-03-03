<?php
  include 'templates/header.php';
?>

  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <h2>User Profile</h2>
        <img src=<?php echo $user['profile_pic'] ?> alt="Profile Picture">
        <p><?php echo $user['first_name'] . " " . $user['last_name'] ?></p>
        <p><?php echo "Posts: " . $user['num_posts'] ?></p>
        <p><?php echo "Likes: " . $user['num_likes'] ?></p>
      </div>

      <div class="col-md-10">
        <h2>User Wall</h2>
      </div>


    </div>
  </div>
  
  </body>
</html>