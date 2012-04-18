<!--Michael Wilson -->
<h1><?=$tag->Name?> : <?=$tag->Description?></h1>
<h2>Recipes Tagged &quot;<?=$tag->Name?>&quot;</h2>
<ul>
<?foreach($recipe->result() as $i){?>
<?$j = $i->ID?>
<li><a href="<?=base_url() . "index.php/recipe/id/$j"?>"> <?echo $i->Name?> </a> </li>
<? } ?>
</ul>
