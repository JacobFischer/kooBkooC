<h1>Tags</h1>
<ul>
<?foreach($tag->result() as $i):?>
<li><a href ="home.jacobfischer.me/mwilson/cs397/index.php/tags/id/\"$i->ID\" "> <?$i->Name?> </a> </li>
<?endforeach;?>
</ul>

