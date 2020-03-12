<?php
include 'templates/header.php';
include 'src/classes/User.php';

$query = $_GET['q'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" type="image/png" href="assets/images/icons/favicon.png">

    <title>Intract x Bordeaux &mdash; Your Reviews</title>
</head>

<body>
    <div class="container">
        <?php
        include 'templates/navigation.php';
        ?>

        <div class="content">
            <?php
                include 'templates/sidebar.php';
            ?>

            <main class="hotel-view">

                <div class="search-detail detail">
                    <div class="description">
                        <?php
                        $names = explode(" ", $query);

                        // If user types an underscore, assume that the user is searching for any kind of username.
                        if (count($names) == 1) {
                            $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed = 'no' LIMIT 5");
                        }

                        // Two words, assume user search for first and last name.
                        else if (count($names) == 2) {
                            $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed = 'no' LIMIT 5");
                        }

                        // If only one word, search both first name and last name.
                        else {
                            $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed = 'no' LIMIT 5");
                        }

                        $num_rows = mysqli_num_rows($user_return_query);

                        if($num_rows == 0) {
                            echo "<p class='paragraph'>No users found!</p>";
                        }

                        if($user_return_query != '') {
                            while ($row = mysqli_fetch_array($user_return_query)) {
                                $user = new User($db, $user_logged_in);
                                $full_name = $row['first_name'] . " " . $row['last_name'];

                                echo "
                                    <div class='search__results--display'>
                                      <a href='" . $row['username'] . "'>
                                        <div class='search__results--profile-picture'>
                                          <img src='" . $row['profile_pic'] . "' style='float:left; margin-right: 3rem; max-width: 15rem; max-height: 15rem;'>
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

                    </div>

                </div>


            </main>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="assets/js/search.js"></script>

</body>

</html>