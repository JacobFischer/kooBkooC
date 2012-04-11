<script type="text/javascript">
  var RecaptchaOptions = { 
        theme:"<?= $theme ?>",
              lang:"<?= $lang ?>"
                };
</script>


<form action="register" method="post">

Display Name: <input type="text" name="name" /><br />
E-mail: <input type="text" name="email" /><br />
Password: <input type="password" name="password" /><br />
<?= $recaptcha ?>
<input type="submit" />
</form>
