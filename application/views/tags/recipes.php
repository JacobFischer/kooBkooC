<!--Michael Wilson -->
<h1>Recipes tagged &quot;<?=$tag->Name?>&quot;</h1>
<p><?=$tag->Description?></p>
<section id="tags-recipes">
  <ol>
  <?foreach($recipes as $recipe):?>
    <li><?=$this->load->view('recipes/short', array('recipe' => $recipe ) )?></li>
  <? endforeach; ?>
  </ol>
</section>
&nbsp;