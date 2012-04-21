<!DOCTYPE html>
<html>
    <head>
        <title>kooBkooC<?=$location != "" ? ' &raquo; ' . $location : ""?><?=$title != "" ? ' &raquo; ' . $title : ""?></title>
        
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
        <script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<?foreach($scripts as $script):?>  
        <script type="text/javascript" src="<?=base_url()?>/scripts/<?=$script?>"></script>
<?endforeach;?>
        <!-- END: Javascript script imports -->
    </head>
    <body>
        <div id="template-title">
            <a href="<?=base_url()?>" id="website-title">koo<span class="cap">B</span>koo<span class="cap">C</span></a>
            <div id="profile-top">
<?php if($logged_in): ?>
              <a href="<?=site_url(array('user', 'me'))?>"><?=$username?></a><a href="<?=site_url(array('user', 'logout'))?>">Logout</a>
<?php else: ?>
              <a href="<?=site_url(array('user', 'user_login'))?>">Login</a><a href="<?=site_url(array('user', 'reg'))?>">Register</a>
<?php endif; ?>
            </div>
        </div>
        <div id="wrapper-top">  
            <header id="template-top">
                <nav id="website-links">
                    <ul>
                        <li<?=$location == "Home" ? ' class="current-location"' : ""?>>
                            <a href="<?=base_url()?>">Home</a>
                        </li>
                        <li<?=$location == "Recipes" ? ' class="current-location"' : ""?>>
                            <a href="<?=site_url(array('recipe'))?>">Recipes</a>
                        </li>
                        <li<?=$location == "Ingredients" ? ' class="current-location"' : ""?>>
                            <a href="<?=site_url(array('ingredients'))?>">Ingredients</a>
                        </li>
                        <li<?=$location == "Tags" ? ' class="current-location"' : ""?>>
                            <a href="<?=site_url(array('tags'))?>">Tags</a>
                        </li>
                        <li<?=$location == "About Us" ? ' class="current-location"' : ""?>>
                            <a href="<?=site_url(array('aboutus'))?>">About Us</a>
                        </li>
                        <li<?=$location == "FAQ" ? ' class="current-location"' : ""?>>
                            <a href="<?=site_url(array('faqs'))?>">FAQ</a>
                        </li>
                        <li<?=$location == "Contact Us" ? ' class="current-location"' : ""?>>
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
