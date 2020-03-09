<?php
  include '../../../config/config.php';
  include '../../classes/User.php';

  $query = $_POST['query'];
  $user_logged_in = $_POST['user_logged_in'];

  $names = explode(" ", $query);
  
  // If user types an underscore, assume that the user is searching for any kind of username.
  if(strpos($query, '_') !== false) {
    $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed = 'no' LIMIT 5");
  }

  // Two words, assume user search for first and last name.
  else if(count($names) == 2) {
    $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed = 'no' LIMIT 5");
  }

  // If only one word, search both first name and last name.
  else {
    $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed = 'no' LIMIT 5");
  }

  if($user_return_query != '') {
    while($row = mysqli_fetch_array($user_return_query)) {
      $user = new User($db, $user_logged_in);
      $full_name = $row['first_name'] . " " . $row['last_name'];

      echo "
        <div class='search__results--display'>
          <a href='" . $row['username'] . "'>
            <div class='search__results--profile-picture'>
              <img src='" . $row['profile_pic'] . "'>
            </div>

            <div class='search__results--text'>
              " . $full_name . "
              <p>" . $row['username'] . "</p> 
            </div>
          </a>
        </div>
      ";

    }

  }

?>