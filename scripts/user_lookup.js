function responseParser( obj ) {
  $("#guessed-users").fadeOut('fast', function() {
    var newGuess = "<ul>";
    var count = 0;
    for(i in obj.users) {
      newGuess += ('<li><a href="'+base_url+'index.php/user/id/'+obj.users[i].ID+'">' + obj.users[i].DisplayName + '</a></li>');
      count++;
    }
    
    if(count == 0) {
      newGuess += ('<li><em>None</em></li>');
    }
    
    newGuess += ("</ul>");
    $("#guessed-users").html(newGuess);
    $("#guessed-users").fadeIn('fast');
  });
}

$(document).ready(function() {
  var typingTimer;                //timer identifier
  var doneTypingInterval = 333;  //time in ms, 1 second for example

  //on keyup, start the countdown
  $("#user-lookup").keyup(function(){
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#user-lookup").keydown(function(){
    clearTimeout(typingTimer);
  });

  //user is "finished typing," do something
  function doneTyping () {
    //do something
    ajaxGuess( "user", $("#user-lookup").val(), responseParser )
  }
});