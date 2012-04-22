<?php if($message != ""):?>
<div class="alert-box"><?=$message?></div>
<?php endif; ?>
<h1><?=$user->DisplayName?></h1>
<?php if( $me ): ?>
<div id="profile-submission">
  &nbsp;Submit your own:
  <a href="<?=site_url( array( 'recipe', 'add' ) )?>">Recipe</a> |
  <a href="<?=site_url( array( 'ingredients', 'add' ) )?>">Ingredient</a> | 
  <a href = "<?=site_url( array( 'tags', 'add' ) )?>">Tag</a>
</div>

<button id="update-profile">Update My Profile</button>
<section id="profile-update">
  <form action="<?=site_url( array('user', 'name_change') )?>" method="post">
    <label for="new-display-name">New Display Name</label>
    <input id="new-display-name" type="text" name="newDisplayName" value="<?=$user->DisplayName?>" />
    <input type="submit" />
  </form>
  <form action="<?=site_url( array('user', 'password_change') )?>" method="post">
    <label for="current-password">Your current password</label>
    <input id="current-password" type="password" name="oldPassword" />
    <label for="new-password1">New Password</label>
    <input id="new-password1" type="password" name="password1" />
    <label for="new-password2">Confirm Password</label>
    <input id="new-password2" type="password" name="password2" />
    <input type="submit" />
  </form>
</section>
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
<a href="<?=site_url( array( 'user', 'lookup' ) )?>" style="font-size: 1.25em; display: block; margin-top: 1em;">Search for other users</a>