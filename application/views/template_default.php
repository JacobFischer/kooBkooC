<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?$this->load->helper('url');?>
    <?foreach($styles as $style):?>  
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>/styles/<?=$style?>"></script>
    <?endforeach;?>
    <?foreach($scripts as $script):?>  
      <script type="text/javascript" src="<?=base_url()?>/scripts/<?=$script?>"></script>
    <?endforeach;?>
    <title>Social Reverse Cookbook</title>
  </head>
  <body>
      <div>
        <div id="Horizontal-Divisor"></div>
        <a class="siteHomeLink">kooBkooC</a>
        <div class="topNaviagationLink">
          <ul>
            <li>
            <a href="index.html">Home</a>
            </li>
            <li>
              <a href="index.html">Profile</a>
            </li>
            <li>
              <a href="index.html">FAQ</a>
            </li>
            <li>
              <a href="index.html">Contact</a>
            </li>
            <li>
              <a href="index.html">About</a>
            </li>
          </ul>
        <div>
        <div id="Horizontal-Divisor"></div>
      </div>
      <div class="contentBox">
          <?=$contents?>
      </div>
  </body>
</html>

</html>
