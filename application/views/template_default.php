<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?$this->load->helper('url');?>
    <?foreach($styles as $style):?>  
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>/styles/<?=$style?>"></script>
    <?endforeach;?>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <?foreach($scripts as $script):?>  
      <script type="text/javascript" src="<?=base_url()?>/scripts/<?=$script?>"></script>
    <?endforeach;?>
    <title>Social Reverse Cookbook</title>
  <body>
    <h1>KoobkooC</h1>
    <div id="contents">
        <?= $contents ?>
    </div>
    <div id="footer">It's Cookbook backwards. Trololololol</div>
  </body>
</html>
