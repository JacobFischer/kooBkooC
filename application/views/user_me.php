<h1>Display Name: <?=$info->DisplayName?></h1>
<h3>ID: <?=$info->ID?></h3>

<form action="password_change" method="post">
Your current password: <input type="password" name="oldPassword" /><br />
New password: <input type="password" name="password1" /><br />
Confirm password: <input type="password" name="password2" /><br />
<input type="submit" />
</form>
