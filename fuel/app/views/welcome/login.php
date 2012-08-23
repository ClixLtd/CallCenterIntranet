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
	<?php echo Asset::css('jquery.tipsy.css'); ?>
	
	<!-- Google WebFonts -->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
	
	<script src="js/libs/modernizr-1.7.min.js"></script>
</head>
<body class="login">
	<section role="main">
	
		<img src="/assets/img/gablogo.png" >

		<!-- Login box -->
		<article id="login-box">
		
			<div class="article-container">
			
				<?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)): ?>
				<div class="notification error">
					<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
					<p>
					<strong>Browser Error</strong> We do not support Internet Explorer. Please use Firefox or Chrome!
					</p>
				</div>
				<?php endif; ?>
		
		
				<?php if (Session::get_flash('success')): ?>
				<div class="notification success">
					<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
					<p>
					<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
					</p>
				</div>
				<?php endif; ?>
				
				<?php if (Session::get_flash('fail')): ?>
				<div class="notification error">
					<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
					<p>
					<?php echo implode('</p><p>', e((array) Session::get_flash('fail'))); ?>
					</p>
				</div>
				<?php endif; ?>
				
				<form method="post">
					<fieldset>
						<dl>
							<dt>
								<label>Login</label>
							</dt>
							<dd>
								<input type="text" class="large" name="username">
							</dd>
							<dt>
								<label>Password</label>
							</dt>
							<dd>
								<input type="password" class="large" name="password">
							</dd>
						</dl>
					</fieldset>
					<button type="submit" class="right">Log in</button>
				</form>
			
			</div>
		
		</article>
		<!-- /Login box -->
		<ul class="login-links">
			<li><a href="#">Lost password?</a></li>
		</ul>
		
	</section>

	<!-- JS Libs at the end for faster loading -->
	<?php echo Asset::js('jquery/jquery-1.5.1.min.js'); ?>
	<?php echo Asset::js('libs/selectivizr.js'); ?>
	<?php echo Asset::js('jquery/jquery.tipsy.js'); ?>
	<?php echo Asset::js('login.js'); ?>
</html>