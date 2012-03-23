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
    alert(url_string);
    $.ajax({
      url: url_string,
      context: document.body,
      success: function(data){
        var obj = jQuery.parseJSON(data); 
        alert("Got here");
        $("#searchResult").html('<p>Recipes:</p><ul id="recipe-list">');
        for(i in obj.recipes){
          $("#searchResult").append('<li class="recipe-matching"><span class="recipe-description">' + obj.recipes[i].Description + '</span><span class="recipe-id" style="display: none;">' + obj.ingredients[i].ID + '</span></li>');
        } 
        $("#searchResult").append('</ul>');        
      }
    });
  });
  //Not sure about this click part
  $("li.recipe-matching").on("click", function(){
    url = base_url + "index.php/recipe/id" + $(this).val();
    window.location(url);
  });
});

//'<ul><li>obj.cookware[0].ID</li><li>obj.cookware[0].Name</li><ul>'
//$(this).children("span.ingredient-name:first").text()








