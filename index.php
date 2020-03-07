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
  
  <div class="user-details">
  
    <div class="user-details__profile">
      <img src=<?php echo $user['profile_pic'] ?> alt="Profile Picture">
      <a href=<?php echo $user_logged_in ?>><?php echo $user['first_name'] . " " . $user['last_name'] ?></a>
      <p><?php echo "Posts: " . $user['num_posts'] ?></p>
      <p><?php echo "Likes: " . $user['num_likes'] ?></p>
    </div>

    <div class="user-details__wall">
      <form action='' method="POST" class="user-details--form">
        <textarea name="post_text" id="post_text" rows="5" cols="100" placeholder="A penny for your thoughts?"></textarea>
        <input type="submit" value="Post" name="post" id="post_button">
      </form>

      <br>

      <div class="user-details__posts-area">
        <!-- Placeholder div for placing the posts. -->
      </div>
      <img class="user-details--loading" src="assets/images/icons/loading.gif" alt="Loading Icon">

    </div>

    <script>
      let user_logged_in = '<?php echo $user_logged_in ?>';

      $(document).ready(function() {
        $('.user-details--loading').show();

        // AJAX request for calling posts.
        $.ajax({
          url: 'src/controllers/handlers/ajax_php_load_posts.php',
          type: 'POST',
          data: 'page=1&user_logged_in=' + user_logged_in,
          cache: false,

          success: function(data) {
            $('.user-details--loading').hide();
            $('.user-details__posts-area').html(data);
          }

        });

        $(window).scroll(function() {
          // Container height containing the posts.
          let height = $('.user-details__posts-area').height();
          let scroll_top = $(this).scrollTop();
          let page = $('.user-details__posts-area').find('.user-details__posts-area__next-post').val();
          let final_post = $('.user-details__posts-area').find('.user-details__posts-area__final-post').val();

          if(($(window).scrollTop() + $(window).height() > $(document).height() - 25) && final_post == 'false') {
            $('.user-details--loading').show();

            let ajax_request = $.ajax({
              url: 'src/controllers/handlers/ajax_php_load_posts.php',
              type: "POST",
              data: "page=" + page + "&user_logged_in=" + user_logged_in,
              cache: false,

              success: function(response) {
                $('.user-details__posts-area').find('.user-details__posts-area__next-post').remove();
                $('.user-details__posts-area').find('.user-details__posts-area__final-post').remove();

                $('.user-details--loading').hide();
                $('.user-details__posts-area').append(response);
              }

            });
          } // End if.
          else {
            return false;
          }
        }); // End of window scroll function.

      });

    </script>

  </div>
  
  </body>
</html>