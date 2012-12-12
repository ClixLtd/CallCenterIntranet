<!DOCTYPE html>
<HTML>
	<HEAD>
		<meta charset="utf-8">
		<TITLE></TITLE>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php echo Asset::css('bootstrap.min.css'); ?>
		<?php echo Asset::css('bootstrap-responsive.min.css'); ?>
		<?php echo Asset::css('ppi-portal.css'); ?>
		
		<?php echo Asset::js('jquery.js'); ?>
		<?php echo Asset::js('ppi-portal.js'); ?>
		
		
	</HEAD>
	<BODY>
		<div id="holder">
		
			<?php echo $content; ?>
						
		</div>
	</BODY>
</HTML>