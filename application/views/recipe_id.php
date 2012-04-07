<div id="recipe-id" style="display: none;"><?=$recipe->ID?></div>
<div id="recipe-top">
  <div id="recipe-voter">
    <button id="recipe-up-vote" class="<?= $users_vote["Direction"] == 1 ? "voted-up" : ""?>">&#9650;</button>
    <span id="recipe-total" class="<?= $users_vote["Direction"] == 1 ? "voted-up" : ($users_vote["Direction"] == -1 ? "voted-down" : "") ?>"><?=$vote_count->Direction?></span>
    <button id="recipe-down-vote"  class="<?= $users_vote["Direction"] == -1 ? "voted-down" : ""?>">&#9660;</button>
  </div>
  <h1>Recipe: <?=$recipe->Name?></h1>
  <div id="recipe-description">
    <?=$recipe->Description?>
  </div>
</div>
<hr style="float: left; width: 100%;"/>
<section id="recipe-body">
  <h2>You'll need</h2>
  <? foreach( $ingredients as $ingredient):?>
  <?=$ingredient->Name?><br/>
  <?php endforeach;?><br/>
  <h2>Directions</h2>
  <p><?=$recipe->Directions?></p>
  <h2>Tags</h2>
  <? foreach( $tags as $tag):?>
  <?$j = $tag->ID?>
  <a href="<?=base_url() . "index.php/tags/recipes/$j"?>"><?=$tag->Name?></a>
  <?php endforeach;?><br/>

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
</section>