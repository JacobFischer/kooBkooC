<h1>User: <?=$info->DisplayName?></h1>
<ul>
  <li>Email: <?=$info->Email?>
</ul>

<h2>Recipes</h2>
<ul>
<?php
  foreach( $recipes as $recipe )
  {
    print "<li> Recipe: $recipe->Description </li>";
  }
?>
</ul>

<h2>Favorites</h2>
<ul>
<?php
  foreach( $favorites as $recipe )
  {
    print "<li> Recipe: $recipe->Description </li>";
  }
?>
</ul>


