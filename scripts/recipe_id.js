$(document).ready(function(){
  
  $(".recipe-up-vote").click(function() {
    recipe_ajax_vote( "up", $("#recipe-id").html() );
  });
  
  $(".recipe-down-vote").click(function() {
    recipe_ajax_vote( "down", $("#recipe-id").html() ); 
  });
  
  $("#add-comment").click(function(){
      $.ajax({
        type: "POST",
        data: { message: $("#new-comment-body").val() },
        context:document.body,
        url: (base_url + "index.php/comment/add/" + $("#recipe-id").html() + "/"),
        success:function(data) {
          var obj = jQuery.parseJSON(data);
          if(obj.success) {
            $("ul#recipie-comments-tree").append( atob( obj.newHTML ) );
            $("ul#recipie-comments-tree li:last-child").fadeIn( 1000 );
          }
          else {
            alert( obj.reason );
          }
        }
      });
  })
});
