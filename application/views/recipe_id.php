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
<div id="recipe-body">
  You'll need:<br/>
  <? foreach( $ingredients as $ingredient):?>
  <?=$ingredient->Name?><br/>
  <?php endforeach;?><br/>
  <p>Directions:<br/><?=$recipe->Directions?></p><br/>
  Tags:
  <? foreach( $tags as $tag):?>
  <?$j = $tag->ID?>
  <a href="<?=base_url() . "index.php/tags/recipes/$j"?>"><?=$tag->Name?></a>
  <?php endforeach;?><br/>

  Comments:<br/>
  <?php foreach( $comments as $comment ): ?>
  <?=$comment->DisplayName?> 
  Date: 
  <?=$comment->Time?> <br/>
  <?=$comment->Text?><br/><br/>
  <?php endforeach; ?>

  Post Comment:
  <textarea id="postcomment" style="height: 100px; width: 500px"></textarea>
  <button id="comment_button"> Post! </button>
</div>