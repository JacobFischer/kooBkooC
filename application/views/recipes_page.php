<h1>Top Voted Recipes! </h1>
<br>
<ol>
<?foreach($recipes->result() as $i):?>
<?$j = $i->RecipesID?>
<li><a href="<?=base_url() . "index.php/recipe/id/$j"?>"><?=$i->Name?></a></li>
<? endforeach; ?>
</ol><br/>

<p>Have your own ideas? Click below to submit your own recipe!</p>
<a href="<?=base_url() . "index.php/recipe/add"?>">Submit A Recipe</a>





