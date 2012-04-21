<h1>Recipes</h1>
<ol start="<?=$page->Start?>">
<?foreach($recipes as $recipe):?>
  <li><?=$this->load->view('recipes/short', array('recipe' => $recipe ) )?></li>
<? endforeach; ?>
</ol><br/>

<p>Have your own ideas? Click below to submit your own recipe!</p>
<a href="<?=base_url() . "index.php/recipe/add"?>">Submit A Recipe</a>


<div id="recipe-paging">
  <nav>
<?php if( $page->Previous ): ?>
    <a href="<?=site_url( array( 'recipe', 'page', $page->Current-1 ) )?>">&laquo;</a>
<?php else: ?>
    <span class="disabled-page">&laquo;</span>
<?php endif; ?>
    <?=$page->Current?>
<?php if( $page->Next ): ?>
    <a href="<?=site_url( array( 'recipe', 'page', $page->Current+1 ) )?>">&raquo;</a>
<?php else: ?>
    <span class="disabled-page">&raquo;</span>
<?php endif; ?>
  </nav>
</div>