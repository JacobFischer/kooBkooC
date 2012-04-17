
<h1>This ingredient is used in:</h1>
<ul>
<?foreach($ingredient->result() as $i){?>
<li><a href = "<?=base_url()."index.php/recipe/id/".$i->ID?>"/><?echo $i->Name ?></a></li>
<? } ?>
</ul>
 
