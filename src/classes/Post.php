<?php
class Post {
  public $user_object;
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

}

?>