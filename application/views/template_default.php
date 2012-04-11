<!DOCTYPE html>
<html>
    <head>
        <title>kooBkooC</title>
        
        <script type="text/javascript">
          var base_url = "<?=base_url()?>";
        </script>
        
        <!-- BEGIN: Style Sheet imports -->
        <link href="<?=base_url()?>/styles/reset.css" rel='stylesheet' type='text/css'>
        <link href="<?=base_url()?>/styles/style.css" rel='stylesheet' type='text/css'>
        <?foreach($styles as $style):?>  
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/styles/<?=$style?>"></script>
        <?endforeach;?>
        <!-- END: Style Sheet imports -->
        
        <!-- BEGIN: Javascript script imports -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <?foreach($scripts as $script):?>  
        <script type="text/javascript" src="<?=base_url()?>/scripts/<?=$script?>"></script>
        <?endforeach;?>
        <!-- END: Javascript script imports -->
    </head>
    <body>
        <div id="template-title">
            <a href="#" id="website-title">koo<span class="cap">B</span>koo<span class="cap">C</span></a>
            <div id="profile-top">
<?php
if($logged_in)
{
?>
  <a href="<?=site_url(array('user', 'logout'))?>">Logout <strong><?=$username?></strong></a>
<?php
} else {
?>
  <a href="<?=site_url(array('user', 'user_login'))?>">Login</a> - <a href="<?=site_url(array('user', 'reg'))?>">Register</a>
<?php
}
?>
            </div>
        </div>
        <div id="wrapper-top">  
            <header id="template-top">
                <nav id="website-links">
                    <ul>
                        <li>
                            <a href="<?=base_url()?>">Home</a>
                        </li>
                        <li>
                            <a href="<?=site_url(array('recipe'))?>">Recipes</a>
                        </li>
                        <li>
                            <a href="<?=site_url(array('ingredients'))?>">Ingredients</a>
                        </li>
                        <li>
                            <a href="<?=site_url(array('tags'))?>">Tags</a>
                        </li>
                        <li>
                            <a href="<?=site_url(array('aboutus'))?>">About Us</a>
                        </li>
                        <li>
                            <a href="<?=site_url(array('faqs'))?>">FAQ</a>
                        </li>
                        <li>
                            <a href="<?=site_url(array('contactus'))?>">Contact Us</a>
                        </li>
                    <ul>
                </nav>
            </header>
        </div>
        <div id="template-main">
            <?= $contents ?>
        </div>
    </body>
</html>
