<div id="recipe-id" style="display: none;"><?=$recipe->ID?></div>
<div id="recipe-top">
  <div id="recipe-voter">
    <button id="recipe-up-vote" class="<?= $users_vote["Direction"] == 1 ? "voted-up" : ""?>">&#9650;</button>
    <span id="recipe-total" class="<?= $users_vote["Direction"] == 1 ? "voted-up" : ($users_vote["Direction"] == -1 ? "voted-down" : "") ?>"><?=$vote_count->Direction?></span>
    <button id="recipe-down-vote"  class="<?= $users_vote["Direction"] == -1 ? "voted-down" : ""?>">&#9660;</button>
  </div>
  <h1><?=$recipe->Name?></h1>
  <div id="recipe-submitter">Submitted by: <a href="<?=site_url('user', 'id', $submitter->ID)?>"><?=$submitter->DisplayName?></a></div>
  <div id="recipe-description">
    <?=$recipe->Description?>
  </div>
</div>
<hr style="float: left; width: 100%;"/>
<div id="recipe-body">
  <img src="<?=/*base_url() . 'uploads/recipes/'*/ 'http://home.jacobfischer.me/cs397_uploads/recipes/' . $recipe->ID . '.jpg'?>" id="recipe-img" />
  
  <section id="recipe-ingredients">
    <h2>You'll need</h2>
    <ul>
<? foreach( $ingredients as $ingredient):?>
      <li><?=$ingredient->Amount?> <?=$ingredient->BaseUnitOfMeasure?> of <a href="<?=site_url(array( 'ingredients', 'id', $ingredient->ID ))?>"><?=$ingredient->Name?></a></li>
<?php endforeach;?><br/>
    </ul>
  </section>
  
  <section id="recipe-directions">
    <h2>Directions</h2>
    <p><?=$recipe->Directions?></p>
  </section>
  <section id="recipe-tags">
    <h2>Tags</h2>
    <ul>
<? foreach( $tags as $tag):?>
      <li><a href="<?=site_url( array( 'tags', 'recipes', $tag->ID) )?>"><?=$tag->Name?></a></li>
<?php endforeach;?>
    </ul>
  </section>
</div>
<div id="recipe-comments">
  <h2>Comments</h2>
  <ul id="recipie-comments-tree">
<?php foreach( $comments as $comment ): ?>
    <?=$this->load->view('recipe_comment', array('comment' => $comment ) )?>
<?php endforeach; ?>
<?= count($comments) == 0 ? "      <p>No Comments...</p>" : "" ?>
  </ul>
</div>
<section id="recipe-new-comment">
  <h2>Add Your Comment</h2>
  <div id="recipe-new-comment-info">kooBkooC uses <a href="http://www.textism.com/tools/textile/">Textile formatting</a> on submissions.</div>
  <textarea id="new-comment-body"></textarea>
  <button id="add-comment">Post Comment</button>
</section>

