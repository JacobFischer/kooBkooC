/*$(document).ready(function(){
  $("#guesser").click(function() {
    $.ajax
    (
      {
        url: base_url+"index.php/search/ingredients/"+$("#ingredients-name").val(),
        context: document.body,
        success: function(data)
        {
          
          var obj = jQuery.parseJSON(data);
          $("#testDiv").html('<p>Ingredients:</p><ul id="ingredient-list">');
          for(i in obj.ingredients){
          $("#testDiv").append('<li><a href="'+base_url+'index.php/ingredients/id/'+obj.ingredients[i].ID+'">' + obj.ingredients[i].Name + '</a></li>');
          }
        }
      }
    );
  });
  
  $("#guesser-tag").click(function() {
    $.ajax
    (
      {
        url: base_url+"index.php/search/tags/"+$("#tag-name").val(),
        context: document.body,
        success: function(data)
        {
          alert(data);
          var obj = jQuery.parseJSON(data);
          $("#testDiv").html('<p>Tags:</p><ul id="tag-list">');
          for(i in obj.tags){
          $("#testDiv").append('<li><a href="'+base_url+'index.php/tags/recipes/'+obj.tags[i].ID+'">' + obj.tags[i].Name + '</a></li>');
          }
        }
      }
    );
  });
});*/

function ajaxGuess( controller, q, parser ) {
  $.ajax ({
    url: base_url + "index.php/search/" + controller + "/" + q,
    context: document.body,
    success: function(data) {
      parser( jQuery.parseJSON(data) );
    }
  });
}