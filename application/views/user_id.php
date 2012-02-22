<h1>User: <?=$info->DisplayName?></h1>
<ul>
  <li>Email: <?=$info->Email?>
</ul>

<ul>
<?php
  foreach( $recipes as $recipe )
  {
    print "<li> Recipe: $recipe->Description </li>";
  }
?>

</ul>
