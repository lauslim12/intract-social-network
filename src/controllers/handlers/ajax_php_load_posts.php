<?php
  include '../../../config/config.php';
  include '../../classes/User.php';
  include '../../classes/Post.php';

  // Number of posts to be loaded during a single request.
  $limit = 10;
  $posts = new Post($db, $_REQUEST['user_logged_in']);
  $posts->load_posts_friends($_REQUEST, $limit);

?>