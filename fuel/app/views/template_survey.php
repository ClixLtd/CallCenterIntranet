<html>
  <head>
    <title>Survey</title>
    
    <?php echo Asset::css('bootstrap.min.css'); ?>
		<?php echo Asset::css('bootstrap-responsive.min.css'); ?>
    <?php echo Asset::css('survey.css'); ?>
    
    <?php echo Asset::js('jquery.js'); ?>
    <?php echo Asset::js('survey.js'); ?>
  </head>
  <body>
    <div id="holder">
      <?=$content;?>
    </div>
  </body>
</html>