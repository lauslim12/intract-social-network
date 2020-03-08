$(document).ready(function() {
  $('#search_text_input').focus(function() {
    if(window.matchMedia("(min-width: 800px)").matches) {
      $(this).animate({width: '25rem'}, 500);
    }
  });

  $('.search__button-holder').click(function() {
    $('.search_form').submit();
  });


});