function responseParser( obj ) {
  $("#guessed-ingredients").fadeOut('fast', function() {
    var newGuess = "<ul>";
    var count = 0;
    for(i in obj.ingredients) {
      newGuess += ('<li><a href="'+base_url+'index.php/ingredients/id/'+obj.ingredients[i].ID+'">' + obj.ingredients[i].Name + '</a></li>');
      count++;
    }
    
    if(count == 0) {
      newGuess += ('<li><em>None</em></li>');
    }
    
    newGuess += ("</ul>");
    $("#guessed-ingredients").html(newGuess);
    $("#guessed-ingredients").fadeIn('fast');
  });
}

$(document).ready(function() {
  var typingTimer;                //timer identifier
  var doneTypingInterval = 333;  //time in ms, 1 second for example

  //on keyup, start the countdown
  $("#ingredients-name").keyup(function(){
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#ingredients-name").keydown(function(){
    clearTimeout(typingTimer);
  });

  //user is "finished typing," do something
  function doneTyping () {
    //do something
    ajaxGuess( "ingredients", $("#ingredients-name").val(), responseParser )
  }
});