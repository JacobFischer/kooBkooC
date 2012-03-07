<h1>Tags</h1>
<ul>
<?foreach($tag->result() as $i){?>
<?$j = $i->ID?>
<li><? Echo "<a href =home.jacobfischer.me/mwilson/cs397/index.php/recipe/$j>"?> <?echo $i->Name?> </a> </li>
<? } ?>
</ul>

