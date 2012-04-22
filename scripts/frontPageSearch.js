/*$(document).ready(function(){
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
        $("section#guessed-reverse").fadeOut( 'fast', function() {
          $(this).html( data );
          $(this).fadeIn( 'fast' );
        });
      }
    });
  })
});*/

function responseIngredientParser( obj ) {
  $("#suggested-ingredient").fadeOut('fast', function() {
    
    $(this).html("<ul id=" + "ingredient-list" + ">");
    
    for(i in obj.ingredients) {
      $("ul#ingredient-list").append('<li class="s-ingredient"><span class="its-name">' + obj.ingredients[i].Name + '</span><span class="its-id" style="display: none;">' + obj.ingredients[i].ID +'</span></li>');
    }
    
    $(this).fadeIn( 'fast' );
    
  })
}

$(document).ready(function(){
  //User to autocomplete on the naming of a recipe ot ensure that the name input will be unique.
  //Allows a user to see if a recipe by the name they want to use already exists in the database.
  var typingTimer;                //timer identifier
  var doneTypingInterval = 333;  //time in ms, 1 second for example
  
  //Trigger events for keyup and keydown for three boxes
  //on keyup, start the countdown
  $("#ingredient-search").keyup(function(){
    typingTimer = setTimeout(doneIngredientTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#ingredient-search").keydown(function(){
    clearTimeout(typingTimer);
  });
  
  function doneIngredientTyping () {
    ajaxGuess( "ingredients", $("#ingredient-search").val(), responseIngredientParser );
  }
  
  function reverseSearch() {
    var searchURL = base_url + "index.php/search/reverse?";
    
    $('ul#ingredients-searching-with li').each( function() {
      searchURL += "ingredients[]=" + $(this).children('span.its-id').html() + "&";
    });
    
    $.ajax({
      url: searchURL,
      context: document.body,
      success: function(data){
        $("section#guessed-reverse").fadeOut( 'fast', function() {
          $(this).html( data );
          $(this).fadeIn( 'fast' );
        });
      }
    });
  }
  
  $('li.s-ingredient').live( 'click', function() {
    var ingredientName = $(this).children('span.its-name').html();
    var ingredientID = $(this).children('span.its-id').html();
    // fade out and clear the autocomplete div
    $("#suggested-ingredient").fadeOut('fast', function() {
      $(this).html("");
      $('#ingredient-search').val("");
    });
    
    var ingredientAlreadyIn = false;
    $('ul#ingredients-searching-with li').each( function() {
      if( $(this).children('span.its-id').html() == ingredientID )
      {
        ingredientAlreadyIn = true;
        return;
      }
    });
    
    if( !ingredientAlreadyIn ) {
      $('ul#ingredients-searching-with').append( '<li id="searching-with-ingredient-' + ingredientID + '" style="display: none;">' + ingredientName + '<span class="its-id" style="display: none;">' + ingredientID + '</span><span class="remove-ingredient-button">&#9747;</span></li>' );
      $('ul#ingredients-searching-with li#searching-with-ingredient-' + ingredientID ).fadeIn( 'slow' );
      
      reverseSearch();
    }
  });
  
  $('span.remove-ingredient-button').live( 'click', function() {
    $( 'li#searching-with-ingredient-' + $(this).parent().children( 'span.its-id' ).html() ).fadeOut( 'slow', function() {
      $(this).remove();
      reverseSearch();
    });
  });
});
