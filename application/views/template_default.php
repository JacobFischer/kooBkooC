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
                <a href="#">Login</a> - <a href="#">Register</a>
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
                            <a href="<?=site_url(array('recipe'))?>">Recipies</a>
                        </li>
                        <li>
                            <a href="#">About Us</a>
                        </li>
                        <li>
                            <a href="#">FAQ</a>
                        </li>
                        <li>
                            <a href="#">Contact Us</a>
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
