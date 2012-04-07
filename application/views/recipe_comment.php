<li class="recipe-comment"<?=isset($hide) ? 'style="display: none;"' : ""?>>
  <header>
    <?=$comment->DisplayName?> 
    <time datetime="<?=gmdate("Y-m-d\TH:i:s\Z", strtotime($comment->Time))?>"><?=date('n/j/Y g:iA',  strtotime($comment->Time) )?></time>
  </header>
  <section>
    <?=$comment->Text?> 
  </section>
</li>