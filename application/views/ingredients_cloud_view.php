<h1>Ingredients</h1>

<?foreach($ingredient->result() as $i):?>
<?$j = $i->ID?>
<a href="<?=base_url() . "index.php/ingredients/id/$j"?>" style="font-size:<?=($i->freq * $max_font)/$total?>pt;"><?=$i->Name?></a>
<? endforeach; ?>

<br/><br/>
Do you have an ingredient not listed?
<h2>
<a href="<?=base_url() . "index.php/ingredients/add"?>">Add an Ingredient!</a>
</h2>

