<h1>Top Voted Recipes! </h1>
<br>
<ol>
<?foreach($recipes->result() as $i):?>
<?$j = $i->RecipesID?>
<li>Name: <a href="<?=base_url() . "index.php/recipe/id/$j"?>"><?=$i->Name?></a></li>
<? endforeach; ?>
</ol>





