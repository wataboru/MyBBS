<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::css('stylesheet.css'); ?>
   <style>
      body { margin: 40px; }
    </style>
  </head>
  <body>
    <header>
      <?php echo $header; ?>
    </header>
    <div class="container">
      <div class="col-md-12">
        <h1><?php echo $title; ?></h1>
        <hr>
      </div>
    </div>
    <div class="col-md-12">
      <?php echo $content; ?>
    </div>
    <footer>
      <?php echo $footer; ?>
    </footer>
  </body>
</html>
