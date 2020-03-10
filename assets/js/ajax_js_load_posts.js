// AJAX loader.
let user_logged_in = '<?php echo $user_logged_in ?>';

$(document).ready(function() {
  $('.posts-area--loading').show();

  // AJAX request for calling posts.
  $.ajax({
    url: 'src/controllers/handlers/ajax_php_load_posts.php',
    type: 'POST',
    data: 'page=1&user_logged_in=' + user_logged_in,
    cache: false,

    success: function(data) {
      $('.posts-area--loading').hide();
      $('.posts-area').html(data);
    }

  });

  $(window).scroll(function() {
    // Container height containing the posts.
    let height = window.pageYOffset;
    let offset = $('.posts-area').offset().top;
    let page = $('.posts-area').find('.posts-area__next-post').val();
    let final_post = $('.posts-area').find('.posts-area__final-post').val();
    
    // We have to prevent the race condition, because scrollTop function can occur more than once!
    // This is called lock variable.
    let loading = false;

    async function load_more() {
      loading = true;
      $('.posts-area--loading').show();

      let ajax_request = $.ajax({
        url: 'src/controllers/handlers/ajax_php_load_posts.php',
        type: "POST",
        data: "page=" + page + "&user_logged_in=" + user_logged_in,
        cache: false,

        success: function(response) {
          $('.posts-area').find('.posts-area__next-post').remove();
          $('.posts-area').find('.posts-area__final-post').remove();

          $('.posts-area--loading').hide();
          $('.posts-area').append(response);
          $('.posts-area').removeClass("loaded");
          loading = false;
        }
      });
    }

    if((height > offset) && final_post == 'false' && loading == false) {
      if(!$('.posts-area').hasClass("loaded")) {
        $('.posts-area').addClass("loaded");
        load_more();
      }
    } // End if.
    else {
      return false;
    }
  }); // End of window scroll function.

});