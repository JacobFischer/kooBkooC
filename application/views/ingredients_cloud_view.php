<!--Michael Wilson and company -->
<h1>Ingredients</h1>
<div id="ingredients-cloud">
<?php foreach($ingredients as $ingredient): ?>
<?
$z = (($ingredient->freq * $max_font)/$total);
	if($z > 300)
	{
	$z = 300;
	}
	
	if($z < 20 )
	{
		$z = 20;
	} 
?>

<a class="ingredient-cloud-item" title="<?=$ingredient->Name?>" href="<?=site_url( array('ingredients', 'id', $ingredient->ID ) )?>"><img src ="http://home.jacobfischer.me/cs397_uploads/ingredients/<?=$ingredient->ID?>.jpg" style="height: <?=$z * 4?>px; width: auto;" /></a>
<? endforeach; ?>
</div>
<br/><br/>
See an ingredient not listed?
<h2>
<a href="<?=base_url() . "index.php/ingredients/add"?>">Add an Ingredient!</a>
</h2>

