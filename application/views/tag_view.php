<h1>Recipe Tags</h1>
<h2>Select a Tag to show recipes that are of that type!</h2>
<?foreach($tag->result() as $i):?>
<?$j = $i->ID?>
<a href="<?=base_url() . "index.php/tags/recipes/$j"?>" style="font-size:<?=($i->freq * $max_font)/$total?>pt;"><?=$i->Name?></a>
<? endforeach; ?>

<br/><br/>
Got your own type to describe recipes?
<h2>
<a href = "<?=base_url()."index.php/tags/add"?>">Add your own Tag!</a>
</h2>

