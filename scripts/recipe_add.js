$(document).ready(function(){
  $("#add-ingredient-button").click(function(){
    $stuff = $('#ingredient-input option:selected').text();
    $("ul#added-ingredients").append('<li class="ingredients[]"><span class="ingredient-name">' + $stuff + '</span>' + " - " + '<span class="ingredient-amount">' + $("#ingredient-amount").val() + '</span></li>'); 
  });
});