$(document).ready(function(){
  $("#guesser").click(function() {
    alert("Woop");
    $.ajax
    (
      {
        url: base_url(),
        context: document.body,
        success: function()
        {
          alert("WUT");
        }
      }
    );
  });
});