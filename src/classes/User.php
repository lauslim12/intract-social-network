<?php
class User {
  private $user;
  private $db;

  public function __construct($db, $user) {
    $this->db = $db;
    $user_details_query = mysqli_query($db, "SELECT * FROM users WHERE username = '$user'");
    $this->user = mysqli_fetch_array($user_details_query);
  }

  public function get_username() {
    return $this->user['username'];
  }

  public function get_full_name() {
    $username = $this->user['first_name'] . " " . $this->user['last_name'];
    return $username;
  }

  public function get_num_posts() {
    $username = $this->user['username'];
    $query = mysqli_query($this->db, "SELECT num_posts FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['num_posts'];
  }

}

?>