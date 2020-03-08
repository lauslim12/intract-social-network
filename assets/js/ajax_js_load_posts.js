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
    
    // We have to prevent the race condition, because scrollTop function can occur more than once!
    // This is called lock variable.
    let loading = false;

    if(($(window).scrollTop() + $(window).height() > $(document).height() - 25) && final_post == 'false' && loading == false) {
      loading = true;
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
          loading = false;
        }
      });

    } // End if.
    else {
      return false;
    }
  }); // End of window scroll function.

});