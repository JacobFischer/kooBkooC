<h1>Tags</h1>
<ul>
<?foreach($tag->result() as $i){?>
<?$j = $i->ID?>
<li><? Echo "<a href=recipe/id/$j>"?> <?echo $i->Name?> </a> </li>
<? } ?>
</ul>

