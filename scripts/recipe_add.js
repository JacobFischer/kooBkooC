$(document).ready(function(){
  $("#add-ingredient-button").click(function(){
    $ingName = $('#ingredient-input option:selected').text();
    $ingId = $('#ingredient-input option:selected').val();
    $approved = true;
    $('ul#added-ingredients').each(function(){
      $(this).find('li.ingredient span.ingredient-id').each(function(){
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
      $("ul#added-ingredients").append('<li class="ingredient"><input type="hidden" name="ingredients[]" value="' + $ingId + '"/><input type="hidden" name="ingredientAmounts[]" value="' + $("#ingredient-amount").val() + '"/><span class="ingredient-name">' + $ingName + '</span><span class="ingredient-id" style="display: none;">' + $ingId + '</span>' + " - " + '<span">' + $("#ingredient-amount").val() + '</span><span>'+ " " + unitLookup[$ingId] + "(s) "+ '</span><span class="remove-ingredient-button" name="' + $ingName + '" >[X]</span></li>');
      $('ul#added-ingredients li.ingredient span.remove-ingredient-button').on("click", function(){
        $item = $(this).attr("name");
        $('ul#added-ingredients').each(function(){
          $(this).find('li.ingredient').each(function(){
            $found = false;
            $(this).find('span.ingredient-name').each(function(){
              if($item == $(this).text()){
                $found = true;
              }
            });
            if($found == true){
              $(this).remove();
            }
          });
        });
      });
    } 
  });
  $("#add-tag-button").click(function(){
    $tagName = $('#tags-input option:selected').text();
    $tagId = $('#tags-input option:selected').val();
    $approved = true;
    $('ul#added-tags').each(function(){
      $(this).find('li.tag span.tag-id').each(function(){
        if($tagId == $(this).text()){
          $approved = false;
        }
      });
    });
    if($approved == true){
      $("ul#added-tags").append('<li class="tag"><input type="hidden" name="tags[]" value="' + $tagId + '"/><span class="tag-name">' + $tagName + '</span><span class="tag-id" style="display: none;">' + $tagId + '</span><span class="remove-tag-button" name="' + $tagName + '" >[X]</span></li>'); 
      $('ul#added-tags li.tag span.remove-tag-button').on("click", function(){
        $item = $(this).attr("name");
        $('ul#added-tags').each(function(){
          $(this).find('li.tag').each(function(){
            $found = false;
            $(this).find('span.tag-name').each(function(){
              if($item == $(this).text()){
                $found = true;
              }
            });
            if($found == true){
              $(this).remove();
            }
          });
        });
      });
    }
  });
  $('#ingredient-input').change(function() {
    $("#measure-span").html('<span>' + " " + unitLookup[$('#ingredient-input option:selected').val()]+ "(s) " + '</span>');
  });
});