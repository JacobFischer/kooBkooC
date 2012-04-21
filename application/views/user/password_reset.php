<h1>Reset Your Password</h1>
<form action="<?=site_url( array( 'user', 'password_reset' ) )?>" method="post">
  <label for="password-reset-email">Forgot your password, eh? Well, we can send you a new one, just tell us your email.</label>
  <input id="password-reset-email" type="text" name="email" /><br />
  <?= $recaptcha ?> 
  <input type="submit" value="Send me a new password"/>
</form>
