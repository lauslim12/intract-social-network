<?php
  include 'templates/header.php';
  include 'src/classes/User.php';
  include 'src/classes/Post.php';

  if(isset($_POST['post'])) {
    $post = new Post($db, $user_logged_in);
    $post->submit_post($_POST['post_text'], 'none');
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
                    <div class="gallery">
                        <figure class="gallery__item">
                            <img src="assets/images/photos/hotel-1.jpg" alt="Photo 1" class="gallery__photo">
                        </figure>

                        <figure class="gallery__item">
                            <img src="assets/images/photos/hotel-2.jpg" alt="Photo 2" class="gallery__photo">
                        </figure>

                        <figure class="gallery__item">
                            <img src="assets/images/photos/hotel-3.jpg" alt="Photo 3" class="gallery__photo">
                        </figure>
                    </div>

                    <div class="overview">
                        <h1 class="overview__heading">Bordeaux Le Grand Hôtel</h1>
                        <div class="overview__stars">
                            <svg class="overview__icon-star">
                                <use xlink:href="assets/images/svg/sprite.svg#icon-star"></use>
                            </svg>
                            <svg class="overview__icon-star">
                                <use xlink:href="assets/images/svg/sprite.svg#icon-star"></use>
                            </svg>
                            <svg class="overview__icon-star">
                                <use xlink:href="assets/images/svg/sprite.svg#icon-star"></use>
                            </svg>
                            <svg class="overview__icon-star">
                                <use xlink:href="assets/images/svg/sprite.svg#icon-star"></use>
                            </svg>
                            <svg class="overview__icon-star">
                                <use xlink:href="assets/images/svg/sprite.svg#icon-star"></use>
                            </svg>
                        </div>

                        <div class="overview__location">
                            <svg class="overview__icon-location">
                                <use xlink:href="assets/images/svg/sprite.svg#icon-location-pin"></use>
                            </svg>
                            <button class="btn-inline">Bordeaux, France</button>
                        </div>
                            
                        <div class="overview__rating">
                            <div class="overview__rating-average">4.5</div>
                            <div class="overview__rating-count">888 votes</div>
                        </div>
                    </div>

                    <div class="detail">
                        <div class="description">
                        
                            <p class="paragraph">
                                An unforgettable journey in the spirit of time in the beating heart of an historic heaven.
                                From fine cuisine to the moments of relaxation offered by the Spa Guerlain, offer yourself some exceptional moments.
                                Our services work in unison in order to provide you the best quality of reception all along your stay, 24/7.
                            </p>
                            <p class="paragraph">
                                InterContinental Bordeaux – Le Grand Hotel is one of the best luxury hotels located in Bordeaux, the magnificent wine region of France. 
                                Book now!
                            </p>

                            <ul class="list">
                                <li class="list__item">Close to the beach</li>
                                <li class="list__item">Breakfast included</li>
                                <li class="list__item">Free airport shuttle</li>
                                <li class="list__item">Free wifi in all rooms</li>
                                <li class="list__item">Close to the museum of France!</li>
                                <li class="list__item">Luxurious hotel</li>
                                <li class="list__item">Comfortable bed</li>
                                <li class="list__item">Ancient style, modern services</li>
                            </ul>

                            <div class="recommend">
                                <p class="paragraph__count">
                                    Nicholas and 5 other friends recommend this place!
                                </p>
                                <div class="recommend__friends">
                                    <img src="assets/images/photos/user-3.jpg" alt="Friend 3" class="recommend__photo">
                                    <img src="assets/images/photos/user-4.jpg" alt="Friend 4" class="recommend__photo">
                                    <img src="assets/images/photos/user-5.jpg" alt="Friend 5" class="recommend__photo">
                                    <img src="assets/images/photos/user-6.jpg" alt="Friend 6" class="recommend__photo">
                                </div>
                            </div>
                        </div>

                        <div class="user-reviews">
                            <figure class="review">
                                <blockquote class="review__text">
                                    During a trip to France this summer, I spent my last night at the InterContinental Bordeaux Le Grand Hôtel. 
                                    I’d actually stayed there several years before when it was part of Regent Hotels, but was eager to stay again now that it’s part of IHG.
                                </blockquote>   
                                <figcaption class="review__user">
                                    <img src="assets/images/photos/user-1.jpg" alt="Photo of reviewer 1" class="review__photo">
                                    <div class="review__user-box">
                                        <p class="review__user-name">Nicholas Dwiarto</p>
                                        <p class="review__user-date">Dec 31st, 2019</p>
                                    </div>
                                    <div class="review__rating">4.5</div>
                                </figcaption>
                            </figure>

                            <figure class="review">
                                <blockquote class="review__text">
                                    Our view overlooked one of the hotel’s central courtyards, which was nice and quiet, and the windows actually opened, so we could enjoy some fresh air.
                                </blockquote>   
                                <figcaption class="review__user">
                                    <img src="assets/images/photos/user-2.jpg" alt="Photo of reviewer 2" class="review__photo">
                                    <div class="review__user-box">
                                        <p class="review__user-name">Marie Julis-Alexia</p>
                                        <p class="review__user-date">Jan 1st, 2020</p>
                                    </div>
                                    <div class="review__rating">4.75</div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="detail">
                        <div class="description--posts">
                            <h2>REVIEWS</h2>
                            <form action='' method="POST">
                                <textarea name="post_text" id="post_text" rows="5" placeholder="A penny for your thoughts?"></textarea>
                                <input type="submit" value="Post" name="post" id="post_button" class="btn-inline">
                            </form>

                            <div class="posts-area">
                                <!-- Placeholder Div -->
                            </div>

                            <img class="posts-area--loading" src="assets/images/icons/loading.gif" alt="Loading Icon">
                    
                        </div>
                        
                    </div>

                    <?php
                        include 'templates/footer.php';
                    ?>
                </main>

            </div>
        </div>

        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
        <script src="assets/js/search.js"></script>
        <script src="assets/js/ajax_js_load_posts.js"></script>

    </body>
</html>