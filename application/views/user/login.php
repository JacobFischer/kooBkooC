<h1>Login</h1>
<form action="login" method="post">
  <label for="login-email">E-mail</label>
  <input id="login-email" type="text" name="email" />
  <label for="login-password">Password</label>
  <input id="login-password" type="password" name="password" />
  <a href="<?=site_url( array( 'user', 'password', 'reset' ) )?>">Forgot your password?</a>
  <input type="submit" value="Login"/>
</form>


