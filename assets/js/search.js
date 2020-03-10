$(document).ready(function() {
  $('.search__button').click(function() {
    $('.search_form').submit();
  });


});

function get_live_search_users(value, user) {
  
  $.post("src/controllers/handlers/ajax_search.php", {query: value, user_logged_in: user}, function(data) {
    
    if($(".search__results--footer-empty")[0]) {
      $(".search__results--footer-empty").toggleClass("search__results--footer");
      $(".search__results--footer-empty").toggleClass("search__results--footer-empty");
    }

    $(".search__results").html(data);

    if(data = '') {
      $(".search__results--footer").html('');
      $(".search__results--footer").toggleClass("search__results--footer");
      $(".search__results--footer").toggleClass("search__results--footer-empty");
    }

    $(".search__results").css("position", "fixed");
    $(".search__results").css("z-index", "100");
    $(".search__results--footer").html("<a href='search.php?q=" + value + "'>See All Results!</a>");

  });

}