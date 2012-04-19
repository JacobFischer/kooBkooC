<script type="text/javascript">
  var unitLookup = new Array();
<?php foreach($ingredients as $ingredient):?>
  unitLookup["<?=$ingredient->ID?>"] = "<?=$ingredient->BaseUnitOfMeasure?>";
<?php endforeach;?>
</script>

<h1>Add Recipe</h1> <br/>
<form action="<?=site_url(array('recipe', 'submit'))?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  Recipe Name: <input type="text" name="recipeName" /><br/><br/>
  Select Tags:<br/><br/>  
  <select id="tags-input">     
    <option value="" name=""></option>
    <?foreach($tags as $tag):?>
      <option value="<?=$tag->ID?>" name="<?=$tag->Name?>" ><?=$tag->Name?></option>
    <?php endforeach;?>
  </select>
  <span id="add-tag-button">Add to Recipe</span><br/><br/>   

  Recipe Tags:
  <ul id="added-tags"></ul><br/>

  Servings: <input type="text" name="servings" /><br/><br/>
 
  Select Ingredients:<br/>
  <select id="ingredient-input" />
    <option value="" name=""></option>
    <? foreach( $ingredients as $ingredient):?>
      <option value="<?=$ingredient->ID?>" name="<?=$ingredient->Name?>" > <?=$ingredient->Name?></option>
    <?php endforeach;?><br/>
  </select>
  <input type="text" id="ingredient-amount" maxlength="6" value="0"/>
  <span id="measure-span"></span>
  <span id="add-ingredient-button">Add to Recipe</span>   
  <br/><br/>
  
  Recipe Ingredients:
  <ul id="added-ingredients"></ul>
  
  <br/>
	<h2>Image of your recipe (must be a JPG)</h2>
	<input type="file" name="userfile" size="20" />
  <div id="ingredient-list"><br/>
	<h2>Provide a Description of your Recipe</h2>
  <textarea name="recipe-description"></textarea><br/>
  <h2>Provide Directions for Preparing your Recipe</h2>
  <textarea name="recipe-directions"></textarea>
  <input type="submit" value="upload" />
</form>
  