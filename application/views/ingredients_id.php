<section id="ingredient-body">
  <img src="<?=/*base_url() . 'uploads/ingredients/'*/ 'http://home.jacobfischer.me/cs397_uploads/ingredients/' . $ingredient->ID . '.jpg'?>" id="ingredient-img" />
  <h1><?=$ingredient->Name?></h1>
  <?=$ingredient->Description?>
  <hr/>
  <div id="ingredient-base">Base Unit: <?=$ingredient->BaseUnitOfMeasure?></div>
</section>
<section id="ingredient-recipes">
  <h2>Recipes using <?=$ingredient->Name?></h2>
  <ul>
  <?php foreach($recipes as $recipe): ?>
    <li><a href = "<?=site_url( array('recipe', 'id', $recipe->ID) )?>"/><?echo $recipe->Name ?></a></li>
  <?php endforeach; ?>
  </ul>
</section>

