<script type="text/javascript">
  var unitLookup = new Array();
<?php foreach($ingredients as $ingredient):?>
  unitLookup["<?=$ingredient->ID?>"] = "<?=$ingredient->BaseUnitOfMeasure?>";
<?php endforeach;?>
</script>

<h1>Add Recipe</h1> <br/>
<form action="<?=site_url(array('recipe', 'submit'))?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  Recipe Name: <input type="text" name="recipeName" id="recipe-name" />
  <div id="suggested-recipes">
    <h2>Similar Recipes</h2>
    <section id="guessed-recipes">
    </section>
  </div><br/><br/>
  Select Tags:<br/><br/>  
  <input type="text" id="tags-input">     </input> 
  <div id="suggested-tags"></div><br/><br/>   

  Recipe Tags:
  <ul id="added-tags"></ul><br/>

  Servings: <input type="text" name="servings" /><br/><br/>
 
  Select Ingredients:<br/>
  <input type="text" id="ingredient-input" /></input>
  <div id="suggested-ingredient"></div>
  <input type="text" id="ingredient-amount" maxlength="6" value="0"/>
  <span id="measure-span"></span> 
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
  