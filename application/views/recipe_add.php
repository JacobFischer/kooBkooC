<li class="recipe-ad"<?=isset($hide) ? 'style="display: none;"' : ""?>>
  <h1>Add Recipe</h1> <br/>
  <form action="<?=site_url(array('recipe', 'submit'))?>" method="post">
    Recipe Name: <input type="text" name="recipeName" /><br/><br/>
    Recipe Tag: <select name="tags">
    <? foreach( $tags as $tag):?>
      <option value="<?=$tag->ID?>"><?=$tag->Name?></option>
    <?php endforeach;?>
    </select><br/><br/>
    Select Ingredients:<br/>
    <? for ($i = 0; $i < 10; $i++):?>
    <select name="ingredients[]" />
    <? foreach( $ingredients as $ingredient):?>
      <option value="<?=$ingredient->ID?>"><?=$ingredient->Name?></option>
    <?php endforeach;?><br/>
    </select>
    <input type="text" name="ingredientAmount" maxlength="6" /><br/>
    <? endfor; ?>
    <br/>
    <div id="ingredient-list">
    <h2>Provide Directions for Preparing your Recipe</h2>
    <textarea name="recipe-directions"></textarea>
    <h2>Provide a Description of your Recipe</h2>
    <textarea name="recipe-description"></textarea>
    <input type="submit" />
  </form>
  
</li>