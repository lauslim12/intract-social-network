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

  public function load_posts_friends() {
    // Initialize $str to prevent errors, because it is returned at the end of the loop.
    $str = "";
    $data = mysqli_query($this->db, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

    while($row = mysqli_fetch_array($data)) {
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

      $user_detail_query = mysqli_query($this->db, "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$added_by'");
      $user_row = mysqli_fetch_array($user_detail_query);
      $first_name = $user_row['first_name'];
      $last_name = $user_row['last_name'];
      $profile_pic = $user_row['profile_pic'];

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
      $str .= 
        "<div class='status-post'>
          <div class='status-post__profile-pic'>
            <img src='$profile_pic' width='50'>
          </div>

          <div class='status-post__posted-by'>
            <a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp; $time_message
          </div>

          <div class='status-post__body'>
            <p>$body</p>
          </div>

        </div>
        <hr>
        ";
    }

    echo $str;

  }

}

?>