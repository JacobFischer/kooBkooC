<li class="recipe-comment <?=isset($extra) ? "recipe-comment-" . $extra : ""?>"<?=isset($hide) ? 'style="display: none;"' : ""?>>
<?php if(isset($comment_on)): ?>
  <span class="comment-on">On <a href="<?=site_url( array('recipe', 'id', $comment->RecipesID) )?>"><?=$comment->Name?></a></span>
<?php endif; ?>
  <header>
    <a href="<?=site_url( array( 'user', 'profile', $comment->ID ) )?>"><?=$comment->DisplayName?></a> 
    <time datetime="<?=gmdate("Y-m-d\TH:i:s\Z", strtotime($comment->Time))?>"><?=date('n/j/Y g:iA',  strtotime($comment->Time) )?></time>
  </header>
  <section>
    <?=$comment->Text?> 
  </section>
</li>