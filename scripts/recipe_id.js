$(document).ready(function(){
  $("#buttonUp").click(function() {
    alert("yes");
    $.ajax({
      url: base_url + "index.php/vote/userid/"+"/voteval/1/recipe_id/"+ $("#recipeid").html(),
      context: document.body,
      success: function(){
        alert("WUT");
      }
      //var query = jQuery.parseJSON();
      //alert( );
    });
  })
  $("#buttonDown").click(function(){
       alert($("#recipeid").html())
      $.ajax({
        url: base_url + "index.php/vote/userid/"+"/voteval/-1/recipe_id/"+ $("#recipeid").val(),
        context:document.body,
        success:function(){
          alert("WUTTORS");
        }
      });
  })
  $("#comment_button").click(function(){
       alert($("#recipeid").html())
      $.ajax({
        url: base_url + "index.php/comment/add/"+userid+"/"+recipeid+"/"+encodeURI($("#postcomment").val()),
        context:document.body,
        success:function(){
          alert("WUTTORS");
        }
      });
  })
  
  
  $(".recipe-up-vote").click(function() {
    recipe_ajax_vote( "up", $("#recipe-id").html() );
  });
  
  $(".recipe-down-vote").click(function() {
    recipe_ajax_vote( "down", $("#recipe-id").html() ); 
  });
  
  $("#add-comment").click(function(){
      $.ajax({
        url: base_url + "index.php/comment/add/" + $("#recipe-id").html() + "/" + encodeURIComponent($("#new-comment-body").val()),
        context:document.body,
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
