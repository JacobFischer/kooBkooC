<script type="text/javascript">
  var unitLookup = new Array();
<?php foreach($ingredients as $ingredient):?>
  unitLookup["<?=$ingredient->ID?>"] = "<?=$ingredient->BaseUnitOfMeasure?>";
<?php endforeach;?>
</script>

<h1>Add Recipe</h1>
<div id="recipes-add-wrapper">
  <form action="<?=site_url(array('recipe', 'submit'))?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="recipes-add">
    <label for="recipe-name">Recipe Name</label>
    <input type="text" name="recipeName" id="recipe-name" />
    
    <br/>
    <label for="tags-input">Search for Tags</label>
    <input type="text" id="tags-input" autocomplete="off"></input> 
    <div id="suggested-tags"></div>  

    <p>The Recipe's Tags</p>
    <ul id="added-tags"></ul><br/>

    <label for="recipes-servings">Servings</label>
    <input type="text" name="servings" id="recipes-servings" /><br/>
   
    <label for="ingredient-input">Search for Ingredients</label>
    <input type="text" id="ingredient-input" autocomplete="off"></input>
    <label for="ingredient-amount" id="ingredient-amount-label">Amount</label>
    <input type="text" id="ingredient-amount" maxlength="6" value="0"/>
    <div id="suggested-ingredient"></div>
    
    <span id="measure-span"></span> 
    
    <p>The Recipe's Ingredients</p>
    <ul id="added-ingredients"></ul><br/>
    
    <label for="recipes-image">Image of your recipe (must be a JPG)</label>
    <input type="file" name="userfile" size="20" id="recipes-image"/>
    <div id="ingredient-list"></div><br/>
    
    <label for="recipes-description">A description of your Recipe</label>
    <textarea name="recipe-description" id="recipes-description"></textarea>
    <br/>
    <br/>
    <label for="recipes-directions">Directions for Preparing your Recipe</label>
    <textarea name="recipe-directions" id="recipes-directions"></textarea>
    <input type="submit" value="Add my Recipe" />
  </form>
  <div id="suggested-recipes">
    <h2>Is your Recipe already added?</h2>
    <section id="guessed-recipes">
    </section>
  </div>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;