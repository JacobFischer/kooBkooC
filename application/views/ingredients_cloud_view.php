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

<a href="<?=base_url() . "index.php/ingredients/id/$j"?>" style="font-size:<?=($i->freq * $max_font)/$total?>pt;"><img src ="http://home.jacobfischer.me/cs397_uploads/ingredients/<?=$j?>.jpg" style="height: <?=$z * 4?>px; width: auto;"/></a>
<? endforeach; ?>

<br/><br/>
See an ingredient not listed?
<h2>
<a href="<?=base_url() . "index.php/ingredients/add"?>">Add an Ingredient!</a>
</h2>

