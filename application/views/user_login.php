Login: <br />
<form action="login" method="post">
E-mail: <input type="text" name="email" /><br />
Password: <input type="password" name="password" /><br />
<input type="submit" />
</form>
<br/>
Reset Your Password: <br/>
<form action="password_reset" method="post">
E-mail: <input type="text" name="email" /><br />
<?= $recaptcha ?> 
<input type="submit" />
</form>


