<html>
  <head>
    <title>Survey</title>
    
    <?php echo Asset::css('bootstrap.min.css'); ?>
		<?php echo Asset::css('bootstrap-responsive.min.css'); ?>
    <?php echo Asset::css('survey.css'); ?>
    <!--<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.min.css" />-->
    
    <?php echo Asset::js('jquery.js'); ?>
    <!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
    <?php echo Asset::js('survey.js'); ?>
  </head>
  <body>
    <div id="holder">
      <?=$content;?>
    </div>
  </body>
</html>