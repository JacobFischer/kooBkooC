$(document).ready(function() {
  $("#recipe-up-vote").click(function() {
    alert("up");
    recipe_ajax_vote( "up", $(this).children('span')[0].val() );
  });
  
  $("#recipe-down-vote").click(function() {
    recipe_ajax_vote( "down", $(this).children('span')[0].val() ); 
  });
});