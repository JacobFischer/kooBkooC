<section class="recipe-short">
  <div class="recipe-voter" id="recipe-voter-<?=$recipe->ID?>">
    <button class="recipe-up-vote <?= $recipe->UsersVote == 1 ? "voted-up" : ""?>">&#9650;<span style="display: none;"><?=$recipe->ID?></span></button>
    <span class="recipe-total <?= $recipe->UsersVote == 1 ? "voted-up" : ($recipe->UsersVote == -1 ? "voted-down" : "") ?>"><?=$recipe->Direction?></span>
    <button class="recipe-down-vote <?= $recipe->UsersVote == -1 ? "voted-down" : ""?>">&#9660;<span style="display: none;"><?=$recipe->ID?></span></button>
  </div>
  <a href="<?=site_url( array( 'recipe', 'id', $recipe->ID ) )?>">
    <img src="http://home.jacobfischer.me/cs397_uploads/recipes/<?=$recipe->ID?>" />
    <div>
      <h2><?=$recipe->Name?></h2>
      <span><?=$recipe->Description?></span>
    </div>
  </a>
</section>