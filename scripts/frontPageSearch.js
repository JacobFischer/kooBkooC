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
    var url_string = ""
    for(item in $("ul#searchList li.ingedient-using span.ingredient-id")){
      url_string.concat('ingredient[]=' + item.val() + '&')
    } 
    $.ajax({
      url: base_url + "index.php/search/reverse?" + url_string,
      context: document.body,
      success: function(data){
        var obj = jQuery.parseJSON(data); 
        $("#searchResult").html('<p>Recipes:</p><ul id="recipe-list">');
        for(i in obj.recipes){
          $("#searchResult").append('<li class="recipe-matching"><span class="recipe-description">' + obj.recipes[i].Description + '</span><span class="recipe-id" style="display: none;">' + obj.ingredients[i].ID + '</span></li>');
        } 
        $("#searchResult").append('</ul>');        
      }
    });
  });
});

//'<ul><li>obj.cookware[0].ID</li><li>obj.cookware[0].Name</li><ul>'
//$(this).children("span.ingredient-name:first").text()








