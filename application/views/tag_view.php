<h1>Tags</h1>
<ul>
<?foreach($tag->result() as $i):?>
<?$j = $i->ID?>
<li><a href="<?=base_url() . "index.php/tags/recipes/$j"?>"><?=$i->Name?></a></li>
<? endforeach; ?>
</ul>
<br/>
<h2>
<a href = "<?=base_url()."index.php/tags/add"?>">Add a Tag!</a>
</h2>
