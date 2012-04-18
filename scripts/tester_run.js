$(document).ready(function() {
  $('div.tester-run').each( function() {
    $.ajax({
      url: $(this).html(),
      success: function(data) {
        $(this).html(data);
      }
    });
  });
});