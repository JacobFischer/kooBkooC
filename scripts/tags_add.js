//Programmers: Tim Pund & Jacob Fischer(I think)
//Desc: Javascript function used to grab the added tag name on the form and return results so the controller can use them
function responseParser( obj ) {
  $("#guessed-tags").fadeOut('fast', function() {
    var newGuess = "<ul>";
    var count = 0;
    for(i in obj.tags) {
      newGuess += ('<li><a href="'+base_url+'index.php/tags/recipes/'+obj.tags[i].ID+'">' + obj.tags[i].Name + '</a></li>');
      count++;
    }
    
    if(count == 0) {
      newGuess += ('<li><em>None</em></li>');
    }
    
    newGuess += ("</ul>");
    $("#guessed-tags").html(newGuess);
    $("#guessed-tags").fadeIn('fast');
  });
}

$(document).ready(function() {
  var typingTimer;                //timer identifier
  var doneTypingInterval = 333;  //time in ms, 1 second for example

  //on keyup, start the countdown
  $("#tags-name").keyup(function(){
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#tags-name").keydown(function(){
    clearTimeout(typingTimer);
  });

  //user is "finished typing," do something
  function doneTyping () {
    //do something
    ajaxGuess( "tags", $("#tags-name").val(), responseParser )
  }
});