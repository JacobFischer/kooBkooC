$(document).ready(function(){
  $("#buttonUp").click(function() {
    alert("yes");
    $.ajax({
      url: base_url + "index.php/vote/userid/"++"/voteval/1/recipe_id/"+ $("#recipeid").html(),
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
      url: base_url + "index.php/vote/userid/"++"/voteval/-1/recipe_id/"+ $("#recipeid").val(),
      context:document.body,
      success:function(){
        alert("WUTTORS");
      }
    });
})
$("#comment_button").click(function(){
     alert($("#recipeid").html())
    $.ajax({
      url: base_url + "index.php/comment/add/"+userid+"/"+recipeid+"/"+$("#postcomment").val(),
      context:document.body,
      success:function(){
        alert("WUTTORS");
      }
    });
})
});