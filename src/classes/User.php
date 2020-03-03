<?php
class User {
  private $user;
  private $db;

  public function __construct($db, $user) {
    $this->db = $db;
    
    if($stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?")) {
      $stmt->bind_param("s", $user);
      $stmt->execute();
      $row = $stmt->get_result();
      $this->user = $row->fetch_array();
      $stmt->free_result();
      $stmt->close();
    }
  }

  public function get_username() {
    return $this->user['username'];
  }

  public function get_full_name() {
    $username = $this->user['first_name'] . " " . $this->user['last_name'];
    return $username;
  }

  public function is_closed() {
    $username = $this->get_username();

    if($stmt = $this->db->prepare("SELECT user_closed FROM users WHERE username = ?")) {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $row = $stmt->get_result();
      $row = $row->fetch_array();
      $stmt->free_result();
      $stmt->close();
    }

    if($row['user_closed'] == 'yes') {
      return true;
    }
    else {
      return false;
    }
    
  }

  public function get_num_posts() {
    $username = $this->get_username();

    if($stmt = $this->db->prepare("SELECT num_posts FROM users WHERE username = ?")) {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $row = $stmt->get_result();
      $row = $row->fetch_array();
      $stmt->free_result();
      $stmt->close();
    }

    return $row['num_posts'];
  }

}

?>