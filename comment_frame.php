<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
    <?php
      require 'config/config.php';
      include 'src/classes/User.php';
      include 'src/classes/Post.php';

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

    <script>
      function toggle() {
        let element = document.getElementById("comment-section");

        if(element.style.display == "block") {
          element.style.display = "none";
        }
        else {
          element.style.display = "block";
        }
      }
    </script>

    <?php
      // Get ID of posts.
      if(isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
      }

      $user_query = mysqli_query($db, "SELECT added_by, user_to FROM posts WHERE id = '$post_id'");
      $row = mysqli_fetch_array($user_query);
      $posted_to = $row['added_by'];

      if(isset($_POST['post_comment' . $post_id])) {
        $post_body = $_POST['post_body'];
        $post_body = mysqli_escape_string($db, $post_body);
        $date_time_now = date("Y-m-d H:i:s");
        $insert_post = mysqli_query($db, "INSERT INTO post_comments VALUES('', '$post_body', '$user_logged_in', '$posted_to', '$date_time_now', 'no', '$post_id')");
        echo "<p>Comment has been posted!</p>";
      }


    ?>

    <form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="post_comment<?php echo $post_id; ?>" method="POST">
      <textarea name="post_body" cols="50" rows="5" placeholder="Write your comment..."></textarea>
      <input type="submit" name="post_comment<?php echo $post_id; ?>" value="Post">
    </form>

    <!-- Loading comments -->
    <?php
      $get_comments = mysqli_query($db, "SELECT * FROM post_comments WHERE post_id = '$post_id' ORDER BY id ASC");
      $num_rows = mysqli_num_rows($get_comments);
      
      if($num_rows != 0) {
        while($comment = mysqli_fetch_array($get_comments)) {
          $comment_body = $comment['post_body'];
          $posted_to = $comment['posted_to'];
          $posted_by = $comment['posted_by'];
          $date_added = $comment['date_added'];
          $removed = $comment['removed'];

          // This piece of code is taken from Post.php (timeline).
          $time_message = '';
          // Fetch time.
          $date_time_now = date("Y-m-d H:i:s");

          // Time of post current time and intervals.
          $start_date = new DateTime($date_added);
          $end_date = new DateTime($date_time_now);
          $interval = $start_date->diff($end_date);

          if($interval->y >= 1) {
            if($interval == 1) {
              $time_message = $interval->y . " a year ago";
            }
            else {
              $time_message = $interval->y . " years ago";
            }
          }
          else if($interval->m >= 1) {
            if($interval->d == 0) {
              $days = " ago";
            }
            else if($interval->d == 1) {
              $days = $interval->d . " day ago";
            }
            else {
              $days = $interval->d . " days ago";
            }

            if($interval->m == 1) {
              $time_message = $interval->m . " month" . $days;
            }
            else {
              $time_message = $interval->m . " months" . $days;
            }
      
          }
          else if($interval->d >= 1) {
            if($interval->d == 1) {
              $time_message = "Yesterday";
            }
            else {
              $time_message = $interval->d . " days ago";
            }
          }
          else if($interval->h >= 1) {
            if($interval->h == 1) {
              $time_message = $interval->h . " hour ago";
            }
            else {
              $time_message = $interval->h . " hours ago";
            }
          }
          else if($interval->i >= 1) {
            if($interval->i == 1) {
              $time_message = $interval->i . " minute ago";
            }
            else {
              $time_message = $interval->i . " minutes ago";
            }
          }
          else {
            if($interval->s < 30) {
              $time_message = "Just now";
            }
            else {
              $time_message = $interval->s . " seconds ago";
            }
          }

          $user_object = new User($db, $posted_by);
          // Break the PHP tags and continue with comment section by every iteration.
    ?>

          <div class="comment-section">
            <a href="<?php echo $posted_by; ?>" target="_parent"><img src="<?php echo $user_object->get_profile_picture(); ?>" alt="Profile Picture" title="<?php echo $posted_by; ?>" style="float: left; margin-right: 2rem;" height="30"></a>
            <a href="<?php echo $posted_by; ?>" target="_parent"><b><?php echo $user_object->get_full_name(); ?></b></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $time_message . "<br>" . $comment_body; ?>
            <hr>
          </div>

    <?php

        }
        
      }
      
    ?>




  </body>
</html>
