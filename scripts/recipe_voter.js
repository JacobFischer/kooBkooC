function recipe_ajax_vote( dir, id ) {
  $.ajax({
    url: base_url + "index.php/vote/" + dir + "/"+ id,
    context:document.body,
    success:function(data){
      var obj = jQuery.parseJSON(data);
      if(obj.success) {
        // remove all the classes from the button and total
        $("#recipe-voter-" + obj.recipeID + " button.recipe-up-vote").removeClass("voted-up");
        $("#recipe-voter-" + obj.recipeID + " span.recipe-total").removeClass("voted-up");
        $("#recipe-voter-" + obj.recipeID + " span.recipe-total").removeClass("voted-down");
        $("#recipe-voter-" + obj.recipeID + " button.recipe-down-vote").removeClass("voted-down");
        
        if(obj.direction == "up") {
          $("#recipe-voter-" + obj.recipeID + " button.recipe-up-vote").addClass( "voted-up" );
          $("#recipe-voter-" + obj.recipeID + " span.recipe-total").addClass( "voted-up" );
          $("#recipe-voter-" + obj.recipeID + " span.recipe-total").html( obj.total );
        }
        else if(obj.direction == "down") {
          $("#recipe-voter-" + obj.recipeID + " button.recipe-down-vote").addClass( "voted-down" );
          $("#recipe-voter-" + obj.recipeID + " span.recipe-total").addClass( "voted-down" );
          $("#recipe-voter-" + obj.recipeID + " span.recipe-total").html( obj.total );
        }
      }
      else{
        alert(obj.reason);
      }
    }
  });
}

$(document).ready(function() {
  $(".recipe-up-vote").click(function() {
    recipe_ajax_vote( "up", $(this).children('span').html() );
  });
  
  $(".recipe-down-vote").click(function() {
    recipe_ajax_vote( "down", $(this).children('span').html() ); 
  });
});