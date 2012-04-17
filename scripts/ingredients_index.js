$(document).ready(function() {
  $(".recipe-up-vote").click(function() {
    recipe_ajax_vote( "up", $(this).children('span').html() );
  });
  
  $(".recipe-down-vote").click(function() {
    recipe_ajax_vote( "down", $(this).children('span').html() ); 
  });
});