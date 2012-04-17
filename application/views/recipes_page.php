<h1>Top Voted Recipes! </h1>
<ol>
<?foreach($recipes as $recipe):?>
<li><?=$this->load->view('recipes/short', array('recipe' => $recipe ) )?></li>
<? endforeach; ?>
</ol><br/>

<p>Have your own ideas? Click below to submit your own recipe!</p>
<a href="<?=base_url() . "index.php/recipe/add"?>">Submit A Recipe</a>





