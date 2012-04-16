<h1>Add Recipe</h1> <br/>
<form action="<?=site_url(array('recipe', 'submit'))?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  Recipe Name: <input type="text" name="recipeName" /><br/><br/>
  Recipe Tags:<br/><br/>
  <? for ($i = 0; $i < 3; $i++):?>   
  <select name="tags[]">     
      <option value=""></option>
    <? foreach($tags as $tag):?>
      <option value="<?=$tag->ID?>"><?=$tag->Name?></option>
    <?php endforeach;?>
  </select><br/>
  <? endfor; ?><br/>
  Servings: <input type="text" name="servings" /><br/><br/>
  Select Ingredients:<br/>
  <? for ($i = 0; $i < 10; $i++):?>
    <select name="ingredients[]" />
      <option value=""></option>
    <? foreach( $ingredients as $ingredient):?>
      <option value="<?=$ingredient->ID?>"><?=$ingredient->Name?></option>
    <?php endforeach;?><br/>
    </select>
    <input type="text" name="ingredientAmount[]" maxlength="6" value="0"/><br/>
  <? endfor; ?>
  <br/>
	<h2>Image of your recipe (must be a JPG)</h2>
	<input type="file" name="userfile" size="20" />
  <div id="ingredient-list">
	<h2>Provide a Description of your Recipe</h2>
  <textarea name="recipe-description"></textarea><br/>
  <h2>Provide Directions for Preparing your Recipe</h2>
  <textarea name="recipe-directions"></textarea>
  <input type="submit" value="upload" />
</form>
  