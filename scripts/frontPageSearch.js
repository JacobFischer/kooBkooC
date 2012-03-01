$(document).ready(function(){
  $("#testButton").click(function(){
    $.ajax({
      url: base_url + "index.php/search/ingredients/" + $("#search").val(),
      context: document.body,
      success: function(data){
        var obj = jQuery.parseJSON(data);
        $("#testDiv").html('<p>Ingredients:</p><ul id="ingredient-list">');
        for(i in obj.ingredients){
          $("#testDiv").append('<li class="ingredient-matching"><span class="ingredient-name">' + obj.ingredients[i].name + '</span><span class="ingredient-id" style="display: none;">' + obj.ingredients[i].id+ '</span></li>');
        }
        $("#testDiv").append('</ul>');
        $("li.ingredient-matching").on("click", function(){
          $("ul#searchList").append('<li class="ingredient-using">' + $(this).html() + '</li>');
        });
      }
    });
  })
  //$("#searchButton").click(function(){
   // $.ajax({
    //  url: base_url + "index.php/search/reverse/" + $("#search").val(),
    //  context: document.body,
    //  success: function(data){
    //    var obj = jQuery.parseJSON(data);
    //  }
   // });
  //});
});

//'<ul><li>obj.cookware[0].ID</li><li>obj.cookware[0].Name</li><ul>'
//$(this).children("span.ingredient-name:first").text()








