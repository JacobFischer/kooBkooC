<h1>Tags</h1>

<?foreach($tag->result() as $i):?>
<?$j = $i->ID?>
<a href="<?=base_url() . "index.php/tags/recipes/$j"?>" style="font-size:<?=($i->freq * $max_font)/$total?>pt;"><?=$i->Name?></a>
<? endforeach; ?>

<br/>
<h2>
<a href = "<?=base_url()."index.php/tags/add"?>">Add a Tag!</a>
</h2>

