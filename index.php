<?php
  include 'templates/header.php';
  include 'src/classes/User.php';
  include 'src/classes/Post.php';

  if(isset($_POST['post'])) {
    $post = new Post($db, $user_logged_in);
    $post->submit_post($_POST['post_text'], 'none');
    header("location: index.php");
  }

?>
  
  <div class="user-details">
    <div class="user-details__profile">
      <img src=<?php echo $user['profile_pic'] ?> alt="Profile Picture">
      <a href=<?php echo $user_logged_in ?>><?php echo $user['first_name'] . " " . $user['last_name'] ?></a>
      <p><?php echo "Posts: " . $user['num_posts'] ?></p>
      <p><?php echo "Likes: " . $user['num_likes'] ?></p>
    </div>

    <div class="user-details__wall">
      <form action='' method="POST" class="user-details--form">
        <textarea name="post_text" id="post_text" rows="5" cols="100" placeholder="A penny for your thoughts?"></textarea>
        <input type="submit" value="Post" name="post" id="post_button">
      </form>

      <br>

      <div class="user-details__posts-area">
        <!-- Placeholder div for placing the posts. -->
      </div>
      <img class="user-details--loading" src="assets/images/icons/loading.gif" alt="Loading Icon">

    </div>

    <script src="assets/js/search.js"></script>
    <script src="assets/js/ajax_js_load_posts.js"></script>

  </div>
  
  </body>
</html>