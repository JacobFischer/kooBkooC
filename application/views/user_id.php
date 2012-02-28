<h1>User: <?=$info->DisplayName?></h1>
<ul>
  <li>Email: <?=$info->Email?>
</ul>

<?php
  if( count( $recipes ) )
  {
    print "<h2>Recipes</h2>";
  }
?>
<ul>
<?php
  foreach( $recipes as $recipe )
  {
    print "<li> Recipe: $recipe->Description </li>";
  }
?>
</ul>

<?php
  if( count( $favorites ) )
  {
    print "<h2>Favorites</h2>";
  }
?>
<ul>
<?php
  foreach( $favorites as $recipe )
  {
    print "<li> Recipe: $recipe->Description </li>";
  }
?>
</ul>


<?php
  if( count( $allergies ) )
  {
    print "<h2>Allergies</h2>";
  }
?>
<ul>
<?php
  foreach( $allergies as $allergy )
  {
    print "<li> Name: $allergy->Name </li>";
  }
?>
</ul>

<?php
  if( count( $stalkers ) )
  {
    print "<h2>Followers:</h2>";
  }
?>
<ul>
<?php
  foreach( $stalkers as $stalker )
  {
    print "<li> $stalker->DisplayName </li>";
  }
?>
</ul>

<?php
  if( count( $stalking ) )
  {
    print "<h2>Following:</h2>";
  }
?>
<ul>
<?php
  foreach( $stalking as $stalk )
  {
    print "<vim> $stalk->DisplayName </li>";
  }
?>
</ul>



