<h1>Ingredients</h1>

<?foreach($ingredient->result() as $i):?>
<?$j = $i->ID;?>
<?$z = (($i->freq * $max_font)/$total);
	if($z > 400)
	{
	$z = 400;
	}
	
	if($z < 10 )
	{
		$z = 10;
	} 
?>

<a href="<?=base_url() . "index.php/ingredients/id/$j"?>" style="font-size:<?=($i->freq * $max_font)/$total?>pt;">


<div style ="background: url('http://home.jacobfischer.me/cs397_uploads/ingredients/<?=$j?>.jpg'); height: <?=$z * 4?>px; width: <?=$z * 4?>px;" class = "ingredient-cloud">

<?=$i->Name?>
</div>
</a>
<? endforeach; ?>

<br/><br/>
Do you have an ingredient not listed?
<h2>
<a href="<?=base_url() . "index.php/ingredients/add"?>">Add an Ingredient!</a>
</h2>

