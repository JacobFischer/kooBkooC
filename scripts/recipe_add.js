/*
$(document).ready(function(){
  $.ajax({
    url: base_url + "index.php/search/tags/",
    context: document.body,
    success: function(data){
      var obj = jQuery.parseJSON(data);
      var combo = document.getElementById("tagDropDown");
      for(i in obj.tags){
        var option = document.createElement("option");
        option.text = obj.tags[i].Name;
        option.value = obj.tags[i].Name;
        combo.add(option,null);
      }
    }
  });
});*/