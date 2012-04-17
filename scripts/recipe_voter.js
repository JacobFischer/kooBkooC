function recipe_ajax_vote( dir, id ) {
  $.ajax({
    url: base_url + "index.php/vote/" + dir + "/"+ id,
    context:document.body,
    success:function(data){
      var obj = jQuery.parseJSON(data);
      if(obj.success){
        // remove all the classes from the button and total
        $("button#recipe-up-vote").removeClass();
        $("span#recipe-total").removeClass();
        $("button#recipe-down-vote").removeClass();
        
        if(obj.direction == "up") {
          $("button#recipe-up-vote").addClass( "voted-up" );
          $("span#recipe-total").addClass( "voted-up" );
          $("span#recipe-total").html( obj.total );
        }
        else if(obj.direction == "down") {
          $("button#recipe-down-vote").addClass( "voted-down" );
          $("span#recipe-total").addClass( "voted-down" );
          $("span#recipe-total").html( obj.total );
        }
      }
      else{
        alert(obj.reason);
      }
    }
  });
}