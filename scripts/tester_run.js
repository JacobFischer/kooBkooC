var currentDiv;
$(document).ready(function() {
  $('div.run-tester').each( function() {
    currentDiv = $(this);
    $.ajax({
      url: $(this).html(),
      success: function(data) {
        currentDiv.html(data);
      }
    });
  });
});