<h1><?=$user->DisplayName?></h1>
<?php if( $me ): ?>
Submit your own:
<a href="<?=site_url( array( 'recipe', 'add' ) )?>">Recipe</a> |
<a href="<?=site_url( array( 'ingredients', 'add' ) )?>">Ingredient</a> | 
<a href = "<?=site_url( array( 'tags', 'add' ) )?>">Tag</a>

<form action="password_change" method="post">
Your current password: <input type="password" name="oldPassword" /><br />
New password: <input type="password" name="password1" /><br />
Confirm password: <input type="password" name="password2" /><br />
<input type="submit" />
</form>
<?php endif; ?>

<h2><?=$me?"My":$user->DisplayName."'s"?> Recipes</h2>

<?php if( count( $recipes ) ): ?>
<ul>
<?php foreach( $recipes as $recipe ): ?>
  <li><?=$this->load->view('recipes/short', array('recipe' => $recipe ) )?></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<?php if( $me ): ?>
  <p>You have not submitted any recipes, <a href="<?=site_url( array( 'recipe', 'add' ) )?>">maybe you should</a>.</p>
<?php else: ?>
  <p><?=$user->DisplayName?> has not submitted any recipes</p>
<?php endif; ?>
<?php endif; ?>
<h2><?=$me?"My":$user->DisplayName."'s"?> Comments</h2>
<?php if( count( $comments ) ): ?>
<ul>
<?php foreach( $comments as $comment ): ?>
  <?=$this->load->view('comment', array('comment' => $comment, 'comment_on' => true) )?>
<?php endforeach; ?>
</ul>
<?php else: ?><?php if( $me ): ?>
  <p>You have never commented on any recipe.</p>
<?php else: ?>
  <p><?=$user->DisplayName?> has not commented any recipes</p>
<?php endif; ?>
<?php endif; ?>