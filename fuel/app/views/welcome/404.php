<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	
	<!-- CSS Styles -->
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::css('colors.css'); ?>
	
	<!-- Google WebFonts -->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,bold' rel='stylesheet' type='text/css'>
	
	<script src="js/libs/modernizr-1.7.min.js"></script>
</head>
<body class="error-page">
	<section role="main">
	
		<strong>404</strong>
		<p class="description">Whoops! Page not found...</p>
		<p>Sorry, it appears the page you were looking for doesn't exist anymore or might have been moved. If the problem persists, please contact our support at <a href="mailto:support@gregsonandbrooke.co.uk">support@gregsonandbrooke.co.uk</a></p>
		<a href="/" class="button" title="Back to Homepage">Back to Homepage</a>
		
	</section>

	<!-- JS Libs at the end for faster loading -->
	<?php echo Asset::js('jquery/jquery-1.5.1.min.js'); ?>
	<?php echo Asset::js('libs/selectivizr.js'); ?>
	
	</body>
</html>