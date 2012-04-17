<section class="recipe-short">
  <div id="recipe-voter">
    <button id="recipe-up-vote">&#9650;</button>
    <span id="recipe-total"><?=$recipe->Direction?></span>
    <button id="recipe-down-vote">&#9660;</button>
  </div>
  <a href="<?=site_url( array( 'recipe', 'id', $recipe->ID ) )?>">
    <img src="http://home.jacobfischer.me/cs397_uploads/recipes/<?=$recipe->ID?>" />
    <div>
      <h2><?=$recipe->Name?></h2>
      <span><?=$recipe->Description?></span>
    </div>
  </a>
</section>