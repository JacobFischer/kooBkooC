$(document).ready(function(){
  $("#testButton").click(function(){
    $.ajax({
      url: base_url + "index.php/search/ingredients/" + $("#search").val(),
      context: document.body,
      success: function(data){
        var obj = jQuery.parseJSON(data);
        $("#testDiv").html('<p>Ingredients:</p><ul id="ingredient-list">');
        for(i in obj.ingredients){
          $("#testDiv").append('<li class="ingredient-matching"><span class="ingredient-name">' + obj.ingredients[i].Name + '</span><span class="ingredient-id" style="display: none;">' + obj.ingredients[i].ID+ '</span></li>');
        }
        $("#testDiv").append('</ul>');
        $("li.ingredient-matching").on("click", function(){
          $("ul#searchList").append('<li class="ingredient-using">' + $(this).html() + '</li>');
        });
      }
    });
  })
  $("#searchButton").click(function(){
    var url_string = base_url + "index.php/search/reverse?";
    $('ul#searchList').each(function(){
      $(this).find('li.ingredient-using span.ingredient-id').each(function(){
        url_string = url_string + "ingredients[]=" + $(this).text() + "&";
      });
    });
    $.ajax({
      url: url_string,
      context: document.body,
      success: function(data){
        var obj = jQuery.parseJSON(data);       
        $("#searchResult").html('<p>Recipes:</p><ul id="recipe-list">');
        for(i in obj.recipe){
          $("#searchResult").append('<li class="recipe-matching"> <a href="' + base_url + 'index.php/recipe/id/' + obj.recipe[i].ID + '">' + obj.recipe[i].Name + '</a> - ' + obj.recipe[i].Description + '</li>');
        } 
        $("#searchResult").append('</ul>');          
      }
    });
  })
});








