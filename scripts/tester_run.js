$(document).ready(function() {
  $('div.run-tester').each( function() {
    var currentDiv = $(this);
    $.ajax({
      url: $(this).html(),
      success: function(data) {
        currentDiv.html(data);
      }
    });
  });
});