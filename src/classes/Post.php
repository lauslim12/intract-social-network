<?php
class Post {
  private $user_object;
  private $db;

  public function __construct($db, $user) {
    $this->db = $db;
    $this->user_object = new User($db, $user);
  }

  public function submit_post($body, $user_to) {
    $body = strip_tags($body);
    $body = mysqli_real_escape_string($this->db, $body);

    // Allow line breaks.
    $body = str_replace('\r\n', '\n', $body);
    $body = nl2br($body);

    $check_empty = preg_replace('/\s+/', '', $body);

    if($check_empty != "") {
      $date_added = date("Y-m-d H:i:s");
      $added_by = $this->user_object->get_username();

      // If user is not on own profile, user_to is set to none.
      if($user_to == $added_by) {
        $user_to = 'none';
      }

      // Insert post.
      $query = mysqli_query($this->db, "INSERT INTO posts VALUES ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')" );
      $returned_id = mysqli_insert_id($this->db);

      // Insert notification.

      // Update post count.
      $num_posts = $this->user_object->get_num_posts();
      $num_posts++;
      $update_query = mysqli_query($this->db, "UPDATE users SET num_posts = '$num_posts' WHERE username = '$added_by'");
    }
  }

  public function load_posts_friends($data, $limit) {
    $page = $data['page'];
    $user_logged_in = $this->user_object->get_username();

    if($page == 1) {
      $start = 0;
    }
    else {
      $start = ($page - 1) * $limit;
    }

    // Initialize $str to prevent errors, because it is returned at the end of the loop.
    $str = "";
    $data_query = mysqli_query($this->db, "SELECT * FROM posts WHERE deleted = 'no' ORDER BY id DESC");

    if(mysqli_num_rows($data_query) > 0) {
      $num_iterations = 0; // Number of results checked, not necessarily posted.
      $count = 1;

      while($row = mysqli_fetch_array($data_query)) {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];

        // Prepare the user_to object variable so it can be read even if not posted to the user.
        if($row['user_to'] == 'none') {
          $user_to = "";
        }
        else {
          $user_to_obj = new User($this->db, $row['user_to']);
          $user_to_name = $user_to_obj->get_full_name();
          $user_to = "<a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
        }

        // If the user account is closed.
        $added_by_obj = new User($this->db, $added_by);
        if($added_by_obj->is_closed()) {
          continue;
        }

        if($num_iterations++ < $start) {
          continue;
        }

        // Once ten posts have been loaded, break.
        if($count > $limit) {
          break;
        } 
        else {
          $count++;
        }

        $user_detail_query = mysqli_query($this->db, "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$added_by'");
        $user_row = mysqli_fetch_array($user_detail_query);
        $first_name = $user_row['first_name'];
        $last_name = $user_row['last_name'];
        $profile_pic = $user_row['profile_pic'];
        ?>

        <script>
          // Small function.
          function toggle<?php echo $id; ?>() {
            let target = $(event.target);

            if(!target.is("a")) {
              let element = document.getElementById("toggle_comment<?php echo $id; ?>");
              if(element.style.display == "block") {
                element.style.display = "none";
              }
              else {
                element.style.display = "block";
              }
            }
            
          }
        </script>

        <?php
        $comments_check = mysqli_query($this->db, "SELECT * FROM post_comments WHERE post_id = '$id'");
        $comments_number = mysqli_num_rows($comments_check);

        // Fetch time.
        $date_time_now = date("Y-m-d H:i:s");

        // Time of post current time and intervals.
        $start_date = new DateTime($date_time);
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

        // Concat the strings if more comes up with the loop.
        // Because the function is run in index.php, the path is displayed as is.
        $str .= 
          "<div class='status-post'>
            <div class='status-post__profile-pic'>
              <img src='$profile_pic' width='50'>
            </div>

            <div class='status-post__posted-by'>
              <a href='$added_by'>$first_name $last_name</a> $user_to
              <p class='paragraph'>$time_message</p>
            </div>
          </div>

          <div class='status-post__body'>
            <p class='paragraph'>$body</p>
          </div>

          <div class='status-post__comments' >
            <p onClick='javscript:toggle$id()'>Comments($comments_number)</p>
          </div>

          <div class='post_comment' id='toggle_comment$id' style='display: none;'>
            <iframe src='comment_frame.php?post_id=$id' id='comment_iframe'></iframe>
          </div>

          <hr>
          ";
      }

      if($count > $limit) {
        $str .= 
          "
            <input type='hidden' class='posts-area__next-post' value='" . ($page + 1) . "'>
              <input type='hidden' class='posts-area__final-post' value='false'>
          ";
      }
      else {
        $str .= 
          "
            <input type='hidden' class='posts-area__final-post' value='true'>
              <p class='paragraph'>No more posts!</p>
          ";
      }


    }

    echo $str;

  }

}

?>