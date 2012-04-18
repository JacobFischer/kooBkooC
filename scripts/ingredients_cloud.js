$(document).ready( function() {
  $("#ingredients-cloud a[title]").tooltip({
      position: "top center",
      effect: "fade",
      });
  
  $('#ingredients-cloud').imagesLoaded( function(){
    $('#ingredients-cloud').masonry({
      itemSelector : '.ingredient-cloud-item'
    });
  });
});