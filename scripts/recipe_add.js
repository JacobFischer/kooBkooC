//This script was created by Steven Williams

//When a user begins to type a recipe this will suggest similar recipes to them on the side of the screen.
//This will allow the user to check is a very similar recipe already exists before creating their own recipe
function responseRecipeParser( obj ) {
  $("#guessed-recipes").fadeOut('fast', function() {
    var newGuess = "<ul>";
    var count = 0;
    for(i in obj.recipe) {
      newGuess += ('<li><a href="'+base_url+'index.php/recipe/id/'+obj.recipe[i].ID+'">' + obj.recipe[i].Name + '</a></li>');
      count++;
    }
    
    if(count == 0) {
      newGuess += ('<li><em>None</em></li>');
    }
    
    newGuess += ("</ul>");
    $("#guessed-recipes").html(newGuess);
    $("#guessed-recipes").fadeIn('fast');
  });
}


//When the add-ingredient button is clicked it will add the ingredient input to a list of ingredients
//On the page. Constraints are applied before the ingredient is added to ensure it is a valid addition. These include
//if the ingredient already exists in the ingredient list and if the amount being added is greater than 0  
function responseIngredientParser( obj ) {
  $("#suggested-ingredient").fadeOut('fast', function() {
    $("#suggested-ingredient").html("<ul id=" + "ingredient-list" + ">");
    var count = 0;
    $("ul#ingredient-list").html("");
    for(i in obj.ingredients) {
      $("ul#ingredient-list").append('<li class="s-ingredient" value="'+obj.ingredients[i].ID+'">' + obj.ingredients[i].Name + 
      '<span>' + " " + unitLookup[obj.ingredients[i].ID]+ "(s) " + '</span></li>');
      $("li.s-ingredient").click(function(){
        $ingName = $(this).text();
        $ingId = $(this).val();
        $approved = true;
        $('ul#added-ingredients').each(function(){
          $(this).find('li.ingredient span.ingredient-id').each(function(){
            if($ingId == $(this).text()){
              $approved = false;
            }
          });
        });
        if($("#ingredient-amount").val() == '0')
        {
          $approved = false;
        }
        //Actually adding the new list item with all of the ingredient information
        //Also constructs arrays to be sent when the form is submitted
        if($approved == true){
          $("ul#added-ingredients").append('<li class="ingredient"><input type="hidden" name="ingredients[]" value="' + 
            $ingId + '"/><input type="hidden" name="ingredientAmounts[]" value="' + $("#ingredient-amount").val() + 
            '"/><span class="ingredient-name">' + $ingName + '</span><span class="ingredient-id" style="display: none;">' + 
            $ingId + '</span>' + " - " + '<span">' + $("#ingredient-amount").val() + '</span><span>'+ " " + unitLookup[$ingId] + "(s) "+ 
            '</span><span class="remove-ingredient-button" name="' + $ingName + '" >&#9747;</span></li>');
          $("ul#ingredient-list").html("");
          $("#ingredient-input").val("");
          $("#ingredient-amount").val("1");
          $('ul#added-ingredients li.ingredient span.remove-ingredient-button').on("click", function(){
            $item = $(this).attr("name");
            $('ul#added-ingredients').each(function(){
              $(this).find('li.ingredient').each(function(){
                $found = false;
                $(this).find('span.ingredient-name').each(function(){
                  if($item == $(this).text()){
                    $found = true;
                  }
                });
                if($found == true){
                  $(this).remove();
                }
              });
            });
          });
        } 
      });
      count++;
    }
    if(count == 0) {
      $("ul#ingredient-list").append('<li><em>None</em></li>');
    }  
    
    $("#suggested-ingredient").append("</ul>");
    $("#suggested-ingredient").fadeIn('fast');
  });
}

function responseTagParser( obj ) {
  $("#suggested-tags").fadeOut('fast', function() {
    $("#suggested-tags").html("<ul id="+ "tag-list" + ">");
    var count = 0;
    for(i in obj.tags) {
      $("ul#tag-list").append('<li class="s-tag" value="'+obj.tags[i].ID+'">' + obj.tags[i].Name + '</li>');
      //Adds a new tag to the list of tags for the recipe when the button is pressed. Makes sure to check if the tag is valid
      //by comparing ot the current tags for the recipe.
      $("li.s-tag").click(function(){
        $tagName = $(this).text();
        $tagId = $(this).val();
        $approved = true;
        $('ul#added-tags').each(function(){
          $(this).find('li.tag span.tag-id').each(function(){
            if($tagId == $(this).text()){
              $approved = false;
            }
          });
        });
        //If the tag is approved it will be added to the list on the page
        if($approved == true){
          //Constructs a list of tags to be passed when the form is submitted
          $("ul#added-tags").append('<li class="tag"><input type="hidden" name="tags[]" value="' + 
            $tagId + '"/><span class="tag-name">' + $tagName + '</span><span class="tag-id" style="display: none;">' + 
            $tagId + '</span><span class="remove-tag-button" name="' + $tagName + '" >&#9747;</span></li>'); 
          $("ul#tag-list").html("");
          $("#tags-input").val("");
          $('ul#added-tags li.tag span.remove-tag-button').on("click", function(){
            $item = $(this).attr("name");
            $('ul#added-tags').each(function(){
              $(this).find('li.tag').each(function(){
                $found = false;
                $(this).find('span.tag-name').each(function(){
                  if($item == $(this).text()){
                    $found = true;
                  }
                });
                if($found == true){
                  $(this).remove();
                }
              });
            });
          });
        }
      });
      count++;
    }
    
    if(count == 0) {
      $("ul#tag-list").append('<li><em>None</em></li>');
    }
    
    $("#suggested-tags").append("</ul>");
    $("#suggested-tags").fadeIn('fast');
  });
}

$(document).ready(function(){
  //User to autocomplete on the naming of a recipe ot ensure that the name input will be unique.
  //Allows a user to see if a recipe by the name they want to use already exists in the database.
  var typingTimer;                //timer identifier
  var doneTypingInterval = 333;  //time in ms, 1 second for example

  
  //Trigger events for keyup and keydown for three boxes
  //on keyup, start the countdown
  $("#recipe-name").keyup(function(){
    typingTimer = setTimeout(doneRecipeTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#recipe-name").keydown(function(){
    clearTimeout(typingTimer);
  });
  
  $("#ingredient-input").keyup(function(){
    typingTimer = setTimeout(doneIngredientTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#ingredient-input").keydown(function(){
    clearTimeout(typingTimer);
  });
  
  $("#tags-input").keyup(function(){
    typingTimer = setTimeout(doneTagTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#tags-input").keydown(function(){
    clearTimeout(typingTimer);
  });

  //Functions for when the user is done typing in the input box.
  function doneRecipeTyping () {
    if($("#recipe-name").val() != ""){  
      ajaxGuess( "recipes", $("#recipe-name").val(), responseRecipeParser );
    }
    else{
      $("#guessed-recipes").html('');
    }
  }
  
  function doneIngredientTyping () {
    if($("#ingredient-input").val() != ""){  
      ajaxGuess( "ingredients", $("#ingredient-input").val(), responseIngredientParser );
    }
    else{
      $("ul#ingredient-list").html('');
    }
  }
  
  function doneTagTyping () {
    if(($("#tags-input").val()) != ""){  
      ajaxGuess( "tags", $("#tags-input").val(), responseTagParser );
    }
    else{
      $("ul#tag-list").html('');
    }
  }
});
