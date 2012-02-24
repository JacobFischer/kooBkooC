//recipe page

<h1>Recipe: <?php =$Recipe ?></h1></br>
Created by <?php lookup(userID) ?></br>

<?php =$Recipe->text?></br>

Rating <?php =$Recipe->rating?></br>
<button type = "button" onclick="<?php  $recipe->rating = $recipe->rating + 1; ?>" />
<h2>Comments</h2>
<?php foreach( $comments as $single )
  print $single+'\n';
?>


