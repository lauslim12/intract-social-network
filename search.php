<?php
    include 'templates/header.php';
    include 'src/classes/User.php';

    $query = $_GET['q'];

    if($_GET['q'] == NULL) {
        header("location: index.php");
    }
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

                        // If only one word, search both first name and last name AND the username.
                        if (count($names) == 1) {
                            $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') OR username LIKE '$query%' AND user_closed = 'no' LIMIT 5");
                        }

                        // Two words, assume user search for first and last name.
                        else if (count($names) == 2) {
                            $user_return_query = mysqli_query($db, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed = 'no' LIMIT 5");
                        }

                        // If 0 query, then return and don't do anything.
                        else {
                            return;
                        }

                        $num_rows = mysqli_num_rows($user_return_query);

                        if($num_rows == 0 || strpos($_SERVER['REQUEST_URI'], '+') != false) {
                            echo "<p class='paragraph--center'>No users found!</p>";
                            return;
                        }

                        if($user_return_query != '') {
                            while ($row = mysqli_fetch_array($user_return_query)) {
                                $user = new User($db, $user_logged_in);
                                $full_name = $row['first_name'] . " " . $row['last_name'];

                                echo "
                                    <div class='search-results__display'>

                                        <div class='search-results__profile-picture'>
                                            <a href='" . $row['username'] . "'>
                                                <img src='" . $row['profile_pic'] . "'>
                                            </a>
                                        </div>
                            
                                        <div class='search-results__text'>
                                          <p class='paragraph'>" . $full_name . " (" . $row['username'] . ")" . "</p> 
                                        </div>

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