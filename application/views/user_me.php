<h1>Display Name: <?=$DisplayName?></h1>
<h3>ID: <?=$ID?></h3>
<a href="<?=base_url() . "index.php/recipe/add"?>">Submit A Recipe</a> |
<a href="<?=base_url() . "index.php/ingredients/add"?>">Add an Ingredient!</a> | 
<a href = "<?=base_url()."index.php/tags/add"?>">Add your own Tag!</a>
<br />
<br />

<h2>Recipes</h2>
<ul>
<?php
  if( !count( $recipes ) )
  {
    print "<li> YOU HAVE NOT YET SUBMITTED A RECIPE, LOSER </li>";
  }
?>
<?php
  foreach( $recipes as $recipe )
  {
    print "<li> Recipe: $recipe->Name </li>";
  }
?>
</ul>

<br />

<h2>Favorites</h2>
<ul>
<?php
  if( !count( $favorites ) )
  {
    print "<li> YOU DO NOT HAVE ANY FAVORITE RECIPES YET, LOSER </li>";
  }
?>
<?php
  foreach( $favorites as $recipe )
  {
    print "<li> Recipe: $recipe->Name </li>";
  }
?>
</ul>

<br />

<h2>Comments</h2>

<ul>
<?php
  if( !count( $comments ) )
  {
    print "<li> NO COMMENTS </li>";
  }
  foreach( $comments as $comment )
  {
    print "<a href=\"" . site_url(array('recipe', 'id', $comment->RecipesID)) . "\">" . $comment->Name . "</a> by <a href=\"" . site_url(array('user', 'id', $comment->ID)) . "\">" . $comment->DisplayName . "</a> <br />";
    print $comment->Text;
  }
?>
</ul>

<br />

<h2>Allergies</h2>

<ul>
<?php
  if( !count( $allergies ) )
  {
    print "<li> YOU DON'T HAVE ANY ALLERGIES YET, BUT YOU WILL!!! LOSER!</li>";
  }
?>
<?php
  foreach( $allergies as $allergy )
  {
    print "<li> Name: $allergy->Name </li>";
  }
?>
</ul>

<br />
<h2>Followers:</h2>
<ul>
<?php
  if( !count( $stalkers ) )
  {
    print "<li> NOBODY FOLLOWS YOU YET!!  YOU'RE A LONELY LOSER!</li>";
  }
?>
<?php
  foreach( $stalkers as $stalker )
  {
    print "<li> $stalker->DisplayName </li>";
  }
?>
</ul>

<br />
<h2>Following:</h2>
<ul>
<?php
  if( !count( $stalking ) )
  {
    print "<li>YOU'RE NOT FOLLOWING ANYONE YET! WAY TO NOT BE CREEPY, LOSER!";
  }
?>
<?php
  foreach( $stalking as $stalk )
  {
    print "<li> $stalk->DisplayName </li>";
  }
?>
</ul>


<br />
<form action="password_change" method="post">
Your current password: <input type="password" name="oldPassword" /><br />
New password: <input type="password" name="password1" /><br />
Confirm password: <input type="password" name="password2" /><br />
<input type="submit" />
</form>
