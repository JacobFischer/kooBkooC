<h1>Tags</h1>
<section id="tag-cloud">
<?php foreach($tags as $tag):?>
  <a href="<?=site_url( array( 'tags', 'recipes', $tag->ID ) )?>" style="font-size:<?=($tag->freq * $max_font)/$total?>pt;" class="tag-cloud-box"><?=$tag->Name?></a>
<?php endforeach; ?>
</section>

<br/><br/>
Got your own type to describe recipes?
<h2>
<a href = "<?=base_url()."index.php/tags/add"?>">Add your own Tag!</a>
</h2>

