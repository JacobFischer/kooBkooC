$(document).ready(function(){
  $("#add-ingredient-button").click(function(){
    $ingName = $('#ingredient-input option:selected').text();
    $ingId = $('#ingredient-input option:selected').val();
    $approved = true;
    $('ul#added-ingredients').each(function(){
      $(this).find('li.ingredients span.ingredient-id').each(function(){
        if($ingId == $(this).text()){
          $approved = false;
        }
      });
    });
    if($("#ingredient-amount").val() == '0')
    {
      $approved = false;
    }
    if($approved == true){
      $("ul#added-ingredients").append('<li><input type="hidden" name="ingredients[]" value="' + $ingId + '"/><input type="hidden" name="ingredientAmounts[]" value="' + $("#ingredient-amount").val() + '"/><span class="ingredient-name">' + $ingName + '</span><span class="ingredient-id" style="display: none;">' + $ingId + '</span>' + " - " + '<span class="ingredient-amount">' + $("#ingredient-amount").val() + '</span></li>');
    } 
  });
  $("#add-tag-button").click(function(){
    $tagName = $('#tags-input option:selected').text();
    $tagId = $('#tags-input option:selected').val();
    $approved = true;
    $('ul#added-tags').each(function(){
      $(this).find('li.tags span.tag-id').each(function(){
        if($tagId == $(this).text()){
          $approved = false;
        }
      });
    });
    if($approved == true){
      $("ul#added-tags").append('<li><input type="hidden" name="tags[]" value="' + $tagId + '"/><span class="tag-name">' + $tagName + '</span><span class="tag-id" style="display: none;">' + $tagId + '</span></li>'); 
    }
  });
  $('#ingredient-input').change(function() {
    $("#measure-div").remove();
    $("#measure-div").append(unitLookup[$('#tags-input option:selected').val()]);
  });
});